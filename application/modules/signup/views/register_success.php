<section class="sec">
    <div class="container">
        <aside class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10 col-xs-12">
            <h3 class="form-title"></h3>
            <div class="alert alert-success text-center"><i
                        class="fa fa-check-circle"></i> <?php echo __('signup_you_have_successfully_created_your_account', 'You have successfully created your account') ?>

            </div>
            <div class="spacer-30"></div>
            <div class="general-form text-center">
                <div class="img-circle">
                    <img src="<?php echo IMAGE; ?>success.png" alt="">
                </div>
                <h3><?php echo __('signup_thank_you', 'Thank You') ?></h3>
                <strong><?php echo __('signup_email_confirm', 'Please activate your account via provided email!') ?></strong>
                <p><?php echo __('signup_email_confirm_spam', 'If you do not receive the confirmation message within a few minutes of signing up, please check your Spam folder just in case the confirmation email got delivered there instead of your inbox. If so, select the confirmation message and click Not Spam, which will allow future messages to get through') ?></p>

                <p><?php echo __('signup_go_to_login_page_please_click_below', 'Go to login page, please click below') ?> </p>

                <a href="<?= VPATH ?>login/"
                   class="btn btn-site btn-block"><?php echo __('signup_login', 'Login') ?></a>
            </div>
        </aside>
    </div>
</section>
