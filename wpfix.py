#!/usr/bin/python
# wpfix.py: Repair a WordPress directory and config file to allow auto-update
# Jake Billo, jake@jakebillo.com
# Directions from http://www.fangsoft.net/?p=227

"""
Version history:
	2013-03-12:
		Add customizable user account. More compliant with Hardening
		WordPress guide (http://codex.wordpress.org/Hardening_WordPress).
		--w3tc option for more permissive write settings.

	2012-09-01 (jbillo):
		Add customizable Apache/httpd user for non-Debian distributions.
		Defaults to "www-data".

    2012-01-10 (jbillo):
        Second release. Look for WP_DEBUG *or* WPLANG as WordPress 3.3.x
        apparently doesn't include WPLANG in a stock wp-config.php file.
    
	2011-03-07 (jbillo):
		Initial release, some bugfixes for web publication. Added UID check.
		Also modified WP_DEBUG locate to WPLANG for older WordPress sites.
"""

import os
import sys

def usage():
    app_name = sys.argv[0]

    print """%s usage:

%s wordpress_dir [owner] [apache_group] [options]

wordpress_dir       The directory WordPress resides in, to be fixed for auto-updating
owner				The name of the user account that should own the directory
apache_group		The name of the webserver group. Default is www-data

Options include:

--w3tc				If included, sets more permissive permissions for W3 Total Cache

""" % (app_name, app_name)
    sys.exit(0)

if len(sys.argv) < 2:
    usage()

if os.getuid() != 0:
    print "E_ROOT: You must be root to use this utility.\n"
    usage()

# Check for owner
if len(sys.argv) > 2 and not sys.argv[2].startswith("--"):
	owner = sys.argv[2]
else:
	owner = None

if len(sys.argv) > 3 and not sys.argv[3].startswith("--"):
	apache_group = sys.argv[3]
else:
	apache_group = "www-data"

plugin_w3tc = "--w3tc" in sys.argv
	
wordpress_dir = sys.argv[1].strip()
if wordpress_dir[-1] == '/':
    wordpress_dir = wordpress_dir[0:-1]

print "I_START: Working on WordPress directory %s" % wordpress_dir
print "I_PROGRESS: Applying 755 permissions on all directories"
os.system("find " + wordpress_dir + " -type d -exec chmod 755 {} \;")
print "I_PROGRESS: Applying 644 permissions on all files"
os.system("find " + wordpress_dir + " -type f -exec chmod 644 {} \;")

print "I_PROGRESS: File and directory permissions set; changing owner and group"

# http://codex.wordpress.org/Hardening_WordPress
# All files are now u+rw, g+r, o+r
# For specific directories we will go through and apply group permissions.

# If a user account was specified, change owner on main WordPress directory
if owner:
	print "I_PROGRESS: Changing owner on WordPress directory to %s" % owner
	os.system("chown -R %s %s" % (owner, wordpress_dir))

# Change group owner to Apache group
os.system("chgrp -R %s %s/" % (apache_group, wordpress_dir))

wp_content_dir = wordpress_dir + "/wp-content"

# Apply write permission to wp_content directory
os.system("chmod g+w %s" % wp_content_dir)
os.system("chmod g+w %s/plugins" % wp_content_dir)
os.system("chmod -R g+w %s/themes" % wp_content_dir)
os.system("chmod -R g+w %s/uploads" % wp_content_dir)
os.system("chmod -R g+w %s/upgrade" % wp_content_dir)

# W3 Total Cache
if plugin_w3tc:
	print "I_PROGRESS: Setting more permissive permissions for W3 Total Cache"
	os.system("chmod -R g+w %s/cache" % wp_content_dir)
	os.system("chmod -R g+w %s/w3tc-config" % wp_content_dir)
	os.system("chmod g+w %s/.htaccess" % wordpress_dir)
	# Stop whinging about wp-content permissions
	os.system("chmod 755 %s" % wp_content_dir)

f = open(wordpress_dir + "/wp-config.php", "r")
config = f.read()
f.close()

if config.find("FS_METHOD") == -1:
    # Find the position in config where we have the WP_DEBUG or WPLANG define.
    insert_pos = config.find("define ('WPLANG',")
    if insert_pos == -1:
        insert_pos = config.find("define('WP_DEBUG',")
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
