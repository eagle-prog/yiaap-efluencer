<!-- Start of Zopim Live Chat Script -->
<!--<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?2Rzam8ZNPz6rZ3NyzlMnYE4R27s4alZK';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<link href="http://blazeworx.com/flags.css" rel="stylesheet">
<script src="http://blazeworx.com/jquery.flagstrap.min.js"></script>-->
<!--End of Zopim Live Chat Script-->
<?php
$unread_msg = 0;
$user = $this->session->userdata('user');
if ($this->session->userdata('user')) {

  $name = $this->auto_model->getFeild('fname', 'user', 'user_id', $user[0]->user_id) . " " . $this->auto_model->getFeild('lname', 'user', 'user_id', $user[0]->user_id);

  $logo = $this->auto_model->getFeild('logo', 'user', 'user_id', $user[0]->user_id);

  if ($logo == '') {
    $logo = "images/user.png";
  } else {
    if (file_exists('assets/uploaded/cropped_' . $logo)) {
      $logo = "uploaded/cropped_" . $logo;
    } else {
      $logo = "uploaded/" . $logo;
    }

  }
  $plan = $user[0]->membership_plan;
  if ($plan == 1) {
    $img = "FREE_img.png";
  } elseif ($plan == 2) {
    $img = "SILVER_img.png";
  } elseif ($plan == 3) {
    $img = "GOLD_img.png";
  } elseif ($plan == 4) {
    $img = "PLATINUM_img.png";
  }


  $dir = "user_message/";
  $filename = $dir . "user_" . $user[0]->user_id . ".newmsg";
  if (!file_exists($filename)) {
    $unread_msg = 0;
  } else {
    $unread_msg = file_get_contents($filename);
  }

}
$style = '';
if ($unread_msg == 0) {
  $style = 'display:none;';
}
?>

