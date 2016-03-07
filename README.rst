Gt Php SDK
===============
使用 3.1 之前版本SDK的用户如果想更新到3.1以及以后版本请先联系极验客服,因为为了兼容老用户,新的特性需要修改验证设置
本项目是面向服务器端的，具体使用可以参考我们的 `文档 <http://www.geetest.com/install/sections/idx-server-sdk.html>`_ ,客户端相关开发请参考我们的 `前端文档 <http://www.geetest.com/install/>`_.

开发环境
----------------

 - php5


快速开始
---------------



1. 获取代码

从 `Github <https://github.com/GeeTeam/gt-php-sdk/>`__ 上Clone代码:

.. code-block:: bash

    $ git clone https://github.com/GeeTeam/gt-php-sdk.git


2. 代码示例

根据自己的私钥出初始化验证

.. code-block :: php

  <?php 
  require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
  require_once dirname(dirname(__FILE__)) . '/config/config.php';
  $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
  session_start();
  $user_id = "test";
  $status = $GtSdk->pre_process($user_id);
  $_SESSION['gtserver'] = $status;
  $_SESSION['user_id'] = $user_id;
  echo $GtSdk->get_response_str();
   ?>



二次验证

.. code-block :: php

  <?php 
  require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
  require_once dirname(dirname(__FILE__)) . '/config/config.php';
  session_start();
  $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
  $user_id = $_SESSION['user_id'];
  if ($_SESSION['gtserver'] == 1) {
      $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $user_id);
      if ($result) {
          echo 'Yes!';
      } else{
          echo 'No';
      }
  }else{
      if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
          echo "yes";
      }else{
          echo "no";
      }
  }
  ?>


发布日志
-----------------
+ 3.2.0

 - 添加用户标识接口

+ 3.1.1

 - 统一接口

+ 3.1.0

 - 添加challenge加密特性，使验证更安全， 老版本更新请先联系管理员
