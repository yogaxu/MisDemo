<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//加载支付宝支付
require_once APPPATH.'Libraries/AliPay/lib/alipay_submit.class.php';

/**
 * 为CI扩展支付宝支付类
 */
class CI_Alipay extends AlipaySubmit {

    protected $_CI;
    
    public function __construct($config){

        // 获得 CI 超级对象
//         $this->_CI = & get_instance();
        
        // 判断是否存在配置文件
//         if (empty($config)) {
            // 加载 Alipay 配置文件
//             $this->_CI->load->config('alipay_config', TRUE);
//             $config = $this->_CI->config->item('alipay_config');
//         }
        
        parent::__construct($config);

    }
}

?>