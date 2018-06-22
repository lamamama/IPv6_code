/*
 * 该文件定义了一个进程coap_server_process，
 * 功能是将需要添加的资源添加到链表restful_services中绑定资源的Uri地址
 */
/**
 * \addtogroup cc26xx-web-demo
 * @{
 *
 * \file
 *     A CC26XX-specific CoAP server
 */
/*---------------------------------------------------------------------------*/
#include "contiki.h"
#include "contiki-net.h"
#include "rest-engine.h"
#include "ds18b20-sensor.h"

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
/*---------------------------------------------------------------------------*/
/* Common resources */

extern resource_t res_hello;
extern resource_t res_leds;
extern resource_t res_ds18b20;

/*---------------------------------------------------------------------------*/
const char *coap_server_not_found_msg = "Resource not found";
const char *coap_server_supported_msg = "Supported:"
                                        "text/plain,"
                                        "application/json,"
                                        "application/xml";
/*---------------------------------------------------------------------------*/
PROCESS(coap_server_process, "CC2530 CoAP Server");
/*---------------------------------------------------------------------------*/
PROCESS_THREAD(coap_server_process, ev, data)
{
  PROCESS_BEGIN();
  
  /* Initialize the REST engine. */
  rest_init_engine();
  rest_activate_resource(&res_hello, "test/hello");//将该资源指定URI
  rest_activate_resource(&res_leds, "test/led");
  
  SENSORS_ACTIVATE(ds18b20_sensor);//设置该资源的configture
  rest_activate_resource(&res_ds18b20, "test/ds18b20");//将资源加入list
  
  /* Define application-specific events here. */
  while(1) {
    PROCESS_WAIT_EVENT();
  }

  PROCESS_END();
}
/*---------------------------------------------------------------------------*/
/**
 * @}
 */
