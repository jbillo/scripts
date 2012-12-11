#!/usr/bin/env python

"""
check_wp_options

Given a file of MySQL database names and a root MySQL password, checks the row count of wp_options.
Issues a WARNING message if more than 10K rows exist in the table so you can grep the output for WARN.
"""

import sys
import os
import subprocess

def usage():
	print "Usage: {0} [database_file] [mysql_root_pw]".format(sys.argv[0])
	sys.exit(1)

if len(sys.argv) < 3:
	usage()

db_file = sys.argv[1]
mysql_root_pw = sys.argv[2]

with open(db_file) as f:
	databases = f.readlines()

for database in databases:
	database = database.strip()
	command_line = "/usr/bin/mysql -u root -p{0} {1} -e".format(mysql_root_pw, database)
	params = command_line.split(" ")
	params.append("SELECT COUNT(*) FROM wp_options");

	print "[{0}] Checking database {0}".format(database)
	result = subprocess.Popen(params, stderr=subprocess.PIPE, stdout=subprocess.PIPE).communicate()
	if "ERROR 1146 (42S02) at line 1" in result[1]:
		print "[{0}] This is not a valid WordPress database; skipping".format(database)
	else:
		lines = result[0].split("\n")
		row_count = int(lines[1])
		print "[{0}] wp_options table has {1} row(s)".format(database, row_count)

		if row_count > 10000:
			print "[{0}] WARNING: wp_options table has many rows!".format(database)


print "I_DONE: Complete"

