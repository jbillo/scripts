#!/usr/bin/env python
import subprocess
import sys

MASTER_TEMPLATE = 'zone "%s" { type master; file "/etc/bind/blockeddomains.db"; };\n'
SLAVE_TEMPLATE = 'zone "%s" { type slave; masters { 10.1.30.32; }; file "slaves/db.%s"; };\n'

is_master = len(sys.argv) > 1 and sys.argv[1] == 'master'

print subprocess.check_output(['wget', '-O', '/root/domains.txt', 'https://raw.githubusercontent.com/jbillo/scripts/master/dnsfilter/domains.txt'])

with open('/root/domains.txt', 'r') as fp:
        domains = fp.readlines()

with open('/etc/bind/blacklisted.zones', 'w') as fp:
        for domain in domains:
                domain = domain.strip()
                if domain:
                        if is_master:
                                line = MASTER_TEMPLATE % domain
                        else:
                                line = SLAVE_TEMPLATE % (domain, domain)
                        fp.write(line)

with open('/etc/bind/blacklisted.zones', 'r') as fp:
        for line in fp.readlines():
                print line

print subprocess.check_output(['named-checkconf'])
print subprocess.check_output(['service', 'bind9', 'reload'])
