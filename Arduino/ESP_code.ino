//Moet nog kijken voor de juiste code van Sep

#include <Arduino.h>

#include <WiFi.h>
#include <WiFiMulti.h>

#include <HTTPClient.h>
#include <ezButton.h>

//gewichtsensor
#include "soc/rtc.h"
#include "HX711.h"

// HX711 circuit wiring.  kan aangepast worden
const int LOADCELL_DOUT_PIN = 16;
const int LOADCELL_SCK_PIN = 4;
HX711 scale;

//ezButton button(23);

#define USE_SERIAL Serial

WiFiMulti wifiMulti;
//stepmotor libary
#include <Stepper.h>

//const int LED_PIN = 5;
//int led_state = 0;


//long start_time=0;
//long REQUEST_INTERVAL_TIME = 1000;

void read_weight() {//iets met gewicht readen
   // deze functie kan denk iets met combineren met set_stock_weight()
}

void send_weight() {//iets met gewicht zenden

}

void get_feed_now_state(){//feed state krijgen
  
}

// void bool update_needed(){ // iets met update. heb van bord. moet nog af gemaakt worden
//   if(changeInTroyWeight > 5){
//     return true;
//   } 
//}



const int STEPS_PER_REVOLUTION = 200;
Stepper stepper(STEPS_PER_REVOLUTION, 8, 9, 10, 11); //initialize stepper motor with specific pins

void rotate_stepper(int num_steps, bool direction) {
  if(direction) { //if true, rotate clockwise
    stepper.setSpeed(60); //set motor speed in RPM
    stepper.step(num_steps);
  }
  else { //if false, rotate counterclockwise
    stepper.setSpeed(60);
    stepper.step(-num_steps);
  }
}


void setup() {

    USE_SERIAL.begin(115200);

   //button.setDebounceTime(100);

   //gewichtsensor
    //  rtc_clk_cpu_freq_set(RTC_CPU_FREQ_80M);
    //  scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);


    //pinMode(LED_PIN, OUTPUT);
    //digitalWrite(LED_PIN, 0);
    
    for(uint8_t t = 4; t > 0; t--) {
        USE_SERIAL.printf("[SETUP] WAIT %d...\n", t);
        USE_SERIAL.flush();
        delay(1000);
    }

  //wifiMulti.addAP("meme_device", "driekeerhoi");
    
    //start_time = millis();
}


void initWifi() {//connect met wifi
  if (WiFi.status() != WL_CONNECTED) {
    WiFi.mode(WIFI_STA);
    WiFi.begin("baspi", "banaan");//verander nog deze onderdeel
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

void set_stock_weight_test(int weight) {
  USE_SERIAL.println("stock weight functie gestart");
  if (WiFi.status() != WL_CONNECTED) {
    USE_SERIAL.println("not connected, returning");
    return;
  }

  USE_SERIAL.println("connected, continuing");
  HTTPClient http;
  http.begin("http://baspi.local/set_stock_weight/" + weight);
  int httpCode = http.GET();
  if (httpCode > 0) {
    USE_SERIAL.println("iets mis");
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      USE_SERIAL.println(payload);
    }
    
  }
  http.end();
}

void set_stock_weight(int weight) {
  USE_SERIAL.println("functie gestart");
  if(wifiMulti.run() == WL_CONNECTED) {
    USE_SERIAL.println("wifi is connected") ;
    HTTPClient http;
    http.begin("http://baspi.local/set_stock_weight/" + weight);//link gaat hier anders zijn
    int httpCode = http.GET();
      if(httpCode > 0) {
        USE_SERIAL.println("uhh idk iets mis");  
        if(httpCode == HTTP_CODE_OK) { String payload = http.getString(); }
      }
    http.end();
  }
  USE_SERIAL.println("wifi is denk ik niet connected");
}

void loop() {//hier kunnen de funciets starten
    // USE_SERIAL.println("");
    // sleep(1000);
    // set_stock_weight(100);
    initWifi();
    set_stock_weight_test(100);
}

//void set_remote_button(){}




