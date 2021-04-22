<?php echo $breadcrumb; ?>
<section id="mainpage">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-2 col-sm-3 col-xs-12">
              <?php $this->load->view('dashboard/dashboard-left'); ?>
            </div>
            <!-- Sidebar End -->
            <div class="col-md-10 col-sm-9 col-xs-12">
                <!--ProfileRight Start-->
                <div class="profile_right">
                  <?php
                  if ($this->session->flashdata('succ_msg')) {
                    ?>
                      <div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg'); ?></div>
                    <?php

                  }

                  if ($this->session->flashdata('error_msg')) {
                    ?>
                      <span id="agree_termsError"
                            class="error-msg2"><?php echo $this->session->flashdata('error_msg'); ?></span>

                    <?php

                  }

                  ?>
                    <form name="testimonial" class="form-horizontal" id="testimonial" action="" method="post">
                        <div class="editprofile well">
                            <input type="hidden" name="uid" value="<?php echo $user_id; ?>"/>
                            <p>We are glad to see you back! </p>
                            <div class="acount_form">
                                <div class="masg3"></div>
                                <input class="btn btn-site" type="submit" id="submit-check"
                                       value="Make account public"/>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
</section>
<script>
  $(document).ready(function () {
    $('.error_close').hide();
    $('#error_submit-check').click(function () {
      $('.error_close').show();
      $('.profile_right').hide();
    });
  });
</script>
