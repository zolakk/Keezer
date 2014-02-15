#!/usr/bin/env python
# Notifier example from tutorial
#
# See: http://github.com/seb-m/pyinotify/wiki/Tutorial
#
import pyinotify
import os

wm = pyinotify.WatchManager()  # Watch Manager
mask = pyinotify.IN_CREATE # watched events

class EventHandler(pyinotify.ProcessEvent):
    def process_IN_CREATE(self, event):
#        print "Modified:", event.pathname
#	print os.path.basename(event.pathname)
	os.kill(int(os.path.basename(event.pathname)), 10)
	os.remove(event.pathname)

handler = EventHandler()
notifier = pyinotify.Notifier(wm, handler)
wdd = wm.add_watch('/var/www/keezerd/pid', mask, rec=True)

notifier.loop()
