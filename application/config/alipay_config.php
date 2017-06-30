<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  

define('PARTNER', get_partner());
define('ALIKEY', get_alikey());

/* * 
 * 配置文件 
 * 版本：3.4 
 * 修改日期：2016-03-08 
 * 说明： 
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。 
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。 
 
 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？ 
 * 解决方法： 
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置 
 * 2、更换浏览器或电脑，重新登录查询。 
 */  
   
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓  
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm  
// $config['partner']      = '2088621879218947';  
$config['partner']      = PARTNER;  
  
//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号  
$config['seller_id']    = $config['partner'];  
  
// MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm  
// $config['key']          = 'nxs0xo0l4109coh5a9t4s58xhme3tcbu';  
$config['key']          = ALIKEY;  
  
// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问  
$config['notify_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/mapp/voucher/alipayNotifyUrl';  
  
// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问  
$config['return_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/mapp/voucher/alipayReturnUrl';  
  
//签名方式  
$config['sign_type']    = strtoupper('MD5');  
  
//字符编码格式 目前支持 gbk 或 utf-8  
$config['input_charset']= strtolower('utf-8');  
  
//ca证书路径地址，用于curl中ssl校验  
//请保证cacert.pem文件在当前文件夹目录中  
$config['cacert']    = APPPATH.'libraries/AliPay/cacert.pem';  
  
//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http  
$config['transport']    = 'http';  
  
// 支付类型 ，无需修改  
$config['payment_type'] = "1";  
          
// 产品类型，无需修改  
$config['service'] = "alipay.wap.create.direct.pay.by.user";  
  
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  
  
  
//↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓  
      
// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数  
$config['anti_phishing_key'] = "";  
      
// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1  
$config['exter_invoke_ip'] = "";  
          
//↑↑↑↑↑↑↑↑↑↑请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ 