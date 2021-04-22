<link href="<?= CSS ?>unveilEffects.css" rel="stylesheet" type="text/css">
<script src="<?= JS ?>jquery.unveilEffects.js" type="text/javascript"></script>
<?php
$page_skill = $this->auto_model->getFeild('skills', 'pagesetup', 'id', '1');
$page_testimonial = $this->auto_model->getFeild('testimonial', 'pagesetup', 'id', '1');
$page_partners = $this->auto_model->getFeild('partner', 'pagesetup', 'id', '1');
$page_cms = $this->auto_model->getFeild('cms', 'pagesetup', 'id', '1');
$page_counting = $this->auto_model->getFeild('counting', 'pagesetup', 'id', '1');
$cms_sec1 = $this->auto_model->getalldata('', 'cms', 'id', '1');
$cms_sec2 = $this->auto_model->getalldata('', 'cms', 'id', '2');
$cms_sec3 = $this->auto_model->getalldata('', 'cms', 'id', '3');

$lang = $this->session->userdata('lang');

?>
<div class="banner">
    <!--<div class="overlay"></div>-->
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <?php for ($i = 0; $i < count($banner); $i++) { ?>
              <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>"
                  class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
          <?php } ?>
        </ol>

        <!-- Wrapper for slides -->
      <?php
      $user = $this->session->userdata('user');
      if (!empty($user)) {
        redirect(base_url('dashboard/overview'));
        // $user_id = $user[0]->user_id;
        // $account_type = $user[0]->account_type;
      }
      ?>
        <div class="carousel-inner" role="listbox">
          <?php if (count($banner) > 0) {
            foreach ($banner as $key => $val) { ?>
                <div class="item <?php if ($key == 0) {
                  echo 'active';
                } ?>"><img src="<?php echo ASSETS . 'banner_image/' . $val['image']; ?>" alt="..."
                           class="hidden-mobile"> <img src="<?php echo ASSETS . 'banner_image/' . $val['image']; ?>"
                                                       alt="..." class="visible-mobile">
                    <div class="overlay" style="display: none"></div>
                    <div class="carousel-caption text-left">
                        <div class="container">
                            <h1 class="hidden-xs"><?php echo $val['title']; ?></h1>
                            <h4><?php echo $val['description']; ?></h4>
                          <?php
                          if (!empty($user_id) && $account_type === 'E') { ?>
                              <a href="<?= VPATH ?>postjob" class="btn btn-lg btn-border btn-border-blue btn-big">
                                  <!--<img src="<?php echo IMAGE; ?>tie.png" alt="">--> <?php echo __('home_post_job', 'Post Job'); ?></a>
                              <span class="hidden-xs">&nbsp;&nbsp;</span>
                          <?php } else if (empty($user_id)) { ?>
                              <a href="<?php echo base_url('login?refer=postjob') ?>"
                                 class="btn btn-lg btn-border btn-border-blue btn-big">
                                  <!--<img src="<?php echo IMAGE; ?>tie.png" alt="">--> <?php echo __('home_post_job', 'Post Job'); ?></a>
                              <span class="hidden-xs">&nbsp;&nbsp;</span>
                          <?php } ?>
                          <?php if (empty($user_id)) { ?>
                              <a href="<?php echo base_url('signup'); ?>"
                                 class="btn btn-lg btn-border btn-border-dark btn-big">
                                  <!--<i class="zmdi zmdi-account" style="font-size: 22px;line-height: 1"></i>-->Join
                                  Now</a>
                          <?php } ?>
                        </div>
                    </div>
                </div>
            <?php }
          } else { ?>
              <div class="item active"><img src="<?php echo IMAGE; ?>banner01.jpg" alt="..." class="hidden-mobile"> <img
                          src="<?php echo IMAGE; ?>mobile_banner01.jpg" alt="..." class="visible-mobile">
                  <div class="overlay" style="display: none"></div>
                  <div class="carousel-caption text-left">
                      <div class="container">
                          <h1 class="hidden-xs"><?php echo __('home_get_more_done_with_freelancer', 'Sell more with influencers'); ?></h1>
                          <h4><?php echo __('home_grow_your_business_with_the_top_freelancing_website', 'Grow your business with the field experts.'); ?></h4>
                        <?php if (!empty($user_id)) { ?>
                            <a href="<?= VPATH ?>postjob" class="btn btn-lg btn-border btn-border-blue btn-big">
                                <!--<img src="<?php echo IMAGE; ?>tie.png" alt="">--> <?php echo __('home_post_job', 'Post Job'); ?></a>
                            <span class="hidden-xs">&nbsp;&nbsp;</span>
                        <?php } else { ?>
                            <a href="<?php echo base_url('login?refer=postjob') ?>"
                               class="btn btn-lg btn-border btn-border-blue btn-big">
                                <!--<img src="<?php echo IMAGE; ?>tie.png" alt="">--> <?php echo __('home_post_job', 'Post a Job'); ?> </a>
                            <span class="hidden-xs">&nbsp;&nbsp;</span>
                        <?php } ?>
                        <?php if (empty($user_id)) { ?>
                            <a href="<?php echo base_url('signup'); ?>"
                               class="btn btn-lg btn-border btn-border-dark btn-big">
                                <!--<i class="zmdi zmdi-account" style="font-size: 22px;line-height: 1"></i>-->Join
                                Now</a>
                        <?php } ?>
                      </div>
                  </div>
              </div>
          <?php } ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?php if ($page_skill == 'Y') { ?>
    <!-- skill secton start -->

    <section class="sec skills">
        <div class="container">
            <h2 class="title">Search through 437k Influencers & Freelancers<br>
            </h2>
            <h4 call="subtitle">Influencer marketing yields ROI as much as 11X that of online ads.<br><br>Collaborating
                with influencers helps companies create content that rises above the noise and resonates with their
                target groups. <br><br>Influencers help build trust, establish brand ideals, and circumvent ad-blockers.
            </h4>
            <br>
            <h2 class="title">Find an Expert. Hire a Specialist<br>
            </h2>
            <div class="skill-box">
              <?php

              if (count($skills) > 0) {
                foreach ($skills as $k => $v) {
                  $img = !empty($v['image']) ? ASSETS . 'skill_image/' . $v['image'] : IMAGE . 'no-image_60x60.png';

                  $skill_name = $v['skill_name'];
                  switch ($lang) {
                    case 'arabic':
                      $skill_name = !empty($v['arabic_skill_name']) ? $v['arabic_skill_name'] : $v['skill_name'];
                      break;
                    case 'spanish':
                      //$categoryName = $val['spanish_cat_name'];
                      $skill_name = !empty($v['spanish_skill_name']) ? $v['spanish_skill_name'] : $v['skill_name'];
                      break;
                    case 'swedish':
                      //$categoryName = $val['swedish_cat_name'];

                      $skill_name = !empty($v['swedish_skill_name']) ? $v['swedish_skill_name'] : $v['skill_name'];
                      break;
                    default :
                      $skill_name = $v['skill_name'];
                      break;
                  }


                  ?>
                    <!--<article class="col-md-3 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
        <div class="skill-widgets"> <a href="<?php echo base_url('findtalents/browse') . '/' . $this->auto_model->getcleanurl($v['skill_name']) . '/' . $v['id'] ?>" class="icon"> <img  src="<?php echo $img; ?>" alt=""/> </a>
          <h5><a href="<?php echo base_url('findtalents/browse') . '/' . $this->auto_model->getcleanurl($v['skill_name']) . '/' . $v['id'] ?>"><?php echo strlen($v['skill_name']) > 20 ? strip_tags(substr(ucwords($skill_name), 0)) . '..' : strip_tags(ucwords($skill_name)); ?></a></h5>
        </div>
      </article>-->
                <?php }
              } ?>

                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/1.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Bloggers and Vloggers</a></h5>
                        <p class="sub-description">They are also usually very active, dedicated and publish content on a
                            regular basis.</p>
                    </div>
                </article>

                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/2.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Social Media Sensations</a></h5>
                        <p class="sub-description">They share glimpses of their regular lives and forge a strong rapport
                            with their followers.</p>
                    </div>
                </article>

                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/3.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Micro-Influencers</a></h5>
                        <p class="sub-description">High engagement levels are very important. This is where
                            micro-influencers come into the pictures.</p>
                    </div>
                </article>


                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/4.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Web & Mobile Devs</a></h5>
                        <p class="sub-description">Hire Web Developers Skilled in PHP, Java, Python, RoR to Build
                            Powerful Websites and Apps. </p>
                    </div>
                </article>

                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/5.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Tech Support</a></h5>
                        <p class="sub-description">Outsourced technical support help desk. In-depth training, QA, and
                            reports. No overheads.</p>
                    </div>
                </article>

                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/6.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Database Experts</a></h5>
                        <p class="sub-description">Proactive Database Assessments Combined with 24×7 Monitoring. Trusted
                            by 600+ Companies. </p>
                    </div>
                </article>

                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/7.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Online Marketers</a></h5>
                        <p class="sub-description"> Hire pre-vetted marketing experts with experience from global brands
                            and hot startups.</p>
                    </div>
                </article>

                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/8.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Admin Support</a></h5>
                        <p class="sub-description">Pick Your Freelancer, See Their Portfolios and Reviews. Hire Agents
                            on Demand.</p>
                    </div>
                </article>

                <article class="col-md-4 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
                    <div class="skill-widgets">
                        <a href="#url" class="icon"><img src="<?php echo ASSETS . 'skills-icons/9.svg'; ?>"
                                                         alt="skill-ico"/> </a>
                        <h5 class="title"><a href="#url">Creative Designers</a></h5>
                        <p class="sub-description">Let Our Portfolios Inspire You· Expert Designers Ready to Help. Post
                            Your Job & Receive Offers In Minutes.</p>
                    </div>
                </article>


            </div>

            <div class="spacer-20"></div>
            <div class="col-md-12 center-block text-center">
                <a style="min-width: 140px;" href="<?php echo base_url('findtalents'); ?>"
                   class="btn btn-site btn-border-blue btn-lg xs-block">Search Now</a>
                <span class="hidden-xs">&nbsp;&nbsp;</span>
                <a style="min-width: 140px;" href="<?php echo base_url('login?refer=postjob'); ?>"
                   class="btn btn-lg btn-site btn-border-blue xs-block">Post a Job</a>
            </div>
    </section>

    <!-- skill section end -->
<?php } ?>
<div class="clearfix"></div>

