#include <sys/process.h>
#include <sys/procinit.h>
#include <sys/etimer.h>
#include <sys/autostart.h>
#include <sys/clock.h>
#include <ioCC2530.h>
#include "dev/watchdog.h"
#include "stdio.h"
#include "sys/rtimer.h"
#include "dev/io-arch.h"
#include "dev/uart1.h"
#include "dev/slip.h"
#include "soc.h"
#include "lib/random.h"
#include "net/netstack.h"
#include "linkaddr.h"
#include "net/mac/frame802154.h"
#include "dev/cc2530-rf.h"
#include "contiki-net.h"
#include "ds18b20-sensor.h"
#include "ds18b20.h"

/*---------------------------------------------------------------*/
#define MY_DEBUG 1
//uchar temp_text[];
#if MY_DEBUG
    #define PRINTF(...) printf(__VA_ARGS__)
    #define PRINT6ADDR(addr) PRINTF(" %02x%02x:%02x%02x:%02x%02x:%02x%02x:%02x%02x:%02x%02x:%02x%02x:%02x%02x ", ((unsigned char *)addr)[0], ((unsigned char *)addr)[1], ((unsigned char *)addr)[2], ((unsigned char *)addr)[3], ((unsigned char *)addr)[4], ((unsigned char *)addr)[5], ((unsigned char *)addr)[6], ((unsigned char *)addr)[7], ((unsigned char *)addr)[8], ((unsigned char *)addr)[9], ((unsigned char *)addr)[10], ((unsigned char *)addr)[11], ((unsigned char *)addr)[12], ((unsigned char *)addr)[13], ((unsigned char *)addr)[14], ((unsigned char *)addr)[15])
    #define PRINTLLADDR(lladdr) PRINTF(" %02x:%02x:%02x:%02x:%02x:%02x ",(lladdr)->addr[0], (lladdr)->addr[1], (lladdr)->addr[2], (lladdr)->addr[3],(lladdr)->addr[4], (lladdr)->addr[5])
#else
    #define PRINTF(...) 
    #define PRINT6ADDR(addr) 
    #define PRINTLLADDR(lladdr)
#endif
void Uart_Send_String(uchar *Data,int len) 
{
 { 
  int j; 
  for(j=0;j<len;j++) 
  { 
    U0DBUF = *Data++; 
    while(UTX0IF == 0); 
    UTX0IF = 0; 
  } 
 }
}
static void
print_local_addresses ( void ) {
	int i;
	unsigned char state;
//	PRINTF ( "Client IPv6 addresses: " );

	for ( i = 0; i < UIP_DS6_ADDR_NB; i++ ) {
		state = uip_ds6_if.addr_list[i].state;

		if ( uip_ds6_if.addr_list[i].isused &&
			 ( state == ADDR_TENTATIVE || state == ADDR_PREFERRED ) ) {
//			PRINT6ADDR ( &uip_ds6_if.addr_list[i].ipaddr );
//			PRINTF ( "\r\n" );
		}
	}
}
/*--------------------------------------------------------------*/
#define LED1 P1_0 /* 定义P1.0口为LED1控制端 */
#define LED2 P1_1 /* 定义P1.1口为LED2控制端 */
#define LED3 P1_4
void IO_Init ( void ) {
	P1SEL &= ~0x13; /* P1.0作为普通IO口 */
	P1DIR |= 0x13;  /* P1.0定义为输出 */
	P1INP |= 0X13;  /* 打开三态 */
        P2SEL &= ~0x01; /* P1.0作为普通IO口 */
	P2DIR |= 0x01;  /* P1.0定义为输出 */
	P2INP |= 0X01;  /* 打开三态 */
        P2_0=0;
}

static void uart1_send_byte ( char dat ) {
	UTX0IF = 0;
	U0DBUF =  dat;

	while ( UTX0IF == 0 );
}

void uart1_send_string ( char *buf ) {
	while ( *buf != '\0' ) {
		uart1_send_byte ( *buf++ );
	}
}

