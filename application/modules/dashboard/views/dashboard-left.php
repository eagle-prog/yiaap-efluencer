<?php
$this->load->model('dashboard/dashboard_model');
$user = $this->session->userdata('user');
$user_id = $user[0]->user_id;
$completeness = $this->auto_model->getCompleteness($user[0]->user_id);

$logo = $this->auto_model->getFeild('logo', 'user', 'user_id', $user[0]->user_id);

if ($logo == '') {
  $logo = base_url("assets/images/user.png");
} else {
  if (file_exists('assets/uploaded/cropped_' . $logo)) {
    $logo = base_url("assets/uploaded/cropped_" . $logo);
  } else {
    $logo = base_url("assets/uploaded/" . $logo);
  }
}

$rating = $this->dashboard_model->getrating_new($user[0]->user_id);

$available_hr = $this->autoload_model->getFeild('available_hr', 'user', 'user_id', $user[0]->user_id);
if (empty($available_hr)) {
  $available_hr = __('n/a', 'N/A');
}
$user_name = $this->auto_model->getFeild('fname', 'user', 'user_id', $user_id);
$user_name .= ' ' . $this->auto_model->getFeild('lname', 'user', 'user_id', $user_id);
$plan = $user[0]->membership_plan;

if ($rating[0]['num'] > 0) {
  $avg_rating = $rating[0]['avg'] / $rating[0]['num'];
} else {
  $avg_rating = 0;
}


$img = '';
if ($plan == 1) {
  $img = "FREE_img.png";
} elseif ($plan == 2) {
  $img = "SILVER_img.png";
} elseif ($plan == 3) {
  $img = "GOLD_img.png";
} elseif ($plan == 4) {
  $img = "PLATINUM_img.png";
}

$acc_balance = getField('acc_balance', 'user', 'user_id', $user[0]->user_id);
$user_wallet_id = get_user_wallet($user[0]->user_id);
$acc_balance = get_wallet_balance($user_wallet_id);
$accountType = $user[0]->account_type;
$accountStatus = getField('status', 'user', 'user_id', $user[0]->user_id);
?>

