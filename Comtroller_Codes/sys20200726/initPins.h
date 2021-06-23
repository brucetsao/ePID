#include <String.h>
#include <WiFi.h>   // WIFI NEED THIS
#include <WiFiMulti.h>  //設定多AP 資料與密碼

//WiFiMulti wifiMulti;    //設定多AP 資料與密碼 物件
#include <String.h>
#include <MQTT.h>


#define RXD2 16
#define TXD2 17
int cmmstatus = 0 ;
char clintid[20];

char Oledchar[30] ;


#define maxfeekbacktime 5000

int phasestage=1 ;
boolean flag1 = false ;
boolean flag2 = false ;
String d,s;


//////////////////////////////////////////////////////
//  control parameter 
boolean systemstatus = false ;
boolean Reading = false ;
boolean Readok = false ;
// int trycount = 0 ;
int wifierror = 0 ;
boolean btnflag = false ;
//---------------

int keyIndex = 0;            // your network key Index number (needed only for WEP)

  IPAddress ip ;
  long rssi ;
  
int status = WL_IDLE_STATUS;
char iotserver[] = "nuk.arduino.org.tw"  ;    // name address for Google (using DNS)
int iotport = 8888 ;
// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):
String strPVGet="GET /pid/dataadd.php";
String strGet="GET /pid/dataadd.php";
String strHttp=" HTTP/1.1";
String strHost="Host: nuk.arduino.org.tw";  //OK
String connectstr ;
String MacData ;
WiFiClient client;
WiFiClient mqclient;
MQTTClient mqttclient;

int deviceid=1 ;
float PV = 0.0 ;
float SV = 0.0 ;
float AL1 = 0.0 ;
float AL2 = 0.0 ;
