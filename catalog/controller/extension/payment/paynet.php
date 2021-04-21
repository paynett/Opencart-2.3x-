<?php
ini_set("display_errors", "on");

class ControllerExtensionPaymentPaynet extends Controller
{

    public function index()
    {
        $this->load->language('payment/epaynet');
        $this->document->addStyle('catalog/view/theme/default/stylesheet/paynet_form.css');
		$this->document->addScript('catalog/view/javascript/paynet/embed.js');

        $data['text_instruction'] = $this->language->get('text_instruction');
        $data['text_description'] = $this->language->get('text_description');
        $data['text_payment'] = $this->language->get('text_payment');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['button_confirm'] = $this->language->get('button_confirm');

        $data['bank'] = nl2br($this->config->get('paynet_bank' . $this->config->get('config_language_id')));
		$data['continue'] = $this->url->link('checkout/success');


        $data['button_url'] =$this->url->link('extension/payment/paynet/paymentform', '', true);
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/paynet.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/paynet.tpl', $data);
			} else {
				return $this->load->view('payment/paynet.tpl', $data);
			}
    }

    public function paymentform()
    {
        $this->load->model('checkout/order');
        $this->load->model('setting/setting');
		
        require_once(DIR_APPLICATION . 'controller/extension/payment/paynetconfig.php');
        if (!isset($this->session->data['order_id']) OR ! $this->session->data['order_id'])
            die('Sipariş ID bulunamadı');
	
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $record = array('result_code' => false, 'result_message' => false);

        $cc_form_key = md5($order_info['order_id'] . $order_info['store_url']);
        $total_cart = $order_info['total'];
        $order_id = $this->session->data['order_id'];
		$gateway_error = false;
		if(isset($this->request->post['session_id']) AND $this->request->post['token_id']){	
			$mode = $this->config->get('paynet_test_mode') == 'on' ? 'test' : 'prod';
			try{
				$paynet = new PaynetClient($this->config->get('paynet_secret_key'), $mode);
				$chargeParams = new ChargeParameters();
				$chargeParams->session_id = $this->request->post['session_id'];
				$chargeParams->token_id = $this->request->post['token_id'];
			    $chargeParams->amount = PaynetTools::FormatWithoutDecimalSeperator($total_cart);					
				$chargeParams->ratio_code = $this->config->get('paynet_ratio_code');
				$chargeParams->tds_required = $this->config->get('paynet_force_tds') == 'on' ? 'true' : 'false';
				$chargeParams->add_comission_amount = $this->config->get('paynet_ins_fee') == 'on' ? 'true': 'false';
				$chargeParams->installments = $this->config->get('paynet_installment_options');
				$result = $paynet->ChargePost($chargeParams);
				
				if($result->is_succeed == true){							
					$this->db->query("UPDATE " . DB_PREFIX . "order SET  `total` = '" . (float) $result->amount . "' WHERE order_id = '$order_id'  "); 
					$this->db->query("UPDATE " . DB_PREFIX . "order_total SET  `value` = '" . (float) $result->amount . "' WHERE order_id = '$order_id'  ");		
					$this->session->data['payment_method']['code'] = 'paynet';
					$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('paynet_order_status_id'), json_encode(array('Paynet_ID' => $result->xact_id)));
					$this->response->redirect($this->url->link('checkout/success', '', 'SSL'));	
				} else {
					$gateway_error = $this->language->get('Your bank responsed:') . '(' . $result->code . ') ' . $result->message.' '.$result->paynet_error_message;
				}
			}
			catch (PaynetException $e)
			{
				$gateway_error = $e->getMessage();
			}
		}		
		
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        $data['cart_id'] = $this->session->data['order_id'];
        $data['form_link'] = $this->url->link('payment/paynet/paymentform', '', 'SSL');
        $data['payment_button'] = $this->getPaymentButton();
        $data['error_message'] = $gateway_error;

        $this->response->setOutput($this->load->view('payment/paynet_form', $data));

    }
	
	
	public function getPaymentButton(){

        $this->load->model('checkout/order');
        $this->load->model('setting/setting');
        require_once(DIR_APPLICATION . 'controller/extension/payment/paynetconfig.php');
        if (!isset($this->session->data['order_id']) OR ! $this->session->data['order_id'])
            die('Sipariş ID bulunamadı');
	
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $record = array('result_code' => false, 'result_message' => false);

        $cc_form_key = md5($order_info['order_id'] . $order_info['store_url']);
        $total_cart = $order_info['total'];
        $order_id = $this->session->data['order_id'];

		$jsurl = 'https://pj.paynet.com.tr/public/js/paynet.min.js';
		if( $this->config->get('paynet_test_mode') == 'on')
			$jsurl = 'https://pts-pj.paynet.com.tr/public/js/paynet.js';
		
		$logo_url_a = $this->config->get('config_ssl') . 'image/' . $this->config->get('config_logo');
		if(!file_exists($logo_url_a))
			$logo_url_a = $this->config->get('config_ssl') . 'catalog/view/theme/default/image/paynet/paynet_logo.png';
		
		$button_text = $this->config->get('paynet_button_text') != "" ? $this->config->get('paynet_button_text') : 'Ödemeyi tamamla';
		$form_text = $this->config->get('paynet_form_text') != "" ? $this->config->get('paynet_form_text') : 'Kart bilgilerinizi girip ödemeyi tamamla butonuna tıklayınız';
		$logo_url = $this->config->get('paynet_logo_url') != "" ? $this->config->get('paynet_logo_url') : $logo_url_a;
		
		$js = '
			 <form action="" method="post" name="checkout-form" id="checkout-form">
		<script type="text/javascript"
			class="paynet-button"
			data-platform_id="OPENCART"
			src="'.$jsurl.'"
			data-key="' . $this->config->get('paynet_data_key'). '"
			data-amount= '.PaynetTools::FormatWithoutDecimalSeperator($total_cart).'
			data-image="'.$logo_url.'"
			data-button_label="'.$button_text.'"
			data-description="'.$form_text.'"
			data-agent="'.$this->config->get('paynet_agent_code').'"
			data-ratio_code="'.$this->config->get('paynet_ratio_code').'"
			data-installments="'.$this->config->get('paynet_installment_options').'"
			data-add_commission_amount="'.($this->config->get('paynet_ins_fee') == 'on' ? 'true': 'false').'"
			data-tds_required="'.($this->config->get('paynet_force_tds') == 'on' ? 'true' : 'false').'"
			data-pos_type="5">
		</script>
	    </form>';
		
		return $js;
		
	}

}