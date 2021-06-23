#include <String.h>

#define RXD2 16
#define TXD2 17



char Oledchar[30] ;
//char* AP2 = "Brucetsao" ;
//char* PW2 = "12345678";

char* AP2 = "R1-1117" ;
char* PW2 = "3716037160";


#define maxfeekbacktime 5000
long temp , humid ;
byte cmd ;
byte receiveddata[250] ;
int receivedlen = 0 ;
byte StrTemp_write[] = {0x01,0x10,0x00,0x03,0x00,0x02,0x04,0x00,0x0A,0x00,0x05,0x53,0xBB}  ;//寫入多筆資料(寫入AL1、AL2)
byte StrTemp_read [] = {0x01,0x03,0x00,0x03,0x00,0x02,0x34,0x0B}  ;  //讀取多筆參數資料(讀取AL1、AL2)



 
