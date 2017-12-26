/*
	This program allow you to sniff RF codes for each outlets
		=> designed for Maclean Energy MCE07G
	You need a receiver and transmitter connected to RX and TX (see below)

	All devices RF Codes need to be stored into devices_data.h

	Your serial monitor need to be
		- on "Carriage Return" ("Retour chariot" in French)
		- with 9600 Bd

	Adapted from https://github.com/bcsedlon/growmat-easy     @bcsedlon
	Adapted for  https://github.com/valentinp72/rbpiDashboard @valentinp72

	LICENSE: GPL-3.0 (https://github.com/valentinp72/rbpiDashboard/blob/master/LICENSE)
*/

#include <RF433.h>         // Library by http://arduinobasics.blogspot.com
#include <SerialCommand.h> // Library by https://github.com/scogswell/ArduinoSerialCommand

#include "devices_data.h"

#define RX  2 /*    Receiver pin */
#define TX  5 /* Transmitter pin */

SerialCommand SCmd;

/* ------------ */
/* MAIN PROGRAM */
/* ------------ */

void setup(){

	// Begin serial monitor
	Serial.begin(9600);

	// Add all commands to SerialCommand
	SCmd.addCommand("r",   SCmd_CodeReceive);
	SCmd.addCommand("s",      SCmd_CodeSend);
	SCmd.addCommand("1+",  SCmd_CodeSend1On);
	SCmd.addCommand("1-", SCmd_CodeSend1Off);
	SCmd.addCommand("2+",  SCmd_CodeSend2On);
	SCmd.addCommand("2-", SCmd_CodeSend2Off);
	SCmd.addCommand("3+",  SCmd_CodeSend3On);
	SCmd.addCommand("3-", SCmd_CodeSend3Off);
	SCmd.addCommand("4+",  SCmd_CodeSend4On);
	SCmd.addCommand("4-", SCmd_CodeSend4Off);

  SCmd.addCommand("h",          SCmd_Help);
	SCmd.addDefaultHandler(SCmd_Unrecognized);

	// Print help
	SCmd_Help();
	Serial.println();

}

void loop(){

	SCmd.readSerial();

}

/* ----------------------------------------- */
/* FUNCTIONS FOR SENDING AND RECEIVING CODES */
/* ----------------------------------------- */

void SCmd_CodeReceive(){
	initData();
	listenForSignal(RX);
	printData();
	Serial.println(F("Done."));
}

void SCmd_CodeSend1On(){
	sendSignal(TX, device_1_ON);
	Serial.println(F("Sent 1 ON"));
}

void SCmd_CodeSend1Off(){
	sendSignal(TX, device_1_OFF);
	Serial.println(F("Sent 1 OFF"));
}

void SCmd_CodeSend2On(){
	sendSignal(TX, device_2_ON);
	Serial.println(F("Sent 2 ON"));
}

void SCmd_CodeSend2Off(){
	sendSignal(TX, device_2_OFF);
	Serial.println(F("Sent 2 OFF"));
}

void SCmd_CodeSend3On(){
	sendSignal(TX, device_3_ON);
	Serial.println(F("Sent 3 ON"));
}

void SCmd_CodeSend3Off(){
	sendSignal(TX, device_3_OFF);
	Serial.println(F("Sent 3 OFF"));
}

void SCmd_CodeSend4On(){
	sendSignal(TX, device_4_ON);
	Serial.println(F("Sent 4 ON"));
}

void SCmd_CodeSend4Off(){
	sendSignal(TX, device_4_OFF);
	Serial.println(F("Sent 4 OFF"));
}

void SCmd_CodeSend(){
	sendSignal(TX);
	Serial.println(F("Sent last recieved code."));
}

void SCmd_Unrecognized(){
	Serial.println(F("Unknown command or too long command line."));
	SCmd_Help();
}

// Display help
void SCmd_Help() {
	char * arg;

	arg = SCmd.next();
	if(arg == NULL){

		Serial.println();

		Serial.print(F("Available commands are :\r\n"\
		               "  h\t This screen, some help and status.\n\r"\
		               "  r\t Sniff code (press original remote control button before).\n\r"\
		               "  s\t Sends last sniffed code.\r\n"\
		               "  1+\t 1 ON\r\n"\
		               "  1-\t 1 OFF\r\n"\
		               "  2+\t 2 ON\r\n"\
		               "  2-\t 2 OFF\r\n"\
		               "  3+\t 3 ON\r\n"\
		               "  3-\t 3 OFF\r\n"\
		               "  4+\t 4 ON\r\n"\
		               "  4-\t 4 OFF\r\n\n"));
	}
	else
		Serial.println(F("Only one argument required."));

}
