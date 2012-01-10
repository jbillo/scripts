#!/usr/bin/python
# wpfix.py: Repair a WordPress directory and config file to allow auto-update
# Jake Billo, jake@jakebillo.com
# Directions from http://www.fangsoft.net/?p=227

"""
Version history:
	2011-03-07 (jbillo):
		Initial release, some bugfixes for web publication. Added UID check.
		Also modified WP_DEBUG locate to WPLANG for older WordPress sites.
"""

import os
import sys

def usage():
    app_name = sys.argv[0]

    print """%s usage:

%s wordpress_dir

wordpress_dir       The directory WordPress resides in, to be fixed for auto-update

""" % (app_name, app_name)
    sys.exit(0)

if len(sys.argv) < 2:
    usage()

if os.getuid() != 0:
    print "E_ROOT: You must be root to use this utility.\n"
    usage()

wordpress_dir = sys.argv[1].strip()
if wordpress_dir[-1] == '/':
    wordpress_dir = wordpress_dir[0:-1]

os.system("find " + wordpress_dir + " -type d -exec chmod 755 {} \;")
os.system("find " + wordpress_dir + " -type f -exec chmod 644 {} \;")

wp_content_dir = wordpress_dir + "/wp-content"
wp_content_subdirs = wp_content_dir + "/plugins/ " + wp_content_dir + "/themes/ " + wp_content_dir + "/upgrade/ " + wp_content_dir + "/uploads/"

os.system("chgrp www-data " + wp_content_dir + "/")
os.system("chgrp www-data " + wp_content_subdirs)
os.system("chmod -R g+w " + wp_content_dir + "/")
os.system("chmod -R g+w " + wp_content_subdirs)
os.system("chmod -R g+w " + wordpress_dir)

f = open(wordpress_dir + "/wp-config.php", "r")
config = f.read()
f.close()

if config.find("FS_METHOD") == -1:
    # Find the position in config where we have the WP_DEBUG define.
    insert_pos = config.find("define ('WPLANG',")
    if insert_pos == -1:
        print "E_FSMETHOD: Could not locate suitable position to add FS_METHOD directive. Add define('FS_METHOD', 'direct'); to " + wordpress_dir + "/wp-config.php.\n"
    else:
        new_config = config[0:insert_pos] + "\n/* wpfix.py: for automatic updates */\ndefine('FS_METHOD', 'direct');\n" + config[insert_pos:]
	f = open(wordpress_dir + "/wp-config.php", "w")
        f.write(new_config)
	f.close()
else:
    print "W_FSMETHOD: FS_METHOD directive seems to already exist in wp-config.php\n"


print "I_COMPLETE: WordPress directory " + wordpress_dir + " fixed for auto-update successfully\n"