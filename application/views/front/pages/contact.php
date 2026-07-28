<div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
        <div class="container">
            <div class="pageheader__content text-center">
                <h2><?php echo translate('contact_us ')?></h2>
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                      <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                      <li class="breadcrumb-item active" aria-current="page"><?php echo translate('contact_us')?></li>
                    </ol>
                </nav> -->
            </div>
        </div>
    </div>
    <!-- ================> Page Header section end here <================== -->

	<!-- ===========Info Section Ends Here========== -->
    <div class="info-section padding-top padding-bottom">
        <div class="container">
			<div class="section__header style-2 text-center">
				<h2><?php echo translate('contact_information ')?></h2>
				<!-- <p>Let us know your opinions. Also you can write us if you have any questions.</p> -->
			</div>
            <div class="section-wrapper">
                <div class="row justify-content-center g-4">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="contact-item text-center">
                            <div class="contact-thumb mb-4">
                                <img src="<?php echo base_url('assets/front');?>/images/contact/icon/01.png" alt="contact-thumb">
                            </div>
                            <div class="contact-content">
                                <h6 class="title mb-5"><?php echo translate('address ')?></h6>
                                <p> <?=translate('address2') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="contact-item text-center">
                            <div class="contact-thumb mb-4">
                                <img src="<?php echo base_url('assets/front');?>/images/contact/icon/02.png" alt="contact-thumb">
                            </div>
                            <div class="contact-content">
                                <h6 class="title"><?php echo translate('phone') ;?></h6>
                                <a target="_blank" href="tel:+919487833674">(+91) 94878 33674</a> / <a href="https://api.whatsapp.com/send?phone=+919894278185&text=">(+91) 98942 78185</a> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="contact-item text-center">
                            <div class="contact-thumb mb-4">
                                <img src="<?php echo base_url('assets/front');?>/images/contact/icon/03.png" alt="contact-thumb">
                            </div>
                            <div class="contact-content">
                                <h6 class="title"><?php echo translate('email') ;?></h6>
                                <p>service@thirumanam.info</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- ===========Info Section Ends Here========== -->



    <!-- ================> contact section start here <================== -->
    <div class="contact-section bg-white">
        <div class="contact-top padding-top padding-bottom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9">
                        <div class="contact-form-wrapper text-center">
                            <h2 class="mb-5"><?php echo translate('contact_us')?></h2>
							<!-- <p class="mb-5">Let us know your opinions. Also you can write us if you have any questions.</p> -->
                            <form class="contact-form" id="demo-form" role="form" action="<?php echo base_url('WelcomeController/contactUs');?>" method="POST">
                                <div class="form-group w-100">
                                    <input type="text" placeholder="<?php echo translate('your_name')?>" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="<?php echo translate('email_address');?>" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="<?php echo translate('subject')?>" id="phone" name="subject" required>
                                </div>
                                <div class="form-group w-100">
                                    <textarea name="message" rows="8" id="message" placeholder="<?php echo translate('message')?>" required></textarea>
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
                                    <button class="default-btn reverse g-recaptcha btn btn-styled btn-base-1 mt-4" data-sitekey="6Le1sDUdAAAAABvXAtM9dW3yvocbWelfg1Eq-zSV" data-callback='onSubmit' data-action='submit'><span><?php echo translate('send_message')?></span></button>
                                    
                                </div>
                            </form>
                            <p class="form-message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-bottom">
            <div class="contac-bottom">
                <div class="row justify-content-center g-0">
                    <div class="col-12">
                        <div class="location-map">
                            <div id="map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7167.2879293178685!2d78.14167178799589!3d11.623953467429658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTHCsDM3JzI4LjYiTiA3OMKwMDgnNDIuMCJF!5e0!3m2!1sen!2sin!4v1591188739729!5m2!1sen!2sin" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================> contact section end here <================== -->
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
  