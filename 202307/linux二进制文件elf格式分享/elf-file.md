
# ELF文件

## 从源码到可执行文件

预处理 ->  编译 ->  汇编 ->  链接

```assembly
gcc -E filename.c > filename.i   ; preprocessed source
gcc -S filename.i > filename.s   ; assembly code
gcc -c filename.s > filename.o   ; object file
gcc    filename.o > filename.out ; binary executable
```

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/05/28/elf-file/0x1.png?raw=true)

### 链接

#### 静态链接 （编译后完成）

可移植性强，文件大

```sh
gcc file.c -static -o bin
```

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/05/28/elf-file/0x2.png?raw=true)

```assembly
gef➤  vmmap 
[ Legend:  Code | Heap | Stack ]
Start              End                Offset             Perm Path
0x00000000400000 0x00000000401000 0x00000000000000 r-- /usr/ctf/pwn/tests/bin_static
0x00000000401000 0x00000000479000 0x00000000001000 r-x /usr/ctf/pwn/tests/bin_static
0x00000000479000 0x000000004a0000 0x00000000079000 r-- /usr/ctf/pwn/tests/bin_static
0x000000004a0000 0x000000004a4000 0x000000000a0000 r-- /usr/ctf/pwn/tests/bin_static
0x000000004a4000 0x000000004a7000 0x000000000a4000 rw- /usr/ctf/pwn/tests/bin_static
0x000000004a7000 0x000000004ce000 0x00000000000000 rw- [heap]
0x007ffff7ff9000 0x007ffff7ffd000 0x00000000000000 r-- [vvar]
0x007ffff7ffd000 0x007ffff7fff000 0x00000000000000 r-x [vdso]
0x007ffffffde000 0x007ffffffff000 0x00000000000000 rw- [stack]
```



#### 动态链接 （程序加载后完成）

可移植性差，文件小

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/05/28/elf-file/0x3.png?raw=true)

```assembly
gef➤  vmmap 
[ Legend:  Code | Heap | Stack ]
Start              End                Offset             Perm Path
0x00555555554000 0x00555555555000 0x00000000000000 r-- /usr/ctf/pwn/tests/a.out
0x00555555555000 0x00555555556000 0x00000000001000 r-x /usr/ctf/pwn/tests/a.out
0x00555555556000 0x00555555557000 0x00000000002000 r-- /usr/ctf/pwn/tests/a.out
0x00555555557000 0x00555555558000 0x00000000002000 r-- /usr/ctf/pwn/tests/a.out
0x00555555558000 0x00555555559000 0x00000000003000 rw- /usr/ctf/pwn/tests/a.out
0x007ffff7dc3000 0x007ffff7dc6000 0x00000000000000 rw- 
0x007ffff7dc6000 0x007ffff7dec000 0x00000000000000 r-- /usr/lib/x86_64-linux-gnu/libc.so.6
0x007ffff7dec000 0x007ffff7f41000 0x00000000026000 r-x /usr/lib/x86_64-linux-gnu/libc.so.6
0x007ffff7f41000 0x007ffff7f94000 0x0000000017b000 r-- /usr/lib/x86_64-linux-gnu/libc.so.6
0x007ffff7f94000 0x007ffff7f98000 0x000000001ce000 r-- /usr/lib/x86_64-linux-gnu/libc.so.6
0x007ffff7f98000 0x007ffff7f9a000 0x000000001d2000 rw- /usr/lib/x86_64-linux-gnu/libc.so.6
0x007ffff7f9a000 0x007ffff7fa7000 0x00000000000000 rw- 
0x007ffff7fc3000 0x007ffff7fc5000 0x00000000000000 rw- 
0x007ffff7fc5000 0x007ffff7fc9000 0x00000000000000 r-- [vvar]
0x007ffff7fc9000 0x007ffff7fcb000 0x00000000000000 r-x [vdso]
0x007ffff7fcb000 0x007ffff7fcc000 0x00000000000000 r-- /usr/lib/x86_64-linux-gnu/ld-linux-x86-64.so.2
0x007ffff7fcc000 0x007ffff7ff1000 0x00000000001000 r-x /usr/lib/x86_64-linux-gnu/ld-linux-x86-64.so.2
0x007ffff7ff1000 0x007ffff7ffb000 0x00000000026000 r-- /usr/lib/x86_64-linux-gnu/ld-linux-x86-64.so.2
0x007ffff7ffb000 0x007ffff7ffd000 0x00000000030000 r-- /usr/lib/x86_64-linux-gnu/ld-linux-x86-64.so.2
0x007ffff7ffd000 0x007ffff7fff000 0x00000000032000 rw- /usr/lib/x86_64-linux-gnu/ld-linux-x86-64.so.2
0x007ffffffde000 0x007ffffffff000 0x00000000000000 rw- [stack]
```

## 重要节信息

| Section  |                             说明                             |          权限           |
| :------: | :----------------------------------------------------------: | :---------------------: |
|  .init   |                   初始化代码，先于main执行                   |           R_X           |
|  .fini   |                     结束代码，在最后执行                     |           R_X           |
|  .text   |                         程序汇编指令                         |           R_X           |
| .rodata  | 存放只读数据，一般是字符串常量（代码中直接使用的字符串也算） |           R__           |
|  .data   |     保存已经初始化（非零初始化）的全局变量和静态局部变量     |           RW_           |
|   .bss   |   未初始化（零初始化）的全局变量和静态局部变量保存在bss段    |           RW_           |
|   .got   |         Global Offset Table  存放外部符号的实际偏移          |           RW_           |
| .got.plt |           和.plt共同发挥作用，存放.plt所需的偏移量           | RW_ \| R__ (full-RELRO) |
|   .plt   | Procedure Linkage Table程序链接表   作为跳板调用外部函数  要么在`.got.plt`节中拿到地址，并跳转。要么当`.got.plt`没有所需地址的时候，触发链接器去找到所需的地址 |           R_X           |
| .plt.got |                   仅当开启full-RELRO时出现                   |           R_X           |
| .dynamic |                     存储动态链接器的加载                     |                         |

![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/05/28/elf-file/0x4.png?raw=true)  
![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/05/28/elf-file/0x5.png?raw=true)

### 调用外部函数时plt和got行为

调用外部函数，首先都跳转至对应PLT区，再跳转至对应GOT区

- 若为首次调用该函数

  ![img](https://github.com/Antel0p3/Antel0p3.github.io/blob/main/2023/05/28/elf-file/0x6.png?raw=true)

  1. 依次跳转到 printf@plt 和 printf@got
  2. 由got跳转至 printf@plt+6   
  3. 跳转至_plt
  4. 再跳转到 resolve 函数获取 printf 函数的绝对地址，将地址存入got表（准确来说是.got.plt）并执行printf

- 非首次调用

  call func -> func@plt -> func@got -> 真实地址

> 参考
>
> https://hackthedeveloper.com/c-program-compilation-process/
>
> https://www.matteomalvica.com/minutes/binary_analysis/
>
> https://intezer.com/blog/research/executable-linkable-format-101-part1-sections-segments/
>
> https://intezer.com/blog/malware-analysis/executable-linkable-format-101-part-4-dynamic-linking/