<div class="left_sidebar left_panel <?php echo $accountStatus !== 'Y' ? 'disabled-section' : '' ?>">
    <!--<h4 class="title-sm">Profile completeness</h4>-->
    <div class="c_details">
        <div class="profile">
            <div class="profile_pic">
                <span><a href="<?php echo base_url('dashboard/profile_professional'); ?>"> <img
                                src="<?php echo $logo; ?>"></a></span></div>
        </div>

        <div class="profile-details text-center">
            <h4><a href="<?php echo base_url('dashboard/profile_professional'); ?>"
                   class=""><?php echo $user_name; ?></a></h4>
          <?php if ($accountType == 'F') { ?>
              <p><?php echo $available_hr; ?><?php echo __('hrs/week', 'hrs/week') ?></p>
          <?php } ?>
            <h4>
              <?php
              for ($i = 1; $i <= 5; $i++) {
                if ($i <= $avg_rating) {
                  echo '<i class="zmdi zmdi-star"></i>';
                } else {
                  echo '<i class="zmdi zmdi-star-outline"></i>';
                }
              }
              ?>
            </h4>
            <div class="progress profile_progress">
                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar"
                     aria-valuenow="<?php echo round($completeness); ?>" aria-valuemin="0" aria-valuemax="100"
                     style="width: <?php echo round($completeness); ?>%">
                  <?php echo round($completeness); ?> %
                </div>
            </div>

            <a href="<?php echo base_url('dashboard/profile_professional'); ?>"
               class="btn btn-site btn-sm btn-block"> <?php echo __('dashboard_leftpanel_edit_profile', 'Edit Profile') ?></a>
        </div>
    </div>

    <div class="myfund">
        <div class="body">
            <h4 class="title-sm"><?php echo __('dashboard_leftpanel_my_fund', 'My Fund') ?></h4>
            <a href="<?php echo base_url('myfinance'); ?>"
               class="btn btn-site btn-sm"><?php echo __('dashboard_leftpanel_add_fund', 'Add Fund') ?></a><span
                    style="padding:6px 0" class="pull-right"><?php echo CURRENCY . $acc_balance; ?></span>
        </div>
    </div>

    <div class="mytracker hidden">
        <h5 class="heading"><?php echo __('dashboard_leftpanel_time_tracker', 'Time Tracker') ?></h5>
        <div class="body">
            <a href="<?php echo base_url('dashboard/tracker'); ?>" target="_blank"
               class="btn btn-site btn-sm"><?php echo __('dashboard_leftpanel_download_timetracker', 'Download Timetracker') ?></a>
        </div>
    </div>

    <ul class="list-group sidebar-links">
      <?php if ($accountType == 'F') { ?>
          <li>
              <span><a href="<?php echo base_url('dashboard/myproject_professional'); ?>"><i
                              class="zmdi zmdi-assignment-check"></i> <?php echo __('dashboard_leftpanel_project', 'Project') ?></a></span><br>
              <span><a href="<?php echo base_url('dashboard/mycontest_entry'); ?>"><i
                              class="zmdi zmdi-assignment-check"></i> <?php echo __('dashboard_leftpanel_contest', 'Contest') ?></a></span><br>
          </li>
      <?php } else { ?>
          <li>
              <span><a href="<?php echo base_url('dashboard/myproject_client'); ?>"><i
                              class="zmdi zmdi-assignment-check"></i> <?php echo __('dashboard_leftpanel_project', 'Project') ?></a></span><br>
              <span><a href="<?php echo base_url('dashboard/mycontest'); ?>"><i
                              class="zmdi zmdi-assignment-check"></i> <?php echo __('dashboard_leftpanel_contest', 'Contest') ?></a></span><br>
          </li>
      <?php } ?>

        <li><a href="<?php echo base_url('invoice/list_all'); ?>"><i
                        class="zmdi zmdi-file"></i> <?php echo __('dashboard_leftpanel_invoices', 'Invoices') ?></a>
        </li>
        <li><a href="<?php echo base_url('myfinance'); ?>"><i
                        class="zmdi zmdi-money"></i> <?php echo __('dashboard_leftpanel_my_finance', 'My Finance') ?>
            </a></li>

        <li class="hide"><a href="<?php echo base_url('membership'); ?>"><i
                        class="zmdi zmdi-money"></i> <?php echo __('dashboard_leftpanel_membership', 'Membership') ?>
            </a></li>
        <li><a href="<?php echo base_url('dashboard/myfeedback'); ?>"><i
                        class="zmdi zmdi-comment"></i> <?php echo __('dashboard_leftpanel_feedback', 'Feedback') ?></a>
        </li>
        <li><a href="<?php echo base_url('dashboard/setting'); ?>"><i
                        class="zmdi zmdi-settings"></i> <?php echo __('dashboard_leftpanel_settings', 'Settings') ?></a>
        </li>
        <li><a href="<?php echo base_url('testimonial'); ?>"><i
                        class="zmdi zmdi-comments"></i> <?php echo __('dashboard_leftpanel_give_testimonial', 'Give Testimonial') ?>
            </a></li>
        <li><a href="<?php echo base_url('dashboard/closeacc'); ?>"><i
                        class="zmdi zmdi-account"></i> <?php echo __('dashboard_leftpanel_close_account', 'Close Account') ?>
            </a></li>
    </ul>
</div>

<script>
  $(window).load(function () {
    $('#mainpage').css('min-height', 900);
    var height = $('#mainpage').height();
    $('.left_panel').css('height', height);
    $('.mobile-menu').click(function () {
      $('.left_panel').toggle(300);
    });
    //$(".left_panel").niceScroll();
  });
</script>

