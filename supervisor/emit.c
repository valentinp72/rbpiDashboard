#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <wiringPi.h>

// Hard-coded RF signals
// You can use Arduino/RF_Sniffer to find theses values
#include "devices_data.h"

#define PIN_TX      23 // PIN of the transmitter
#define DEVICES_NB   8 // Number of devices (x2, for 1 device, there is actually 2 codes)
#define TIME_DELAY 105 // Delay between each upate state of the transmitter
#define DATA_SIZE  125 // Size of the data

typedef char byte;

typedef struct {
	char * name;
	byte code[DATA_SIZE];
} Devices;

// Table of bytes, that correspond to MCE07G electrical outlets
// You can get theses values with RF_Sniffer.ino
// Each device name must start with "OUTLET_"
const Devices devices[DEVICES_NB] = {
	{
		"OUTLET_1_ON",
		{4,3,3,4,29,30,3,3,3,11,3,11,3,10,3,4,3,11,3,10,3,4,3,4,3,10,3,4,3,3,3,4,3,3,3,4,3,4,3,10,3,4,3,3,3,4,3,11,2,4,3,3,3,12,2,11,3,4,3,10,3,11,3,11,3,11,3,10,3,11,3,11,3,4,3,3,3,4,3,3,3,11,3,11,3,10,3,181,3,3,3,4,29,30,3,3,3,11,3,11,3,10,3,4,3,11,3,10,3,4,3,4,3,10,3,4,3,3,3,4,3,3,3,4,3}
	},
	{
		"OUTLET_1_OFF",
		{4,3,3,3,30,29,3,4,3,11,3,10,3,11,3,3,4,10,3,11,3,4,3,3,3,11,3,3,3,4,3,3,3,4,3,3,3,4,3,11,3,3,3,4,3,3,3,11,3,4,3,3,3,11,3,11,3,3,3,11,3,11,3,11,3,10,3,11,3,11,3,4,3,10,3,11,3,11,3,11,3,3,3,3,3,4,3,181,3,3,3,3,29,30,3,4,3,10,3,11,3,11,3,3,3,11,3,11,3,4,3,3,3,11,3,3,3,4,3,3,3,4,3,3,3}
	},

	{
		"OUTLET_2_ON",
		{4,3,3,3,30,29,3,4,3,11,3,10,3,11,3,4,3,10,3,11,3,4,3,3,3,11,3,4,3,3,3,4,2,4,3,3,3,4,3,11,3,4,3,3,3,4,3,10,3,4,3,3,3,11,3,11,3,3,3,11,3,11,3,11,3,10,3,11,3,11,3,4,3,10,3,4,3,3,3,11,3,4,3,10,3,11,3,181,3,3,3,3,30,29,3,4,3,11,3,10,3,11,3,4,3,10,3,11,3,4,3,3,3,11,3,4,3,3,3,4,3,3,3,4,2}
	},
	{
		"OUTLET_2_OFF",
		{4,3,3,3,29,30,3,3,3,11,3,11,3,11,3,3,3,11,3,11,3,3,3,4,3,11,3,3,3,4,3,3,3,4,3,3,3,4,3,11,3,3,3,4,3,3,3,11,3,3,3,4,3,11,3,11,3,3,3,11,3,11,3,10,3,11,3,11,3,11,3,11,3,3,3,11,3,11,2,4,3,11,3,3,3,4,3,181,3,3,3,3,29,30,3,3,3,11,3,11,3,11,3,3,3,11,3,11,3,3,3,4,3,11,3,3,3,4,3,3,3,4,3,3,3}
	},

	{
		"OUTLET_3_ON",
		{4,3,3,3,29,30,3,4,3,10,3,11,3,11,3,3,3,11,3,11,3,3,3,4,3,11,3,3,3,4,2,4,3,4,2,4,3,4,3,11,3,3,3,3,3,4,3,11,3,3,3,4,3,11,3,10,3,4,3,11,3,10,3,11,3,11,3,11,2,12,2,11,3,11,3,3,3,4,3,3,3,4,3,11,3,10,3,181,3,3,3,3,30,29,3,4,3,11,3,10,3,11,3,4,2,11,3,11,3,4,3,3,3,11,3,3,3,4,3,3,3,4,3,3,3}
	},
	{
		"OUTLET_3_OFF",
		{4,3,3,3,30,29,3,4,3,11,2,11,3,11,3,3,3,11,3,11,3,4,3,3,3,11,3,3,3,4,3,3,3,4,3,3,3,4,3,11,3,3,3,4,3,3,3,11,3,4,2,4,3,11,3,11,3,3,3,11,3,11,3,10,3,11,3,11,3,11,3,3,3,4,3,11,2,11,3,11,3,11,3,3,3,4,3,180,3,4,3,3,29,30,3,3,3,11,3,11,3,10,3,4,3,11,3,10,3,4,3,4,2,11,3,4,3,3,3,4,3,3,3,4,3}
	},

	{
		"OUTLET_4_ON",
		{4,3,3,4,29,30,3,3,3,11,3,11,3,10,3,4,3,10,3,11,3,4,3,3,3,11,3,4,3,3,3,4,3,3,3,4,3,3,3,11,3,4,3,3,3,4,3,10,3,4,3,3,3,11,3,11,3,4,2,11,3,11,3,11,3,10,3,11,3,11,3,4,3,3,3,11,3,3,3,11,3,11,3,3,3,11,3,181,3,3,3,3,29,30,3,4,3,11,2,11,3,11,3,3,3,11,3,11,3,4,3,3,3,11,3,3,3,4,3,3,3,4,3,3,3}
	},
	{
		"OUTLET_4_OFF",
		{4,3,3,3,29,30,3,4,3,10,3,11,3,11,3,3,3,11,3,11,3,3,3,4,3,11,3,3,3,4,3,3,3,4,3,3,3,4,3,11,3,3,3,4,3,3,3,11,3,3,3,4,3,11,3,11,3,3,3,11,3,11,2,11,3,11,3,11,3,11,3,11,2,11,3,4,3,10,3,4,3,3,3,11,3,4,3,180,3,4,3,3,29,30,3,3,3,11,3,11,3,10,3,4,3,11,3,10,3,4,3,4,3,10,3,4,3,3,3,4,3,3,3,4,3}
	}
};


