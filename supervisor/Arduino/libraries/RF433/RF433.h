/*
	433 MHz RF REMOTE REPLAY sketch
		Written by ScottC 24 Jul 2014
		Arduino IDE version 1.0.5
		Website: http://arduinobasics.blogspot.com
		Receiver: XY-MK-5V      Transmitter: FS1000A/XY-FST
		Description: Use Arduino to receive and transmit RF Remote signal

		Edited by Valentin Pelloin (@valentinp72) for
		https://github.com/valentinp72/rbpiDashboard/
 */

#ifndef	RF433_H
#define RF433_H

#include "Arduino.h"

void initData();
void listenForSignal(int rfReceivePin);
void listenForSignal(int rfReceivePin);
void sendSignal(int rfTransmitPin);
void sendSignal(int rfTransmitPin, byte storedData[]);
void printData();

#endif
