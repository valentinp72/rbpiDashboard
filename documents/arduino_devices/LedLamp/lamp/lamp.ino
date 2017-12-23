#include <RCSwitch.h>           // https://github.com/sui77/rc-switch
#include <PinChangeInterrupt.h> // https://github.com/NicoHood/PinChangeInterrupt

#include <EEPROM.h>             // https://www.arduino.cc/en/Reference/EEPROM


#define PIN_RECEPTEUR 2 // pin utilisé pour le recepteur : doit être un pin interruptible
#define PIN_RUBAN     3 // pin du transistor du ruban
#define PIN_BUTTON    4 // le pin utilisé pour le bouton pour forcer le toggle

#define TEMPS_STEP  5   // temps entre chaque pas du changement de la luminosité, en ms
#define ADRESSE_MEM 0   // l'adresse en memoire EEPROM de l'état du ruban

RCSwitch mySwitch = RCSwitch();

float currentState = 0.0;


void setup() {
  Serial.begin(9600);
  
  mySwitch.enableReceive(digitalPinToInterrupt(PIN_RECEPTEUR));
  
  pinMode(PIN_RUBAN,  OUTPUT);
  pinMode(PIN_BUTTON, INPUT_PULLUP);

  // utilisation de la librairie PinChangeInterrupt pour l'interruption
  // par le bouton : il aurait simplement fallu souder le bouton sur un
  // pin interruptible ...
  // https://github.com/NicoHood/PinChangeInterrupt
  attachPCINT(digitalPinToPCINT(PIN_BUTTON), interruptButtonForce, RISING);
  
  EEPROM.get(ADRESSE_MEM, currentState);
  if(currentState < 0 || currentState > 255)
    currentState = 0;
  analogWrite(PIN_RUBAN, currentState);
  
  TCCR1B = TCCR1B & 0b11111000 | 0x02;
}

void interruptButtonForce() {
  if(currentState == 0)
    currentState = 255;
  else
    currentState = 0;
    
  analogWrite(PIN_RUBAN, currentState);
  EEPROM.put(ADRESSE_MEM, currentState);

  // reset to main loop
  asm volatile ("  jmp 0"); 
}

void loop() {

  if (mySwitch.available()) {
    
    int value = mySwitch.getReceivedValue();
    
    if (value == 0) {
      Serial.print("Unknown encoding");
    } else {
      
      String code = String(mySwitch.getReceivedValue());
      
      if(code[0] == '1' && code.length() == 6){
        int toState  = code.substring(1, 4).toInt();
        int timeToGo = code.substring(4, 6).toInt();

        if(toState >= 0 && toState <= 255 && timeToGo >= 0 && timeToGo <= 99) {

          Serial.println("To do : ");
          Serial.print("Actual: ");
          Serial.println(currentState);
          Serial.print("Want: ");
          Serial.println(toState);
          Serial.print("In seconds: ");
          Serial.println(timeToGo);            

          int i;
          int steps = toState - currentState;
          int maxSteps = timeToGo * (1000 / TEMPS_STEP);
          float stepValue = steps / (maxSteps * 1.0);
          
          for(i = 0 ; i < maxSteps ; i++) {
            currentState += stepValue;
            analogWrite(PIN_RUBAN, currentState);
            delay(TEMPS_STEP);
          }

          currentState = toState;
          analogWrite(PIN_RUBAN, currentState);
          EEPROM.put(ADRESSE_MEM, currentState);

          Serial.println("");

        }
        else {
          Serial.println("Invalide state / time");
        }

      }
      else {
        Serial.println("Not for me");
      }

    }

    mySwitch.resetAvailable();
  }
  delay(100);
}


