#include <String.h>

#define RXD2 16
#define TXD2 17
int cmmstatus = 0 ;


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



 
