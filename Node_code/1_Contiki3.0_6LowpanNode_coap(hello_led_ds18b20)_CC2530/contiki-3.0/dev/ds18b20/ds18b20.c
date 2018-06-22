#include "iocc2530.h"
#include "ds18b20.h"

uchar ucharFLAG,uchartemp;
uchar shidu_shi,shidu_ge,wendu_shi,wendu_ge=4;
uchar ucharT_data_H,ucharT_data_L,ucharRH_data_H,ucharRH_data_L,ucharcheckdata;
uchar ucharT_data_H_temp,ucharT_data_L_temp,ucharRH_data_H_temp,ucharRH_data_L_temp,ucharcheckdata_temp;
uchar ucharcomdata;

#define LED2 P1_1 /* 定义P1.1口为LED2控制端 */
uchar temp[2]={0,0}; 
uchar temp1[5]="temp=";
uchar humidity[2]={0,0};
uchar humidity1[9]="humidity=";
#define wenshi P1_5 /* 温度传感器引脚 */

#define ON  0x01  /* 读取成功返回0x00，失败返回0x01 */
#define OFF 0x00
void Delay_us(void); //1 us延时
void Delay_10us(void); //10 us延时
void Delay_ms(uint Time);//n ms延时
void COM(void);	// 温湿写入
void Ds18b20Initial(void) ;  //温湿传感启动
/*
void Delay_us() //1 us延时
{
    for(int i=0;i<4;i++)
    {
     asm("nop");
    asm("nop");
    asm("nop");
    asm("nop");
    asm("nop");    
    asm("nop");
    asm("nop");
    }
             
}
*/
void Delay_10us() //10 us延时
{
  Delay_us();
  
}

void Delay_ms(uint Time)//n ms延时
{
 volatile unsigned char i;
  while(Time--)
  {
    for(i=0;i<100;i++)
     Delay_10us();
  }
}
void COM(void)	// 温湿写入
{     
    uchar i;         
    for(i=0;i<8;i++)    
    {
     ucharFLAG=2; 
     while((!wenshi)&&ucharFLAG++);//拉低50us左右
     Delay_10us();
     Delay_10us();
     Delay_10us();
     uchartemp=0;
     if(wenshi)uchartemp=1;//如果过了30us后还是高电平则输出为1，否则为0
     ucharFLAG=2;
     while((wenshi)&&ucharFLAG++);   
     if(ucharFLAG==1)break;    
     ucharcomdata<<=1;
     ucharcomdata|=uchartemp; 
     }    
}

/* 时钟频率为32M */
void Delay_us () {
volatile unsigned int i;
  for( i=0;i<2;i++);
}


/* ds18b20初始化，初始化成功返回0x00，失败返回0x01 */

void Ds18b20Initial ( void ) {
	//uchar Status = 0x00;
	//uint CONT_1 = 0;
	//uchar Flag_1 = ON;
    
	wenshi=0;
        Delay_ms(19);  //>18MS
        wenshi=1;   //主机拉低必须大于18ms，然后拉高，DHT开始发送低电平响应信号80us，
        P1DIR &= ~0x20; //重新配置IO口方向为输入，延时20-40ms后读取响应信号，
        Delay_10us();
        Delay_10us();						
        Delay_10us();
        Delay_10us(); 

	 if(!wenshi) //响应信号正确 为低电平
     {
      ucharFLAG=2; 
      while((!wenshi)&&ucharFLAG++);
        ucharFLAG=2;
      while((wenshi)&&ucharFLAG++); //再把总线拉高，开始传送数据，每个bit都以50us低电平间隙开始
        COM();
        ucharRH_data_H_temp=ucharcomdata;
        COM();
        ucharRH_data_L_temp=ucharcomdata;
        COM();
        ucharT_data_H_temp=ucharcomdata;
        COM();
        ucharT_data_L_temp=ucharcomdata;
        COM();
        ucharcheckdata_temp=ucharcomdata;
        wenshi=1; 
        uchartemp=(ucharT_data_H_temp+ucharT_data_L_temp+ucharRH_data_H_temp+ucharRH_data_L_temp);
      if(uchartemp==ucharcheckdata_temp)
      {
          ucharRH_data_H=ucharRH_data_H_temp;
          ucharRH_data_L=ucharRH_data_L_temp;
          ucharT_data_H=ucharT_data_H_temp;
          ucharT_data_L=ucharT_data_L_temp;
          ucharcheckdata=ucharcheckdata_temp;
           
       }
         wendu_shi=ucharT_data_H/10; 
         wendu_ge=ucharT_data_H%10;
	 
         shidu_shi=ucharRH_data_H/10; 
         shidu_ge=ucharRH_data_H%10;     
        if(wendu_shi==wendu_ge&&shidu_shi==shidu_ge);
        
    } 
    
   P1DIR |= 0x20; //IO口需要重新配置 设置为输出
}

/*
void Ds18b20Write ( uchar infor ) {
	uint i;
	Ds18b20OutputInitial();

	for ( i = 0; i < 8; i++ ) {
		if ( ( infor & 0x01 ) ) {
			Ds18b20Data = 0;
			Ds18b20Delay ( 6 );
			Ds18b20Data = 1;
			Ds18b20Delay ( 50 );
		}
		else {
			Ds18b20Data = 0;
			Ds18b20Delay ( 50 );
			Ds18b20Data = 1;
			Ds18b20Delay ( 6 );
		}

		infor >>= 1;
	}
}


uchar Ds18b20Read ( void ) {
	uchar Value = 0x00;
	uint i;
	Ds18b20OutputInitial();
	Ds18b20Data = 1;
	Ds18b20Delay ( 10 );

	for ( i = 0; i < 8; i++ ) {
		Value >>= 1;
		Ds18b20OutputInitial();
		Ds18b20Data = 0;
		Ds18b20Delay ( 3 );
		Ds18b20Data = 1;
		Ds18b20Delay ( 3 );
		Ds18b20InputInitial();

		if ( Ds18b20Data == 1 ) {
			Value |= 0x80;
		}

		Ds18b20Delay ( 15 );
	}

	return Value;
}
*/

int Temp_test ( void )
{
  Ds18b20Initial();
  
  return (int)ucharT_data_H;

}
int Humi_test ( void )
{
  Ds18b20Initial();
  
  return (int)ucharRH_data_H;

}