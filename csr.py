#!/usr/bin/python
import os
import sys

if os.getuid() != 0:
    print "E_ROOT: You must be root to use this utility.\n"
    sys.exit(1)

print "WARNING: For NameCheap, the 'common name' field must be the domain name you would like to activate."

SSL_DIR = "/etc/ssl/"

def usage():
    app_name = sys.argv[0]
    print """%s usage:
%s domain_name

domain_name     The domain name to generate a key and CSR for
""" % (app_name, app_name) 
    sys.exit(0)

if len(sys.argv) < 2:
	usage()

domain_name = sys.argv[1].strip()

os.system("openssl genrsa -out " + SSL_DIR + domain_name + ".key 2048")
os.system("openssl req -new -sha256 -key " + SSL_DIR + domain_name + ".key -out " + SSL_DIR + domain_name + ".csr")
os.system("cat " + SSL_DIR + domain_name + ".csr") 

print "\n\nCSR generation complete"
