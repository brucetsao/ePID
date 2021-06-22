long POW(long num, int expo) ;
String SPACE(int sp) ;
String strzero(long num, int len, int base)  ;
unsigned long unstrzero(String hexstr, int base) ;
String  print2HEX(int number)  ;

//------------------------

long temp , humid ;
byte cmd ;
byte receiveddata[250] ;
int receivedlen = 0 ;
byte StrTemp[] = {0x01,0x04,0x00,0x01,0x00,0x02,0x20,0x0B}  ;
byte Str1[] = {0x01,0x03,0x00,0x8A,0x00,0x01,0xA5,0xE0}  ;  //讀取單筆參數資料：Master送出資料(讀取PV現在資料)
byte Str2[] = {0x01,0x04,0x00,0x02,0x00,0x01,0x90,0x0A}  ;

//----------SV 
byte Read_PV[8] = {0x01,0x03,0x00,0x8A,0x00,0x01,0xA5,0xE0}  ;  //讀取單筆參數資料：Master送出資料(讀取PV現在資料)

//-----------------
  typedef struct Word
  {
      byte HI;
      byte LO;
  }  ;
 typedef struct Word DATA; 
 
  typedef struct AnsData
  {
      byte DeviceID;
      byte Cmd;
      byte Len;
      Word Data;
      Word CRC16;
  } ;
 typedef struct AnsData ansdata; 

AnsData retdata ;
//-------
void requestdata(byte *sendstr, int len) ;
void requesttemperature() ;
void requesthumidity() ;
int GetDHTdata(byte *dd) ;
int Get_PV(AnsData *devdata) ;
void DisplayAnsData(AnsData *devdata) ;
unsigned int WordValue(Word *twobyte) ;
String WordHex(Word *twobyte) ;
//-------------

unsigned int WordValue(Word *twobyte)
{
  return ((*twobyte).HI *256+(*twobyte).LO) ;
}
String WordHex(Word *twobyte)
{
  return (print2HEX((byte)(*twobyte).HI)+ print2HEX((byte)(*twobyte).LO)) ;
}
void requestdata(byte *sendstr, int len)
{
    Serial.println("now send data to device") ;
    Serial2.write(sendstr,len);
     Serial.println("end sending") ;      
}

void requesttemperature()
{
    Serial.println("now send data to device") ;
    Serial2.write(Str1,8);
     Serial.println("end sending") ;      
}
void requesthumidity()
{
    Serial.println("now send data to device") ;
    Serial2.write(Str2,8);
     Serial.println("end sending") ;      
}


int GetDHTdata(byte *dd)
{
  int count = 0 ;
  long strtime= millis() ;
  while ((millis() -strtime) < 2000)
    {
    if (Serial2.available()>0)
      {
        Serial.println("Controler Respones") ;
          while (Serial2.available()>0)
          {
             Serial2.readBytes(&cmd,1) ;
             Serial.print(print2HEX((int)cmd)) ;
              *(dd+count) =cmd ;
              count++ ;

          }
          Serial.print("\n---------\n") ;
      }
      return count ;
    } 
}
//-----------
int Get_PV(AnsData *devdata) 
{
  int stage = 0 ;
   Serial.println("Enter Get_PV--While") ;
  while (Serial2.available()>0)
  {

    if (stage == 0)
      {
           Serial.println("Enter Stage0") ;
             Serial2.readBytes(&cmd,1) ;        
             (*devdata).DeviceID = cmd ;
             stage = 1 ;
             continue ;
      }
    if (stage == 1)
      {
           Serial.println("Enter Stage1") ;
             Serial2.readBytes(&cmd,1) ;        
             (*devdata).Cmd = cmd ;
             stage = 2 ;
             continue ;
      }
    if (stage == 2)
      {
           Serial.println("Enter Stage2") ;
             Serial2.readBytes(&cmd,1) ;        
             (*devdata).Len = cmd ;
             stage = 3 ;
             continue ;
      }
    if (stage == 3)
      {
           Serial.println("Enter Stage3") ;
             Serial2.readBytes(&cmd,1) ;        
             (*devdata).Data.HI = cmd ;
             Serial2.readBytes(&cmd,1) ;        
              (*devdata).Data.LO = cmd ;
             stage = 4 ;
             continue ;
      }
    if (stage == 4)
      {
           Serial.println("Enter Stage4") ;
             Serial2.readBytes(&cmd,1) ;        
             (*devdata).CRC16.HI = cmd ;
             Serial2.readBytes(&cmd,1) ;        
             (*devdata).CRC16.LO = cmd ;
              return 1 ;
      }
      

  
  } 
  // return -1 ==> CRC16 ERROR
  return 1 ;
}
//-------------------
void DisplayAnsData(AnsData *devdata) 
{
       Serial.print("Device ID:(") ;
       Serial.print((*devdata).DeviceID) ;
       Serial.print(")\n") ;

       Serial.print("Command:(") ;
       Serial.print((*devdata).Cmd) ;
       Serial.print(")\n") ;

       Serial.print("Length:(") ;
       Serial.print((*devdata).Len) ;
       Serial.print(")\n") ;

       Serial.print("Data:(") ;
       Serial.print(WordValue(&(*devdata).Data)) ;
       Serial.print(")\n") ;


       Serial.print("CRC:(") ;
       Serial.print(WordHex(&(*devdata).CRC16)) ;
       Serial.print(")\n") ;
       
}
