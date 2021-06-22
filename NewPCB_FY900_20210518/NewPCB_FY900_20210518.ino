//-----------------------
#include "initPins.h"
#include "command.h"
#include "crc16.h"

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
   Serial.begin(9600);      // initialize serial communication
  myHardwareSerial.begin(9600, SERIAL_8N1, RXD2, TXD2);

  //myHardwareSerial.begin(9600, SERIAL_8N1, RXD2, TXD2);     // initialize serial communication
  pinMode(WifiLed,OUTPUT) ;
  pinMode(AccessLED,OUTPUT) ;
  pinMode(BeepPin,OUTPUT) ;
  BeepOff() ;
  AccessOff() ;
  WifiOff() ;
   LCDinit() ;

}






void setup() 
{
        
  //Initialize serial and wait for port to open:
    initAll() ;
  WiFi.disconnect(true);
  WiFi.setSleep(false);
    
  // --------------- wifi connection start    
  WiFi.disconnect(true);
  WiFi.setSleep(false);

  
    wifiMulti.addAP("NCNUIOT", "12345678");
    wifiMulti.addAP("NCNUIOT2", "12345678");
    wifiMulti.addAP("androidAP", "12345678");
    wifiMulti.addAP("lab309", "");    //加入一組熱點
    wifiMulti.addAP("5FAI", "ncnueeai");  //加入一組熱點
    wifiMulti.addAP("lib-tree", "wtes26201959");
    wifiMulti.addAP("Wtes-Aruba", "26201959");

    Serial.println("Connecting Wifi...");
    if(wifiMulti.run() == WL_CONNECTED) 
    {
        Apname = WiFi.SSID();
        ip = WiFi.localIP();
        Serial.println("");
        Serial.print("Successful Connectting to Access Point:");
        Serial.println(apname);
        Serial.print("\n");
        ipdata = IpAddress2String(ip);
        Serial.println("WiFi connected");
        Serial.println("IP address: ");
        Serial.println(ipdata);
         ShowAP() ;
              
    }
  //  Serial.println("001") ;
    delay(2000);
    WifiOn() ;    
 //   Serial.println("002") ;
  MacData = GetMacAddress() ;  
  ipdata = IpAddress2String(ip) ;
 //   Serial.println("003") ;
 
  ShowInternet() ;
  // --------------- wifi connection end
    phasestage=1 ;
    flag1 = false ;
    flag2 = false ;
 //-------------------------MQTT Process
  mqttclient.setServer("www.iot.ncnu.edu.tw", 1883);
  mqttclient.onMessage(messageReceived);
  fillCID(MacData); // generate a random clientid based MAC
  Serial.print("MQTT ClientID is :(") ;
  Serial.print(clintid) ;
  Serial.print(")\n") ;

  connectMQTT();
     

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

void fillCID(String mm)
{
  // generate a random clientid based MAC
  //compose clientid with "tw"+MAC 
  clintid[0]= 't' ;  
  clintid[1]= 'w' ;  
      mm.toCharArray(&clintid[2],mm.length()+1) ;
    clintid[2+mm.length()+1] = '\n' ;

}

//------------------

void messageReceived(String &topic, String &payload) {
            //CarNumber = payload ;
            Serial.println("Msg:"+payload) ;
       Serial.println("MSG:" +payload);
     // msgDecode(payload) ; 
     /*
        if (ValueDecode(payloadcount,rfidnum)==CarNumber)
          {      
              ShowString("Para Count:"+String(payloadcount)) ;
          }
      */
}
 void connectMQTT()
 {
  Serial.print("MQTT ClientID is :(") ;
  Serial.print(clintid) ;
  Serial.print(")\n") ;
  long strtime = millis() ;  
  while (!mqttclient.connect(clintid, "power412", "ncnueeai")) {
    Serial.print("~");
    delay(1000);
    if ((millis()-strtime )>WaitingTimetoReboot )
      {
            Serial.println("No Wifi and Rebooting") ;
            ShowString("Rebooting.") ;            
            ESP.restart();        
      }    
  }
    Serial.print("\n");
  
  mqttclient.subscribe("ncnu/pid/#");
  Serial.println("\n MQTT connected!");


  // client.unsubscribe("/hello");
}