// Send a signal
void sendSignal(int pin, byte data[]){
	int i;

	printf("Sending a signal...");

	for(i = 0 ; i < DATA_SIZE ; i = i + 2){

		//Send HIGH signal
		digitalWrite(pin, HIGH);
		delayMicroseconds(data[i] * TIME_DELAY);

		//Send LOW signal
		digitalWrite(pin, LOW);
		delayMicroseconds(data[i + 1] * TIME_DELAY);

	}

	printf("Done!\n");

}

// This function checks for hard-coded devices
void checkForHardCoded(int pin, byte code[]){
	int i;
	code += 7; // we already checked the first 7 characters

	for(i = 0 ; i < DEVICES_NB ; i++){
		// We found the device in the list
		if(strcmp(code, devices[i].name) == 0){
			sendSignal(pin, devices[i].code);
			return;
		}
	}
}

void usage(char * name){
	printf("Usage : %s <RF Code>\n", name);
}

int main(int argc, char * argv[]){

	if(argc != 2){
		usage(argv[0]);
		exit(1);
	}

	char * code = argv[1];

	wiringPiSetupGpio();
	pinMode(PIN_TX, OUTPUT);

	// All the devices that are hard-coded needs to start with OUTLET_
	if(strncmp(code, "OUTLET_", 7) == 0)
		checkForHardCoded(PIN_TX, code);
	else
		sendSignal(PIN_TX, code);


}
