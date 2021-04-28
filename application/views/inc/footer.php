<!-- Footer Start -->
<?php
$page_partner = $this->auto_model->getFeild('partner', 'pagesetup', 'id', '1');
$page_newsletter = $this->auto_model->getFeild('newsletter', 'pagesetup', 'id', '1');
$page_posts = $this->auto_model->getFeild('posts', 'pagesetup', 'id', '1');
$page_popular_links = $this->auto_model->getFeild('popular_links', 'pagesetup', 'id', '1');
$footer_text = $this->auto_model->getFeild('footer_text', 'setting', 'id', '1');

$event = $this->auto_model->getalldata('', 'event', 'status', 'Y');
$partner = $this->auto_model->getalldata('', 'partner', 'status', 'Y', 6);
$popular = $this->auto_model->getalldata('', 'popular', 'id', '1');

$lang = $this->session->userdata('lang');
?>

<div class="clearfix"></div>
<footer id="home-footer">
    <div>
        <div class="container">
            <div class="row">

              <?php if ($page_popular_links == 'Y') { ?>
                <article class="col-sm-2 col-xs-4">
                    <h4>efluencer</h4>
                    <ul class="foot-nav">
                        <li><a href="<?= VPATH ?>information/info/about_us/"
                               <?php if ($current_page == "about_us"){ ?>id="current"<?php } ?>><?php echo __('about_us', 'About Us'); ?></a>
                        </li>
                        <li><a href="<?php echo VPATH; ?>knowledgebase/"
                               <?php if ($current_page == "knowledge_base"){ ?>id="current"<?php } ?>><?php echo __('success_tips', 'Success Tips'); ?></a>
                        </li>
                      <?php foreach ($popular as $vals) { ?>
                        <?php if ($vals->faq == 'Y') { ?>
                              <li><a href="<?php echo base_url() ?>faq_help"><?php echo __('faqs', 'FAQs'); ?></a></li>
                        <?php } ?>
                      <?php } ?>
                    </ul>
                </article>

                <article class="col-sm-2 col-xs-4">
                    <h4>Legal</h4>
                    <ul class="foot-nav">
                      <?php foreach ($popular as $vals) { ?>

                        <?php if ($vals->privacy == 'Y') { ?>
                              <li>
                                  <a href="<?php echo base_url() ?>information/info/privacy_policy"><?php echo __('privecy_policy', 'Privacy Policy'); ?></a>
                              </li>
                        <?php } ?>
                        <?php if ($vals->terms == 'Y') { ?>
                              <li>
                                  <a href="<?php echo base_url() ?>information/info/terms_condition"><?php echo __('terms_&_conditions', 'Terms & Conditions'); ?></a>
                              </li>
                        <?php } ?>
                        <?php if ($vals->refund == 'Y') { ?>
                              <li>
                                  <a href="<?php echo base_url() ?>information/info/refund_policy"><?php echo __('refund_policy', 'Refund Policy'); ?></a>
                              </li>
                        <?php } ?>
                        <?php if ($vals->service == 'Y') { ?>
                              <li><a href="<?php echo base_url() ?>information/info/service_agreement">Service
                                      Agreement</a></li>
                        <?php } ?>

                        <?php if ($vals->sitemap == 'Y') { ?>
                              <li><a href="<?php echo base_url() ?>sitemap"><?php echo __('sitemap', 'Sitemap'); ?></a>
                              </li>
                        <?php } ?>

                      <?php } ?>
                    </ul>

                  <?php } ?>
                </article>

                <article class="col-sm-2 col-xs-4">
                    <h4>Need Help?</h4>
                    <ul class="foot-nav">
                        <li><a href="https://vipleyo.com/helpdesk" target="_blank">Live Chat</a></li>
                        <li><a href="https://vipleyo.com/helpdesk/knowledge.html" target="_blank">Resources</a></li>
                      <?php foreach ($popular as $vals) { ?>
                        <?php if ($vals->contact == 'Y') { ?>
                              <li>
                                  <a href="<?php echo VPATH; ?>contact/"><?php echo __('contact_us', 'Contact Us'); ?></a>
                              </li>
                        <?php } ?>
                      <?php } ?>


                    </ul>
                </article>

              <?php
              $top_categories = $this->db->select("p.category , c.cat_name,c.arabic_cat_name,c.spanish_cat_name,c.swedish_cat_name, COUNT(p.id) AS total")->from('projects p')->join('categories c', 'c.cat_id=p.category', 'LEFT')->where(array('p.status' => 'O', 'p.project_status' => 'Y'))->group_by('p.category')->order_by('total', 'DESC')->limit(5, 0)->get()->result_array();
              ?>
                <!--<article class="col-sm-2 col-xs-12">
    	<h4><?php echo __('browse', 'Browse'); ?></h4>
    	<ul class="foot-nav">
			<?php if (count($top_categories) > 0) {
                  foreach ($top_categories as $k => $v) {

                    switch ($lang) {
                      case 'arabic':
                        $categoryName = !empty($v['arabic_cat_name']) ? $v['arabic_cat_name'] : $v['cat_name'];
                        break;
                      case 'spanish':
                        //$categoryName = $val['spanish_cat_name'];
                        $categoryName = !empty($v['spanish_cat_name']) ? $v['spanish_cat_name'] : $v['cat_name'];
                        break;
                      case 'swedish':
                        //$categoryName = $val['swedish_cat_name'];

                        $categoryName = !empty($v['swedish_cat_name']) ? $v['swedish_cat_name'] : $v['cat_name'];
                        break;
                      default :
                        $categoryName = $v['cat_name'];
                        break;
                    }

                    ?>
			<li><a href="<?php echo base_url('findjob/browse') . '/' . $this->auto_model->getcleanurl($v['cat_name']) . '/' . $v['category'] ?>"><?php echo $categoryName; ?></a></li>
			<?php }
                } ?>
        </ul>
    </article>-->
                <article class="col-sm-2 col-xs-6">
                    <!--
                  <a class="twitter-timeline" data-width="250" data-height="300" data-theme="dark" data-link-color="#19CF86" href="https://twitter.com/TwitterDev">Tweets by TwitterDev</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                    <h4>Latest Tweet</h4>
                    <ul class="twitter-widget">
                        <li><i class="fa fa-twitter"></i> <span>Lorem Ipsum is simply dummy text of the printing and typesetting <a href="#">#myboodesign</a>
                        <h6><a href="#">an hour ago</a> &nbsp;&nbsp;&nbsp; <a href="#">reply</a>&nbsp;&nbsp;&nbsp;<a href="#">retweet</a></h6></span>
                        </li>
                        <li><i class="fa fa-twitter"></i> <span>Lorem Ipsum is simply dummy text of the printing and typesetting <a href="#">#myboodesign</a>
                        <h6><a href="#">an hour ago</a> &nbsp;&nbsp;&nbsp; <a href="#">reply</a>&nbsp;&nbsp;&nbsp;<a href="#">retweet</a></h6></span></li>

                    </ul>-->
                </article>
              <?php if ($page_newsletter == 'Y') { ?>
                  <article class="col-sm-4 col-xs-12">
                      <div class="newsletter">
                          <h4>Subscribe to jobs</h4>
                          <form>
                              <div class="row">
                                  <div class="col-sm-8 col-xs-12">
                                      <input type="email" name="" id="sub_email" class="form-control"
                                             placeholder="<?php echo __('email_address', 'Email Address'); ?>"/>
                                      <span id="subs_error"
                                            style="float: left;margin-top: 0px; margin-bottom: 8px; width: 100%;color:#f00;font-size: 12px; display:none;"><?php echo __('enter_your_email', 'Email address'); ?>!!!</span>
                                  </div>
                                  <div class="col-sm-3 col-xs-12">
                                      <button type="button" class="btn" id="subscription" value="Subscribe"
                                              onclick="getSubscription()"><?php echo __('subscribe', 'Subscribe'); ?></button>
                                  </div>
                              </div>
                          </form>
                          Subscribe to receive our latest jobs' newsletter.
                      </div>
                  </article>
              <?php } ?>
            </div>
        </div>
    </div>
    <div class="copyright text-center">
        <div class="container">
            <!-- <p><?php echo $footer_text; ?></p> -->
            © Copyright <?php echo date("Y"); ?> eFluencer.
        </div>
    </div>
