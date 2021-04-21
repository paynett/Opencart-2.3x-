<?php echo $header; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
{{ header }}
{{ column_left }}
{{ column_right }}

<style>
.paynetj-button{
  padding: 10px 16px;
    font-size: 16px;
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background-color: #5bb75b;
    background-image: linear-gradient(to bottom, #62c462, #51a351);
    background-repeat: repeat-x;
    border-color: #51a351 #51a351 #387038;
    border: 1px solid #cccccc;
    border-radius: 4px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
}
</style>

<script>
jQuery( document ).ready(function() {
    jQuery(window).load(function() {
		jQuery(".paynetj-button").click();
	});
});
</script>

<div class="container">{{ content_top }}


<section>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h2>Kredi Kartı ile Güvenli Ödeme</h2>
                    Bu sayfada kredi kartınız ile güvenli ödeme yapabilirsiniz.<br/>
                    3D güvenlik için telefonunuza SMS gönderilebilir. 
        </div>
         <div class="col-xs-12 col-sm-6">
            <img src="{{ HTTPS_SERVER }}catalog/view/theme/default/image/eticsoft_paynet/available_cards.png" style="max-width:100%"/>
         </div>
    </div>
    {% if error_message %}
		<div class="row">
            <div class="alert alert-danger" id="errDiv">
                Ödemeniz yapılamadı. Bankanızın cevabı: <br/> 
                <b>{{ error_message}}</b><br/>
                Lütfen formu kontrol edip yeniden deneyiniz.
            </div>
        </div>
    {% endif %}
	
    <hr/>
	{{ payment_button }}
</section>
{{ footer }}
<div class="container"><?php echo $content_top; ?>


<section>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h2>Kredi Kartı ile Güvenli Ödeme</h2>
                    Bu sayfada kredi kartınız ile güvenli ödeme yapabilirsiniz.<br/>
                    3D güvenlik için telefonunuza SMS gönderilebilir. 
        </div>
         <div class="col-xs-12 col-sm-6">
            <img src="<?php echo $HTTPS_SERVER; ?>catalog/view/theme/default/image/paynet/available_cards.png" style="max-width:100%"/>
         </div>
    </div>
	<?php  if ($error_message) { ?>
     
		<div class="row">
            <div class="alert alert-danger" id="errDiv">
                Ödemeniz yapılamadı. Bankanızın cevabı: <br/> 
                <b><?php echo $error_message; ?></b><br/>
                Lütfen formu kontrol edip yeniden deneyiniz.
            </div>
        </div>
    <?php } ?>
	
    <hr/>
	<?php echo $payment_button; ?>
</section>
<?php echo $footer; ?>