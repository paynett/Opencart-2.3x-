<?php
ini_set("display_errors", "on");

class ControllerExtensionPaymentPaynet extends Controller
{
	private $error = array();

	/* 	
	 * 	Do not change following lines, 
	 * 	will be used for checking updates and for support processes 
	 */
	private $id_eticsoft = 33;
	private $key_eticsoft = 'fef7a93a6fcfe146395db619082c5996';
	private $version = 1.0;

	/* -- */
	
	
	public function install () {
		$this->load->model('extension/payment/paynet');
		$this->model_extension_payment_paynet->install();
	}
	

	public function index()
	{
		$this->load->language('payment/paynet');	
		$this->document->setTitle('Kredi Kartı İle Ödeme');
		$this->load->model('setting/setting');
		include(DIR_CATALOG . 'controller/extension/payment/paynetconfig.php');

		if (isset($this->request->post['paynet_submit'])) {
			$this->model_setting_setting->editSetting('paynet', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/payment/paynet', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}



		if (isset($this->request->post['confirm_paynet_register'])) {
			$this->registerPaynet();
			$this->model_setting_setting->editSetting('paynet', array('paynet_registered' => "ok"));
			$this->response->redirect($this->url->link('extension/payment/paynet', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

	
        $data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['help_total'] = $this->language->get('help_total');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['paynet_registered'] = $this->config->get('paynet_registered');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if ($this->config->get('paynet_data_key') == null)
			$data['error_warning'] .= 'paynet Data Key Alanı Boş<br/>';

		if ($this->config->get('paynet_secret_key') == null)
			$data['error_warning'] .= 'paynet Secret Key Alanı Boş<br/>';

		if (isset($this->request->post['paynet_agent_code'])) {
			$data['paynet_agent_code'] = $this->request->post['paynet_agent_code'];
		} else {
			$data['paynet_agent_code'] = $this->config->get('paynet_agent_code');
		}
		
		if (isset($this->request->post['paynet_ratio_code'])) {
			$data['paynet_ratio_code'] = $this->request->post['paynet_ratio_code'];
		} else {
			$data['paynet_ratio_code'] = $this->config->get('paynet_ratio_code');
		}
				
		if (isset($this->request->post['paynet_data_key'])) {
			$data['paynet_data_key'] = $this->request->post['paynet_data_key'];
		} else {
			$data['paynet_data_key'] = $this->config->get('paynet_data_key');
		}
		if (isset($this->request->post['paynet_secret_key'])) {
			$data['paynet_secret_key'] = $this->request->post['paynet_secret_key'];
		} else {
			$data['paynet_secret_key'] = $this->config->get('paynet_secret_key');
		}
		
		if (isset($this->request->post['paynet_button_text'])) {
			$data['paynet_button_text'] = $this->request->post['paynet_button_text'];
		} else {
			$data['paynet_button_text'] = $this->config->get('paynet_button_text');
		}

		if (isset($this->request->post['paynet_form_text'])) {
			$data['paynet_form_text'] = $this->request->post['paynet_form_text'];
		} else {
			$data['paynet_form_text'] = $this->config->get('paynet_form_text');
		}

		if (isset($this->request->post['paynet_logo_url'])) {
			$data['paynet_logo_url'] = $this->request->post['paynet_logo_url'];
		} else {
			$data['paynet_logo_url'] = $this->config->get('paynet_logo_url');
		}

		if (isset($this->request->post['paynet_ins_fee'])) {
			$data['paynet_ins_fee'] = $this->request->post['paynet_ins_fee'];
		} else {
			$data['paynet_ins_fee'] = $this->config->get('paynet_ins_fee');
		}

		if (isset($this->request->post['paynet_installment_options'])) {
			$data['paynet_installment_options'] = $this->request->post['paynet_installment_options'];
		} else {
			$data['paynet_installment_options'] = $this->config->get('paynet_installment_options');
		}

		if (isset($this->request->post['paynet_force_tds'])) {
			$data['paynet_force_tds'] = $this->request->post['paynet_force_tds'];
		} else {
			$data['paynet_force_tds'] = $this->config->get('paynet_force_tds');
		}

		if (isset($this->request->post['paynet_test_mode'])) {
			$data['paynet_test_mode'] = $this->request->post['paynet_test_mode'];
		} else {
			$data['paynet_test_mode'] = $this->config->get('paynet_test_mode');
		}

		if (isset($this->request->post['paynet_status'])) {
			
			$data['paynet_status'] = $this->request->post['paynet_status'];
		} else {
			$data['paynet_status'] = $this->config->get('paynet_status');
		}

		if (isset($this->request->post['paynet_order_status_id'])) {
			$data['paynet_order_status_id'] = $this->request->post['paynet_order_status_id'];
		} else {
			$data['paynet_order_status_id'] = $this->config->get('paynet_order_status_id');
		}
		
		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$data['base'] = $this->config->get('config_ssl');
		} else {
			$data['base'] = $this->config->get('config_url');
		}
		
		$paynet_rates = $this->getRates();

		if ($paynet_rates->code != 0) {
			$installments = $this->error = 'Oranlar alınamadı. Lütfen gizli anahtarınızı (PayNet Secret Key) kontrol edin!' . print_r($paynet_rates, true);
		} else
			$installments = PaynetTools::getAdminInstallments(100, $paynet_rates->data);

		$data['paynet_rates_table'] = $installments;

		$data['text_edit'] = 'Paynet SanalPOS modülü ayarları';
		$data['heading_title'] = 'Paynet SanalPOS modülü ayarları';
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['breadcrumbs'] = array();
		$data['header'] = $this->load->controller('common/header');

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('PayNet SanalPOS'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('PayNet Ayarlar'),
			'href' => $this->url->link('payment/paynet', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['action'] = $this->url->link('extension/payment/paynet', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->response->setOutput($this->load->view('payment/paynet.tpl', $data));
	}

	public function getTransaction($xact_id)
	{
		include_once(DIR_CATALOG . 'controller/payment/paynetconfig.php');
		$test_mode = $this->config->get('paynet_test_mode') == 'on' ? 'test' : 'prod';
		try {
			$paynet = new PaynetClient($this->config->get('paynet_secret_key'), $test_mode);
			$param = new TransactionDetailParameters();
			$param->xact_id = $xact_id;
		} catch (PaynetException $e) {
			echo $e->getMessage();
		}
		return $paynet->GetTransactionDetail($param);
	}

	public function getRates($price = 100)
	{
		$test_mode = $this->config->get('paynet_test_mode') == 'on' ? 'test' : 'prod';
		try {
			$paynet = new PaynetClient($this->config->get('paynet_secret_key'), $test_mode);
			$ratioParameters=new RatioParameters();
			$ratioParameters->ratio_code=$this->config->get('paynet_ratio_code');
			$rates = $paynet->GetRatios($ratioParameters);
		} catch (PaynetException $e) {
			return $e->getMessage();
		}
		return $rates;
	}

	private function registerPaynet($url = "")
	{
		$d = $_SERVER['HTTP_HOST'];
		if (substr($d, 0, 4) == " www.")
			$d = substr($d, 4);
		$data = array();
		$data['product_id'] = $this->id_eticsoft;
		$data['product_version'] = $this->version;
		$data['product_name'] = 'Opencart EticSoft_Paynet SanalPOS';
		$data['key_eticsoft'] = $this->key_eticsoft;
		$data['merchant_email'] = $this->config->get('config_email');
		$data['merchant_domain'] = $d;
		$data['merchant_ip'] = $_SERVER['SERVER_ADDR'];
		$data['merchant_name'] = $this->config->get('config_name');
		$data['merchant_version'] = VERSION;
		$data['merchant_software'] = 'Opencart';
		$data['hash_key'] = md5($d . $this->version);
		return json_decode($this->CurlPostExt(array("q" => json_encode($data)), 'http://api.eticsoft.net/license/'));
	}

	private function curlPostExt($data, $url, $json = false)
	{
		$ch = curl_init(); // initialize curl handle
		curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
		if ($json)
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); // times out after 4s
		curl_setopt($ch, CURLOPT_POST, 1); // set POST method
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // add POST fields
		if ($result = curl_exec($ch)) { // run the whole process
			curl_close($ch);
			return $result;
		}
		return false;
	}

	public function order()
	{
		$order_comments = $this->model_sale_order->getOrderHistories($this->request->get['order_id']);
		if (!$order_comments OR empty($order_comments))
			return false;
		$x_id = false;

		foreach ($order_comments as $oc) {
			if (!isset($oc['comment']) OR ! $oc['comment']) {
				continue;
			}
			$decode = json_decode($oc['comment']);
			if (!$decode OR ! isset($decode->Paynet_ID))
				continue;
			$x_id = $decode->Paynet_ID;
			break;
		}
		if ($x_id)
			$transaction = $this->getTransaction($x_id);
		if ((int) $transaction->code != 0)
			return $transaction->code . ' ' . $transaction->message;
		$tr = $transaction->Data[0]; 
		
		return '<table class="table table-bordered">
		<tr>
			<td>Ödenen Tutar
			</td><td>' . $tr->amount . ' ' . $tr->currency . '</td>
		</tr>
		<tr>
			<td>Net Tutar</td><td>' . $tr->netAmount . ' ' . $tr->currency . '</td>
		</tr>
		<tr>
			<td>Komisyon Oranı </td><td> &percnt; ' . ($tr->ratio * 100) . ' ' . $tr->payment_string . '</td>
		</tr>
		<tr>
			<td>Tarih </td><td>'.$tr->xact_date.' '.$tr->ipaddress.'</td>
		</tr>
		<tr>
			<td>Sonuç</td><td>' . $tr->message . '</td>
		</tr>
		<tr>
			<td>Kredi Kartı</td><td>' . $tr->card_no . '
			<br/>' . $tr->card_holder . '
			<br/>' . $tr->card_type . ' ' . $tr->bank_id . '</td>
		</tr>
		</table>';
		return "İşlem Numarası Bulunamadı!";
		
		
									
	}
	public function updatedb(){
	
		$this->load->model('sale/order');
		$this->load->language('extension/payment/paynet');
		
	}	


	protected function validate()
	{

		if (!$this->user->hasPermission('modify', 'payment/paynet')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return true;

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (empty($this->request->post['paynet_bank' . $language['language_id']])) {
				$this->error['bank' . $language['language_id']] = $this->language->get('error_bank');
			}
		}

		return !$this->error;
	}
	
}
