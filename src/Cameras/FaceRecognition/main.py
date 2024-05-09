import cv2
import urllib.request
import numpy as np
import serial
from struct import pack
 
# initzializing opencv
f_cas= cv2.CascadeClassifier(cv2.data.haarcascades+'haarcascade_frontalface_default.xml')
cam_ip = input("Enter cam IP address: ")
url=f'http://{cam_ip}/capture'
#initzializing serial communication
try:
    cam_port = input("Enter cam port: ")
    ser = serial.Serial(cam_port, 115200, dsrdtr=None)
except:
    print("Serial port not found!!")
    exit()
ser.setRTS(False)
ser.setDTR(False)

cv2.namedWindow("ESP32-Cam Face-Recognition", cv2.WINDOW_AUTOSIZE)
while True:
    try:
        img_resp=urllib.request.urlopen(url)
    except:
        print("Cannot reach camera webserver!!")
        exit()
    imgnp=np.array(bytearray(img_resp.read()),dtype=np.uint8)
    img=cv2.imdecode(imgnp,-1)
    gray=cv2.cvtColor(img,cv2.COLOR_BGR2GRAY)
    face=f_cas.detectMultiScale(gray,scaleFactor=1.1,minNeighbors=5)
    for x,y,w,h in face:
        cv2.rectangle(img,(x,y),(x+w,y+h),(0,0,255),3)
        roi_gray = gray[y:y+h, x:x+w]
        roi_color = img[y:y+h, x:x+w]
        # creating raw data bytes
        raw_data = pack("iii", x, y, -1)
        try:
            ser.write(raw_data)
        except:
            print("Error while writing on serial port!!")
            exit()
        print(f"Sent x = {x}, y = {y}")
    cv2.imshow("live transmission",img)
    key=cv2.waitKey(5)
    if key==ord('q'):
        break
ser.close()
cv2.destroyAllWindows()
