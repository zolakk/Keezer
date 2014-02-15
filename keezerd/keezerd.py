#!/usr/bin/env python
import math
import pygame
import time
import MySQLdb
import os
import logging
import sys
import argparse
import RPi.GPIO as GPIO
import signal
from flowmeter import *
from seekrits import *

from datetime import datetime

boardRevision = GPIO.RPI_REVISION
GPIO.setmode(GPIO.BCM) # use real GPIO numbering

fm = FlowMeter('metric')
fm.enabled = True

debug = False
#kegNo = 0

kegChanLow = ""
kegChanNormal = ""
kegChanOut = ""

def receive_signal(signum, stack):
    logInfo('Received:' + str(signum))
    refreshFromDB()
    
def incFlowCounter(channel):
	currentTime = int(time.time() * FlowMeter.MS_IN_A_SECOND)
	if fm.enabled == True:
	    fm.update(currentTime)

def logInfo(message):
	global debug
        if debug == True:
                print str(datetime.now()) + " " + message
                
        logging.debug(str(datetime.now()) + " " + message)
        
def refreshFromDB():
	global kegChanLow
	global kegChanNormal
	global kegChanOut
	
        logInfo ("Refreshing info from DB, kegNo=" + str(kegNo) + "...")
	
	db=MySQLdb.connect(host="localhost", user=DB_USER, passwd=DB_PASSWORD, db="keezer")
	db.autocommit(True)
	cur = db.cursor()
	# Enabled, CapacityLiters, CurrentLevelLiters, KegSoundNormal, KegSoundLow, KegSoundOut, Pid, KegID
        cur.execute("SELECT Enabled, CurrentLevel, KegSoundNormal, KegSoundLow, KegSoundOut FROM Keg WHERE KegID=" + str(kegNo))

        logInfo("Got the following from DB:")
        logInfo("Enabled, CurrentLevel (Liters), KegSoundNormal, KegSoundLow, KegSoundOut")
        
        for row in cur.fetchall() :
                logInfo(str(row))
                fm.enabled = row[0]
                fm.currentLevel = row[1]
		
		logInfo("loading " + row[2])
		kegChanNormal.play(pygame.mixer.Sound('/var/www/sound/' + row[2]),-1)
		kegChanNormal.set_volume(0.0)
		kegChanNormal.pause()
		
		logInfo("loading " + row[3])
		kegChanLow.play( pygame.mixer.Sound('/var/www/sound/' + row[3]),-1)
		kegChanLow.set_volume(0.0)
		kegChanLow.pause()
		
		logInfo("loading " + row[4])
		kegChanOut.play(pygame.mixer.Sound('/var/www/sound/' + row[4]),-1)
		kegChanOut.set_volume(0.0)
		kegChanOut.pause()
	cur.close()
	tmpSound = pygame.mixer.Sound('/var/www/sound/dbRefresh.ogg')
	tmpSound.play()

	db.close()

	logInfo("Finished refreshing from DB!")

