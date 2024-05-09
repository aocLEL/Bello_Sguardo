// MAC micro-usb(slave): 08:D1:F9:27:C3:04
// MAC usb-c(master):    E4:65:B8:1B:37:C8
#include <WiFi.h>
#include <esp_now.h>
#include "../../Common/data.h"

#define JOYX_PIN 4
#define JOYY_PIN 5
#define POT_PIN  6

const uint8_t reciver_mac_addr[] = {0x08, 0xD1, 0xF9, 0x27, 0xC3, 0x04};

// peer
esp_now_peer_info_t peer;

// callback when data is sent
void on_sent(const uint8_t *mac_addr, esp_now_send_status_t status) {
  Serial.println(status == ESP_NOW_SEND_SUCCESS ? "OK" : "ERR");
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
    esp_now_send(reciver_mac_addr, (uint8_t*)&data, sizeof(BSData));
    prev_time = millis();
  }
}
