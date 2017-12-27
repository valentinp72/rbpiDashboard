#include <stdio.h>
#include <stdbool.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <wiringPi.h>

// Hard-coded RF signals
// You can use Arduino/RF_Sniffer to find theses values
#include "devices_data.h"
#include "RCSwitch.h"

#define FILE_LOCK_R "/tmp/emit_c.lock"
#define PIN_TX         23 // PIN of the transmitter
#define DEVICES_NB      8 // Number of devices (x2, for 1 device, there is actually 2 codes)
#define PREFIX_SIZE     7 // Size of the default prefix for hard-coded devices (OUTLET_)
#define TIME_DELAY    105 // Delay between each upate state of the transmitter
#define DATA_SIZE     125 // Size of the data
#define SEND_REPEAT    10 // As we cannot know if the message was received, we send it multiple time
#define TIME_BTWM_SNDS 75 // Delay between each send of messages (in microseconds) 

typedef char byte;

typedef struct {
	char * name;
	byte code[DATA_SIZE];
} Devices;

// Table of bytes, that correspond to MCE07G electrical outlets
// You can get theses values with RF_Sniffer.ino
// Each device name must start with "OUTLET_" (size of PREFIX_SIZE)
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

// Send a signal (using rc-switch)
int codesend(int pin, const byte data[]) {

    int code = atoi(data);

    printf("Sending code: %i\n", code);
    RCSwitch mySwitch = RCSwitch();
    mySwitch.enableTransmit(pin);

    mySwitch.send(code, 24);

    return 0;

}

// Send a signal (low-level library)
void sendSignal(int pin, const byte data[]){
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

// We send multiple times the same signal because we don't know if it was received
void sendSignalR(int pin, const byte data[]){
	int i;
	for(i = 0 ; i < SEND_REPEAT ; i++) {
		sendSignal(pin, data);
		delayMicroseconds(TIME_BTWM_SNDS);
	}	
}

// This function checks for hard-coded devices
void checkForHardCoded(int pin, const byte code[]){
	int i;
	code += PREFIX_SIZE; // we already checked the first 7 characters

	printf("We are checking for an hard-coded device called %s...", code);
	for(i = 0 ; i < DEVICES_NB ; i++){
		// We found the device in the list
		if(strcmp(code, devices[i].name + PREFIX_SIZE) == 0){
			printf("Found!\n");
			sendSignalR(pin, devices[i].code);
			return;
		}
	}
	printf("Not found!\n");
}

void usage(char * name){
	printf("Usage : %s <RF Code>\n", name);
}


int lockFile = -1;

void setRunning(bool state){

	if(lockFile < 0){
		printf("Error: lockfile doesn't exist!\n");
		exit(-1);	
	}

	if(state == true)
		lockf(lockFile, F_LOCK, 0);  // lock the file, blocking, if the file is already locked, it will wait to be unlocked
	else
		lockf(lockFile, F_ULOCK, 0); // unlock the file

}



int main(int argc, char * argv[]){

	if(argc != 2){
		usage(argv[0]);
		exit(1);
	}

	char * code = argv[1];

	// Open a lock file to prevent multiple executions of this program in the same time
	lockFile = open(FILE_LOCK_R, O_WRONLY | O_CREAT);	
	// This function is blocking, it will unblock only when the other same program will stop
	setRunning(true);


	wiringPiSetupGpio();
	pinMode(PIN_TX, OUTPUT);

	// All the devices that are hard-coded needs to start with OUTLET_
	if(strncmp(code, "OUTLET_", 7) == 0)
		checkForHardCoded(PIN_TX, code);
	else
		codesend(PIN_TX, code);	
	//sendSignalR(PIN_TX, code);


	setRunning(false); // stop here
	close(lockFile);

}
