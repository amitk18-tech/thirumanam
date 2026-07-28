<?php 

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

?>

<style>
  body
  {
    background-image: none;
  }
  .form-control
  {
    border :1px solid #f8587e;
  }
</style>
<div class="page-content-wrapper">
      <!-- Contact Form-->
      <div class="contact-form-wrapper">
        <div class="container">
          <!-- <h4 class="mb-2">Get in touch with us</h4> -->
          <h6><?php echo translate('address ')?>:</h6><p> <?=translate('address2') ?></p>
          <h6><?php echo translate('phone') ;?></h6><p><a target="_blank" href="tel:+919487833674">(+91) 94878 33674</a> / <a href="https://api.whatsapp.com/send?phone=+919894278185&text=">(+91) 98942 78185</a> </p>
          <h6 class="mb-0"><?php echo translate('email') ;?></h6><p>service@thirumanam.info</p>
          <!-- Contact Form-->
          <div class="contact-form mt-4">
            <form class="contact-form" id="demo-form" action="<?php echo base_url('AppController/contactUs');?>" method="POST">
              <div class="form-group w-100">
                  <input class="form-control" type="text" placeholder="<?php echo translate('your_name')?>" id="name" name="name" required>
              </div>
              <div class="form-group">
                  <input class="form-control" type="text" placeholder="<?php echo translate('email_address');?>" id="email" name="email" required>
              </div>
              <div class="form-group">
                  <input class="form-control" type="text" placeholder="<?php echo translate('subject')?>" id="phone" name="subject" required>
              </div>
              <div class="form-group w-100">
                  <textarea class="form-control" name="message" rows="8" id="message" placeholder="<?php echo translate('message')?>" required></textarea>
              </div>
              <?php
              if (get_settings_value('third_party_settings', 'captcha_status', 'value') == 'ok') { ?>
                  <div class="row">
                      <div class="col-md-12">
                          <?php echo $recaptcha_html;?>
                      </div>
                  </div>
              <?php } ?>
              <div class="form-group w-100 text-center">
                  <button class="btn btn-primary btn-lg w-100 reverse g-recaptcha" data-sitekey="6Le1sDUdAAAAABvXAtM9dW3yvocbWelfg1Eq-zSV" data-callback='onSubmit' data-action='submit'><span style="color:white;"><?php echo translate('send_message')?></span></button>
                  
              </div>
          </form>
          </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="location-map">
                        <div id="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7167.2879293178685!2d78.14167178799589!3d11.623953467429658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTHCsDM3JzI4LjYiTiA3OMKwMDgnNDIuMCJF!5e0!3m2!1sen!2sin!4v1591188739729!5m2!1sen!2sin" frameborder="0" style="border:0;width: 100%;
                            height: 215px;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js"></script>

<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
</script>
    
    <!-- <script type="text/javascript">
      var verifyCallback = function(response) {
        alert(response);
      };
      var widgetId1;
      var widgetId2;
      var onloadCallback = function() {
        // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
        // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
        widgetId1 = grecaptcha.render('example1', {
          'sitekey' : '6Le1sDUdAAAAABvXAtM9dW3yvocbWelfg1Eq-zSV',
          'theme' : 'light'
        });
        widgetId2 = grecaptcha.render(document.getElementById('example2'), {
          'sitekey' : '6Le1sDUdAAAAABvXAtM9dW3yvocbWelfg1Eq-zSV'
        });
        grecaptcha.render('example3', {
          'sitekey' : '6Le1sDUdAAAAABvXAtM9dW3yvocbWelfg1Eq-zSV',
          'callback' : verifyCallback,
          'theme' : 'dark'
        });
      };
    </script>
  -->
    <!-- The g-recaptcha-response string displays in an alert message upon submit. -->
    <!-- <form action="javascript:alert(grecaptcha.getResponse(widgetId1));">
      <div id="example1"></div>
      <br>
      <input type="submit" value="getResponse">
    </form> -->
    <br>
    <!-- Resets reCAPTCHA widgetId2 upon submit. -->
    
    <!-- POSTs back to the page's URL upon submit with a g-recaptcha-response POST parameter. -->
    
    <!-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script> -->