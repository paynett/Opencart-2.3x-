<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">

 <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-paynet-settings" data-toggle="tooltip" title="Kaydet" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="İptal Et" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1>Paynet Ödeme Altyapısı</h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

 
	  <?php if(!$paynet_registered OR $paynet_registered == null) { ?>
	<br/><hr/>
	<form action="" method="post">
		<div class="alert alert-warning">
			<h2>Kullanım Şartları </h2>
			<ul>
				<li>PayNet modülü PayNet Ödeme Kuruluşu A.Ş tarafından GPL lisansı ile açık kaynaklı ve ücretsiz sunulmaktadır. <b>Satılamaz.</b></li>
				<li>PayNet modülü PayNet Ödeme Kuruluşu A.Ş 'nin sağladığı servisleri kullanmak için geliştirilmiştir. Başka amaçla kullanılamaz.</li>
				<li>Uluslararası kabul görmüş güvenlik standartlarına göre kredi kartı bilgilerine erişim veya bilgilerin kayıt edilmesi yasaktır. Bu eklenti orijinal kaynak kodlarıyla müşterilerinizin kredi kartı bilgilerini siteminize veya herhangi bir yere asla kaydetmez. Kaynak kodlarını bu kurallara uygun tutmak sizin sorumluluğunuzdadır.</li>
				<li>Eklentinin kurulu olacağı mağazaya ait version ve iletişim bilgileriniz (mağaza eposta, OpenCat versiyonu v.b.) geliştirici teknik destek ve bilgilendirme sistemine otomatik kayıt edilecek ve bu bilgiler önemli bildirimler ile güncellemelerden haberdar olmanız için kullanılacaktır.</li>
			</ul>
			<hr>
			<input type="checkbox" value="1" name="confirm_paynet_register" checked><br/>
			<label for="confirm_paynent">Kullanım şartlarını kabul ediyorum</label>
			<br>
			<button type="submit" class="btn btn-primary">Mağazamı Kaydet ve Başla</button>
		</div>
	</form>

 <?php } else { ?>

    <div class="container-fluid">
<?php  if ($error_warning) { ?>  
       
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $text_edit; ?></h3>
            </div>

            <div class="panel-body">
                <ul class="nav nav-tabs" id="tabs">
                    <li class="active"><a href="#tab-paynet_settings" data-toggle="tab">Genel Ayarlar</a></li>
                    <li><a href="#tab-paynet_rates" data-toggle="tab">Taksit Oranları</a></li>
                    <li><a href="#tab-paynet_about" data-toggle="tab">PayNet Hakkında</a></li>
                    <li><a href="#tab-paynet_help" data-toggle="tab">Yardım & Teknik Destek</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-paynet_settings">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-paynet-settings" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_data_key">Paynet Data Key (Publishable Key)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="paynet_data_key" value="<?php echo $paynet_data_key; ?>" placeholder="pbk_pcs_sQ37X..." id="paynet_data_key" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_secret_key">Paynet Secret Key </label>
                                <div class="col-sm-10">
                                    <input type="text" name="paynet_secret_key" value="<?php echo $paynet_secret_key; ?>" placeholder="sck_pcs_w0012..." id="paynet_secret_key" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_agent_code">Paynet Bayi Kodu (opsiyonel)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="paynet_agent_code" value="<?php echo $paynet_agent_code; ?>" placeholder="123.." id="paynet_agent_code" class="form-control" />
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_ratio_code">Paynet Oran Kodu (opsiyonel)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="paynet_ratio_code" value="<?php echo $paynet_ratio_code; ?>" placeholder="123.." id="paynet_ratio_code" class="form-control" />
                                </div>
                            </div>
							
								
							<div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_installment_options">Paynet Taksit Seçenekleri(opsiyonel)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="paynet_installment_options" value="<?php echo $paynet_installment_options; ?>" placeholder="1,2,3.." id="paynet_installment_options" class="form-control" />
                                </div>
                            </div>
							
							
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_ins_fee">Taksit komisyonları ödemeye eklensin</label>
                                <div class="col-sm-10">
                                    <select name="paynet_ins_fee" id="paynet_ins_fee" class="form-control">              
                                        <option value="on">Evet</option>
										<option value="off" <?php if ($paynet_ins_fee=='off'){ ?> selected="selected" <?php } ?>>Hayır</option>
                                         
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_force_tds">3D Secure zorunlu</label>
                                <div class="col-sm-10">
                                    <select name="paynet_force_tds" id="input-paynet_force_tds" class="form-control">              
                                        <option value="on">Evet</option>
										<option value="off" <?php if ($paynet_force_tds=='off'){ ?> selected="selected" <?php } ?>>Hayır</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status">Modül Durumu</label>
                                <div class="col-sm-10">
                                    <select name="paynet_status" id="input-status" class="form-control">                
                                        <option value="1" >Aktif</option>
										<option value="0" <?php if ($paynet_status=='0'){ ?> selected="selected" <?php } ?>>Pasif</option>
                                         
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status">Test Modu</label>
                                <div class="col-sm-10">
                                    <select name="paynet_test_mode" id="input-status" class="form-control">                
                                        <option value="off" >Kapalı (Mağaza online)</option>
										<option value="on" <?php if ($paynet_test_mode=='on'){ ?> selected="selected" <?php } ?>>Açık (Ödemeler gerçekten alınmayacak)</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status">Sipariş Durumu</label>
                                <div class="col-sm-10">
                                    <select name="paynet_order_status_id" id="input-order-status" class="form-control">
									
									<?php foreach ($order_statuses as $order_status) { ?>
                                        
                                        <?php if ($order_status['order_status_id']  ==$paynet_order_status_id){ ?>
										
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option> <?php } ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                            </div>
							
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_button_text">Button Text </label>
                                <div class="col-sm-10">
                                    <input type="text" name="paynet_button_text" value="<?php echo $paynet_button_text; ?>" placeholder="Ödemeyi tamamla" id="paynet_button_text" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_form_text">Form Text </label>
                                <div class="col-sm-10">
                                    <input type="text" name="paynet_form_text" value="<?php echo $paynet_form_text; ?>" placeholder="Kart bilgilerinizi girip ödemeyi tamamla butonuna tıklayınız" id="paynet_form_text" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="paynet_logo_url">Payment Logo URL (https) </label>
                                <div class="col-sm-10">
                                    <input type="text" name="paynet_logo_url" value="<?php echo $paynet_logo_url; ?>" placeholder="https://store.com/paymetlogo.jpg" id="paynet_logo_url" class="form-control" />
                                </div>
                            </div>

                            <input type="hidden" name="paynet_submit" value="1"/>
                    </div>
                    <div class="tab-pane" id="tab-paynet_rates">
                        <div class="form-group">
							<div class="alert alert-success"> Taksit oranları PayNet Ödeme A.Ş. hesabınızdan otomatik olarak getirilmektedir. Aşağıda taksitleri göremiyorsanız ayarlar formundaki anahtarları ve ortamı kontrol ediniz.</div>
                           <?php echo $paynet_rates_table; ?>
                        </div>
                        <input type="hidden" name="paynet_rates_submit" value="1"/>
                        <input type="hidden" name="paynet_registered" value="ok"/>

                        </form>
                    </div>
                    <div class="tab-pane" id="tab-paynet_about">
                        <div class="panel">
                            <div class="row paynet-header">
                                <img src="../catalog/view/theme/default/image/paynet/paynet_logo.png" class="col-xs-4 col-md-2 text-center" id="payment-logo" />
                                <div class="col-xs-6 col-md-5 text-center">
                                    <h4>PayNet Ödeme Kuruluşu A.Ş.</h4>
                                    <h5>Paynet Sanal Pos internet sitenizde satış yapıp tüm kredi 
										kartlarından ödeme alabilmenizi sağlar.</h5>
                                </div>
                                <div class="col-xs-12 col-md-5 text-center">
                                    <a target=_blank;" href="https://odeme.paynet.com.tr/" class="btn btn-primary" id="create-account-btn">Hesabınıza giriş yapın</a>
                                </div>
                            </div>                        
							<hr />
							<div align="center">
								<video style="width:80%; max-width:980px; height: 100%;" controls="controls" poster="https://www.paynet.com.tr/assets/images/urunvideogorsel/sanalpos.jpg">
									<source src="https://www.paynet.com.tr/assets/video/sanalpos.mp4" type="video/mp4">
								</video>
							</div>
                            <hr />


                            <div class="paynet-content">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
                                        <div class="thumbnail">
                                            <figure class="figure text-center">
                                                <img src="../catalog/view/theme/default/image/paynet/icons/icon_clock.png" width="140" height="100"/>
                                            </figure>
                                            <p class="text text-center">
                                                Hızlı ve Kolay
                                                <br> Müşterileriniz için enkolay ödeme yöntemin
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="thumbnail">
                                            <figure class="figure text-center">
                                                <img src="../catalog/view/theme/default/image/paynet/icons/icon_money.png" width="140" height="100"/>
                                            </figure>
                                            <p class="text text-center">
                                                7/24 Tahsilat
                                                <br>dilediğiniz saat tahsilat yapabilirsiniz.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="thumbnail">
                                            <figure class="figure text-center">
                                                <img src="../catalog/view/theme/default/image/paynet/icons/icon_credit_card.png" width="140" height="100"/>
                                            </figure>
                                            <p class="text text-center">
                                                Tüm Kredi Kartları
                                                <br>Sanal Pos tüm bankalara ait kredi kartlarıyla uyumlu çalışır.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="thumbnail">
                                            <figure class="figure text-center">
                                                <img src="../catalog/view/theme/default/image/paynet/icons/icon_visa_mastercard.png" width="140" height="100"/>
                                            </figure>
                                            <p class="text text-center">
                                                Sitenizde Tahsilat
                                                <br>Yönlendirme yok. Doğrudan kendi internet sitenizden satış yapın
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="thumbnail">
                                            <figure class="figure text-center">
                                                <img src="../catalog/view/theme/default/image/paynet/icons/icon_exchange.png" width="140" height="100"/>
                                            </figure>
                                            <p class="text text-center">
                                                Raporlanabilir
                                                <br>Finansal işlemlerinize ait  gelişkin raporlara dilediğiniz an ulaşabilirsiniz.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="thumbnail">
                                            <figure class="figure text-center">
                                                <img src="../catalog/view/theme/default/image/paynet/icons/icon_cogs.png" width="140" height="100"/>
                                            </figure>
                                            <p class="text text-center">
                                                Hızlı ve kolay
                                                <br>Sitenize özel olarak entegre edilir ve kolayca olarak düzenlenebilir
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>					





                    </div>
             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	 <?php } ?></div>
<?php echo $footer; ?> 
<style>
    #content .tab-pane:first-child .panel {
        border-top-left-radius: 0;
    }

    .paynet-header .text-branded,
    .paynet-content .text-branded {
        color: #00aff0;
    }

    .paynet-header h4,
    .paynet-content h4,
    .paynet-content h5 {
        margin: 2px 0;
        color: #00aff0;
        font-size: 1.8em;
    }

    .paynet-header h4 {
        margin-top: 5px;
    }

    .paynet-header .col-md-6 {
        margin-top: 18px;
    }

    .paynet-content h4 {
        margin-bottom: 10px;
    }

    .paynet-content h5 {
        font-size: 1.4em;
        margin-bottom: 10px;
    }

    .paynet-content h6 {
        font-size: 1.3em;
        margin: 1px 0 4px 0;
    }

    .paynet-header > .col-md-4 {
        height: 65px;
        vertical-align: middle;
        border-left: 1px solid #ddd;
    }

    .paynet-header > .col-md-4:first-child {
        border-left: none;
    }

    .paynet-header #create-account-btn {
        margin-top: 14px;
    }

    .epaynet-content dd + dt {
        margin-top: 5px;
    }

    .paynet-content ul {
        padding-left: 15px;
    }

    .paynet-content .ul-spaced li {
        margin-bottom: 5px;
    }
    table.paynet_table {
        width:90%;
        margin:auto;
    }
    table.paynet_table td,th {
        width: 60px;
        margin:0px;
        padding:2px;
    }
    table.paynet_table input[type="number"] {
        width:50px;
    }
</style>