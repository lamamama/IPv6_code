#ifndef CONTROL_H
#define CONTROL_H

#include <QDialog>
#include "cantcoap.h"
#include <QtNetwork>
#include <QByteArray>
#include<QDebug>
namespace Ui {
    class control;
}
static int Control_Status=1;
class control : public QDialog {
    Q_OBJECT
public:
    explicit control ( QWidget *parent = 0 );
    ~control();
    QString Status_1on="1on";
    QString Status_1off="1off";
    QString Status_2on="2on";
    QString Status_2off="2off";
    QString Status_3on="3on";
    QString Status_3off="3off";
private slots:
    void room_switch_state( void );
    void on_room1_light_clicked(bool checked);
    void on_room2_light_clicked(bool checked);
    void on_room3_light_clicked(bool checked);
     void readPendingDatagrams(void);

private:
    Ui::control *ui;
    int current_select = 0; /* 当前选择的大棚 */
    //CoapPDU *get_switch_state; /* 使用coap获取开关的当前状态 */
     //QUdpSocket *udpSocket;
     QUdpSocket *relay_udpSocket;

    void send_coap_test_cmd( QString coap_url_cmd ); /* 发送coap节点状态测试指令 */
    QString coap_payload; /* coap接收到的负载 */
    void Send_Udp(int i,QString *Data);
    QString *Udp_Date;
    QByteArray Receive_Udp;
    void Receive_exp( QHostAddress sender,QByteArray rev);
};



typedef enum switch_state { /* 定义开关的状态 */
    SWITCH_ON = 1,
    SWITCH_OFF = 2
} switch_state;

#endif // CONTROL_H