<body>
<header class="main-header-menu">
    <section class="menuA">
        <nav class="navbar navbar-default navbar-fixed-top" id="slide-nav">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                  <?php
                  $currLang = '';
                  if ($this->session->userdata('lang')) {
                    $currLang = $this->session->userdata('lang');
                  }
                  ?>
                  <?php if ($currLang == 'arabic') { ?>
                      <a class="navbar-brand" href="<?= VPATH ?>" alt="<?= SITE_TITLE ?>" title="<?= SITE_TITLE ?>"><img
                                  src="<?= ASSETS ?>img/logo_ar.png" alt="" title="" class="img-responsive"></a>
                  <?php } else { ?>
                      <a class="navbar-brand" href="<?= VPATH ?>" alt="<?= SITE_TITLE ?>" title="<?= SITE_TITLE ?>"><img
                                  src="<?= ASSETS ?>img/<?php echo SITE_LOGO; ?>" alt="" title=""
                                  class="img-responsive"></a>
                  <?php } ?>

                </div>
                <div id="slidemenu">
                  <?php
                  $langMap = array(
                    'arabic'  => IMAGE . 'cuntryflag/uae.png',
                    'spanish' => IMAGE . 'cuntryflag/spanish.png',
                    'swedish' => IMAGE . 'cuntryflag/swedish.png',
                    'english' => IMAGE . 'cuntryflag/britain.png',
                  );

                  $curr_lang = 'english';
                  if ($this->session->userdata('lang')) {
                    $curr_lang = $this->session->userdata('lang');
                  }

                  ?>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav">

                          <?php if ($this->session->userdata('user')) {
                            $user = $this->session->userdata('user'); //print_r($user);
                            if ($user[0]->account_type == 'F') { ?>
                                <li class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle"
                                                        data-toggle="dropdown" role="button" aria-haspopup="true"
                                                        aria-expanded="false"><?php echo strtoupper(__('browse', 'Browse')); ?>
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <!--            <li><a href="--><?//=VPATH
                                      ?><!--findjob/">--><?php //echo strtoupper(__('find_job','FIND JOB'));
                                      ?><!--</a></li>-->
                                        <!--            <li><a href="--><?//=VPATH
                                      ?><!--contest/browse">-->
                                      <?php //echo strtoupper(__('find_contest','Find Contest'));
                                      ?><!--</a></li>-->
                                        <li><a class="text-btn-menu" href="<?= VPATH ?>findjob/">Search Jobs</a></li>
                                        <li><a class="text-btn-menu" href="<?= VPATH ?>contest/browse">Find Contest</a>
                                        </li>
                                    </ul>
                                </li>
                            <?php }
                          } else { ?>
                              <!--<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo strtoupper(__('browse', 'Browse')); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= VPATH ?>findjob/"><?php echo strtoupper(__('find_job', 'FIND JOB')); ?></a></li>
            <li><a href="<?= VPATH ?>contest/browse"><?php echo strtoupper(__('find_contest', 'Find Contest')); ?></a></li>
          </ul>
        </li>-->
                              <!--            <li><a class="text-btn-menu" href="--><? //=VPATH?><!--findjob/">Browse Jobs</a></li>-->
                              <!--            <li><a class="text-btn-menu" href="--><? //=VPATH?><!--contest/browse">Find Contest</a></li>-->
                          <?php } ?>
                          <?php if ($this->session->userdata('user')) {
                            $user = $this->session->userdata('user');
//		 var_dump($user[0]->account_type);
                            if ($user[0]->account_type == 'E') {
                              ?>
                                <li class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle"
                                                        data-toggle="dropdown" role="button" aria-haspopup="true"
                                                        aria-expanded="false"><?php echo __('post', 'Post') ?><span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?= VPATH ?>postjob/"><?php echo strtoupper(__('post_job', 'POST JOB')); ?></a>
                                        </li>
                                        <li>
                                            <a href="<?= VPATH ?>contest/post_contest"><?php echo strtoupper(__('post_contest', 'POST CONTEST')); ?></a>
                                        </li>
                                    </ul>
                                </li>

                                <!--<li><a href="<?= VPATH ?>postjob" <?php if ($current_page == "postjob") { ?> id="current"<?php } ?>><?php echo strtoupper(__('post_job', 'POST JOB')); ?></a></li> -->
                            <?php }
                          } else {/*  ?>
			<li><a href="<?=VPATH?>login?refer=postjob/" <?php if($current_page=="postjob"){?> id="current"<?php }?>>POST JOB</a></li>
		<?php */
                          } ?>
                          <?php if ($this->session->userdata('user')) {
                            $user = $this->session->userdata('user');
                            //static buttons
                            if ($user[0]->account_type == 'E') {
                              ?>
                                <li><a class="text-btn-menu" style="font-weight: 400"
                                       href="<?= VPATH ?>findtalents/" <?php if ($current_page == "findtalent") { ?> id="current"<?php } ?>>FIND
                                        INFLUENCER</a></li>
                                <!--                <li><a class="text-btn-menu" href="--><?//=VPATH
                              ?><!--findjob/">Browse Jobs</a></li>-->
                            <?php }
                          } else { ?>
                              <li><a class="text-btn-menu"
                                     href="<?= VPATH ?>findtalents/" <?php if ($current_page == "findtalent") { ?> id="current"<?php } ?>>Search
                                      eFluencers</a></li>
                              <li><a class="text-btn-menu" href="<?= VPATH ?>findjob/">Find Jobs</a></li>
                          <?php } ?>
                          <?php if ($this->session->userdata('user')) { ?>
                              <li><a href="<?= VPATH ?>message/browse"
                                     <?php if ($current_page == "membership"){ ?>id="current"<?php } ?>>Messages</a><span
                                          class="badge" id="msg_count"
                                          style="position: absolute;top: 0px;right: 0; <?php echo $style; ?>"><?php echo $unread_msg; ?></span>
                              </li>
                              <li><a href="<?= VPATH ?>dashboard">Dashboard</a></li>
                          <?php } ?>
                        </ul>


                      <?php
                      if ($this->session->userdata('user')) {

                        if ($this->router->fetch_class() == "affiliate") {
                          ?>
                            <ul class="nav navbar-nav">
                                <li class="profile-imgEcnLi"><a href="<?= VPATH ?>affiliate/dashboard/"
                                                                <?php if ($current_page == "dashboard"){ ?>id="current"<?php } ?>><i
                                                class="fa fa-user" style="font-size:20px" id="head_noti_profile"></i>&nbsp;</a>
                                    <ul>
                                        <li><a href="<?= VPATH ?>affiliate/dashboard/"
                                               <?php if ($current_page == "dashboard"){ ?>id="current"<?php } ?>><?php echo strtoupper(__('dashboard', 'DASHBOARD')); ?></a>
                                        </li>
                                        <li><a href="<?= VPATH ?>affiliate/logout/"
                                               <?php if ($current_page == "logout"){ ?>id="current"<?php } ?>><?php echo strtoupper(__('logout', 'LOGOUT')); ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        <?php } else {

                          ?>

                            <ul class="nav navbar-nav navbar-right">
                                <li><span class="dropdown language hide">
          <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="true">
            <img src="<?php echo $langMap[$curr_lang] ?>" alt="">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="min-width:40px;">
		  <?php foreach ($langMap as $key => $v) { ?>
              <li><a onClick="changeLang(this,'<?php echo $key ?>')"><img src="<?php echo $v; ?>" alt=""></a></li>

          <?php } ?>
          </ul>
        </span></li>
                                <li class="headnotification hidden-xs hidden-sm"><a href="javascript:void(0)"
                                                                                    class="Noback hidden-xs"> <i
                                                class="zmdi zmdi-notifications" style="font-size:20px"></i>&nbsp; <span
                                                class="badge" id="head_noti"
                                                style="position:absolute;top:0;left:18px;background-color:#ff1638;color:#f5f5f5;"></span>
                                    </a></li>

                                <li class="headnotification visible-xs visible-sm"><a href="<?= VPATH ?>notification">
                                        <i class="zmdi zmdi-notifications" style="font-size:20px"></i>&nbsp; <span
                                                class="badge" id="head_noti"
                                                style="position:absolute;top:0;left:18px;background-color:#ff1638;color:#f5f5f5;"></span>
                                    </a></li>

                                <li class="profile-imgEcnLi hidden"><a href="javascript:void(0)"
                                                                       <?php if ($current_page == "dashboard"){ ?>id="current"<?php } ?>
                                                                       class="Noback profile-imgEcn hidden-xs">
                                        <i class="zmdi zmdi-account profile-imgEcn" style="font-size:20px"
                                           id="head_noti_profile"></i>&nbsp;</a></li>
                                <li>
                                    <figure class="profile-imgEc toggle-leftbar"><img
                                                src="<?= VPATH ?>assets/<?= $logo ?>"
                                                style="height:36px; width:36px; border-radius:50%"></figure>
                                </li>
                            </ul>
                          <?php
                        }

                      }

                      ?>

                      <?php if (!$this->session->userdata('user')) { ?>
                          <form class="navbar-form navbar-right"
                                action="<?php echo (!empty($_GET['lookin']) and $_GET['lookin'] == 'freelancer') ? VPATH . 'findtalents' : VPATH . 'findjob/browse'; ?>"
                                id="header_search_form">
                              <div class="form-group form-group-search">
                                  <div class="input-group input-group-search">
                                      <input type="hidden" name="lookin"
                                             value="<?php echo !empty($_GET['lookin']) ? $_GET['lookin'] : 'Influencer'; ?>"
                                             id="lookin"/>
                                      <input type="text" id="search_input" class="form-control input-search"
                                             placeholder="<?php echo __('search', 'Search'); ?> <?php echo (!empty($_GET['lookin']) and $_GET['lookin'] == 'freelancer') ? __('Influencer', 'Influencer') : __('jobs', 'Jobs'); ?>"
                                             name="q" value="<?php echo !empty($_GET['q']) ? $_GET['q'] : ''; ?>">
                                      <span class="input-group-btn">
			  <div class="dropdown">
				  <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"
                          style="border:none;background-color:#f5f5f5">
                      <span id="srch_txt"
                            style="display:none"><?php echo (!empty($_GET['lookin']) and $_GET['lookin'] == 'freelancer') ? __('Influencer', 'Influencer') : __('jobs', 'Jobs'); ?></span>
				  <span class="caret"></span></button>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="left:0;right:auto">
					<li role="presentation"><a role="menuitem" href="#" class="srch_dropdown_item"
                                               data-srch="Jobs"><?php echo __('jobs', 'Jobs'); ?></a></li>
					<li role="presentation"><a role="menuitem" href="#" class="srch_dropdown_item"
                                               data-srch="Freelancer"><?php echo __('Influencer', 'Influencer'); ?></a></li>
				  </ul>
				</div>
			  </span>
                                  </div>

                              </div>
                              <span class="hidden-xs">&nbsp;&nbsp;</span>

                            <?php

                            if ($this->router->fetch_class() == "affiliate") {
                              if (!$this->session->userdata('user_affiliate')) {
                                ?>
                                  <a class="text-btn" href="<?= VPATH ?>affiliate/"
                                     <?php if ($current_page == "signup"){ ?>id="current"<?php } ?>> Sign Up</a>
                                  <a class="text-btn" href="<?= VPATH ?>affiliate/"> Sign In</a>
                                <?php
                              }
                              ?>
                              <?php
                            } else {
                              if (!$this->session->userdata('user')) {
                                ?>
                                  <a class="text-btn" href="<?= VPATH ?>login/">Sign In</a><span class="hidden-xs">&nbsp;&nbsp;</span>
                                  <a class="text-btn" href="<?= VPATH ?>signup/"
                                     <?php if ($current_page == "signup"){ ?>id="current"<?php } ?>>Sign Up</a>
                              <?php }
                            } ?>
                              <a class="btn btn-site post-job " href="<?= VPATH ?>postjob/">Post Job</a>
                              <span class="dropdown language hide">
          <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="true">
            <img src="<?php echo $langMap[$curr_lang] ?>" alt="">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="min-width:40px;">
		  <?php foreach ($langMap as $key => $v) { ?>
              <li><a onClick="changeLang(this,'<?php echo $key ?>')"><img src="<?php echo $v; ?>" alt=""></a></li>

          <?php } ?>
          </ul>
        </span>
                          </form>
                      <?php } ?>

                    </div><!-- /.navbar-collapse -->
                </div>
            </div><!-- /.container-fluid -->
        </nav>
    </section>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