<section class="sec sec-how-it-works whiteBg" data-effect="slide-bottom">
    <div class="container">
        <h2 class="title"><?php echo __('home_how_it_works', 'How it works'); ?></h2>
        <div class="row ">
            <div class="col-md-6 how-plate">
                <h3 class="text-center">If you're a business or a brand.</h3>

                <div class="wrapper how-box">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6 how-box-item">
                            <div class="img-icon"><img src="<?= IMAGE ?>hows/ico-1l.svg" alt="" width="60" height="60">
                            </div>
                            <div class="title">Post Project</div>
                            <div class="sub-title">Post a project with requirements, we will match your requirements to
                                qualified influencers.
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 how-box-item">
                            <div class="img-icon"><img src="<?= IMAGE ?>hows/ico-2l.svg" alt="" width="60" height="60">
                            </div>
                            <div class="title">Find & Hire</div>
                            <div class="sub-title">Browse proposals, check influencer profiles, portfolios, ratings and
                                the number of completed projects.
                            </div>
                        </div>
                    </div>
                    <div class="spacer-30"></div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6 how-box-item">
                            <div class="img-icon"><img src="<?= IMAGE ?>hows/ico-3l.svg" alt="" width="60" height="60">
                            </div>
                            <div class="title">Award & Pay</div>
                            <div class="sub-title">Award a project to an influencer, communicate project details and pay
                                as milestones are submitted.
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 how-box-item">
                            <div class="img-icon"><img src="<?= IMAGE ?>hows/ico-4l.svg" alt="" width="60" height="60">
                            </div>
                            <div class="title">Approval</div>
                            <div class="sub-title">Share files using the safe, built-in chat feature, review designs,
                                and approve the work progress.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer-30"></div>
                <a style="min-width: 140px; max-width: 200px;" href="<?php echo base_url('postjob'); ?>"
                   class="center-block btn btn-site btn-border-blue btn-lg xs-block">Post a Project</a>
            </div>

            <div class="col-md-6 how-plate">
                <h3 class="text-center">If you're an influencer or a Freelancer.</h3>


                <div class="wrapper how-box">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6 how-box-item">
                            <div class="img-icon"><img src="<?= IMAGE ?>hows/ico-1r.svg" alt="" width="60" height="60">
                            </div>
                            <div class="title">Complete your profile</div>
                            <div class="sub-title">Make your profile interactive by highlighting key skills, projects &
                                strengths in key areas.
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 how-box-item">
                            <div class="img-icon"><img src="<?= IMAGE ?>hows/ico-2r.svg" alt="" width="60" height="60">
                            </div>
                            <div class="title">Find projects</div>
                            <div class="sub-title">Find projects that are relevant to your niche, and submit proposals
                                to clients.
                            </div>
                        </div>
                    </div>
                    <div class="spacer-30"></div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6 how-box-item">
                            <div class="img-icon"><img src="<?= IMAGE ?>hows/ico-3r.svg" alt="" width="60" height="60">
                            </div>
                            <div class="title">Bid on projects</div>
                            <div class="sub-title">Bid on a project that fits your skills, budget and time constraints
                                as required by the client's project.
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 how-box-item">
                            <div class="img-icon"><img src="<?= IMAGE ?>hows/ico-4r.svg" alt="" width="60" height="60">
                            </div>
                            <div class="title">Get hired & paid</div>
                            <div class="sub-title">If your bid is accepted, communicate with the client, and get paid
                                after project completion.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer-30"></div>
                <a style="min-width: 140px; max-width: 200px;" href="<?php echo base_url('findjob'); ?>"
                   class="center-block btn btn-site btn-border-blue btn-lg xs-block">Find Projects</a>
            </div>
        </div>

        <!--    <div class="row process">-->
        <!--      <div class="row-same-height">-->
        <!--        <div class="col-md-6 process-item border-right border-bottom">-->
        <!--          <div class="media content fadeIn">-->
        <!--            <div class="media-left icon"> <img src="-->
      <? //=IMAGE?><!--icon_find.svg" alt="" width="80" height="80"> </div>-->
        <!--            <div class="media-body">-->
        <!--              <h4>--><?php //echo strtoupper(__('home_find','FIND')); ?><!--</h4>-->
        <!--              <p>-->
      <?php //echo __('home_find_text','Sed posuere consectetur est at lobortis. Maecenas sed diam eget risus varius blandit sit amet non magna. Integer posuere erat a ante venenatis dapibus.'); ?><!--</p>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->

        <!--        <div class="col-md-6 process-item">-->
        <!--          <div class="media content fadeIn">-->
        <!--            <div class="media-left icon"> <img src="-->
      <? //=IMAGE?><!--icon_hire.png" alt="" width="80" height="80"> </div>-->
        <!--            <div class="media-body">-->
        <!--              <h4>--><?php //echo strtoupper(__('home_hire','HIRE')); ?><!--</h4>-->
        <!--              <p>-->
      <?php //echo __('home_hire_text','Morbi leo risus, porta ac consectetur, vestibulum at eros. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo.'); ?><!--</p>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->

        <!---->
        <!--        <div class="col-md-6 process-item border-right border-top">-->
        <!--          <div class="media content fadeIn">-->
        <!--            <div class="media-left icon"> <img src="-->
      <? //=IMAGE?><!--icon_work.svg" alt="" width="80" height="80"> </div>-->
        <!--            <div class="media-body">-->
        <!--              <h4>--><?php //echo strtoupper(__('home_work','WORK')); ?><!--</h4>-->
        <!--              <p>-->
      <?php //echo __('home_work_text','Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum ligula porta felis euismod semper. Cras justo odio, dapibus ac facilisis in, egestas eget quam.'); ?><!--</p>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->

        <!--        <div class="col-md-6 process-item border-top">-->
        <!--          <div class="media content fadeIn">-->
        <!--            <div class="media-left icon"> <img src="-->
      <? //=IMAGE?><!--icon_pay.png" alt="" width="80" height="80"> </div>-->
        <!--            <div class="media-body">-->
        <!--              <h4>--><?php //echo strtoupper(__('home_pay','PAY')); ?><!--</h4>-->
        <!--              <p>-->
      <?php //echo __('home_pay_text','Curabitur blandit tempus porttitor. Vestibulum ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Duis mollis, est non commodo luctus.'); ?><!--</p>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->

        <!--      </div>-->

        <!--    </div>-->

        <!--/.row -->
    </div>
</section>

<div class="clearfix"></div>
<?php /*?>
<section class="sec wow pulse animated">
<div class="container">
<h2 class="title"><?php echo __('home_our_plans','Our Plans'); ?></h2>
<div class="plans">
<div class="pricing-table">
<div class="price" data-effect="slide-left">
    <div class="name"><h2>&nbsp;</h2><h4>&nbsp;</h4></div>
        <ul>
            <li><?php echo __('home_bids','Bids'); ?></li>
            <li><?php echo __('home_skills','Skills'); ?></li>
            <li><?php echo __('home_portfolio','Portfolio'); ?></li>
            <li><?php echo __('home_projects','Projects'); ?></li>
            <li><?php echo __('home_unlimited_days','Unlimited Days'); ?></li>
        </ul>
	</div>
	<?php if(count($mem_plans) > 0){ foreach($mem_plans as $k => $v){
	$price_cls = 'free';
	$style = 'background-color:#00e676;';
	$border = 'border-bottom: 5px solid #00e676;';
	if($k == 1){
		$price_cls = 'silver featured';
		$style = 'background-color:#29b6f6';
		$border = 'border-bottom: 5px solid #29b6f6;';
	}else if($k == 2){
		$price_cls = 'gold';
		$style = 'background-color:#ffb300';
		$border = 'border-bottom: 5px solid #ffb300;';
	}else if($k == 3){
		$price_cls = 'platinum';
		$style = 'background-color:#aa00ff';
		$border = 'border-bottom: 5px solid #aa00ff;';
	}
?>

<div class="price <?php echo $price_cls;?>" data-effect="slide-left" style="<?php echo $border;?>">
    <div class="name" style="<?php echo $style;?>"><h2><?php echo ucfirst($v['name']);?></h2><h4><?php echo __('home_commission','Commission'); ?>: <span><?php echo round($v['bidwin_charge']);?></span> % </h4></div>
		<ul>
			<li><?php echo $v['bids'];?></li>
            <li><?php echo $v['skills'];?></li>
            <li><?php echo $v['portfolio'];?></li>
            <li><?php echo $v['project'];?></li>
			<?php if(strtolower($v['days']) == 'unlimited'){ ?>
			<li><i class="zmdi zmdi-check"></i></li>
			<?php } else { ?>
			 <li><i class="zmdi zmdi-close"></i></li>
			<?php } ?>

        </ul>
</div>
<?php } } ?>


</div>
</div>
<div class="spacer-10"></div>

  <a href="javascript:void(0)" id="compare">
    <i class="zmdi zmdi-unfold-more"></i> <!--<i class="zmdi zmdi-unfold-less">--></i>
    <span class="sr-only">Toggle Dropdown</span> <?php echo __('home_compare_details','Compare details'); ?>
  </a>

</div>
</section>
<script>
$(document).ready(function(){
    $('#compare').click(function(){
    $('.plans').toggleClass('autoH', 100000);
    });
});
</script>
<?php */ ?>
<!--<div class="clearfix"></div>
<section class="sec freeStart">
  <div class="container">
  <aside class="col-sm-6 col-xs-12" data-effect="slide-right">
      <h2>Free <span>started</span></h2>
      <hr class="thin-line" />
      <h4>Try the free trial starter pack, and enjoy all the advantages<br> of our service is absolutely free.</h4>
  </aside>
  <aside class="col-sm-6 col-xs-12 hidden-xs" data-effect="slide-left">
  	<a href="<?php // echo base_url('signup');?>" class="btn btn-lg btn-white">Get Started</a>
  </aside>
  </div>
