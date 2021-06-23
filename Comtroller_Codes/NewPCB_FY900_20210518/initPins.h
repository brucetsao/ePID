#include <String.h>
#define Ledon HIGH
#define Ledoff LOW
#include "comlib.h"
HardwareSerial myHardwareSerial(2); //ESP32可宣告需要一個硬體序列，軟體序列會出錯

#include <WiFi.h>   // WIFI NEED THIS
#include <WiFiMulti.h>  //設定多AP 資料與密碼

WiFiMulti wifiMulti;
WiFiClient pvclient;

//WiFiMulti wifiMulti;    //設定多AP 資料與密碼 物件
#include <String.h>
#include <MQTT.h>


#define RXD2 16
#define TXD2 17
int cmmstatus = 0 ;
char clintid[20];




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
  String ipdata ;
 String Apname;
String MacData ;
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
#define WifiLed 2
#define AccessLED 15
#define BeepPin 8
#define RXD2 16
#define TXD2 17

WiFiClient client;
WiFiClient mqclient;
MQTTClient mqttclient;
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x3F,16,2);  // set the LCD address to 0x27 for a 16 chars and 2 line display

int deviceid=1 ;
float PV = 0.0 ;
float SV = 0.0 ;
float AL1 = 0.0 ;
float AL2 = 0.0 ;

//----------------
void ShowAP(String apname)
{
    Serial.print("Access Point:") ;
    Serial.print(apname) ;
    Serial.print("\n:") ;
}


void ShowMAC()
{
    Serial.print("MAC:") ;
    Serial.print(MacData) ;
    Serial.print("\n:") ;


}
void ShowIP()
{

    Serial.print("IP Address:") ;
    Serial.print(ipdata) ;
    Serial.print("\n:") ;
}

void ShowInternet()
{
    ShowMAC() ;
    ShowIP()  ;
}






//-----------------


void ClearShow()
{
    lcd.setCursor(0,0);
    lcd.clear() ;
    lcd.setCursor(0,0);
}
 void LCDinit()   //initialize the lcd 
 {
   lcd.init();  // initialize the lcd 
  // Print a message to the LCD.
  lcd.backlight();
  lcd.setCursor(0,0);
 }
void ShowLCD1(String cc)
{
  lcd.setCursor(0,0);
  lcd.print("                    ");  
  lcd.setCursor(0,0);
  lcd.print(cc);  
  
}
void ShowLCD2(String cc)
{
  lcd.setCursor(0,1);
  lcd.print("                    ");  
  lcd.setCursor(0,1);
  lcd.print(cc);  
  
}


void ShowString(String ss)
{
  lcd.setCursor(0,1);
  lcd.print("                    ");  
  lcd.setCursor(0,1);
  lcd.print(ss.substring(0,19)); 
  //delay(1000);
}







String GetMacAddress() {
  // the MAC address of your WiFi shield
  String Tmp = "" ;
  byte mac[6];
  
  // print your MAC address:
  WiFi.macAddress(mac);
  for (int i=0; i<6; i++)
    {
        Tmp.concat(print2HEX(mac[i])) ;
    }
    Tmp.toUpperCase() ;
  return Tmp ;
}

String IpAddress2String(const IPAddress& ipAddress)
{
  return String(ipAddress[0]) + String(".") +\
  String(ipAddress[1]) + String(".") +\
  String(ipAddress[2]) + String(".") +\
  String(ipAddress[3])  ; 
}




String chrtoString(char *p)
{
    String tmp ;
    char c ;
    int count = 0 ;
    while (count <100)
    {
        c= *p ;
        if (c != 0x00)
          {
            tmp.concat(String(c)) ;
          }
          else
          {
              return tmp ;
          }
       count++ ;
       p++;
       
    }
}


void CopyString2Char(String ss, char *p)
{
         //  sprintf(p,"%s",ss) ;

  if (ss.length() <=0)
      {
           *p =  0x00 ;
          return ;
      }
    ss.toCharArray(p, ss.length()+1) ;
   // *(p+ss.length()+1) = 0x00 ;
}

boolean CharCompare(char *p, char *q)
  {
      boolean flag = false ;
      int count = 0 ;
      int nomatch = 0 ;
      while (flag <100)
      {
          if (*(p+count) == 0x00 or *(q+count) == 0x00)
            break ;
          if (*(p+count) != *(q+count) )
              {
                 nomatch ++ ; 
              }
             count++ ; 
      }
     if (nomatch >0)
      {
        return false ;
      }
      else
      {
        return true ;
      }
      
        
  }

//---------------------
void printWiFiStatus() {
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength:
  rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}
void WifiOn()
{
    digitalWrite(WifiLed,Ledon) ;
}

void WifiOff()
{
    digitalWrite(WifiLed,Ledoff) ;
}




void AccessOn()
{
    digitalWrite(AccessLED,Ledon) ;
}

void AccessOff()
{
    digitalWrite(AccessLED,Ledoff) ;
}
void BeepOn()
{
    digitalWrite(BeepPin,Ledon) ;
}
void BeepOff()
{
    digitalWrite(BeepPin,Ledoff) ;
}
