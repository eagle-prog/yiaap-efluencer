<!-- Content Start -->
<script type="text/javascript">
  var RecaptchaOptions = {
    theme: 'white'
  };
</script>

<?php echo $breadcrumb; ?>

<script type="text/javascript">

  function loginFormPost() {
//	alert('alert');
    FormPost('#submit-check', "<?=VPATH?>", "<?=VPATH?>login/checkCode", 'logform');

  }
</script>
<script src="<?= JS ?>mycustom.js"></script>
<section class="sec sec-login">
    <div class="container">
        <h2 class="title">Confirm Login</h2>
        <div class="spacer-30"></div>
        <div class="container flex-center">
            <div class="col-md-6 col-sm-6 col-xs-12" data-effect="slide-top">


                <div class="form">
                    <!--        <div class="img-circle">-->
                    <!--        	<img src="--><?php //echo VPATH;?><!--assets/images/lock.png" alt="">-->
                    <!--        </div>-->
                  <?php
                  $attributes = array('id' => 'logform', 'class' => 'form-horizontal', 'role' => 'form', 'name' => 'logform', 'onsubmit' => "loginFormPost(); return false;");
                  echo form_open('', $attributes);
                  ?>
                    <strong>Email message with Confirmation Code has been sent to your email</strong>
                    <div class="spacer-30"></div>
                    <div class="login-form">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <!--            	<label for="" class="control-label">-->
                              <?php //echo __('login_password','Password'); ?><!--:</label>            	-->
                                <input type="text" class="form-control" value="" name="confirmation_code"
                                       placeholder="Confirmation Code">
                                <span id="confirmation_codeError" class="error-msg13"></span>
                            </div>
                        </div>
                    </div>
                    <button id="signin-btn"
                            class="btn btn-site btn-block btn-new">
                      <?php echo __('login_sign_in', 'Sign In'); ?></button>
                </div>
            </div>


        </div>
    </div>
    <div class="spacer-30"></div>
</section>
