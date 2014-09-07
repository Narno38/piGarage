#!/usr/bin/python
import math
import time
import socket
import Adafruit_CharLCD as LCD

# Initialize the LCD using the pins
lcd = LCD.Adafruit_CharLCDPlate()
lcd.set_color(1.0, 1.0, 1.0)
lcd.clear()

import fcntl
import struct

isLAN = False;

def get_ip_address(ifname):
	s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
	return socket.inet_ntoa(fcntl.ioctl(
		s.fileno(),
		0x8915,  # SIOCGIFADDR
		struct.pack('256s', ifname[:15])
	)[20:24])

try:
	lan_ip = get_ip_address('eth0')
except IOError:
	lan_ip = "Not available"

try:
	wlan_ip = get_ip_address('wlan0')
except IOError:
	wlan_ip = "Not available"

lcd.message('Press SELECT for\nLAN or WLAN IP.')

while True:
	if lcd.is_pressed(LCD.SELECT):
		if not isLAN:
			lcd.set_color(1.0,0.0,0.0)
			lcd.clear()
			lcd.message('LAN IP :\n'+lan_ip)
			isLAN = True
		else:
			lcd.set_color(0.0, 1.0, 0.0)
	                lcd.clear()
        	        lcd.message('WLAN IP:\n'+wlan_ip)
			isLAN = False
	if lcd.is_pressed(LCD.RIGHT):
		lcd.set_color(0.0,0.0,0.0)
		lcd.clear()
