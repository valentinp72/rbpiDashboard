#include "RF433.h"

const int dataSize = 125;           //Arduino memory is limited (max=1700)
byte storedData[dataSize + 1];      //Create an array to store the data
const unsigned int threshold = 100; //signal threshold value
int maxSignalLength = 255;          //Set the maximum length of the signal
int dataCounter = 0;                //Variable to measure the length of the signal
int timeDelay = 105;                //Used to slow down the signal transmission (can be from 75 - 135)

// Send the last signal
void sendSignal(int rfTransmitPin){
	sendSignal(rfTransmitPin, storedData);
}

// Send a signal
void sendSignal(int rfTransmitPin, byte storedData[]){
	int i;

	pinMode(rfTransmitPin, OUTPUT);

	for(i = 0 ; i < dataSize ; i = i + 2){

		//Send HIGH signal
		digitalWrite(rfTransmitPin, HIGH);
		delayMicroseconds(storedData[i] * timeDelay);
		//Send LOW signal
		digitalWrite(rfTransmitPin, LOW);
		delayMicroseconds(storedData[i + 1] * timeDelay);

	}

}

// Listen for a signal
void listenForSignal(int rfReceivePin){

	int i;

	//Wait here until an RF signal is received
	while(analogRead(rfReceivePin) < threshold);

	//Read and store the rest of the signal into the storedData array
	for(i = 0 ; i < dataSize ; i = i + 2){

		//Identify the length of the HIGH signal

		dataCounter = 0; //reset the counter
		while(analogRead(rfReceivePin) > threshold && dataCounter < maxSignalLength)
			dataCounter++;

		storedData[i] = dataCounter; //Store the length of the HIGH signal


		//Identify the length of the LOW signal

		dataCounter = 0; //reset the counter
		while(analogRead(rfReceivePin) < threshold && dataCounter < maxSignalLength)
			dataCounter++;

		storedData[i + 1] = dataCounter; //Store the length of the LOW signal
	}

	storedData[0]++; //Account for the first AnalogRead>threshold = lost while listening for signal

}

void initData(){
	int i;
	for(i = 0 ; i < dataSize ; i++)
		storedData[i] = 0;
}

void printData() {
	int i;
	for(i = 0 ; i < dataSize - 1 ; i++){
		Serial.print(storedData[i]);
		Serial.print(",");
	}
	Serial.print(storedData[i]);

	Serial.println();
}
