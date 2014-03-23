#!/usr/bin/python
import re
import sys
import subprocess
from subprocess import call
import tempfile
import logging
import os
import datetime
import re 

# http://serverfault.com/questions/189932/how-to-delete-ip-address-from-denyhosts

#http://daniweb.com/code/snippet216475.html
#http://www.doughellmann.com/PyMOTW/tempfile/
#http://www.daniweb.com/forums/thread73705.html
#http://pbe.lightbird.net/tempfile-module.html
#http://www.palewire.com/posts/2008/04/07/python-recipe-open-multiple-files-search-for-matches count-your-hits-on-the-fly/
#http://docs.python.org/library/logging.html
#http://docs.python.org/library/subprocess.html#module-subprocess
#http://docs.python.org/tutorial/errors.html#handling-exceptions

#You actually need to stop denyhosts and remove the offending entry from 5 other files. '/var/lib/denyhosts/hosts','/var/lib/denyhosts/hosts-restricted','/var/lib/denyhosts/hosts-root','/var/lib/denyhosts/hosts-valid','/var/lib/denyhosts/users-hosts','/etc/hosts.deny'
#Here is a link to a ruby script to do so, http://robotplaysguitar.com/2009/10/30/remove-an-ip-banned-by-denyhosts/
#Or here is a Python script I created to do the same thing -- usage is sudo python ./unban.py ip-goes-here



def returnTime():
  dt = datetime.datetime.now()
  str(dt)
  return dt.strftime("%Y%m%d_%H:%M:%S")

#########################################
#  Uncomment these below for debugging  #
#########################################
#print sys.argv[1]
#print len(sys.argv)
#########################################  
#  Change these values for logging      #
#########################################
LOG_FILENAME = './unban.log'
logging.basicConfig(filename=LOG_FILENAME,level=logging.DEBUG)
logging.debug("---------------" + returnTime() + "----------------------") # initialize debugging

denyhosts=("/etc/init.d/denyhosts")
start="start"
stop="stop"
denyhosts_files=['/var/lib/denyhosts/hosts','/var/lib/denyhosts/hosts-restricted','/var/lib/denyhosts/hosts-root','/var/lib/denyhosts/hosts-valid','/var/lib/denyhosts/users-hosts','/var/lib/denyhosts/users-invalid','/etc/hosts.deny']

if len(sys.argv) <> 2:
  print "Wrong number of args"
  print "Usage: sudo python ./unban.py ip"
  sys.exit(1)
else:
  if subprocess.call([denyhosts,stop]) == 0:
    logging.debug("/etc/init.d/denyhosts stopped at:\t" + returnTime())
    print "/etc/init.d/denyhosts stopped"
  else:
    print "error stopping denyhosts..."
    logging.debug("Error stopping /etc/init.d/denyhosts\t" + returnTime())
    sys.exit("bork =(")

  ip = sys.argv[1]

  for f in denyhosts_files:
    tf = tempfile.NamedTemporaryFile(delete=False)
    print "Temp Filename is:" + tf.name + " Real file name is: " + f

    try:
      text = open(f,"r")
      data_list = text.readlines()  
      logging.debug("File: "+ f + " is being worked on.\t"+returnTime())
    except IOError as (errno, strerror):
      print "I/O error({0}): {1}".format(errno, strerror)

    for line in data_list:  
      if re.search(ip, line):
        print line    
        # just do nothing here -- because we are writing all the good IP's to a file!  genius! 
        logging.debug("Deleting ip: " + ip + " because we found a match.\t" + returnTime())
      else:
        tf.write(line)
    ####
    #  Close the temporary file
    ####                 
    try:
      text.close()
      tf.close()
      logging.debug('This is where the text file: ' + tf.name + ' is closed.\t' + returnTime() )
    except OSError:  
      print "OS error({0}): {1}".format(errno, strerror)
    except:
      print "Unexpected error:", sys.exc_info()[0] 

    try:
      os.rename(f,f+"_tmp") 
    except OSError:
      print "OS error({0}): {1}".format(errno, strerror)
    except:
      print "Unexpected error:", sys.exc_info()[0]
    try:
      os.chmod(f+"_tmp",0644) # this makes the temp file 644
    except OSError:
      print "OS error({0}): {1}".format(errno, strerror)
    except:
      print "Unexpected error:", sys.exc_info()[0]  
    try:
      os.rename(tf.name,f)  
    except OSError:
      print "OS error({0}): {1}".format(errno, strerror)
    except:
      print "Unexpected error:", sys.exc_info()[0]
    try:    
      os.chmod(f,0644) # this make the newly edited file 0644
      logging.debug("File: "+ f + " has been renamed. - " + returnTime())
    except OSError:
      print "OS error({0}): {1}".format(errno, strerror)
    except:
      print "Unexpected error:", sys.exc_info()[0]



###
#  Clean up and restart denyhosts
###  
if subprocess.call([denyhosts,start]) == 0:
  print "/etc/init.d/denyhosts Started"
  logging.debug("/etc/init.d/denyhosts succesfully restarted!\t" + returnTime()) 
else:
  print "There was an error starting /etc/init.d/denyhosts...\t"
  logging.debug("/etc/init.d/denyhosts did not restart successfully \t" + returnTime()) 
