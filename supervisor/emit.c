#include <stdio.h>
#include <stdbool.h>
#include <wiringPi.h>

#define PIN_LED 23

int main(){

	wiringPiSetupGpio();

	pinMode(PIN_LED, OUTPUT);

//	while(true){
//		digitalWrite(PIN_LED, HIGH);
//		delay(50);
//		digitalWrite(PIN_LED, LOW);
//		delay(50);
//	}

}
