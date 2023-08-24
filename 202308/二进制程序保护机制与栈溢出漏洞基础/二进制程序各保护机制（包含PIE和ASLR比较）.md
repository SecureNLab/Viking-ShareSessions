# 二进制程序各保护机制（包含PIE和ASLR比较）

```assembly
checksec bin 
[*] '/usr/ctf/pwn/tests/bin'
    Arch:     amd64-64-little
    RELRO:    Partial RELRO
    Stack:    No canary found
    NX:       NX enabled
    PIE:      PIE enabled
```

## CANARY

> 栈溢出保护是一种缓冲区溢出攻击缓解手段，当函数存在缓冲区溢出攻击漏洞时，攻击者可以覆盖栈上的返回地址来让shellcode能够得到执行。当启用栈保护后，函数开始执行的时候会先往栈里插入cookie信息，当函数真正返回的时候会验证cookie信息是否合法，如果不合法就停止程序运行。攻击者在覆盖返回地址的时候往往也会将cookie信息给覆盖掉，导致栈保护检查失败而阻止shellcode的执行。在Linux中我们将cookie信息称为canary。

编译时可以控制栈保护程度

```sh
gcc -fno-stack-protector -o test test.c  //禁用栈保护
gcc -fstack-protector -o test test.c   //启用堆栈保护，不过只为局部变量中含有 char 数组的函数插入保护代码
gcc -fstack-protector-all -o test test.c //启用堆栈保护，为所有函数插入保护代码
```

## NX

> NX即No-eXecute（不可执行）的意思，NX的基本原理是将**数据所在内存页标识为不可执行**，当程序溢出成功转入shellcode时，程序会尝试在数据页面上执行指令，此时CPU就会抛出异常，而不是去执行恶意指令。

总的说就是开了栈上就不可执行代码，没开就可以

gcc编译器默认开启NX，关闭选项：

```sh
gcc test.c -z execstack -o test 
```

## RELRO

> 设置符号重定向表格为只读或在程序启动时就解析并绑定所有动态符号，从而减少对GOT（Global Offset Table）攻击。RELRO为” Partial RELRO”，说明我们对GOT表具有写权限。

Partial RELRO 可以写GOT表；FULL RELRO写不了

## PIE

> PIE（Position Independent Executables）是编译器（gcc，..）功能选项（-fPIE），作用于excutable编译过程，可将其理解为特殊的PIC（so专用，Position Independent Code），加了PIE选项编译出来的ELF用file命令查看会显示其为so，其随机化了ELF装载内存的基址（代码段、plt、got、data等共同的基址）

## ASLR

> 首先ASLR是归属于系统功能的， 是一种针对缓冲区溢出的安全保护技术，通过对堆、栈、共享库映射等线性区布局的随机化，通过增加攻击者预测目的地址的难度，防止攻击者直接定位攻击代码位置，达到阻止溢出攻击的目的的一种技术。

有三种模式  存储于 `/proc/sys/kernel/randomize_va_space`

```
0 - 表示关闭进程地址空间随机化。
1 - 表示将mmap的基址，stack和vdso页面随机化。
2 - 表示在1的基础上增加栈（heap）的随机化。
```

PWN的话题目环境一般都是开 2

## PIE和ASLR异同

单看比较生硬，看下面的vmmap比较会更清晰，建议读者执行程序对比分析

- PIE是编译器功能选项，作用于excutable编译过程，随机化了ELF装载内存的基址（代码段、plt、got、data等共同的基址）
- ASLR的是操作系统的功能选项，作用于executable（ELF）装入内存运行时，只能随机化stack、heap、libraries（.so）的基址，不负责代码段、plt、got、data基地址的随机化
- ASLR早于PIE出现
- CTF中PWN题基本都会开ASLR=2

gcc编译默认开启PIE，关闭选项：

```sh
gcc test.c -o bin_pie
gcc test.c -no-pie -o bin_no_pie
```

gef 调试时默认关闭ASLR，启动方式：

```sh
gef➤  aslr on
[+] Enabling ASLR
gef➤  start	# 注意aslr开启一定要在start之前
```

#### pie off, aslr off

每次执行后 所有地址区间都是固定的

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/07/17/binary-protection/0x1.png?raw=true)

#### pie off, aslr on

- 可以看到红色部分代码程序段与ASLR关闭时相同，说明ASLR不负责这部分地址随机化
- 蓝色部分每次执行都是随机的，即 堆、栈、libc段等

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/07/17/binary-protection/0x2.png?raw=true)

#### pie on, aslr off

- 与 `pie off, aslr off` 的差别仅在于红色部分代码程序段，相当于都加了一个偏移量
- 但是每次执行后  所有地址区间也都是固定的

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/07/17/binary-protection/0x3.png?raw=true)

#### pie on, aslr on

这时候相当于所有地址区域每次执行后  蓝色区域都是随机的

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/07/17/binary-protection/0x4.png?raw=true)

## 总结

1. PIE相当于能力赋予，而ASLR才是真正使用
2. 在CTF中，PIE主要影响程序（不包含libc）的地址，影响跳转目标执行地址的确定；ASLR主要影响 libc, stack 和 heap 的地址确定
3. 注意即便地址是随机的，但同一地址区域内的内容的偏移量都是固定的
4. PIE开启后，IDA中看到的代码地址不能直接使用，要加上一个base（通常需泄露）

## 其他

开了PIE和ASLR时每次地址都会变，那么如何下断点呢？

如果有符号表的话当然可以直接使用 `b func_name` ，但如果没有符号表，在gef中可以使用 `pie b offset` ，gef会自动帮我们计算出正确的地址，如下图

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/07/17/binary-protection/0x5.png?raw=true)