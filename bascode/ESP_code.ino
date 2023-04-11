
#include <Arduino.h>

#include <WiFi.h>
#include <WiFiMulti.h>

#include <HTTPClient.h>
#include <ezButton.h>


//stepper libary
#include <Stepper.h> 

const int stepsPerRevolution = 1000; //snelheid van stepper

// ULN2003 Motor Driver Pins. de aanstuurding tussen ESP en stepper
#define IN1 19
#define IN2 18
#define IN3 5
#define IN4 17

// initialize the stepper library
Stepper myStepper(stepsPerRevolution, IN1, IN3, IN2, IN4);

//gewichtsensor
#include "soc/rtc.h"
#include "HX711.h"

// HX711 circuit wiring.  aanstuurding tussen weegschaal en ESP
 const int LOADCELL_DOUT_PIN = 16;
 const int LOADCELL_SCK_PIN = 4;
 
 HX711 scale;

//ezButton button(23);

#define USE_SERIAL Serial

WiFiMulti wifiMulti;


//const int LED_PIN = 5;
//int led_state = 0;


//long start_time=0;
//long REQUEST_INTERVAL_TIME = 1000;

void read_scale() {//het gewicht uitlezen van de weegsensor. wordt aangeroepen in setup
                      
    USE_SERIAL.begin(115200);
    Serial.begin(115200);
    Serial.println("HX711 Demo");
    Serial.println("Initializing the scale");

    scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);

    Serial.println("Before setting up the scale:");
    Serial.print("read: \t\t");
    Serial.println(scale.read());      // print a raw reading from the ADC

    Serial.print("read average: \t\t");
    Serial.println(scale.read_average(20));   // print the average of 20 readings from the ADC

    Serial.print("get value: \t\t");
    Serial.println(scale.get_value(5));   // print the average of 5 readings from the ADC minus the tare weight (not set yet)

    Serial.print("get units: \t\t");
    Serial.println(scale.get_units(5), 1);  // print the average of 5 readings from the ADC minus tare weight (not set) divided
            // by the SCALE parameter (not set yet)
            
    scale.set_scale(-1965.374);
      //scale.set_scale(-471.497);                      // this value is obtained by calibrating the scale with known weights; see the README for details
    scale.tare();               // reset the scale to 0

    Serial.println("After setting up the scale:");

    Serial.print("read: \t\t");
    Serial.println(scale.read());                 // print a raw reading from the ADC

    Serial.print("read average: \t\t");
    Serial.println(scale.read_average(20));       // print the average of 20 readings from the ADC

    Serial.print("get value: \t\t");
    Serial.println(scale.get_value(5));   // print the average of 5 readings from the ADC minus the tare weight, set with tare()

    Serial.print("get units: \t\t");
    Serial.println(scale.get_units(5), 1);        // print the average of 5 readings from the ADC minus tare weight, divided
            // by the SCALE parameter set with set_scale

    Serial.println("Readings:");
}

void print_scale_readings() {// print de scale readings uit. wordt aangeroepen in loop
   
  Serial.print("one reading:\t");
  Serial.print(scale.get_units(), 1);
  Serial.print("\t| average:\t");
  Serial.println(scale.get_units(10), 5);

  delay(5000);
}

void rotate_stepper_motor(int stepsPerRevolution, int delayTime) {//stepper motor aansturing
  // step one revolution in one direction:
  Serial.println("clockwise");
  myStepper.step(stepsPerRevolution);
  delay(delayTime);

  // step one revolution in the other direction:
  Serial.println("counterclockwise");
  myStepper.step(-stepsPerRevolution);
  delay(delayTime);
}



void get_feed_now_state(){//feed state krijgen denk ik
  
}

void setup() {

    read_scale();//roep scale aan
 
    
    for(uint8_t t = 4; t > 0; t--) {
        USE_SERIAL.printf("[SETUP] WAIT %d...\n", t);
        USE_SERIAL.flush();
        delay(1000);

        // set the speed in rpm. is ook de enige van de stepmotor
        myStepper.setSpeed(10);


    }
}

// dit stuk is voor draadloze verbinding
void initWifi() {//connect met wifi
  if (WiFi.status() != WL_CONNECTED) {
    WiFi.mode(WIFI_STA);
    WiFi.begin("baspi", "banaan");//hier kan je de raspberry pi dingen wijzigen.
    USE_SERIAL.println("trying to connect");
  }
  sleep(100);
  if (WiFi.status() == WL_CONNECTED) {
    USE_SERIAL.print("connected");
    sleep(200);
  }
  USE_SERIAL.print("hoi2");
  return;
}




void loop() {
    // USE_SERIAL.println("");
    // sleep(1000);
    // set_stock_weight(100);
    // initWifi();
    //set_stock_weight_test(100);

  rotate_stepper_motor(2000, 1000);

  print_scale_readings();


}

//vanaf line 177 code om later te toevoegen

  //wifiMulti.addAP("meme_device", "driekeerhoi");
    
    //start_time = millis();
//void set_remote_button(){}


// komt later in gebruik
// void set_stock_weight_test(int weight) {
//   USE_SERIAL.println("stock weight functie gestart");
//   if (WiFi.status() != WL_CONNECTED) {
//     USE_SERIAL.println("not connected, returning");
//     return;
//   }

//   USE_SERIAL.println("connected, continuing");
//   HTTPClient http;
//   http.begin("http://baspi.local/set_stock_weight/" + weight);
//   int httpCode = http.GET();
//   if (httpCode > 0) {
//     USE_SERIAL.println("iets mis");
//     if (httpCode == HTTP_CODE_OK) {
//       String payload = http.getString();
//       USE_SERIAL.println(payload);
//     }
    
//   }
//   http.end();
// }

// komt later in gebruik
// void set_stock_weight(int weight) {
//   USE_SERIAL.println("functie gestart");
//   if(wifiMulti.run() == WL_CONNECTED) {
//     USE_SERIAL.println("wifi is connected") ;
//     HTTPClient http;
//     http.begin("http://baspi.local/set_stock_weight/" + weight);//link gaat hier anders zijn
//     int httpCode = http.GET();
//       if(httpCode > 0) {
//         USE_SERIAL.println("uhh idk iets mis");  
//         if(httpCode == HTTP_CODE_OK) { String payload = http.getString(); }
//       }
//     http.end();
//   }
//   USE_SERIAL.println("wifi is denk ik niet connected");
// }

  //dit stuk hoort bij loop maar was voor nu niet nodig.
    // USE_SERIAL.println("");
    // sleep(1000);
    // set_stock_weight(100);
    // initWifi();
    //set_stock_weight_test(100);