/*---------------------------------------------------------------------------*/
static void set_rf_params ( void ) CC_NON_BANKED {
	char i;
	uint16_t short_addr;
	uint8_t ext_addr[8];

#if CC2530_CONF_MAC_FROM_PRIMARY
	volatile unsigned char *macp = &X_IEEE_ADDR;
#else
	__code unsigned char *macp = ( __code unsigned char * ) 0xFFE8;
#endif

//	PRINTF ( "Rime is 0x" );
//	PRINTF ( "%x", sizeof ( linkaddr_t ) );
//	PRINTF ( " bytes long\n" );

#if CC2530_CONF_MAC_FROM_PRIMARY
//	PRINTF ( "Reading MAC from Info Page\n" );
#else
	PUTSTRING ( "Reading MAC from flash\n" );

	/*
	 * The MAC is always stored in 0xFFE8 of the highest BANK of our flash. This
	 * maps to address 0xFFF8 of our CODE segment, when this BANK is selected.
	 * Load the bank, read 8 bytes starting at 0xFFE8 and restore last BANK.
	 * Since we are called from main(), this MUST be BANK1 or something is very
	 * wrong. This code can be used even without a bankable firmware.
	 */

	/* Don't interrupt us to make sure no BANK switching happens while working */
	DISABLE_INTERRUPTS();

	/* Switch to the BANKn,
	 * map CODE: 0x8000 - 0xFFFF to FLASH: 0xn8000 - 0xnFFFF */
	FMAP = CC2530_LAST_FLASH_BANK;
#endif

	/*
	 * Read IEEE address from flash, store in ext_addr.
	 * Invert endianness (from little to big endian)
	 */
	for ( i = 7; i >= 0; --i ) {
		ext_addr[i] = *macp;
		macp++;
	}

#if !CC2530_CONF_MAC_FROM_PRIMARY
	/* Remap 0x8000 - 0xFFFF to BANK1 */
	FMAP = 1;
	ENABLE_INTERRUPTS();
#endif

	short_addr = ext_addr[7];
	short_addr |= ext_addr[6] << 8;

	/* Populate linkaddr_node_addr. Maintain endianness */
	memcpy ( &linkaddr_node_addr, &ext_addr[8 - LINKADDR_SIZE], LINKADDR_SIZE );

	/* Now the address is stored MSB first */
#if STARTUP_CONF_VERBOSE
	PRINTF ( "Rime configured with address " );

	for ( i = 0; i < LINKADDR_SIZE - 1; i++ ) {
		PRINTF ( "%x", linkaddr_node_addr.u8[i] );
		PRINTF ( ":" );
	}

	PRINTF ( "%x", linkaddr_node_addr.u8[i] );
	PRINTF ( "\n" );
#endif

	/* Write params to RF registers */
	NETSTACK_RADIO.set_value ( RADIO_PARAM_PAN_ID, IEEE802154_PANID );
	NETSTACK_RADIO.set_value ( RADIO_PARAM_16BIT_ADDR, short_addr );
	NETSTACK_RADIO.set_value ( RADIO_PARAM_CHANNEL, CC2530_RF_CHANNEL );
	NETSTACK_RADIO.set_object ( RADIO_PARAM_64BIT_ADDR, ext_addr, 8 );
	return;
}
/*---------------------------------------------------------------------------*/

/*-------------------------------------------------------------*/
PROCESS ( led_process, "led" );
PROCESS_THREAD ( led_process, ev, data ) {
	PROCESS_BEGIN();
	IO_Init();

	while ( 1 ) {
		static struct etimer et;
		etimer_set ( &et, CLOCK_SECOND / 2 );
		PROCESS_WAIT_EVENT_UNTIL ( etimer_expired ( &et ) );
		LED2 = !LED2; /* LED1闪烁 */
	}

	PROCESS_END();
}

PROCESS ( print_process, "print" );
PROCESS_THREAD ( print_process, ev, data ) {
	PROCESS_BEGIN();

	while ( 1 ) {
		static struct etimer et;
		etimer_set ( &et, CLOCK_SECOND / 2 );
		PROCESS_WAIT_EVENT_UNTIL ( etimer_expired ( &et ) );
		uart1_send_string ( "hello\r\n" );
	}

	PROCESS_END();
}

