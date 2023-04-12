#include <Arduino.h>

#include <WiFi.h>
#include <WiFiMulti.h>

#include <HTTPClient.h>

#include <ezButton.h>

#include <Stepper.h>
#include "soc/rtc.h"
#include "HX711.h"

WiFiMulti wifiMulti;

const char* ssid = "meme-master";
const char* password = "driekeerhoi";

const int stepsPerRevolution = 1000;
#define IN1 19
#define IN2 18
#define IN3 5
#define IN4 17

Stepper myStepper(stepsPerRevolution, IN1, IN3, IN2, IN4);

const int LOADCELL_DOUT_PIN = 16;
const int LOADCELL_SCK_PIN = 4;
HX711 scale;

int old_stock_weight = 0;
int old_tray_weight = 0;

void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);

  Serial.println("setup started..");
  delay(1000);

  while (WiFi.status() != WL_CONNECTED){
    init_wifi();
  }

}

void init_wifi () {
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.println("connecting to wifi..");
  int i = 0;
  while ((WiFi.status() != WL_CONNECTED) && (i<20)) { //while NOT connected for 20 seconds
    Serial.print(".");
    delay(1000);
    i++;
  }
  Serial.println(WiFi.localIP());
}

int check_food_state() { //of er food gegeven moet worden. werkt
  Serial.println("checking food state on server");
  int food_state = 0;
  HTTPClient http;
  http.begin("http://willempi.local/check_food_state");
  int httpCode = http.GET();
  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      food_state = payload.toInt();
      
    }
  } else {
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }
  http.end();
  return food_state;
}

int set_food_is_given() { // om food flag uit te zetten. werkt
  Serial.println("setting food flag on server to false");
  int food_now_state = 0;
  HTTPClient http;
  http.begin("http://willempi.local/food_is_given");
  int httpCode = http.GET();
  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      food_now_state = payload.toInt();
    }
  } else {
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }
  http.end();
  return food_now_state;
}

void set_stock_weight(int weight) { // om stock gewicht te uploaden. werkt
  Serial.println("setting stock weight on server");
  WiFiClient client;
  HTTPClient http;
  http.begin(client, "http://willempi.local/set_stock_weight");
  // http.begin(client, websiteUrl + "set_stock_weight");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  String httpRequestData = "stock_weight=" + String(weight);
  int httpResponseCode = http.POST(httpRequestData);  
  Serial.print("HTTP Response code: ");
  Serial.println(httpResponseCode);
  http.end();
}

void set_tray_weight(int weight) { // om tray gewicht te uploaden.werkt
  Serial.println("setting tray weight on server");
  WiFiClient client;
  HTTPClient http;
  http.begin(client, "http://willempi.local/set_tray_weight");
  // http.begin(client, websiteUrl + "set_stock_weight");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  String httpRequestData = "tray_weight=" + String(weight);
  int httpResponseCode = http.POST(httpRequestData);  
  Serial.print("HTTP Response code: ");
  Serial.println(httpResponseCode);
  http.end();
}

int get_food_amount() { //hoeveel eten geven
  Serial.println("checking how much food from server");
  HTTPClient http;
  http.begin("http://willempi.local/check_food_amount");
  int httpCode = http.GET();
  String payload = http.getString();
  int food_amount = payload.toInt();
  http.end();
  return food_amount;
}

int get_stock_weight() {
  Serial.println("getting stock weight from sensor");
  int stock_weight = 0; 
  // todo, iets met weight sensor
  return stock_weight;
}

bool stock_weight_changed_enough() { //of de stock_weight genoeg is veranderd om te updaten
  bool stock_weight_changed = true;
  int old_stock_weight;
  

  //todo
  return stock_weight_changed;
}

bool tray_weight_changed_enough() {

}

void conditional_update_stock_weight(){
  if (stock_weight_changed_enough()) {
    Serial.println("stock weight changed, updating server");
    set_stock_weight(get_stock_weight());
  }
}

void conditional_update_tray_weight(){
  if (tray_weight_changed_enough()) {
    Serial.println("tray weight changed, updating server");
  }
}

void rotate_stepper_motor(int stepsPerRevolution, int delayTime) {
  myStepper.step(stepsPerRevolution);
  delay(delayTime);
}

void give_food(int weight) {
  //iets met motor bewegen
  Serial.print("giving food: ");
  Serial.println(weight);
}

void loop() {

  
  delay(3000);

  Serial.println(get_food_amount());

  // conditional_update_stock_weight();
  // delay(50);
  // conditional_update_tray_weight(); //todo
  // delay(50);
  
  // if (check_food_state()) { //if server food flag
  //   delay(10);
  //   give_food(get_food_amount());
  //   delay(10);
  //   set_food_is_given();
  // }
  delay(5000);
}
