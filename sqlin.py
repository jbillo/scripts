#!/usr/bin/python

import sys

f = open(sys.argv[1], 'r')
lines = f.readlines()

values = []

for line in lines:
    if line[0:2] == '| ':
        # This is a value from SQL
        value = line[2:]
        value = value[0:-4]
        if value.isdigit():
            values.append(value)

sql = ""
for value in values:
    sql += "'" + value + "',"
sql = sql[0:-1]
sql = "(" + sql + ")"

print sql + "\n"

f.close()
