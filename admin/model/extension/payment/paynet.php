<?php 
class ModelExtensionPaymentPaynet extends Model {
	public function install() {
		$this->load->model('setting/setting');	
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.DB_PREFIX.'paynet_payment` (
		  `id_order` int(10) unsigned NOT NULL,
		  `id_cart` int(10) unsigned NOT NULL,
		  `id_customer` int(10) unsigned NOT NULL,
		  `bank` varchar(12) NULL,
		  `amount` decimal(10,4) NOT NULL,
		  `amount_paid` decimal(10,4) NOT NULL,
		  `installment` int(2) unsigned NOT NULL DEFAULT 1,
		  `cc_name` varchar(25) NULL,
		  `cc_number` varchar(16) NULL,
		  `cc_expiry` varchar(8) NULL,
		  `id_paynet` varchar(32) NULL,
		  `date_create` datetime NOT NULL,
		  `debug` text NULL,
		  `result` tinyint(1) DEFAULT 0,
		  `result_message` varchar(60) NULL,
		  `result_code` varchar(6) NULL,
		  KEY `id_order` (`id_order`),
		  KEY `id_cart` (`id_cart`),
		  KEY `id_customer` (`id_customer`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
		$this->config->set('paynet_test_mode', 'on');
		return true;
	}
}
