#include <Arduino.h>

#include <WiFi.h>
#include <WiFiMulti.h>

#include <HTTPClient.h>

#include <ezButton.h>

WiFiMulti wifiMulti;


const char* ssid = "meme-device";
const char* password = "driekeerhoi";

//int food_now_state = 0; //de int om de state te veranderen
//int food_state = 0; // de int voor het checken van de state

void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);

  Serial.println("setup started..");
  delay(1000);
  //init wifi
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("connecting to wifi..");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(1000);
  }
  Serial.println(WiFi.localIP());
  
}

int check_food_state() {
  int food_state = 0;
  HTTPClient http;
  http.begin("http://wimpi.local/check_food_state");
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

int set_food_is_given() {
  int food_now_state = 0;
  HTTPClient http;
  http.begin("http://wimpi.local/food_is_given");
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

void set_stock_weight(int weight) {
  WiFiClient client;
  HTTPClient http;
  http.begin(client, "http://wimpi.local/set_stock_weight");
  http.addHeader("Content-Type", "text/plain");

  int httpResponseCode = http.POST(String(weight));
//  
//  String httpRequestData = weight;
//  int httpResponseCode = http.POST(httpRequestData);
  
  Serial.print("HTTP Response code: ");
  Serial.println(httpResponseCode);
  http.end();
}

int get_food_amount() {
  
}

void loop() {

  Serial.println("attempting to set weight");
  set_stock_weight(322);
  delay(5000);

  
//  delay(10000);
//  Serial.println("checking if food must be given..");
//  if (check_food_state()) {
//    Serial.println("food must be given! ..");
//    // motor runnen voor eten
//    delay(1000);
//    Serial.println("running set_food_is_given");
//    Serial.println(set_food_is_given());
//  }
}