</header>
<div class="clearfix"></div>
<!-- Header End -->

<script type="text/javascript">

  function postjob_fn() {
    $("#post_div").toggle();
    document.getElementById("login_div").style.display = "none";
  }

  function login_fn() {
    document.getElementById("post_div").style.display = "none";
    $("#login_div").toggle();
  }

  function check() {
    var title = $('#title_name').val();
    var mail = $('#mail').val();
    var atpos = mail.indexOf("@");
    var dotpos = mail.lastIndexOf(".");

    if (title == '' || title == 'What do want to get done?') {
      alert('<?php echo __('job_title_cant_be_left_blank', 'job title cant be left blank')?>');
      return false;
    } else if (mail == '' || mail == 'Your email address') {
      alert('<?php echo __('email_cant_be_left_blank', 'email cant be left blank')?>');
      return false;
    } else if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
      alert("<?php echo __('not_a_valid_email_address', 'Not a valid e-mail address')?>");
      return false;
    } else {
      return true;
    }
  }

</script>
<?php
if ($this->session->userdata('user')) {
  $user = $this->session->userdata('user');

  $acc_balance = $this->auto_model->getFeild('acc_balance', 'user', 'user_id', $user[0]->user_id);
  $user_wallet_id = get_user_wallet($user[0]->user_id);
  $acc_balance = get_wallet_balance($user_wallet_id);

  ?>
    <div class="ecdevsec">
        <div class="user-sidebar-container quicknav" style="display: none;">
            <div class="sidebar user-sidebar">
                <div class="user-sidebar-info">
                    <figure class="profile-img"><a href="<?= VPATH ?>dashboard"> <img
                                    src="<?= VPATH ?>assets/<?= $logo ?>"> </a></figure>
                    <div class="user-sidebar-name">
                        <h4><?= ucwords($name) ?></h4>
                        <b><?php echo strtoupper(__('header_sticky_balance', 'BALANCE')); ?>
                            :</b> <?php echo CURRENCY . ' ' . $acc_balance; ?>
                      <?php if ($user[0]->account_type == 'F') { ?>
                          <a href="<?php echo base_url('tracker.zip'); ?>" target="_blank" class="btn btn-primary"
                             style="margin-top:10px"><?php echo __('header_sticky_download_tracker', 'Download Tracker'); ?></a>
                      <?php } ?>
                    </div>
                    <!--<div class="user-sidebar-status" style="margin-bottom:10px"> <img src="<?php // echo IMAGE;
                    ?><?= $img ?>"> </div>-->

                    <!--<a href="<? //=VPATH
                    ?>dashboard/tracker/" target="_blank" class="btn btn-warning btn-sm" style="color:#FFF">Download Timetracker</a>-->
                </div>
                <nav class="sidebar-nav menu ">
                    <ul>
                        <li><a class="sidebar-link" href="<?= VPATH ?>dashboard/"><i
                                        class="zmdi zmdi-account"></i> <?php echo __('header_sticky_my_account', 'My Account'); ?>
                            </a></li>
                        <li class="hide"><a class="sidebar-link" href="<?= VPATH ?>membership/"><i
                                        class="zmdi zmdi-account"></i> <?php echo __('header_sticky_membership', 'Membership'); ?>
                            </a></li>
                      <?php if ($user[0]->account_type == 'E') { ?>
                          <li><a class="sidebar-link" href="<?= VPATH ?>dashboard/myproject_client"><i
                                          class="fa fa-briefcase"></i> <?php echo __('header_sticky_my_posted_job', 'My Posted Jobs'); ?>
                              </a></li> <?php } ?>
                      <?php if ($user[0]->account_type == 'F') { ?>
                          <li><a class="sidebar-link" href="<?= VPATH ?>dashboard/myproject_working"><i
                                      class="fa fa-briefcase"></i> <?php echo __('header_sticky_my_working_job', 'My Working Jobs'); ?>
                          </a></li><?php } ?>
                        <li><a class="sidebar-link" href="<?= VPATH ?>myfinance"><i
                                        class="fa fa-dollar-sign"></i> <?php echo __('header_sticky_add_fund', 'Add Fund'); ?>
                            </a></li>
                        <li><a class="sidebar-link" href="<?= VPATH ?>myfinance/transaction"><i
                                        class="fa fa-list-alt"></i> <?php echo __('header_sticky_transaction_history', 'Transaction History'); ?>
                            </a></li>

                        <li><a class="sidebar-link" href="<?= VPATH ?>dashboard/setting"><i
                                        class="fa fa-cogs"></i> <?php echo __('header_sticky_settings', 'Settings'); ?>
                            </a></li>
                        <li><a class="sidebar-link" href="<?= VPATH ?>user/logout/"><i
                                        class="fa fa-sign-out-alt"></i> <?php echo __('header_sticky_logout', 'Logout'); ?>
                            </a></li>
                    </ul>
                </nav>
                <span class="sidebar-close-alt">&times;</span></div>
        </div>
    </div>
<?php } ?>
<?php
if ($this->session->userdata('user')) {
  ?>
    <div class="profileSe" style="display: none">
        <!--<div class="profileSetop">
          <div class="profileSetopBTN">
            <input name="view" checked="" id="online" type="radio">
            <label class="BtN btnSec" for="online">Online</label>
            <input name="view" id="invisible" type="radio">
            <label class="BtN btnSec" for="invisible">Invisible</label>
          </div>
        </div>-->
        <ul class="secentList">
            <li title="<?= ucwords($name) ?>" class="secentListInactive"><a href="<?= VPATH ?>dashboard"
                                                                            class="secentListItem secentListItemActive">
                    <span class=""> <img src="<?= VPATH ?>assets/<?= $logo ?>"
                                         style="height: 36px;width: 36px;border-radius: 18px;"></span>
                <?= ucwords($name) ?>
                </a></li>

            <!--<li><a href="<?//=VPATH
            ?>dashboard/setting" class="secentListItem SectionBottom"><i class="fa fa-cogs"></i> Settings</a> </li>-->
            <li><a href="<?= VPATH ?>user/logout/" class="secentListItem" title="Log out"> <i
                            class="fa fa-sign-out"></i> <?php echo __('header_sticky_logout', 'Logout'); ?> <span
                            class="float-right">
    <?= $user[0]->username ?>
    </span> </a></li>
        </ul>
    </div>
    <ul class="notiH" role="menu" style="width:300px; display:none"></ul>

  <?php
}
?>
<style>

    .notification:after, .notification:before {
        right: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }

    .notification {
        -webkit-border-radius: 3px;
        border-radius: 3px;
        border: 1px solid #5b6779;
        background: #6f7a8a;
        padding: 0px 6px;
        position: relative;
        color: #f2f2f2;
        font-weight: bold;
        font-size: 12px;
    }

    .notification.red {
        border-color: #be3d3c;
        background: #d8605f;
        color: #f2f2f2;
    }

    .notification:before {
        border-color: rgba(182, 119, 9, 0);
        border-right-color: #5b6779;
        border-width: 7px;
        top: 50%;
        margin-top: -7px;
    }

    .notification.red:before {
        border-color: rgba(190, 61, 60, 0);
        border-right-color: #be3d3c;
    }

    .notification.red:after {
        border-color: rgba(216, 96, 95, 0);
        border-right-color: #d8605f;
    }

    .notification:after {
        border-color: rgba(111, 122, 138, 0);
        border-right-color: #6f7a8a;
        border-width: 6px;
        top: 50%;
        margin-top: -6px;
    }