def main(kegNo):
        global debug
        #global kegNo

	global kegChanLow
	global kegChanNormal
	global kegChanOut
	
        signal.signal(signal.SIGUSR1, receive_signal)
        logging.basicConfig(filename='/var/www/keezerd/log/keezer' + str(kegNo) + '.log',filemode='w',level=logging.DEBUG)

        kegPin = kegNo + 1

        logInfo("keezerd.py starting as Keg# " + str(kegNo))
	logInfo("PID is " + str(os.getpid()))
		
	db=MySQLdb.connect(host="localhost", user=DB_USER, passwd=DB_PASSWORD,db="keezer")
	db.autocommit(True)
	cur = db.cursor()
	cur.execute("UPDATE Keg SET PID=" + str(os.getpid()) + " WHERE KegID=" + str(kegNo))
	cur.close()
	
        #logging.debug(str(datetime.now()) + " Initializing pygame for sound...")
        logInfo("Initializing pygame for sound...")
        
        pygame.mixer.pre_init(22050, -16, 2) # setup mixer to avoid sound lag
        pygame.init()

	kegChanLow = pygame.mixer.Channel(3)
	kegChanOut = pygame.mixer.Channel(4)
	kegChanNormal = pygame.mixer.Channel(2)

        logInfo("Mixer settings:" + str(pygame.mixer.get_init()))
        logInfo("Mixer channels:" + str(pygame.mixer.get_num_channels()))
        
        pygame.mixer.music.set_volume(1.0)
        logInfo("Registering flow counters...")
        GPIO.setup(kegPin,GPIO.IN, pull_up_down=GPIO.PUD_UP)
	GPIO.add_event_detect(kegPin, GPIO.RISING, callback=incFlowCounter, bouncetime=20)

        refreshFromDB()
	
        logInfo("Beginning main loop!")
	startLoop = pygame.mixer.Sound('/var/www/sound/startup.ogg')
	startLoop.play()

        while True:
		#time.sleep(1) # Give the CPU a break
		currentTime = int(time.time() * FlowMeter.MS_IN_A_SECOND)
		if (fm.thisPour > 0.1 and currentTime - fm.lastClick > 10000): # 10 seconds of inactivity causes a tweet
			if kegChanNormal.get_volume() == 1.0:
			    kegChanNormal.set_volume(0.0)
			    kegChanNormal.pause()
			if kegChanOut.get_volume() == 1.0:
			    kegChanOut.set_volume(0.0)
			    kegChanOut.pause()
			if kegChanLow.get_volume() == 1.0:
			    kegChanLow.set_volume(0.0)
			    kegChanLow.pause()
			
			logInfo("Pouring stopped from keg " + str(kegNo))

			logInfo("Updating keg " + str(kegNo) + "!")
			#update DB with level
		
			db=MySQLdb.connect(host="localhost", user=DB_USER, passwd=DB_PASSWORD,db="keezer")
			db.autocommit(True)
			cur = db.cursor()
			
			print "UPDATE Keg SET LastPour='" + str(fm.getRawThisPour()) + "', CurrentLevel='" + str(fm.getCurrentLevel()) + "' WHERE KegID=" + str(kegNo)
			cur.execute("UPDATE Keg SET LastPour='" + str(fm.getRawThisPour()) + "', CurrentLevel='" + str(fm.getCurrentLevel()) + "' WHERE KegID=" + str(kegNo))
			cur.close()
			db.close()

			logInfo("New keg level: " + str(fm.currentLevel))
			logInfo("Update complete!")
			fm.thisPour = 0.0
		elif (fm.thisPour > 0.1 and currentTime - fm.lastClick > 1000): # Turn off sound after 1 second		
			if kegChanNormal.get_volume() == 1.0:
			    kegChanNormal.set_volume(0.0)
			    kegChanNormal.pause()
			if kegChanOut.get_volume() == 1.0:
			    kegChanOut.set_volume(0.0)
			    kegChanOut.pause()
			if kegChanLow.get_volume() == 1.0:
			    kegChanLow.set_volume(0.0)
			    kegChanLow.pause()
			    
		elif fm.thisPour > 0.1:				
			if fm.currentLevel - fm.thisPour <= 0:
				if kegChanOut.get_volume() == 0.0:
					logInfo("Playing out")
					
					if kegChanNormal.get_volume() == 1.0:
					    kegChanNormal.set_volume(0.0)
					    kegChanNormal.pause()
					if kegChanLow.get_volume() == 1.0:
					    kegChanLow.set_volume(0.0)
					    kegChanLow.pause()
					    
					kegChanOut.set_volume(1.0)
					kegChanOut.unpause()
			elif fm.currentLevel - fm.thisPour <= 3:
				if kegChanLow.get_volume() == 0.0:
					logInfo("Playing low")
					if kegChanNormal.get_volume() == 1.0:
					    kegChanNormal.set_volume(0.0)
					    kegChanNormal.pause()
					if kegChanOut.get_volume() == 1.0:
					    kegChanOut.set_volume(0.0)
					    kegChanOut.pause()
					    
					kegChanLow.set_volume(1.0)
					kegChanLow.unpause()
			else:
				if kegChanNormal.get_volume() == 0.0:
					logInfo("Playing normal")
					
					if kegChanOut.get_volume() == 1.0:
					    kegChanOut.set_volume(0.0)
					    kegChanOut.pause()
					if kegChanLow.get_volume() == 1.0:
					    kegChanLow.set_volume(0.0)
					    kegChanLow.pause()
					    
					kegChanNormal.set_volume(1.0)
					kegChanNormal.unpause()

if __name__ == "__main__":
        parser = argparse.ArgumentParser()
        parser.add_argument('keg',type=int)
        parser.add_argument('--verbose', action='store_true')
        args = parser.parse_args()
        kegNo = args.keg

        if args.verbose:
                debug = True
                
        main(kegNo)
