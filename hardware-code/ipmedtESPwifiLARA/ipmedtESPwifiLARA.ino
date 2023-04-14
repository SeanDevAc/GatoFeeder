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

const int BUTTON_PIN = 23;

#define IN1 14
#define IN2 27
#define IN3 26
#define IN4 25

const int stepsPerRevolution = 100;
Stepper motor(stepsPerRevolution, IN1, IN3, IN2, IN4);

const int LOADCELL_DOUT_PIN = 16;
const int LOADCELL_SCK_PIN = 4;
HX711 scale;

const int WEIGHT_CHANGE = 10;
int old_stock_weight = 0;
int old_tray_weight = 0;

void setup() {
  Serial.begin(115200);
  Serial.println("setup started..");
  init_scale();
  init_stepper_motor();
  delay(1000);
  
  //button.setDebounceTime(50);
  pinMode(BUTTON_PIN, INPUT_PULLUP);

  while (WiFi.status() != WL_CONNECTED){
    init_wifi();
  }
}

void init_scale() {
  scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);
  // scale.read(); //raw readings van load cell
  // scale.read_average(20); // avg van 20 readings
  // scale.get_value(5);
  // scale.get_units(5);
  scale.set_scale(-1965);
  scale.tare();
}

int return_scale_read_ten() {
  float value = scale.get_units();
  value = int(value*10);
  return value;
}

void init_stepper_motor() {
  motor.setSpeed(30);
}

void rotate_stepper_motor(int rotations) {
  //motor.setSpeed(30);
  //motor.step(rotations * stepsPerRevolution);
  motor.step(200);
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

int check_food_state() { //of er food gegeven moet worden. returnt 1 of 0
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

void set_food_now() {
  Serial.println("setting food now on server");
  HTTPClient http;
  http.begin("http://willempi.local/food_now_true");
  int httpCode = http.GET();
  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) {
      Serial.println("yeah it worked");
    }
  } else {
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }
  http.end();
}

int set_food_is_given() { // om food flag uit te zetten op de server
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

void set_stock_weight(int weight) { // om stock gewicht te uploaden op de server
  Serial.println("setting stock weight on server");
  WiFiClient client;
  HTTPClient http;
  http.begin(client, "http://willempi.local/set_stock_weight");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // de http POST header
  String httpRequestData = "stock_weight=" + String(weight); // de daadwerkelijke data
  int httpResponseCode = http.POST(httpRequestData);  
  Serial.print("HTTP Response code: "); // debugging porpoises; returnt gelukkig altijd 200 OK
  Serial.println(httpResponseCode);
  http.end();
}

void set_tray_weight(int weight) { // om tray gewicht te uploaden op de server
  Serial.println("setting tray weight on server");
  WiFiClient client;
  HTTPClient http;
  http.begin(client, "http://willempi.local/set_tray_weight");
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
  Serial.println("getting stock weight from sensor: ");
  int stock_weight = 0; 
  stock_weight = return_scale_read_ten();
  Serial.println(stock_weight);
  return stock_weight;
}

bool stock_weight_changed_enough(int new_weight) { //of de stock_weight genoeg is veranderd om te updaten
  //return (abs(old_stock_weight-new_weight)<5); 
  if (abs(old_stock_weight - new_weight) < WEIGHT_CHANGE) {
    Serial.println("weight change insignificant");
    old_stock_weight = new_weight;
    return false;
  } // if change is bigger than 5: 
  old_stock_weight = new_weight;
  return true;
}

bool tray_weight_changed_enough() { //todo
  return true;
}

void conditional_update_stock_weight(){
  if (stock_weight_changed_enough(get_stock_weight())) {
    Serial.println("stock weight changed, updating server");
    set_stock_weight(get_stock_weight());
  }
}

void conditional_update_tray_weight(){
  if (tray_weight_changed_enough()) {
    Serial.println("tray weight changed, updating server");
  }
}

void give_food(int weight) {
  //iets met motor bewegen
  rotate_stepper_motor(weight/10);
  Serial.print("giving food: ");
  Serial.println(weight);
}

void check_and_give_food() {
  if (!check_food_state()) {
    Serial.println("no food");
    return;
  }
  Serial.println("food time");
  give_food(get_food_amount());
  set_food_is_given();
}

int buttonState() {
  return !digitalRead(BUTTON_PIN);
}

void mainflow() {
  int msecondsPassed = 0;
  while ( msecondsPassed<3000 && !buttonState()) {
    //this code while waiting on 30 seconds or button press
    if (msecondsPassed%300==0) {Serial.print(".");}
    delay(10);
    msecondsPassed+= 1;
  }
  if (buttonState()) { // if button is pressed
    Serial.println("button pressed");
    set_food_now();
    delay(1000);
  }
  Serial.println("okay letsgo");
  // if button is pressed or 30 seconds have passed
  check_and_give_food();
  delay(100);
  conditional_update_stock_weight();
  delay(100);
  //conditional_update_tray_weight();
  //delay(100);
}

void loop() {
  mainflow();

}