</style>
<script>
  jQuery(document).ready(function ($) {
    $('.srch_dropdown_item').click(function (e) {
      e.preventDefault();
      var srch = $(this).attr('data-srch');
      if (srch == 'Freelancer') {
        // $('#srch_txt').html(srch);

        $('#srch_txt').html('<?php echo __('Influencer', 'Influencer'); ?>');
        $("#search_input").attr("placeholder", "Search <?php echo __('Influencer', 'Influencer'); ?>");
        $('#header_search_form').attr('action', '<?php echo VPATH;?>findtalents');
        $('#lookin').val('freelancer');
      }

      if (srch == 'Jobs') {
        // $('#srch_txt').html(srch);
        $('#srch_txt').html('<?php echo __('jobs', 'Jobs'); ?>');
        $("#search_input").attr("placeholder", "Search <?php echo __('jobs', 'Jobs'); ?>");
        $('#header_search_form').attr('action', '<?php echo VPATH;?>findjob/browse');
        $('#lookin').val('findjob');
      }
    });
  });
</script>

<script>
  $(document).ready(function () {


    //stick in the fixed 100% height behind the navbar but don't wrap it
    //$('#slide-nav.navbar-inverse').after($('<div class="inverse" id="navbar-height-col"></div>'));

    $('#slide-nav.navbar-default').after($('<div id="navbar-height-col"></div>'));

    // Enter your ids or classes
    var toggler = '.navbar-toggle';
    var pagewrapper = '#page-content';
    var navigationwrapper = '.navbar-header';
    var menuwidth = '100%'; // the menu inside the slide menu itself
    var slidewidth = '80%';
    var menuneg = '-100%';
    var slideneg = '-100%';


    $("#slide-nav").on("click", toggler, function (e) {

      var selected = $(this).hasClass('slide-active');
      $('#slidemenu').stop().animate({
        left: selected ? menuneg : '0px'
      });
      $('#navbar-height-col').stop().animate({
        left: selected ? slideneg : '0px'
      });
      $(pagewrapper).stop().animate({
        left: selected ? '0px' : slidewidth
      });
      $(navigationwrapper).stop().animate({
        left: selected ? '0px' : slidewidth
      });
      $(this).toggleClass('slide-active', !selected);
      $('#slidemenu').toggleClass('slide-active');
      $('#page-content, .navbar, .navbar-header').toggleClass('slide-active');
    });

    var selected = '#slidemenu, #page-content, .navbar, .navbar-header';

    $(window).on("resize", function () {

      if ($(window).width() > 767 && $('.navbar-toggle').is(':hidden')) {
        $(selected).removeClass('slide-active');
      }
    });

  });

</script>

<div id="page-content">
