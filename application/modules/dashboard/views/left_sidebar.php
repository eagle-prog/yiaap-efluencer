    <?php
    $user = $this->session->userdata('user');
    $u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user[0]->user_id)));

    ?>

    <div class="col-md-4 col-xs-12" style="border:1px solid #e0e0e0; padding:15px; min-height:520px">
        <div class="left_sidebar ">
            <div class="profile" style="padding-top:0">
                <div class="profile_pic">
                    <a href="javascript:void(0)" class="profile-pic-cam"
                       title="<?php echo __('myprofile_emp_update_profile_picture', 'Update profile picture'); ?>"><i
                                class="zmdi zmdi-hc-2x zmdi-camera" style="line-height: 0.5;vertical-align: middle;"
                                onclick="$('#profileModal').modal('show');"></i></a>
                    <span>
                <?php
                if ($logo != '') {
                  if (file_exists('assets/uploaded/cropped_' . $logo)) {
                    $logo = 'cropped_' . $logo;
                  }

                  ?>
                    <img alt="" src="<?php echo VPATH; ?>assets/uploaded/<?php echo $logo; ?>" class="img-circle">
                  <?php
                } else {
                  ?>
                    <img alt="" src="<?php echo VPATH; ?>assets/images/user.png" class="img-circle">
                <?php } ?>
            </span>

                </div>
            </div>

            <div class="profile-details" style="padding:0">
              <?php if ($account_type == 'F') { ?>
                  <p class="" style="background-color: #5e7f98; padding: 6px 15px; color: #fff;"><i
                              class="zmdi zmdi-label-box"></i> <?php echo __('myprofile_emp_availability', 'Availability'); ?>
                      <span class="pull-right">
                <?php if ($available_hr > 0) { ?>
                  <?php echo $available_hr; ?><?php echo __('myprofile_emp_hr_per_week', 'hr/week'); ?>
                <?php } else { ?>
                    Not Available
                <?php } ?>
                      <a href="javascript:void(0);" data-toggle="modal" data-target="#hourly_rateModal"
                         style="color:#fff"><i class="zmdi zmdi-edit"></i></a>
                      </span></p>
              <?php } ?>

              <?php
              if ($this->session->userdata('user')) {
                $userid = $this->session->userdata('user');
                $user_login = $userid[0]->user_id;
                ?>

              <?php } ?>


                <!--
        <p><a href="<?= VPATH ?>dashboard/tracker/" target="_blank"><i class="zmdi zmdi-time"></i> Track time with the desktop app</a></p>
        <p style="display:none;"><a href="#"><i class="fa fa-handshake-o"></i> Hiring Headquarters</a></p>
        <p><i class="zmdi zmdi-label"></i> Over <?php // echo CURRENCY;?> <?php // echo $this->clientdetails_model->get_total_expenditure($curr_user[0]->user_id);?> Total Spent</p>
        <p style="display:none;"><span>20 Hire, 6 Active</span></p>
        <p style="display:none;">$10.50/hr Avg Hourly Rate Paid</p>
        <p style="display:none;"><span>100 Hours</span></p>-->
            </div>
        </div>
    </div>