</section>

<section class="sec freeStart visible-xs" style="background-color:#2c597a">
  <div class="container">
  <aside class="col-sm-6 col-xs-12">
  	<a href="<?php echo base_url('signup'); ?>" class="btn btn-lg btn-white">Get Started</a>
  </aside>
  </div>
</section>
-->
<div class="clearfix"></div>

<section class="sec ourTeam">
  <?php
  $this->load->model('findtalents/findtalents_model');
  $data['srch_param'] = array();
  $data['limit'] = 0;
  $data['offset'] = 4;
  $our_teams = $this->findtalents_model->list_freelancer($data['srch_param'], $data['limit'], $data['offset']);

  ?>
    <div class="container">
        <h2 class="title"><font color="heaven">Trusted Experts for Your Projects!</font></h2>

        <div class="row-10">
          <?php if (count($our_teams) > 0) {
            foreach ($our_teams as $k => $v) {
              $logo = '';
              if ($v['logo'] != '') {

                if (file_exists('assets/uploaded/cropped_' . $v['logo'])) {
                  $logo = 'uploaded/cropped_' . $v['logo'];
                } else {
                  $logo = 'uploaded/' . $v['logo'];
                }
              } else {
                $logo = 'images/user.png';
              }
              ?>
                <article class="col-md-3 col-sm-6 col-xs-6" data-effect="slide-left">
                    <div class="team">
                        <h4>
                            <a href="<?php echo base_url('clientdetails/showdetails/' . $v['user_id']); ?>"><?php echo $v['fname'] . ' ' . $v['lname']; ?></a>
                        </h4>
                        <div class="hexagon"><a
                                    href="<?php echo base_url('clientdetails/showdetails/' . $v['user_id']); ?>"><img
                                        src="<?php echo ASSETS . $logo; ?>" alt=""/></a></div>
                        <div class="uDetails">

                            <h5><?php echo $v['slogan']; ?></h5>
                            <div class="row text-center">
                                <div class="col-xs-6"><?php echo __('hourly_rate', 'Hourly Rate') ?><br/>
                                    <span class=""><b><?php echo CURRENCY; ?> <?php echo $v['hourly_rate']; ?>/<?php echo __('hr', 'hr') ?></b></span>
                                </div>
                                <div class="col-xs-6">
                                  <?php if (!empty($v['country'])) { ?>
                                    <?php echo __('location', 'Location') ?><br/>
                                    <?php
                                    $code = strtolower(getField('code2', 'country', 'Code', $v['country']));
                                    $country_name = getField('Name', 'country', 'Code', $v['country']);
                                    ?>
                                      <img src="<?php echo IMAGE; ?>cuntryflag/<?php echo $code; ?>.png" alt=""
                                           title="<?php echo $country_name; ?>" class="flag"/> <span class="f20"><b></b></span>
                                  <?php } ?>
                                </div>
                            </div>
                          <?php
                          $v['com_project'] = get_freelancer_project($v['user_id'], 'C');
                          $v['total_project'] = $this->findtalents_model->countTotalProject_professional($v['user_id']);
                          $success_prjct = (int)$v['com_project'] * 100 / (int)$v['total_project'];
                          $success_prjct = !empty($success_prjct) ? (int)$success_prjct : '0';
                          ?>
                            <h6><?php echo __('job_success', 'Job Success') ?> <span
                                        class="pull-right"><?= $success_prjct; ?>%</span></h6>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped active"
                                     role="progressbar" aria-valuenow="<?= $success_prjct; ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width: <?= $success_prjct; ?>%"></div>
                            </div>
                        </div>
                    </div>
                </article>
            <?php }
          } ?>


          <?php /* ?>
            <!-- Specialist Profiles -->
            <article class="col-md-3 col-sm-6 col-xs-12" data-effect="slide-left">
                <div class="team">
                    <!-- <div class="hexagon" style="background-image: url(<?php echo IMAGE;?>team1.png)">
                  <div class="hexTop"></div>
                  <div class="hexBottom"></div>
                </div> -->
                    <div class="hexagon">
                        <img src="<?php echo IMAGE;?>team1.png" alt="" />
                    </div>
                    <p>Kelly</p>
                    <h5>Web Designer</h5>
                    <p>Hourly Rate: $20/hr</p>
                    <p>Location: India</p>
                    <ul class="social-icons icon-circle icons-A hidden">
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                    </ul>
                </div>
            </article>

            <article class="col-md-3 col-sm-6 col-xs-12" data-effect="slide-left">
                <div class="team">

                    <div class="hexagon">
                        <img src="<?php echo IMAGE;?>team2.png" alt="" />
                    </div>
                    <p>Jonathan Doe</p>
                    <h5>Android Developer</h5>
                    <ul class="social-icons icon-circle icons-A hidden-xs" style="display:none">
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                    </ul>
                </div>
            </article>

            <article class="col-md-3 col-sm-6 col-xs-12" data-effect="slide-right">
                <div class="team">

                    <div class="hexagon">
                        <img src="<?php echo IMAGE;?>team3.png" alt="" />
                    </div>
                    <p>Elvira</p>
                    <h5>Web Designer</h5>
                    <ul class="social-icons icon-circle icons-A hidden-xs" style="display:none">
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                    </ul>
                </div>
            </article>

            <article class="col-md-3 col-sm-6 col-xs-12" data-effect="slide-right">
                <div class="team">
                    <div class="hexagon">
                        <a href="#"><img src="<?php echo IMAGE;?>team4.png" alt=""></a>
                    </div>

                    <p>Adam Smith</p>
                    <h5>Video Editor</h5>
                    <ul class="social-icons icon-circle icons-A hidden-xs" style="display:none">
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                        <li data-effect="helix"><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                    </ul>
                </div>
            </article>

            <?php */ ?>

        </div>
    </div>
