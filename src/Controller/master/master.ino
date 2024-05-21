// MAC micro-usb(master): 08:D1:F9:27:C3:04
// MAC usb-c(slave):    E4:65:B8:1B:37:C8
#include <WiFi.h>
#include <esp_now.h>
#include "Common/data.h"

#define JOYX_PIN 33
#define JOYY_PIN 32
#define POT_PIN  35
#define LED_PIN  34

const uint8_t reciver_mac_addr[] = {0xE4, 0x65, 0xB8, 0x1B, 0x37, 0xC8};

// peer
esp_now_peer_info_t peer;


// callback when data is sent
void on_sent(const uint8_t *mac_addr, esp_now_send_status_t status) {
  if(status == ESP_NOW_SEND_SUCCESS) {
    digitalWrite(LED_PIN, HIGH);
    Serial.println("OK");
  }
  else {
    // led blinks when there is a connection error
    digitalWrite(LED_PIN, HIGH);
    delay(200);
    digitalWrite(LED_PIN, LOW);
    delay(200);
    Serial.println("ERR");
  }
}
 
void setup(){
  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  if(esp_now_init() != ESP_OK) {
    Serial.println("Error initializing ESP-NOW");
    return;
  }
  //register callback
  esp_now_register_send_cb(on_sent);
  // Register peer
  memcpy(peer.peer_addr, reciver_mac_addr, 6);
  peer.channel = 0;  
  peer.encrypt = false;
  // Add peer        
  if (esp_now_add_peer(&peer) != ESP_OK){
    Serial.println("Failed to add peer");
    return;
  }
}

BSData data; 
unsigned int prev_time = 0;

void loop(){
  if(millis() > prev_time + 1000) {
    data.x = analogRead(JOYX_PIN);
    data.y = analogRead(JOYY_PIN);
    data.p_val = analogRead(POT_PIN);
    Serial.printf("X --> %d | Y --> %d | POT --> %d\n", data.x, data.y, data.p_val);
    esp_now_send(reciver_mac_addr, (uint8_t*)&data, sizeof(BSData));
    prev_time = millis();
  }
}
