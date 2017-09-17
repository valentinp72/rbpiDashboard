#include <RCSwitch.h>

RCSwitch mySwitch = RCSwitch();

void setup() {
  Serial.begin(9600);
  mySwitch.enableReceive(0);  // Receiver on inerrupt 0 => that is pin #2
  Serial.println("We are ready");
}

void loop() {
  if (mySwitch.available()) {
    
    int value = mySwitch.getReceivedValue();
    
    if (value == 0) {
      Serial.print("Unknown encoding");
    } else {
      
      char code[50];
      itoa(mySwitch.getReceivedValue(), code, 10);
      Serial.println(code);

      if(code[0] == '1' && strlen(code) == 6){
        Serial.println("It's for me!");
      }
      else {
        Serial.println("Not for me");
      }
       Serial.println(strlen(code));
       Serial.println(code[0]);

    }

    mySwitch.resetAvailable();
  }
}