</footer>

<div class="gotop"><i class="fa fa-arrow-up"></i></div>
</div><!--page-content end (start in header.php)-->
<script>
  /*JavaScript Document must be on body*/
  jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 1) {
      jQuery('.gotop').css({bottom: "50px"});
    } else {
      jQuery('.gotop').css({bottom: "-200px"});
    }
  });
  jQuery('.gotop').click(function () {
    jQuery('html, body').animate({scrollTop: '0px'}, 800);
    return false;
  });
</script>
<link href="<?= CSS ?>bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="<?= JS ?>moment-with-locales.js"></script>
<script src="<?= JS ?>bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('.datepicker').datetimepicker({
      format: 'YYYY-MM-DD', minDate: new Date()
      /*debug:true*/
    });
  });
</script>
<script src="<?= JS ?>bootstrap.js"></script>

<script>
  var is_open_notification = 0;
  jQuery(document).ready(function () {
    setInterval(function () {
      var dataString = '';
      jQuery.ajax({
        type: "POST",
        data: dataString,
        url: "<?php echo base_url();?>dashboard/getNotificationcount/",
        success: function (return_data) {

          if (return_data > 0) {
            jQuery("#head_noti").html(return_data).show();
            jQuery('.count_list').html('');
            jQuery('.count_list').html(return_data);
            jQuery('.count_list').show();
          } else {
            jQuery("#head_noti").hide();
          }
        }
      });
    }, 3000);

    setInterval(function () {
      var dataString = '';
      jQuery.ajax({
        type: "POST",
        data: dataString,
        url: "<?php echo base_url();?>dashboard/getMessagecount/",
        success: function (return_data) {

          if (return_data > 0) {
            jQuery("#msg_count").html(return_data).show();
          } else {
            jQuery("#msg_count").hide();
          }
        }
      });
    }, 30000);

    setTimeout(function () {
      var matches = [];
      jQuery('.notifid').each(function () {
        if (jQuery(this).hasClass('unread')) {
          matches.push(jQuery(this).val());
        }

      });
      var dataString = 'notifid=' + matches;
      jQuery.ajax({
        type: "POST",
        data: dataString,
        url: "<?php echo base_url();?>dashboard/updatenotification/",
        success: function (return_data) {
          /*alert(return_data);*/
          if (return_data > 0) {
            jQuery('.notifbox').removeClass('notif_active');
          }
        }
      });

    }, 6000);


    jQuery("li.headnotification").on('click', function (e) {
      e.stopPropagation();
      console.log(is_open_notification);
      if (is_open_notification > 0) {
        jQuery(".notiH").fadeOut();
        is_open_notification = 0;
      } else {

        is_open_notification = 1;
        if (jQuery(".headnotification").length) {
          var positionright = jQuery(".headnotification").position();

          var head_noti = document.getElementById("head_noti").offsetWidth;
          if (head_noti > 0) {
            var mimx = 215 + parseFloat(head_noti);
          } else {
            var mimx = 245;
          }
          var l = parseFloat(positionright.left) - parseFloat(mimx);
          jQuery('.notiH').css('left', l + "px");
        }
        jQuery('.notiH').html(' <li><a href="#" class="">Loading...</a></li>');
        jQuery.ajax({
          type: "POST",
          url: "<?php echo base_url();?>dashboard/getnotification/",
          success: function (return_data) {

            jQuery('.notiH').html(return_data);
            jQuery('.notiH').show();
            /*var matches=jQuery('.readids').val();
    var dataString = 'notifid='+matches;
    jQuery.ajax({
      type:"POST",
      data:dataString,
      url:"<?php echo base_url();?>dashboard/updatenotification/",
					success:function(return_data)
					{
					//alert(return_data);
						if(return_data>0)
						{
							jQuery('.notifbox').removeClass('notif_active');
						}
					}
				})*/
          }
        });
      }

    });
    jQuery('.sidebar-close-alt').click(function (e) {
      jQuery(".quicknav").fadeOut();
    });
    jQuery('.toggle-leftbar img').click(function (e) {
      jQuery(".quicknav").fadeIn();
    });
    jQuery('.toggle-leftbar').click(function (e) {
      if (jQuery(".profile-imgEcnLi").length) {
        var positionright = jQuery(".profile-imgEcnLi").position();
        /* console.log(positionright);

        console.log(head_noti); */

        var mimx = 297;
        var l = parseFloat(positionright.left) - parseFloat(mimx);
        jQuery('.profileSe').css('left', l + "px");
      }
      jQuery(".profileSe").fadeIn();
    })
  });
  jQuery(document).click(function (e) {
    if (!jQuery(e.target).is('.toggle-leftbar') && jQuery('.profileSe').has(e.target).length === 0) {
      jQuery(".profileSe").fadeOut();
    }

    is_open_notification = 0;


    jQuery(".notiH").fadeOut();


    if (!jQuery(e.target).is('.headnotification a') && jQuery('.notiH').has(e.target).length === 0) {

    }
  })

