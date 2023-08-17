# 一、XSS

### 1.简介：XSS 又称CSS(Cross Site Scripting)或[跨站脚本攻击](https://so.csdn.net/so/search?q=%E8%B7%A8%E7%AB%99%E8%84%9A%E6%9C%AC%E6%94%BB%E5%87%BB\&spm=1001.2101.3001.7020)，攻击者在网页中插入由JavaScript编写的恶意代码，当用户浏览被嵌入恶意代码的网页时，恶意代码将会在用户的浏览器上执行。

### 2.类型

*   反射型XSS：只是简单地把用户输入的数据反射给浏览器，简单来说，黑客往往需要用户诱使用户点击一个恶意链接，才能攻击成功。（经后端，不经数据库）

    ![image.png](https://note.youdao.com/yws/public/resource/60002547c9405810af9eb37779031896/WEBRESOURCE4202d4ee25594b688c2691178b4c76a6)
*   存储型XSS：将用户输入的数据存储在服务器端。用户访问了带有xss代码的页面代码后，产生安全问题。(经后端和数据库)

    ![image.png](https://note.youdao.com/yws/public/resource/60002547c9405810af9eb37779031896/WEBRESOURCEfb7582f2c5114d7abe16113e64bf54dc)
*   DOM  XSS：通过修改页面的DOM节点形成的XSS。客户端的脚本程序可以通过DOM动态地检查和修改页面内容，它不依赖于提交数据到服务器端，而从客户端获得DOM中的数据在本地执行，如果DOM中的数据没有经过严格确认，就会产生DOM XSS漏洞。一般是浏览器前端代码进行处理。(不经过后端，是基于文档对象模型的一种漏洞，是通过url传入参数去控制触发的)

### 3.XSS的危害

*   盗取用户cookie
*   盗取各类用户帐号，如机器登录帐号、用户网银帐号、各类管理员帐号
*   控制企业数据，包括读取、篡改、添加、删除企业敏感数据的能力
*   盗窃企业重要的具有商业价值的资料
*   强制发送电子邮件
*   网站挂马
*   ...

### 4.常见XSS攻击方式

1.  script标签

    \<script>标签用于定义客户端脚本，比如JavaScript

    \<script>alert(1);\</script>

    \<script>alert("xss");\</script>
2.  img标签

    \<img>标签定义HTML页面中的图像

    \<img src=1 onerror=alert(1);>
3.  video标签

    \<video>标签定义视频，比如电影片段或其他视频流

    \<video>\<source onerror=alert(1)>
4.  audio标签

    \<audio>标签定义声音，比如音乐或其他音频流

    \<audio src=x  onerror=alert(1)>
5.  body标签

    \<body>标签定义文档的主体

    \<body onload=alert(1);>

# 二、DVWA

### （1）配置DVWA环境

1.  完成phpstudy的配置
2.  将DVWA.zip压缩包解压到phpstudy的WWW路径下（注：把 DVWA 文件夹放在 WWW 下面，不能再嵌套文件夹，也不能直接把代码文件放在 WWW 目录下）
3.  在phpstudy上添加网站

    ![image.png](https://note.youdao.com/yws/public/resource/60002547c9405810af9eb37779031896/WEBRESOURCE1f1e222fef6c44298c3c27dda5b34a0e)
4.  修改配置文件

    在DVWA的config文件夹中找到config.inc.php.dist

    复制，并在当前目录下粘贴一个副本

    将副本文件名修改为config.inc.php

    打开config.inc.php，修改用户名与密码，均改为root
5.  用http\://dvwa打开即可

### （2）XSS（Reflected）反射型

1.  Low

        <?php

        header ("X-XSS-Protection: 0");

        // Is there any input?
        if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
            // Feedback for end user
            echo '<pre>Hello ' . $_GET[ 'name' ] . '</pre>';
        }

        ?>

    发现没有任何防御，所以我们直接输入\<script>alert('xss')\</script>
2.  Medium

        <?php

        header ("X-XSS-Protection: 0");

        // Is there any input?
        if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
            // Get input
            $name = str_replace( '<script>', '', $_GET[ 'name' ] );

            // Feedback for end user
            echo "<pre>Hello ${name}</pre>";
        }

        ?>

    发现源码过滤了\<script>,可以通过大写字母，双写，输入其他可执行弹窗的标签等方法来实现攻击.

    如果用\<script>alert('xss')\</script>会直接显示alert('xss')

    大写绕过    \<Script>alert('xss')\</script>

    双写绕过  \<sc\<script>ript>alert('xss')\</script>

    标签img   \<img src=1 οnerrοr=alert('xss');>
3.  High

        <?php

        header ("X-XSS-Protection: 0");

        // Is there any input?
        if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
            // Get input
            $name = preg_replace( '/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i', '', $_GET[ 'name' ] );

            // Feedback for end user
            echo "<pre>Hello ${name}</pre>";
        }

        ?>

    查看源代码，发现preg\_replace 函数，是执行一个正则表达式的搜索和替换，直接将所有的\<script>无论大小写都进行了过滤，但并未对其他标签进行限制，所以我们继续使用img等标签来进xss利用。

    \<img src=1 οnerrοr=alert('xss');>
