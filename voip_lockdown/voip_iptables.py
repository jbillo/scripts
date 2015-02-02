#!/usr/bin/env python

import os
import subprocess

IPTABLES_CHAIN = 'voip_inbound'
ALLOWED_HOSTS_FILE = 'allowed_hosts.txt'

def get_provider_ips():
    valid_ips = []

    with open(ALLOWED_HOSTS_FILE) as f:
        for host in f:
            if host.strip():
                ip_candidate = subprocess.check_output(['dig +short %s' % host.strip()], shell=True, stderr=subprocess.STDOUT)
                if ip_candidate.strip():
                    valid_ips.append(ip_candidate.strip())

    return valid_ips

def main():
    # Get IP addresses associated with hostnames
    print "[+] Getting IP addresses associated with VOIP providers..."
    valid_ips = get_provider_ips()
    print "[+] IP addresses that will be allowed to connect to udp:5060: %s" % valid_ips

    with open(os.devnull, 'w') as FNULL:
        subprocess.call('iptables -F %s' % IPTABLES_CHAIN, shell=True, stderr=FNULL)
        subprocess.call('iptables -X %s' % IPTABLES_CHAIN, shell=True, stderr=FNULL)
        subprocess.call('iptables -N %s' % IPTABLES_CHAIN, shell=True, stderr=FNULL)

    print "[+] iptables commands that will be run to generate the %s chain: " % IPTABLES_CHAIN
    for ip in valid_ips:
        cmd = 'iptables -A %s -p udp -s %s --dport 5060 -j ACCEPT' % (IPTABLES_CHAIN, ip)
        print cmd
        subprocess.call(cmd, shell=True)

    # Log packets
    cmd = ('iptables -A %s -p udp --dport 5060 -m limit --limit 2/min -j LOG '
          '--log-prefix "iptables dropped: " --log-level 4') % IPTABLES_CHAIN
    print cmd
    subprocess.call(cmd, shell=True)

    # Drop packets
    cmd = 'iptables -A %s -p udp --dport 5060 -j DROP' % IPTABLES_CHAIN
    print cmd
    subprocess.call(cmd, shell=True)

    print "[+] Done; make sure your INPUT chain references %s" % IPTABLES_CHAIN

if __name__ == '__main__':
    main()
