//-----------------------
#include "initPins.h"
#include "comlib.h"
#include "command.h"
#include "crc16.h"
#include <WiFi.h>
#include <WiFiMulti.h>


WiFiMulti wifiMulti;


int keyIndex = 0;            // your network key Index number (needed only for WEP)
          // your network key Index number (needed only for WEP)

  IPAddress ip ;
  long rssi ;
  
int status = WL_IDLE_STATUS;
char iotserver[] = "nuk.arduino.org.tw";    // name address for Google (using DNS)
String strGet="GET /lab203_iot/fy_900/dataadd.php?";
String strHttp=" HTTP/1.0 nuk.arduino.org.tw";
String connectstr ;
String MacData ;
WiFiClient client;


///////////////////////////////////////////////////////
//http://140.127.205.165/lab203_iot/fy_900/dataadd.php?t=01asda01dsasd01
void sendNAS()
{
    connectstr = "t="+d;
  Serial.println(connectstr) ;
  if (client.connect(iotserver, 80)) 
    { 
      Serial.println("Make a HTTP request ... ");           
      String strHttpGet = strGet + connectstr + strHttp;
      Serial.println(strHttpGet);
            //### Send to Server
      client.println(strHttpGet);
      client.println();
    }
}








void initAll()
{
    Serial.begin(9600);
     Serial2.begin(9600, SERIAL_8N1, RXD2, TXD2);
  Serial.println("System Start") ;  


}



void ShowInternet()
{
    ShowMAC() ;
    ShowIP()  ;
}

void ShowAP(String apname)
{

}
void ClearShow()
{

}

void ShowMAC()
{


}
void ShowIP()
{


}




void ShowString(String ss)
{

}



void setup() 
{
        
  //Initialize serial and wait for port to open:
    initAll() ;
  // --------------- wifi connection start    
   wifiMulti.addAP("Brucetsao", "12345678");
    wifiMulti.addAP("IOT", "0123456789");
    wifiMulti.addAP("Brucetsao2", "12345678");

    Serial.println("Connecting Wifi...");
    wifiMulti.run() ;
   while (WiFi.status() != WL_CONNECTED)   //WiFi.status() ==網路狀態，WL_CONNECTED ==連線狀態成功
        {
              delay(500);
              Serial.print(".");    //等待連線印出符號
        }

    Serial.println("");
    Serial.println("WiFi connected");
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
  printWiFiStatus();
  MacData = GetMacAddress() ;
  ShowInternet() ;
  // --------------- wifi connection end
    phasestage=1 ;
    flag1 = false ;
    flag2 = false ;
    

} 


void loop()   
{
  requestdata(&Read_PV[0],8);
    delay(200);
    if (Serial2.available()>0)
      {
        Serial.println("Controler Respones") ;
        cmmstatus = Get_PV(&retdata) ;
        if (cmmstatus == 1)
          {
            DisplayAnsData(&retdata) ;
          }
          else
          {
              Serial.print("Status:(") ;
              Serial.print(cmmstatus) ;
              Serial.print(")\n") ;
          }
      }
    delay(5000) ;
} // END Loop



void printWiFiStatus() {
  // printStrTemp the SSID of the network you're attached to:
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
