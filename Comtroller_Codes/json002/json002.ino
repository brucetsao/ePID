#include <ArduinoJson.h>
//https://randomnerdtutorials.com/decoding-and-encoding-json-with-arduino-or-esp8266/
StaticJsonBuffer<200> jsonBuffer;

struct clientData {
  char MAC[14];
  char JOB[12];
  float VALUE ;
};

char json[] = "{\"sensor\":\"gps\",\"time\":1351824120,\"data\":[48.756080,2.302038]}";

void setup() {
  // put your setup code here, to run once:
    Serial.begin(9600);
    JsonObject& root = jsonBuffer.createObject();
    root["MAC"] = "001122334455";
    root["JOB"] = PV;
    root["VALUE"]= 23.4 ;
}

void loop() {
  // put your main code here, to run repeatedly:
    root.printTo(Serial);
    delay(2000);
}
