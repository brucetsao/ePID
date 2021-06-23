//-----------------------
#include "initPins.h"
#include "comlib.h"
#include "command.h"
#include "crc16.h"

WiFiMulti wifiMulti;
WiFiClient pvclient;



///////////////////////////////////////////////////////
//http://140.127.205.165/lab203_iot/fy_900/dataadd.php?t=01asda01dsasd01
void sendNAS()
{
   // connectstr = "t="+d;
  Serial.println(connectstr) ;
  if (client.connect(iotserver, iotport)) 
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
  Serial.print("MAC is :(") ;
  Serial.print(MacData) ;
  Serial.print(")\n") ;
  ShowInternet() ;
  // --------------- wifi connection end
    phasestage=1 ;
    flag1 = false ;
    flag2 = false ;
    

} 


void loop()   
{
  pvflag = false ;
  svflag = false ;
  requestdata(&Read_PV[0],8);
    delay(200);
    if (Serial2.available()>0)
      {
        Serial.println("Controler Respones") ;
        cmmstatus = Get_PV(&retdata) ;
        if (cmmstatus == 1)
          {
            DisplayPVData(&retdata) ;
             PV = GETPV();            
            pvflag = true ;
           // sendPV();
          }
          else
          {
            pvflag = false ;
              Serial.print("Status:(") ;
              Serial.print(cmmstatus) ;
              Serial.print(")\n") ;
          }
      }
//-------------SV
  requestdata(&Read_SV[0],8);
    delay(200);
    if (Serial2.available()>0)
      {
        Serial.println("Controler Respones") ;
        cmmstatus = Get_SV(&retdata) ;
        if (cmmstatus == 1)
          {
             DisplaySVData(&retdata) ;
             SV = GETSV();  
            svflag = true ;
            //sendSV();
          }
          else
          {
              svflag = false ;
              Serial.print("Status:(") ;
              Serial.print(cmmstatus) ;
              Serial.print(")\n") ;
          }
      }
    if (pvflag && svflag)
      {
        sendPV();
      }
    
    delay(10000) ;
} // END Loop


//void sendPV(Word pvvalue)
void sendPV()
{


  //http://nuk.arduino.org.tw:8888/pid/dataadd.php?MAC=CC50E3B6B808&id=1&pv=23.4&sv=23.1
  connectstr = "?MAC="+MacData+"&id="+String(deviceid)+"&pv="+String(PV)+"&sv="+String(SV);
 // connectstr = "?MAC='";
  Serial.println(connectstr) ;
  if (pvclient.connect(iotserver, iotport)) 
    { 
      Serial.println("Make a HTTP request ... ");           
      String strHttpGet = strPVGet + connectstr + strHttp;
      Serial.println(strHttpGet);
            //### Send to Server
            //-----Http GET 用法-------
           pvclient.println(strHttpGet);//送到URL
           pvclient.println(strHost);   //告知用Http GET
           pvclient.println();  //結束碼
           //-----Http GET 用法----end--
    }
      if (pvclient.connected()) 
      { 
        pvclient.stop();  // DISCONNECT FROM THE SERVER
      }    
}