</section>

<div class="clearfix"></div>

<?php if ($page_testimonial == 'Y') { ?>
    <!-- client testimonial section -->

    <section class="sec happyClient testimonials" data-effect="slide-bottom">
        <div class="container">
            <h2 class="title">Reviews and Ratings</h2>
            <!--    <h5 class="text-center" style="position:relative">-->
          <?php //echo __('home_find_out_that_people_say_about_us_text','Find out what people say about us and think hundreds of satisfied customers.'); ?><!--</h5>-->
            <div id="testimonial-carousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators hidden-xs">
                    <li data-target="#testimonial-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#testimonial-carousel" data-slide-to="1"></li>
                    <li data-target="#testimonial-carousel" data-slide-to="2"></li>
                    <!--        <li data-target="#testimonial-carousel" data-slide-to="3"></li>-->
                </ol>
                <div class="carousel-inner client" role="listbox">
                  <?php
                  if (count($testimonials) > 0) {
                    foreach ($testimonials as $k => $v) {
                      if ($k > 3) {
                        break;
                      }

                      $client = $this->db->select('fname , lname , logo')->where('user_id', $v['user_id'])->get('user')->row_array();
                      $client['logo'] = !empty($client['logo']) ? ASSETS . 'uploaded/' . $client['logo'] : ASSETS . 'images/user.png';


                      if (strpos($v['description'], "http") !== false) {
                        $rev_desc_arr = explode("<vid=", $v['description']);
                        $rev_desc_arr = explode(">", $rev_desc_arr[1]);

                        // var_dump($rev_desc_arr);
                      }

                      ?>
                        <div class="item <?php if ($k == 0) {
                          echo 'active';
                        } ?> ">
                            <div class="wrapper">
                                <div class="image-section">
                                  <?php if (strpos($v['description'], "http") !== false) { ?>
                                      <video controls onclick="this.paused ? this.play() : this.pause();">
                                          <source src="<?php echo $rev_desc_arr[0]; ?>" type="video/mp4">
                                      </video>
                                  <?php } else { ?>
                                      <img src="<?php echo $client['logo']; ?>" alt="Client image" class="img-circle">
                                  <?php } ?>

                                </div>
                                <div class="text-section">
                                    <p><?php echo $v['description']; ?></p>
                                    <h4 class="name"><?php echo $client['fname'] . ' ' . $client['lname']; ?></h4>
                                </div>
                            </div>

                            <!--          <div class="carousel-caption">-->
                            <!--            <p class="designation">-->
                          <?php //echo date('d M , Y' , strtotime($v['posted']));?><!--</p>-->
                            <!--          </div>-->
                        </div>
                    <?php }
                  } ?>
                </div>
            </div>
            <!-- Carousel nav -->
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>

            <script>
              $('.carousel-control.left').click(function () {
                $('#testimonial-carousel').carousel('prev');
              });

              $('.carousel-control.right').click(function () {
                $('#testimonial-carousel').carousel('next');
              });
            </script>

        </div>

        <div class="container">
            <div class="row news-block">
              <?php

              //var_dump($this->auto_model->getFeild('event_name', 'event'));
              //var_dump($this->event_model->getAllevent($id));

              $news = $this->db->from('event')->where(array('status' => 'Y'))->get()->result();

              foreach ($news as $item) {

                $str_replaced = str_replace("</p>", "", $item->event_desc);
                $desc_arr = explode('<p>', $str_replaced);
                $link = explode('"', $desc_arr[3]);

                if (count($desc_arr) < 3) {
                  continue;
                }
                //if(empty($link)){ continue; }

                echo "<div class='col-md-4 col-sm-4 col-xs-12'>";
                echo "<a href='$link[1]'>";
                echo "<div class='news-title'>$item->event_name</div>";
                echo "<div class='news-img'>$desc_arr[1]</div>";
                echo "<div class='news-desc'>$desc_arr[2]</div>";
                echo "<div class='news-link' style='display: none'>$desc_arr[3]</div>";
                echo "</a>";

                echo '</div>';
              }

              ?>

            </div>
        </div>


    </section>

    <!-- end of client testimonial section -->