</script>

<?php
if ($current_page == 'jobdetails') {
  ?>
    <script type="text/javascript" src="<?php echo ASSETS; ?>js/new_ajaxfileupload.js"></script>
  <?php
}
?>
<?php
if ($current_page == 'dashboard' || $current_page == "talentdetails") {
  ?>
    <!--<script src="<?php echo VPATH ?>assets/js/mootools-1.2.1-core-yc.js" type="text/javascript"></script>
<script src="<?php echo VPATH ?>assets/js/mootools-1.2-more.js" type="text/javascript"></script>
<script src="<?php echo VPATH ?>assets/js/jd.gallery.js" type="text/javascript"></script>
<script type="text/javascript">
			function startGallery() {
				var myGallery = new gallery($('myGallery'), {
					timed: true
				});
			}
			window.addEvent('domready',startGallery);
		</script>-->
  <?php
}
if ($current_page == 'editprofile_professional' || $current_page == 'postjob' || $current_page == 'editportfolio' || $current_page == 'addportfolio') {
  if ($current_page != 'postjob') {
    ?>
      <!--<script type="text/javascript" src="<?php echo JS; ?>jquery.min.js"></script>-->
  <?php } ?>
    <script type="text/javascript" src="<?php echo JS; ?>ajaxfileupload.js"></script>
  <?php
}
?>
<!--<script src="<? //=JS?>jquery.parallax.js"></script>
<script src="<? //=JS?>modernizr-2.6.2.min.js"></script>
<script src="<? //=JS?>revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
<script src="<? //=JS?>jquery.nivo.slider.pack.js"></script>
<script src="<? //=JS?>jquery.prettyPhoto.js"></script>-->

