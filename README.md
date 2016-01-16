##dii是什么?

测试版1.0

结合Discuz与amazeui前端框架,模仿Yii开发的一个轻量级PHP框架.

##使用方法：
* 1.将dii目录放入Discuz网站的根目录
* 2.浏览访问地址  http://域名/dii/web/index.php?r=site/index

##简单开发逻辑讲解
* 1.dii唯一入口文件web/index.php;
* 2.入口参数?r=site/index分解 site-> controllerid , index-> actionid;
* 3.从入口参数获取 controllerid与actionid ,对应的执行对应的PHP文件与方法;

##例子：

http://域名/dii/web/index.php?r=site/index

* 1.分解;
  * $controllerid = 'site';
  * $actionid = 'index';
* 2.controller文件;
  * dii目录controllers 找到对应的 SiteController.php文件
* 3.action方法;
  * 根据actionid 执行对应的方法
* 4.view文件;
  * 根据controllerid与actionid请求对应的view/site/index.htm文件
  
##Dii亮点：
* 1.支持Discuz的所有核心函数,用户系统等;
* 2.view文件支持Discuz的template的标签所有的用法;
* 3.支持国内流行的前端框架amazeui;