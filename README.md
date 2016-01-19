##dii是什么?

测试版1.1 (不定期更新中,请勿使用于正式网站,仅供学习交流使用)

作者:尹兴飞 

演示地址:http://dii.thinfell.com/

(定期同步最新版)

结合Discuz程序与amazeui前端框架,模仿Yii框架的基本方法,开发的一个轻量级PHP框架.

##使用方法：
* 1.将dii文件夹放入Discuz网站的根目录;
* 2.浏览访问地址"http://域名/dii/web/index.php?r=site/index";

##简单开发逻辑讲解：
* 1.dii唯一入口文件web/index.php;
* 2.入口参数?r=site/index
	* site-> controllerid;
	* index-> actionid;
* 3.从入口参数获取controllerid与actionid,执行对应的PHP文件与方法;

##例子：

URL: http://域名/dii/web/index.php?r=site/index

* 1.分解;
  * $controllerid = 'site';
  * $actionid = 'index';
* 2.controller文件;
  * dii目录controllers找到对应的SiteController.php文件;
* 3.action方法;
  * 根据actionid执行对应的public function actionIndex()方法;
* 4.models类;
  * 找到对应的models/SiteIndex.php处理数据;
* 5.view文件;
  * 根据controllerid与actionid请求对应的view/site/index.htm文件;
  
##Dii亮点：
* 1.支持Discuz的所有核心函数,用户系统等;
* 2.打通Ucenter无缝注册与登录;
* 2.view文件支持Discuz的template的标签所有的用法;
* 3.包含国内流行的前端框架amazeui;