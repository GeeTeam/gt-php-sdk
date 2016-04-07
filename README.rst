Gt Php SDK
===============
使用 3.1 之前版本SDK的用户如果想更新到3.1以及以后版本请先联系极验客服,因为为了兼容老用户,新的特性需要修改验证设置
本项目是面向服务器端的，具体使用可以参考我们的 `文档 <http://www.geetest.com/install/sections/idx-server-sdk.html>`_ ,客户端相关开发请参考我们的 `前端文档 <http://www.geetest.com/install/>`_.

开发环境
----------------

 - php5.2


部署架构
---------------
详见 `部署架构 <http://www.geetest.com/install/sections/idx-basic-introduction.html#id7>`__ 


前端接口
-------------------
详见 `前端接口 <http://www.geetest.com/install/sections/idx-client-sdk.html#config-para>`__ 

宕机回滚
--------------
详见 `宕机回滚 <http://www.geetest.com/install/sections/idx-basic-introduction.html#id8>`__ 


文件说明
---------------
 - config/config.php 极验ID和KEY配置文件,请在 `极验后台 <http://account.geetest.com>`__ 申请,进行替换
 - lib/class.geetestlib.php 极验库文件(请不要随意改动)
 - static/login.php 前端展示页面,根据您的需求进行自定义
 - web/StartCaptchaServlet.php 根据自己的私钥初始化验证
 - web/VerifyLoginServlet.php 根据post参数进行二次验证



常见问题
--------------
1. 3.1.0之前的老版本SDK,不兼容现在的id和key

发布日志
-----------------
+ 3.2.0

 - 添加用户标识接口

+ 3.1.1

 - 统一接口

+ 3.1.0

 - 添加challenge加密特性，使验证更安全， 老版本更新请先联系管理员
