// Servohandler code
#include <ESP32Servo.h>
#include <HardwareSerial.h>
#include <Common/data.h>


// servo pins
#define SM_X 12
#define SM_Y 14
#define SM_RIGHT1 21
#define SM_RIGHT2 19
#define SM_LEFT1 18
#define SM_LEFT2 17


// Servo
Servo servo_x;
Servo servo_y;
Servo servo_r1;
Servo servo_r2;
Servo servo_l1;
Servo servo_l2;

//Serial port
HardwareSerial SerialPort(2);
HardwareSerial SerialPort2(1);

BSData data;

void setup() {
  Serial.begin(115200);
  SerialPort.begin(115200);
  SerialPort2.begin(115200, SERIAL_8N1, 4, 2);

  // initizializing servo
  servo_x.attach(SM_X);
  servo_y.attach(SM_Y);
  servo_r1.attach(SM_RIGHT1);
  servo_r2.attach(SM_RIGHT2);
  servo_l1.attach(SM_LEFT1);
  servo_l2.attach(SM_LEFT2);
  servo_x.write(0);
  servo_y.write(0);
  servo_r1.write(0);
  servo_r2.write(0);
  servo_l1.write(0);
  servo_l2.write(0);
}


void move(BSData *data) {
    data->x = map(data->x, 0, 4096, 0, 90);
    data->y = map(data->x, 0, 4096, 0, 90);
    int pot_v_high = map(data->p_val, 0, 4096, 10, 80);
    int pot_v_low = map(data->p_val, 0, 4096, 80, 10);
    servo_x.write(data->x);
    servo_y.write(data->y);
    servo_l1.write(pot_v_high);
    servo_l2.write(pot_v_low);
}

void loop() {
  //Controller
  if(SerialPort.available() >= sizeof(BSData)) {
    SerialPort.readBytes((char*)&data, sizeof(BSData));
    Serial.printf("from: %d | X --> %d | Y --> %d | POT --> %d\n", data.device, data.x, data.y, data.p_val);
    move(&data);
  }
  //GSheet
  if(SerialPort2.available() >= sizeof(BSData)) {
    SerialPort2.readBytes((char*)&data, sizeof(BSData));
    Serial.printf("from: %d | X --> %d | Y --> %d | POT --> %d\n", data.device, data.x, data.y, data.p_val);
    move(&data);
  } 
}
