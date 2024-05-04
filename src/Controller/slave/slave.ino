#include <WiFi.h>
#include <esp_now.h>
#include <ESP32Servo.h>

#define SM_X 12
#define SM_Y 14
#define SM_right1 21
#define SM_right2 19
#define SM_left1 18
#define SM_left2 5

Servo servoX;
Servo servoY;
Servo servo_right1;
Servo servo_right2;
Servo servo_left1;
Servo servo_left2;

typedef struct _datas {
  int x;
  int y;
  int p_val;
} ControllerData;


ControllerData data;

void on_recv(const uint8_t *mac, const uint8_t *in_data, int len) {
  memcpy(&data, in_data, sizeof(ControllerData));
  Serial.printf("X --> %d | Y --> %d | P_VAL --> %d\n", data.x, data.y, data.p_val);
  // mapping and applying x/y servo datas
  int x = map(data.x, 0, 4096, 0, 60);
  int y = map(data.y, 0, 4096, 0, 60);
  servoX.write(x);
  servoY.write(y);
  //mapping and applying pot values
  int pot_v_high = map(data.p_val, 0, 4096, 0, 45);
  int pot_v_low = 45 - pot_v_high;
  servo_right1.write(pot_v_high);
  servo_right2.write(pot_v_low);
  servo_left1.write(pot_v_high);
  servo_left2.write(pot_v_low);
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
  servoX.attach(SM_X);
  servoY.attach(SM_Y);
  servo_right1.attach(SM_right1);
  servo_right2.attach(SM_right2);
  servo_left1.attach(SM_left1);
  servo_left2.attach(SM_left2);
  servoX.write(0);
  servoY.write(0);
  servo_right1.write(0);
  servo_right2.write(0);
  servo_left1.write(0);
  servo_left2.write(0);
}

int x;
int y;
int pot_v;
int pot_v_high;
int pot_v_low;

void loop() {
  x = analogRead(VRX_PIN);
  y = analogRead(VRY_PIN);
 
  x = map(x, 0, 4096, 0, 90);
  y = map(y, 0, 4096, 90, 10);
  servoX.write(x);
  servoY.write(y);
 
  pot_v = analogRead(POT);
  pot_v_high = map(pot_v, 0, 4096, 0, 45);
  pot_v_low = map(pot_v, 0, 4096, 45, 0); 
  servo_right1.write(pot_v_high);
  servo_right2.write(pot_v_low);
  servo_left1.write(pot_v_low);
  servo_left2.write(pot_v_high);
}
