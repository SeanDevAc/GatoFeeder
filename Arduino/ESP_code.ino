
#include <Arduino.h>

#include <WiFi.h>
#include <WiFiMulti.h>

#include <HTTPClient.h>
#include <ezButton.h>


//stepper libary
#include <Stepper.h> 

const int steps_per_rev = 200; //Set to 200 for NIMA 17
#define IN1 14
#define IN2 27
#define IN3 26
#define IN4 25


// initialize the stepper library
Stepper motor(steps_per_rev, IN1, IN2, IN3, IN4);


//gewichtsensor
#include "soc/rtc.h"
#include "HX711.h"

// HX711 circuit wiring.  aanstuurding tussen weegschaal en ESP
 const int LOADCELL_DOUT_PIN_1KG = 16;
 const int LOADCELL_SCK_PIN_1KG = 4;

int old_stock_weight = 0;
int old_tray_weight = 0;

 HX711 scale;

//ezButton button(23);

#define USE_SERIAL Serial

WiFiMulti wifiMulti;





//long start_time=0;
//long REQUEST_INTERVAL_TIME = 1000;

void read_scale() {//voor de setup van de weegschaal. wordt aangeroepen in setup
                      
  Serial.begin(115200);
  Serial.println("HX711 Demo");
  Serial.println("Initializing the scale");

  scale.begin(LOADCELL_DOUT_PIN_1KG, LOADCELL_SCK_PIN_1KG);
  

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
            
  scale.set_scale(-1965);
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

int print_scale_readings() {//geeft de value terug van de weegschaal als int.
   Serial.print("one reading:\t");
   int value = int(scale.get_units());
   Serial.print(value);
   Serial.print("\t| average:\t");
   Serial.println(int(scale.get_units(10)), 5);
   delay(2000);
   return value * 10;
  }



void rotate_stepper_motor() {//stepper motor aansturing

  Serial.println("Rotating Clockwise...");
  motor.step(steps_per_rev);
    
}



void setup() {

    read_scale();//roep scale aan
    
    motor.setSpeed(30);//aantal stappen

    Serial.begin(115200);

 
    
}

void loop() {

  print_scale_readings();
 
  rotate_stepper_motor();

}