<script src="<?= JS ?>superfish.js"></script>
<script src="<?= JS ?>tytabs.js"></script>
<script src="<?= JS ?>jquery.gmap.min.js"></script>
<script src="<?= JS ?>circularnav.js"></script>
<script src="<?= ASSETS ?>plugins/sticky/jquery.sticky.js"></script>
<script src="<?= JS ?>imagesloaded.pkgd.min.js"></script>
<script src="<?= JS ?>jflickrfeed.js"></script>
<script src="<?= JS ?>waypoints.min.js"></script>
<script src="<?= JS ?>spectrum.js"></script>
<script src="<?= JS ?>custom.js"></script>

<script>
  var $ = jQuery;
  /*$(function() {

  $( "#datepicker_from" ).datepicker({

    maxDate: new Date(),

    showOn: "button",

    buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true

		});

	});

	$(function() {

		$( "#datepicker_to" ).datepicker({

			showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true

		});

	});

	$(function() {

		$( "#dep_date" ).datepicker({

			maxDate: new Date(),

			showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true

		});

	});

	$(function() {

		$( ".mdt" ).datepicker({

			minDate: new Date(),

			showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true

		});

	});*/

  function getSubscription() {
    if ($("#sub_email").val() == "") {
      $("#subs_error").show();
    } else {
      var dataString = 'email=' + $("#sub_email").val();

      $.ajax({
        type: "POST",
        data: dataString,
        url: "<?php echo VPATH;?>user/newsletterSubscription",
        success: function (return_data) {
          if (return_data == '1') {
            $("#subs_error").text("<?php echo __('subscription_successful', 'Thank you. Your newsletter subscription is successful.'); ?>");
            $("#subs_error").css("color", "#FFFFFF");
            $("#subs_error").show();
            $("#sub_email").val('');
          } else if (return_data == '2') {
            $("#subs_error").text("<?php echo __('subscription_failed', 'Sorry..! Unable to process your request.'); ?>");
            $("#subs_error").show();
          } else if (return_data == '3') {
            $("#subs_error").text("<?php echo __('alert_email_exist', 'Sorry..! This Email Id already exist.'); ?>");
            $("#subs_error").show();
          } else if (return_data == '4') {
            $("#subs_error").text("<?php echo __('alert_valid_email', 'Enter a valid email.'); ?>");
            $("#subs_error").show();
          } else {
            $("#subs_error").show();
          }
        }
      });


    }
  }