PROCESS ( ds18b20_process, "print" );
PROCESS_THREAD ( ds18b20_process, ev, data ) {
	PROCESS_BEGIN();
	Ds18b20Initial();

	while ( 1 ) {
            static struct etimer et1;
		etimer_set ( &et1, CLOCK_SECOND );
		PROCESS_WAIT_EVENT_UNTIL ( etimer_expired ( &et1 ) );
            Ds18b20Initial();       //获取温湿度
         P1DIR |= 0x20; //IO口需要重新配置为输出 
         temp[0]=wendu_shi+0x30;
         temp[1]=wendu_ge+0x30;
         humidity[0]=shidu_shi+0x30;
         humidity[1]=shidu_ge+0x30;
         /*******信息通过串口打印********/
         Delay_ms(50); //延时，使周期性2S读取1次
         Uart_Send_String(temp1,5);
         Uart_Send_String(temp,2);
         Uart_Send_String("\n",1);
         Uart_Send_String(humidity1,9);
         Uart_Send_String(humidity,2);
        Uart_Send_String("\n",1);
       //  temp_text[0]=(uchar)Temp_test();
       // Uart_Send_String(&temp_text[0],1);
       // Uart_Send_String("\n",1);
	LED1 = !LED1; /* LED1闪烁 */
        
	}

	PROCESS_END();
}

/*-----------------------------------------------------------------*/
PROCESS_NAME(udp_client_process);
PROCESS_NAME(coap_server_process);
PROCESS_NAME(sensors_process);
PROCESS_NAME(udp_server_process);
SENSORS(&ds18b20_sensor);

extern uip_lladdr_t uip_lladdr;
static CC_AT_DATA uint16_t len;
extern void soc_init();
AUTOSTART_PROCESSES ( &led_process, &print_process, &coap_server_process, &ds18b20_process,&udp_server_process,&udp_client_process );
  
int main ( void ) {
	clock_init();
	soc_init();
	rtimer_init();
	process_init();
	io_arch_init(); /* 初始化串口0，用于SLIP通信 */
	PRINTF ( "##########################################\r\n" );
	PRINTF ( CONTIKI_VERSION_STRING "\n" );
	PRINTF ( MODEL_STRING );

	switch ( CHIPID ) {
		case 0xA5:
			PRINTF ( "cc2530" );
			break;

		case 0xB5:
			PRINTF ( "cc2531" );
			break;

		case 0x95:
			PRINTF ( "cc2533" );
			break;

		case 0x8D:
			PRINTF ( "cc2540" );
			break;
	}

	PRINTF ( "-" CC2530_FLAVOR_STRING ", " );
	PRINTF ( "%x", CHIPINFO1 + 1 );
	PRINTF ( "KB SRAM\n" );
	PRINTF ( " Net: " );
	PRINTF ( NETSTACK_NETWORK.name );
	PRINTF ( "\r\n" );
	PRINTF ( " MAC: " );
	PRINTF ( NETSTACK_MAC.name );
	PRINTF ( "\r\n" );
	PRINTF ( " RDC: " );
	PRINTF ( NETSTACK_RDC.name );
	PRINTF ( "\r\n" );
	PRINTF ( "##########################################\r\n" );
	watchdog_init();
	random_init ( 0 );
	ctimer_init();
	netstack_init();
	set_rf_params();
	memcpy ( &uip_lladdr.addr, &linkaddr_node_addr, sizeof ( uip_lladdr.addr ) );
	queuebuf_init();
	process_start ( &tcpip_process, NULL );
	process_start ( &etimer_process, NULL );
	autostart_start ( autostart_processes );
	watchdog_start();
    print_local_addresses();
	while ( 1 ) {
		do {
			/* Reset watchdog and handle polls and events */
			watchdog_periodic();
		}
		while ( process_run() > 0 );

		len = NETSTACK_RADIO.pending_packet();

		if ( len ) {
            PRINTF("I receieve some\r\n");
			packetbuf_clear();
			len = NETSTACK_RADIO.read ( packetbuf_dataptr(), PACKETBUF_SIZE );

			if ( len > 0 ) {
				packetbuf_set_datalen ( len );
				NETSTACK_RDC.input();
			}
		}
	}

	return 0;
}
