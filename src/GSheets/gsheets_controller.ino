#include <ArduinoJson.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include "secrets.h"

typedef int value_t;

String GS_ID = "---DEPLOYMENT-ID---";

const char* host = "script.google.com"; 

value_t x = 0;  //  LEFT/RIGHT
value_t y = 0;  //  UP/DOWN
value_t z = 0;  //  OPEN/CLOSE
String payload = "";

unsigned long time_ms;
unsigned long last_read;
unsigned long time_sheet_update_buf;
unsigned long time_dif;


void setup(){
  Serial.begin(115200);
  setup_wifi();
}


void loop(){
  time_ms = millis();
  time_dif = time_ms - last_read;
  if(time_dif >= 15000){  // 15 sec
    last_read = time_ms;
    read_sheet();
    tokenize_payload();
  }
}


void setup_wifi() {
  delay(1000);
  Serial.print("\nConnecting to ");
  Serial.println(wifi_ssid);
  WiFi.begin(wifi_ssid, wifi_password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("WiFi connected at IP address: ");
  Serial.println(WiFi.localIP());
}


void read_sheet(){
  HTTPClient clientR;
  String url="https://script.google.com/macros/s/"+GS_ID+"/exec?read";
  Serial.println("Read data by a GET request");
  clientR.begin(url.c_str()); //Specify the URL and certificate
  clientR.setFollowRedirects(HTTPC_STRICT_FOLLOW_REDIRECTS);
  int httpCode = clientR.GET();
  if (httpCode > 0) { //Check for the returning code
      payload = clientR.getString();
      }
  else {
    Serial.println("Error on HTTP request\n");
  }
  clientR.end();  
}


void tokenize_payload(){
  String buffer = payload;
  JsonDocument doc;
  deserializeJson(doc, buffer);
  x = doc[0][0];
  y = doc[1][0];
  z = doc[2][0];
  Serial.printf("X --> %d Y --> %d Z --> %d\n", x, y, z);
}