<?php } ?>

<?php if ($page_partners == 'Y') { ?>

    <!-- partner section start -->
    <section class="partner" data-effect="slide-right">
        <h2 class="title">Our Partners</h2>
        <div class="container">
            <div id="testimonial-carousel" class="carousel slide" data-ride="carousel">
              <?php if (count($partner) > 0) {
                foreach ($partner as $k => $v) { ?>
                <article class="col-md-3 col-sm-6 col-xs-6" data-effect="slide-left">
                    <div class="partner-item">
                        <a target="_blank" href="<?php echo $v['url'] ?>">
                            <img src="<?php echo ASSETS . 'partner_image/' . $v['image'] ?>"
                                 alt="<?php echo $v['name'] ?>"></a>
                    </div>
                </article>
                <?php }
              } ?>

        </div>
    </section>

<?php } ?>

<!-- end of partner section -->

<div class="clearfix"></div>
<section class="sec experts hidden-xs" data-effect="slide-bottom" style="display:none">
    <div class="container">
        <div class="row">
            <article class="col-sm-5 col-xs-12">
                <div class="diamondSquare diamond-lg">
                    <h3>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci
                        velit..."</h3>
                </div>
            </article>
            <article class="col-sm-5 col-xs-12 pull-right">
                <div class="diamondSquare diamond-sm">
                    <h3>Mr. Josef<br>
                        <span>CEO</span></h3>
                </div>
            </article>
        </div>
    </div>