</script>
<!--<script type="text/javascript">
    var tooltipObj = new DHTMLgoodies_formTooltip();
    tooltipObj.setTooltipPosition('right');
    tooltipObj.setPageBgColor('#EEEEEE');
    tooltipObj.setTooltipCornerSize(15);
    tooltipObj.initFormFieldTooltip();
</script>-->
<div id="fb-root"></div>
<script type="text/javascript">
  window.fbAsyncInit = function () {
    //Initiallize the facebook using the facebook javascript sdk
    FB.init({
      appId: '<?php echo YOUR_APP_ID; ?>', // App ID
      cookie: true, // enable cookies to allow the server to access the session
      status: true, // check login status
      xfbml: true, // parse XFBML
      oauth: true //enable Oauth
    });
  };
  //Read the baseurl from the config.php file
  (function (d) {
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {
      return;
    }
    js = d.createElement('script');
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
  }(document));
  //Onclick for fb login
  jQuery('.facebook').click(function (e) {
    FB.login(function (response) {
      if (response.authResponse) {
        parent.location = '<?php echo base_url(); ?>login/fblogin'; //redirect uri after closing the facebook popup
      }
    }, {scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
  });
</script>
<script src="<?php echo JS; ?>select2.min.js"></script>
<script type="text/javascript">
  function select2load() {
//$(".select2-selection__choice").remove(); // clear out values selected
  }
</script>
<script>
  (function () {
    // setup your carousels as you normally would using JS
    // or via data attributes according to the documentation
    // http://getbootstrap.com/javascript/#carousel
    $('#carousel123').carousel({interval: 2000});
  })();

  (function () {
    $('.carousel-showsixmoveone .item').each(function () {
      var itemToClone = $(this);

      for (var i = 1; i < 6; i++) {
        itemToClone = itemToClone.next();

        // wrap around if at end of item collection
        if (!itemToClone.length) {
          itemToClone = $(this).siblings(':first');
        }

        // grab item, clone, add marker class, add to collection
        itemToClone.children(':first-child').clone()
          .addClass("cloneditem-" + (i))
          .appendTo($(this));
      }
    });
  }());

  /*$(".carousel").swipe({

    swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

      if (direction == 'left') $(this).carousel('next');
      if (direction == 'right') $(this).carousel('prev');

    },
    allowPageScroll:"vertical"

  });*/
</script>
<script>
  function changeLang(ele, lang) {
    //alert(lang);
    $.ajax({
      url: "<?php echo base_url('user/changeLanguage'); ?>",
      type: "post",
      dataType: "JSON",
      data: {language: lang},
      success: function (data) {
        if (data.status == 1) {
          //$(this).parent().parent().prev().html($(this).html() + '<span class="caret"></span>');
          location.reload();
        }
      }
    });
  }
</script>
</body>
</html>
