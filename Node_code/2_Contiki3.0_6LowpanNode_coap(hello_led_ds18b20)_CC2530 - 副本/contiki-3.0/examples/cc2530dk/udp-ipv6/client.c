/*
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. Neither the name of the Institute nor the names of its contributors
 *    may be used to endorse or promote products derived from this software
 *    without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE INSTITUTE AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE INSTITUTE OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 *
 * This file is part of the Contiki operating system.
 *
 */

#include "contiki.h"
#include "contiki-lib.h"
#include "contiki-net.h"
//#include "led_init.h"
#include <string.h>
#include "dev/leds.h"
//#include "dev/button-sensor.h"
#include "debug.h"
#include "string.h"
#define DEBUG DEBUG_PRINT
#include "net/ip/uip-debug.h"
#include "ds18b20.h"
#undef PRINTF(...) 
#define PRINTF(...) 

#define SEND_INTERVAL       10 * CLOCK_SECOND
#define MAX_PAYLOAD_LEN     40
 
static char buf[MAX_PAYLOAD_LEN];

/* Our destinations and udp conns. One link-local and one global */
#define LOCAL_CONN_PORT 3001
static struct uip_udp_conn *l_conn;
#if UIP_CONF_ROUTER
	#define GLOBAL_CONN_PORT 3002
	static struct uip_udp_conn *g_conn;
#endif

/*---------------------------------------------------------------------------*/
PROCESS ( udp_client_process, "UDP client process" );
#if BUTTON_SENSOR_ON
	PROCESS_NAME ( ping6_process );
	AUTOSTART_PROCESSES ( &udp_client_process, &ping6_process );
#else
	//AUTOSTART_PROCESSES(&udp_client_process);
#endif
/*---------------------------------------------------------------------------*/
static void
tcpip_handler ( void ) {
	//  leds_on ( LEDS_GREEN );
	if ( uip_newdata() ) {
		PRINTF ( "0x" );
		PRINTF ( "%x", uip_datalen() );
		PRINTF ( " bytes response=0x" );
		PRINTF ( "%x", ( * ( uint16_t * ) uip_appdata ) >> 8 );
		PRINTF ( "%x", ( * ( uint16_t * ) uip_appdata ) & 0xFF );
		PRINTF ( "\n" );
                //LED2 =!LED2;
	}
 
        
	//  leds_off ( LEDS_GREEN );
	return;
}
/*---------------------------------------------------------------------------*/
static void
timeout_handler ( void ) {
	static int seq_id;//作用是增加msg编号
	struct uip_udp_conn *this_conn;
	//  leds_on ( LEDS_RED );
	memset ( buf, 0, MAX_PAYLOAD_LEN );
	seq_id++;
        Ds18b20Initial();
        P1DIR |= 0x20; //IO口需要重新配置为输出 
         temp[0]=wendu_shi+0x30;
         temp[1]=wendu_ge+0x30;
         humidity[0]=shidu_shi+0x30;
         humidity[1]=shidu_ge+0x30;
         unsigned char temp_humi[8]={'N','O','0','2',temp[0],temp[1],humidity[0],humidity[1]};
        
	/* evens / odds */
	if ( seq_id & 0x01 ) {//这样全局和本地依次发送数据包
		this_conn = l_conn;
	}
        
        
	else {
		//this_conn = g_conn;

		//if ( uip_ds6_get_global ( ADDR_PREFERRED ) == NULL ) {
			//return;
		//}
	}

	Uart_Send_String ( "Client to: ",strlen("Client to: ") );
	PRINT6ADDR ( &this_conn->ripaddr );
	memcpy ( buf, &temp_humi, sizeof ( temp_humi ) );//将msg id放入buf
	PRINTF ( " Remote Port %u,", UIP_HTONS ( this_conn->rport ) );
	PRINTF ( " (msg=0x%04x), %u bytes\n", * ( uint16_t * ) buf, sizeof ( seq_id ) );
	uip_udp_packet_send ( this_conn, buf, sizeof ( temp_humi ) );
        //LED1 =!LED1;
        Uart_Send_String(&temp_humi,sizeof ( temp_humi ) );
       
        Uart_Send_String("send",strlen("send"));
    //uip_udp_packet_send ( this_conn, "3456", strlen ( "3456" ) );
	//  leds_off ( LEDS_RED );
}
/*---------------------------------------------------------------------------*/
PROCESS_THREAD ( udp_client_process, ev, data ) {
	static struct etimer et;
	uip_ipaddr_t ipaddr;
	PROCESS_BEGIN();
	PRINTF ( "UDP client process started\n" );
	uip_ip6addr ( &ipaddr, 0x2001,0x250,0x500a,0x111, 0x7d8b, 0x2cf9,  0xbee3, 0x60b );
       // uip_ip6addr ( &ipaddr, 0xfe80,0x0,0x0,0x0, 0x0, 0x0, 0x0, 0x0 );
	/* new connection with remote host */
	l_conn = udp_new ( &ipaddr, UIP_HTONS ( 8888 ), NULL );

	if ( !l_conn ) {
		PRINTF ( "udp_new l_conn error.\n" );
	}

	udp_bind ( l_conn, UIP_HTONS ( LOCAL_CONN_PORT ) );
	PRINTF ( "Link-Local connection with " );
	PRINT6ADDR ( &l_conn->ripaddr );
	PRINTF ( " local/remote port %u/%u\n",
			 UIP_HTONS ( l_conn->lport ), UIP_HTONS ( l_conn->rport ) );
	//uip_ip6addr ( &ipaddr, 0x2001,0x250,0x500a,0x111, 0x0, 0x0,0x0,0x3);//pc地址
        //uip_ip6addr ( &ipaddr, 0x2001,0x1,0x0,0x0, 0x810f, 0xb17c,  0xf31c, 0x2386);
        //uip_ip6addr ( &ipaddr, 0x2001,0x1,0x0,0x0, 0x1863, 0xa02b,  0x202a, 0xc901 );//服务器地址
        uip_ip6addr ( &ipaddr, 0x2001,0x250,0x500a,0x111, 0x7d8b, 0x2cf9,  0xbee3, 0x60b );
        //uip_ip6addr ( &ipaddr, 0x2001,0xda8,0x270,0x2019,0x0,0x0,0x0,0xa8 );//云服务器
	g_conn = udp_new ( &ipaddr, UIP_HTONS ( 8080 ), NULL );

	if ( !g_conn ) {
		PRINTF ( "udp_new g_conn error.\n" );
	}

	udp_bind ( g_conn, UIP_HTONS ( GLOBAL_CONN_PORT ) );
	PRINTF ( "Global connection with " );
	PRINT6ADDR ( &g_conn->ripaddr );
	PRINTF ( " local/remote port %u/%u\n",
			 UIP_HTONS ( g_conn->lport ), UIP_HTONS ( g_conn->rport ) );
	etimer_set ( &et, SEND_INTERVAL );

	while ( 1 ) {
		PROCESS_YIELD();

		if ( etimer_expired ( &et ) ) {
			timeout_handler();
			etimer_restart ( &et );
		}
		else if ( ev == tcpip_event ) {
			tcpip_handler();
		}
	}

	PROCESS_END();
}
/*---------------------------------------------------------------------------*/
