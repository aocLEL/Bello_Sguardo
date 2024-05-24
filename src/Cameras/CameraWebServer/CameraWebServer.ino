#include "esp_camera.h"
#include <WiFi.h>
#include "camera_pins.h"
#include "Common/secrets.h"
#include "Common/data.h"

// comment this define declaration for the bot cam code
//#define CAM_EYE

#define CAMERA_MODEL_AI_THINKER

void startCameraServer();
void setupLedFlash(int pin);

void setup() {
  Serial.begin(115200);
  Serial.setDebugOutput(true);
  Serial.println();
  // camera init
  camera_config_t conf = camera_config();
  esp_err_t err = esp_camera_init(&conf);
  if (err != ESP_OK) {
    Serial.printf("Camera init failed with error 0x%x", err);
    return;
  }
  sensor_t * s = esp_camera_sensor_get();
  // drop down frame size for higher initial frame rate
  s->set_framesize(s, FRAMESIZE_HD);
  setupLedFlash(LED_GPIO_NUM);
  WiFi.begin(wifi_ssid, wifi_password);
  WiFi.setSleep(false);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  startCameraServer();
  Serial.print("Camera Ready! Use 'http://");
  Serial.print(WiFi.localIP());
  Serial.println("' to connect");
}

BSData cam_data;

void loop() {
  #ifdef CAM_EYE
    if(Serial.available() >= sizeof(BSData)) {
      if(Serial.readBytes((char*)&cam_data, sizeof(BSData)) == sizeof(BSData)) {
        Serial.printf("X --> %d | Y --> %d | P_VAL --> %d\n", cam_data.x, cam_data.y, cam_data.p_val);
        cam_data.device = CAM_AI;
        // ledcWrite(2, 255);
        // delay(400);
        // ledcWrite(2, 0);
        Serial.write((char*)&cam_data, sizeof(BSData));
      }
    }
  #endif
}
