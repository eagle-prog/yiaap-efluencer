<?php echo $breadcrumb; ?>
<style>
    .error_close {
        border: 1px solid red;
        width: 60%;
        margin: 0 auto;
        padding: 17px;
        color: red;
        display: none
    }
</style>
<script src="<?= JS ?>mycustom.js"></script>
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

                    <!--EditProfile Start-->

                    <!--<form name="testimonial" class="form-horizontal" id="testimonial" action="<?php echo VPATH; ?>dashboard/closeacc/" method="post"> -->
                    <form name="testimonial" class="form-horizontal" id="testimonial" action="" method="post">
                        <div class="editprofile well">

                            <input type="hidden" name="uid" value="<?php echo $user_id; ?>"/>
                            <p><?php echo __('closeacc_msg', 'We are sorry to see you go. Please spare a few minutes to tell us why you are leaving (optional)') ?>
                                : </p>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <textarea class="form-control" size="30" name="description" id="description"
                                              tooltipText="Write Your Reason for Leaving"></textarea>
                                    <div class="error-msg2"> <?php echo form_error('description'); ?></div>
                                </div>
                            </div>
                            <div class="acount_form">
                                <div class="masg3"></div>
                              <?php
                              if ($user_id == 251 || $user_id == 252 || $user_id == 253) {
                                ?>
                                  <a class="btn btn-site" href="javaScript:void(0);"
                                     id="error_submit-check"><?php echo __('closeacc_confirm', 'Confirm') ?></a>
                                <?php
                              } else {
                                ?>
                                  <input class="btn btn-site" type="submit" id="submit-check" value="Confirm"/>
                                <?php
                              }
                              ?>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="clearfix"></div>

                <div class="text-center">
                    <h4 class="error_close"><?php echo __('closeacc_msg_not', 'You can\'t perform this operation because this is demo user') ?>
                        ...</h4>
                </div>

              <?php


              if (isset($ad_page)) {

                $type = $this->auto_model->getFeild("type", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));

                if ($type == 'A') {

                  $code = $this->auto_model->getFeild("advertise_code", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));

                } else {

                  $image = $this->auto_model->getFeild("banner_image", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));

                  $url = $this->auto_model->getFeild("banner_url", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));

                }


                if ($type == 'A' && $code != "") {

                  ?>

                    <div class="addbox2">

                      <?php

                      echo $code;

                      ?>

                    </div>

                  <?php

                } elseif ($type == 'B' && $image != "") {

                  ?>

                    <div class="addbox2">

                        <a href="<?php echo $url; ?>" target="_blank"><img
                                    src="<?= ASSETS ?>ad_image/<?php echo $image; ?>" alt="" title=""/></a>

                    </div>

                  <?php

                }

              }

              ?>
                <div class="clearfix"></div>

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
