#include <WiFi.h>
#include <esp_now.h>
#include "Common/data.h"


BSData data;

void on_recv(const uint8_t *mac, const uint8_t *in_data, int len) {
  memcpy(&data, in_data, sizeof(BSData));
  Serial.printf("X --> %d | Y --> %d | P_VAL --> %d\n", data.x, data.y, data.p_val);
}

void setup() {
  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  if (esp_now_init() != ESP_OK) {
    Serial.println("Error initializing ESP-NOW");
    return;
  }
  // recive callback
  esp_now_register_recv_cb(on_recv);
}

void loop() {
  // empty, all handled by the callback
}