</section>
<section class="sec experts" data-effect="slide-bottom" style="display:none">
    <div class="container">
        <div class="row">
            <article class="col-sm-5 col-xs-12">
                <h3>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci
                    velit..."</h3>
            </article>
            <article class="col-sm-4 col-xs-12">
                <h3>Mr. Josef<br>
                    <span>CEO</span></h3>
            </article>
        </div>
    </div>
</section>
<section class="sec whiteBg browseCat hide">
    <div class="container">
        <h2 class="title"><?php echo __('home_browae_top_skills', 'Browse top skills'); ?></h2>
        <div class="row">
          <?php
          $count = 0;
          foreach ($catagories as $k => $val) {

            if ($count == 0) {
              $color = 'blue';
            }
            if ($count == 1) {
              $color = 'pink';
            }
            if ($count == 2) {
              $color = 'green';
            }
            if ($count == 3) {
              $color = 'yellow';
            }

            switch ($lang) {
              case 'arabic':
                $categoryName = !empty($val['arabic_cat_name']) ? $val['arabic_cat_name'] : $val['skill_name'];
                break;
              case 'spanish':
                //$categoryName = $val['spanish_cat_name'];
                $categoryName = !empty($val['spanish_cat_name']) ? $val['spanish_cat_name'] : $val['skill_name'];
                break;
              case 'swedish':
                //$categoryName = $val['swedish_cat_name'];

                $categoryName = !empty($val['swedish_cat_name']) ? $val['swedish_cat_name'] : $val['skill_name'];
                break;
              default :
                $categoryName = $val['skill_name'];
                break;
            }

            ?>
              <article class="col-sm-6 col-md-4 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0s"><a
                          href="<?php echo base_url('findjob/browse') . '/' . $this->auto_model->getcleanurl($val['skill_name']) . '/' . $val['id'] ?>">
                      <div class="box-color text-center <?php echo $color; ?>">
                          <div class="icon-large"><i class="<?php echo $val['icon_class']; ?>"></i></div>
                          <!--  <h4><?php // echo $val['skill_name'];
                          ?></h4> -->
                          <h4><?php echo $categoryName; ?></h4>
                          <p> <?php echo $count_project[$val['id']]; ?><?php echo __('home_projects', 'Projects'); ?></p>
                      </div>
                  </a></article>
            <?php
            $count = $count + 1;
            if ($count > 3) {
              $count = 0;
            }
          } ?>
        </div>
        <div class="center-block text-center"><a href="<?php echo base_url('findjob'); ?>"
                                                 class="btn btn-lg btn-border xs-block"><?php echo __('home_browae_all_skills', 'Browse All Skills'); ?></a><span
                    class="hidden-xs">&nbsp;&nbsp;</span> <a href="<?php echo base_url('signup'); ?>"
                                                             class="btn btn-lg btn-site xs-block"><?php echo __('home_get_started', 'Get Started'); ?></a>
        </div>
    </div>
