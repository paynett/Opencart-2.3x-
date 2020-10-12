<?php echo $header; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>

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