#ifndef __DS18B20_H__
#define __DS18B20_H__
#define uint unsigned int
#define uchar unsigned char
extern uchar temp[2]; 
extern uchar temp1[5];
extern uchar humidity[2];
extern uchar humidity1[9];
extern uchar shidu_shi,shidu_ge,wendu_shi,wendu_ge;
extern int Humi_test ( void );
extern void Ds18b20Initial(void);

extern int Temp_test ( void );
extern void Delay_ms(uint Time);
#endif