4.  Impossible

        <?php

        // Is there any input?
        if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
            // Check Anti-CSRF token
            checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' );

            // Get input
            $name = htmlspecialchars( $_GET[ 'name' ] );

            // Feedback for end user
            echo "<pre>Hello ${name}</pre>";
        }

        // Generate Anti-CSRF token
        generateSessionToken();

        ?>

    使用htmlspecialchar函数，把字符转换为实体，防止浏览器将其作为HTML元素，过滤了我们输入的任何包含脚本标记语言。从源头上把跨站脚本攻击的可能性降到了最低。例如：

    ![image.png](https://note.youdao.com/yws/public/resource/60002547c9405810af9eb37779031896/WEBRESOURCEef22db012eb04587b4d1ef1b010ac5b9)

### （3）XSS（Stored）存储型

1.  Low

        <?php

        if( isset( $_POST[ 'btnSign' ] ) ) {
            // Get input
            $message = trim( $_POST[ 'mtxMessage' ] );
            $name    = trim( $_POST[ 'txtName' ] );

            // Sanitize message input
            $message = stripslashes( $message );
            $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $message ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

            // Sanitize name input
            $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $name ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

            // Update database
            $query  = "INSERT INTO guestbook ( comment, name ) VALUES ( '$message', '$name' );";
            $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

            //mysql_close();
        }

        ?>

    查看源代码，发现使用mysqli\_real\_escape\_string函数来对string中的特殊符号进行转义处理，但并未对我们输入的Name和Message进行xss的过滤。因此我们只需要直接输入JS代码进行攻击即可得到弹窗，攻击成功。

    \<script>alert(1)\</script>
2.  Medium

        <?php

        if( isset( $_POST[ 'btnSign' ] ) ) {
            // Get input
            $message = trim( $_POST[ 'mtxMessage' ] );
            $name    = trim( $_POST[ 'txtName' ] );

            // Sanitize message input
            $message = strip_tags( addslashes( $message ) );
            $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $message ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
            $message = htmlspecialchars( $message );

            // Sanitize name input
            $name = str_replace( '<script>', '', $name );
            $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $name ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

            // Update database
            $query  = "INSERT INTO guestbook ( comment, name ) VALUES ( '$message', '$name' );";
            $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

            //mysql_close();
        }

        ?>

    查看源代码，发现将Message所有可能xss攻击的标签都进行了转义或过滤，但对Name仅仅限制了\<script>的标签，因此我们依旧可以在Name中使用大写、双写、使用其他标签等方法来进行注入。

    \<Script>alert(1)\</script>
3.  High

        <?php

        if( isset( $_POST[ 'btnSign' ] ) ) {
            // Get input
            $message = trim( $_POST[ 'mtxMessage' ] );
            $name    = trim( $_POST[ 'txtName' ] );

            // Sanitize message input
            $message = strip_tags( addslashes( $message ) );
            $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $message ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
            $message = htmlspecialchars( $message );

            // Sanitize name input
            $name = preg_replace( '/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i', '', $name );
            $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $name ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

            // Update database
            $query  = "INSERT INTO guestbook ( comment, name ) VALUES ( '$message', '$name' );";
            $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

            //mysql_close();
        }

        ?>

    查看代码，发现在Medium的基础上对Name的输入进行了\<script>的转义限制，因此我们只需要换一个同样能进行弹窗的标签即可。

    \<img src=1 onerror=alert('2');>
4.  Impossible

        <?php

        if( isset( $_POST[ 'btnSign' ] ) ) {
            // Check Anti-CSRF token
            checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' );

            // Get input
            $message = trim( $_POST[ 'mtxMessage' ] );
            $name    = trim( $_POST[ 'txtName' ] );

            // Sanitize message input
            $message = stripslashes( $message );
            $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $message ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
            $message = htmlspecialchars( $message );

            // Sanitize name input
            $name = stripslashes( $name );
            $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $name ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
            $name = htmlspecialchars( $name );

            // Update database
            $data = $db->prepare( 'INSERT INTO guestbook ( comment, name ) VALUES ( :message, :name );' );
            $data->bindParam( ':message', $message, PDO::PARAM_STR );
            $data->bindParam( ':name', $name, PDO::PARAM_STR );
            $data->execute();
        }

        // Generate Anti-CSRF token
        generateSessionToken();

        ?>

    查看源代码，发现使用内置的PHP函数来转义任何改变输入行为的值。

# 三、cookie的介绍

### （1）Cookie

1.  内容：key/value 格式，例如：name=abc，id=99，islogin=1
2.  产生：

    Set-Cookie：第一次访问，服务器响应给客户端

    Cookie：之后的访问，客户端发送给服务器

    ![image.png](https://note.youdao.com/yws/public/resource/60002547c9405810af9eb37779031896/WEBRESOURCEe8c3599138997fd924bbbf4073973047)
3.  set-cookie格式：

    ![image.png](https://note.youdao.com/yws/public/resource/60002547c9405810af9eb37779031896/WEBRESOURCE07c8aad61e5ea8a35c88e9fdfdc933ae)
4.  cookie用途：记住登录状态；跟踪用户行为

### （2）Session

1.  session创建、校验、销毁

    ![image.png](https://note.youdao.com/yws/public/resource/60002547c9405810af9eb37779031896/WEBRESOURCE817344040a2a6fa813a917b9b99c8da2)
2.  cookie与session的区别

    ![image.png](https://note.youdao.com/yws/public/resource/60002547c9405810af9eb37779031896/WEBRESOURCE50a66a11540a1e8da5c3798eca3e4642)

### （3）利用cookie实现登录