</section>
<div class="clearfix"></div>

<!-- Specialist Profiles END-->

<!-- fantastic facts section start -->
<?php
$page_counting = $this->auto_model->getFeild('counting', 'pagesetup', 'id', '1');
if ($page_counting == 'Y') {
  $user = $this->auto_model->getFeild('no_of_users', 'setting', 'id', 1);
  $project = $this->auto_model->getFeild('no_of_projects', 'setting', 'id', 1);
  $complete_project = $this->auto_model->getFeild('no_of_completed_prolects', 'setting', 'id', 1);
  ?>
    <section class="sec edesk-facts" data-effect="slide-left">
        <h2 class="title">Stats & Facts about efluencer</h2>

        <div class="clearfix">

            <div class="clearfix">
                <article class="col-sm-1"></article>
                <article class="col-sm-2 col-xs-6">
                    <div class="facts">
                        <h3>24/7/365</h3>
                        <h4>Live Chat</h4>
                </article>
                <article class="col-sm-2 col-xs-6">
                    <div class="facts">
                        <h3><?php echo $user; ?></h3>
                        <h4><?php echo __('home_total_user', 'Total user'); ?></h4>
                </article>
                <article class="col-sm-2 col-xs-6">
                    <div class="facts">
                        <h3>242</h3>
                        <h4>Open Projects</h4>
                      <?php
                      $open_projects = $this->db->where(array('status' => 'O'))->count_all_results('projects');
                      echo "<div id='open_project' style='display:none'>$open_projects</div>";
                      ?>
                </article>
                <article class="col-sm-2 col-xs-6">
                    <div class="facts">
                        <h3><?php echo $complete_project; ?></h3>
                        <h4>Completed Projects</h4>
                        <!-- <img src="<?php echo IMAGE; ?>suitcase.png" alt=""> </div> -->
                </article>
                <article class="col-sm-2 col-xs-12">
                    <div class="facts">
                        <h3><?php echo $project; ?></h3>
                        <h4>Total Projects</h4>
                </article>
                <article class="col-sm-1"></article>
            </div>

        </div>
    </section>
<?php } ?>
<!-- fantastic facts section end -->

<!-- social section start -->
<!--
<section class="triangle-icon">
  <ul class="social-icons diamondShape-icon">
    <?php
$popular = $this->auto_model->getalldata('', 'popular', 'id', '1');
if (!empty($popular)) {
  foreach ($popular as $vals) { ?>
    <?php if ($vals->facebook == 'Y' && ADMIN_FACEBOOK != '') { ?>
    <li data-effect="helix"><a href="<?php echo ADMIN_FACEBOOK; ?>" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
    <?php } ?>
    <?php if ($vals->twitter == 'Y' && ADMIN_TWITTER != '') { ?>
    <li data-effect="helix"><a href="<?php echo ADMIN_TWITTER; ?>" target="_blank"><i class="zmdi zmdi-twitter"></i></a></li>
    <?php } ?>
    <?php if ($vals->linkedin == 'Y' && ADMIN_LINKEDIN != '') { ?>
    <li data-effect="helix"><a href="<?php echo ADMIN_LINKEDIN; ?>" target="_blank"><i class="zmdi zmdi-linkedin"></i></a></li>
    <?php } ?>
    <?php }
} ?>
  </ul>
</section>
-->
<!-- social section end -->

<script>
  $(function () {
    $('body').addClass('home');
  });
</script>
