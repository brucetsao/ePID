#include <ArduinoJson.h>
 // sample from https://techtutorialsx.com/2019/05/02/esp32-arduinojson-v6-serializing-json/
void setup() {
 
  Serial.begin(9600);
   
  StaticJsonDocument<100> testDocument;
   
  testDocument["sensorType"] = "Temperature";
  testDocument["value"] = 10;
 
  char buffer[100];
 
  serializeJson(testDocument, buffer);
 
  Serial.println(buffer);
}
 
void loop() {
 
}
