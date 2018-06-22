#include "main_dialog.h"
#include "ui_main_dialog.h"
#include "qdebug.h"
#include "control.h"
#include "QTextCodec"
#include <QFile>
#include "curve_show.h"
#include <QDebug>
#include <ex_variable.h>
#include "measure_timer.h"
int current_sel;
temp_humi Temp_Humi[Room_Number];
static int Choose_Status=0;
 extern const room_addr  addr_set[Room_Number] = { /* 大棚号码和IPv6地址的集合 */
 {1, "aaaa::212:4b00:102a:a556"},
 {2, "aaaa::212:4b00:1024:a7a6"},
{3, "aaaa::212:4b00:ef3:486b"}
};
main_Dialog::main_Dialog ( QWidget *parent ) : QDialog ( parent ), ui ( new Ui::main_Dialog ) {
    ui->setupUi ( this );
    //QTextCodec::setCodecForTr ( QTextCodec::codecForName ( "UTF-8" ) ); /* 指定字符集为UTF-8 */
    setWindowTitle ( QObject::tr ( "主界面" ) ); /* 设置界面的标题 */
    /*-------------------------------------------------------------*/
    temp_timer = new measure_timer ( this ); /* 启动定时器，定期向COAP服务器发送请求数据 */
    /*-------------------------------------------------------------*/
    current_date = QDateTime::currentDateTime().toString ( "yyyy-MM-dd" );
    for(double i=0;i<Room_Number;i++)
    {
        QString str=QString("_%1").arg(i);
        sql_create ( current_date+ str+ ".db" ); /* 数据库的名称是日期 */
    }
    //以下代码是定时器功能，每五秒更新一次面板的各个大棚数据
    timer = new QTimer();
    timer->setInterval ( 10*5000 ); /* 设置定时时间为1秒钟 */
    connect ( timer, SIGNAL ( timeout() ), this, SLOT ( show_temp_humi() ) ); /* 超时信号和测量的槽连接 */
    timer->start(); /* 启动定时器 */
}

void main_Dialog::show_temp_humi ( void ) {

        ui->temp->setText (Temp_Humi[0].temp + QObject::tr ( " 摄氏度" ));
        ui->humi->setText ( Temp_Humi[0].humi + " RH" );
        ui->temp_2->setText  (Temp_Humi[1].temp + QObject::tr ( " 摄氏度" ));
        ui->humi_2->setText ( Temp_Humi[1].humi + " RH" );
        ui->temp_3->setText (Temp_Humi[2].temp + QObject::tr ( " 摄氏度" ));
        ui->humi_3->setText ( Temp_Humi[2].humi + " RH" );
        double Max_Temp=ui->lineEdit->text().toDouble();
        double Min_Temp=ui->lineEdit_2->text().toDouble();
        double Max_Humi=ui->lineEdit_3->text().toDouble();
        double Min_Humi=ui->lineEdit_4->text().toDouble();
        double Choose_Temp=Temp_Humi[current_sel].temp.toDouble();
        double Choose_Humi=Temp_Humi[current_sel].humi.toDouble();

        Choose_Status=0;//每次将其设置为0，最后判断是否有异常
     if(Temp_Humi[current_sel].temp.toDouble()>-10&&Temp_Humi[current_sel].humi.toDouble()>0)
     {
         if(Max_Temp<Min_Temp)
             {
             ui->label_11->setText("温度参数设置错误");
         }else
         if(Max_Humi<Min_Humi)
             {
             ui->label_11->setText("湿度参数设置错误");
         }else
         {
             if(Choose_Temp>Max_Temp)
             {
                 qDebug()<<current_sel<<"号大棚温度过高";
                 ui->label_11->setText("大棚温度过高");
                 Choose_Status=1;
             }
             if(Choose_Temp<Min_Temp)
             {
                 qDebug()<<current_sel<<"号大棚温度过低";
                  ui->label_11->setText( "大棚温度过低");
                  Choose_Status=1;
             }
             if(Choose_Humi>Max_Humi)
             {
                 qDebug()<<current_sel<<"号大棚湿度太大";
                  ui->label_11->setText("大棚湿度太大");
                 Choose_Status=1;
             }
             if(Choose_Humi<Min_Humi)
             {
                 qDebug()<<current_sel<<"号大棚湿度太小";
                  ui->label_11->setText("大棚湿度太小");
                 Choose_Status=1;
             }
            if(!Choose_Status)
                ui->label_11->setText("大棚状态正常");

         }
     }else
          ui->label_11->setText("大棚尚未选取");


}

void main_Dialog::sql_create ( QString sql_name ) {
    QFile file ( sql_name );

    if ( file.exists() ) { /* judge whether the file is exist */
        qDebug ( "The file is exist" );
        return ;
    }

    QString create_sql = "create table measure_temp (room_id int, time double, temp int, humi int)";
    QSqlDatabase db;

    if(QSqlDatabase::contains ( "qt_sql_default_connection" ) ) {
        db = QSqlDatabase::database ( "qt_sql_default_connection" );
    } else {
        db = QSqlDatabase::addDatabase ( "QSQLITE" );
        qDebug()<<"使用qslite3数据库";
    }

    db.setDatabaseName ( sql_name ); /* 设置数据库的名字 */

    if ( !db.open() ) {
        qDebug ( "数据库不能打开" );
        qFatal ( "failed to connect." );
    }

    QSqlQuery sql_query ( db );
    sql_query.prepare ( create_sql );

    if ( !sql_query.exec() ) {
        qDebug() << sql_query.lastError();
    } else {
        qDebug() << "table created!";
    }

    db.close(); /* 关闭数据库 */
}

main_Dialog::~main_Dialog() {
    delete ui;
    Control->~control();
     curveShow->~curve_show();

}

void main_Dialog::receivelogin ( void ) {
    this->show();
}

void main_Dialog::on_temp_data_clicked() {
    curveShow = new curve_show ( this );
    curveShow->setAttribute( Qt::WA_DeleteOnClose, true );
    curveShow->show();
}

void main_Dialog::on_choose_class_currentIndexChanged ( int index ) {
    qDebug() << "change it" << index;
    ui->ip_addr->setText ( addr_set[index].ipv6_addr ); /* 显示当前IPv6地址 */
    current_sel = index;
   // show_temp_humi();
}


void main_Dialog::on_control_button_clicked()
{
    Control=new control;
    Control->setAttribute( Qt::WA_DeleteOnClose, true );
    Control->show();
}
