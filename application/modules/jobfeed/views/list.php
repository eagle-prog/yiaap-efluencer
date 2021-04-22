<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53a028a2284897c6"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
//$total=count($projects);
if (isset($category)) {
  $cat = $category = str_replace('%20', ' ', $category);
  $cate = explode("-", $category);
  $parentc = array();
  foreach ($cate as $rw) {
    $pcat = $this->auto_model->getFeild('parent_id', 'categories', 'cat_name', $rw);
    $parentc[] = $pcat;
  }
} else {
  $parentc = array();
  $cat = 'All';
}
if (isset($project_type)) {
  $ptype = $project_type;
} else {
  $ptype = 'All';
}
if (isset($min_budget)) {
  $minb = $min_budget;
} else {
  $minb = '0';
}
if (isset($max_budget)) {
  $maxb = $max_budget;
} else {
  $maxb = '0';
}
if (isset($posted)) {
  $post_with = $posted;
} else {
  $post_with = 'All';
}
if (isset($country)) {
  $coun = $country;
} else {
  $coun = 'All';
}
if (isset($city)) {
  $ct = $city;
} else {
  $ct = 'All';
}
if (isset($featured)) {
  $featured = $featured;
} else {
  $featured = 'All';
}
if (isset($environment)) {
  $environment = $environment;
} else {
  $environment = 'All';
}
if (isset($uid)) {
  $uid = $uid;
} else {
  $uid = '0';
}
$user = $this->session->userdata('user');

?>
<!-- Content Start -->

<?php if ($user) {
  if ($user[0]->account_type == 'employee'):?>
      <!-- Content Start -->
      <!--<div class="h_bar">
<div class="container">

<div class="oNavTabpanel oNavInline">
<nav class="oPageCentered" role="navigation">
<ul class="oSecondaryNavList">

<li class="isCurrent">
<a class="oNavLink isCurrent" href="<?php echo VPATH; ?>dashboard/myproject_client">My Job</a>
</li>

<li class="isCurrent">
<a class="oNavLink isCurrent" href="<?php echo VPATH; ?>dashboard/myproject_client">Contracts</a>
</li>
<li class="isCurrent">
<a class="oNavLink isCurrent" href="<?php echo VPATH; ?>postjob">Post a Job</a>
</li>

</ul>
</nav>
</div>
</div>
</div>-->
  <?php endif;
  if ($user[0]->account_type == 'freelancer') : ?>
      <!--<div class="h_bar">
<div class="container">

<div class="oNavTabpanel oNavInline">
<nav class="oPageCentered" role="navigation">
<ul class="oSecondaryNavList">
<li class="isCurrent">
<a class="oNavLink isCurrent" href="<?php echo VPATH; ?>findjob">Find Jobs</a>
</li>
<li class="isCurrent">
<a class="oNavLink isCurrent" style="cursor: pointer;">Saved Jobs</a>
</li>
<li class="isCurrent">
<a class="oNavLink isCurrent" style="cursor: pointer;">Proposals</a>
</li>
<li class="isCurrent">
<a class="oNavLink isCurrent" href="<?php echo VPATH; ?>dashboard">Profile</a>
</li>
<li class="isCurrent">
<a class="oNavLink isCurrent" style="cursor: pointer;">My Stats</a>
</li>

<li class="isCurrent">
<a class="oNavLink isCurrent" style="cursor: pointer;">Tests</a>
</li>
</ul>
</nav>
</div>
</div>
</div>-->
  <?php endif;
} ?>
<!-- Title, Breadcrumb Start-->
<?php echo $breadcrumb; ?>

<script src="<?= JS ?>mycustom.js"></script>
<section id="autogenerate-breadcrumb-id-joobfeed" class="breadcrumb-classic">
    <div class="container">
        <div class="row">
            <aside class="col-sm-6 col-xs-12">
                <h3>Freelancer Dashboard</h3>
            </aside>
            <aside class="col-sm-6 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a href="<?php echo base_url('dashboard/profile_professional'); ?>">Profile</a></li>
                    <li class="active">Freelancer Dashboard</li>
                </ol>
            </aside>
        </div>
    </div>
</section>
<?php
$this->load->model('dashboard/dashboard_model');
$curr_user = $this->session->userdata('user');
$rate = $this->auto_model->getFeild('hourly_rate', 'user', 'user_id', $curr_user[0]->user_id);
$ldate = $user[0]->ldate;
$rating = $this->dashboard_model->getrating($user[0]->user_id);
$country = $this->auto_model->getFeild('country', 'user', 'user_id', $user[0]->user_id);
$city = $this->auto_model->getFeild('city', 'user', 'user_id', $user[0]->user_id);
$fname = $this->auto_model->getFeild('fname', 'user', 'user_id', $user[0]->user_id);
$lname = $this->auto_model->getFeild('lname', 'user', 'user_id', $user[0]->user_id);
?>
<?php
$this->load->model('clientdetails/clientdetails_model');
$flag = $this->auto_model->getFeild("code2", "country", "Code", $country);
$flag = strtolower($flag) . ".png";
if (is_numeric($city)) {
  $city = getField('Name', 'city', 'ID', $city);
}
$c = getField('Name', 'country', 'Code', $country);
?>
<div class="clearfix"></div>
<section class="sec">
    <div class="container">
        <div class="row">
            <aside class="col-md-3 col-sm-12 col-xs-12">
                <h4 class="title-sm">My Professional Profile</h4>
                <div class="left_sidebar">
                    <div class="c_details">
                        <div class="profile">
                            <div class="profile_pic">
<span>
    <a href="<?= VPATH ?>jobfeed/"><img src="<?= VPATH ?>assets/<?= $logo ?>" class="img-circle"></a>
    <a href="<?php echo base_url('dashboard/editprofile_professional'); ?>" class="edit"><i class="fa fa-pencil"></i> Edit</a>
</span>
                            </div>
                        </div>
                        <div class="profile-details">
                            <h4><?php echo $fname . ' ' . $lname; ?></h4>
                            <p><?php echo !(empty($available_hr)) ? number_format($available_hr) : 'N/A'; ?></p>
                            <p>hrs/week <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal"><i
                                            class="fa fa-pencil"></i></a></p>

                            <h4>

                              <?php
                              if ($rating[0]['num'] > 0) {
                                $avg_rating = $rating[0]['avg'] / $rating[0]['num'];
                                for ($i = 0; $i < $avg_rating; $i++) {
                                  ?>
                                    <i class="zmdi zmdi-star"></i>
                                  <?php
                                }
                                for ($i = 0; $i < (5 - $avg_rating); $i++) {
                                  ?>
                                    <i class="zmdi zmdi-star-outline"></i>
                                  <?
                                }
                              } else {
                                ?>

                                  <i class="zmdi zmdi-star-outline"></i>
                                  <i class="zmdi zmdi-star-outline"></i>
                                  <i class="zmdi zmdi-star-outline"></i>
                                  <i class="zmdi zmdi-star-outline"></i>
                                  <i class="zmdi zmdi-star-outline"></i>
                                <?php
                              }
                              ?>
                            </h4>
                            <div class="progress profile_progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo round($completeness); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width: <?php echo round($completeness); ?>%">
                                  <?php echo round($completeness); ?> %
                                </div>
                            </div>
                            <ul class="profile-list">
                                <li><img src="<?php echo VPATH; ?>assets/images/cuntryflag/<?php echo $flag; ?>"
                                         alt=""/> &nbsp;<span><?php echo $city; ?>,</span> <?php echo $c; ?></li>
                                <li><i class="zmdi zmdi-time"></i> Hourly
                                    Rate: <?php echo CURRENCY; ?><?php echo $rate; ?></li>
                                <li><i class="zmdi zmdi-sign-in"></i> Last logged
                                    on: <?php echo date('d M,Y', strtotime($ldate)); ?></li>
                                <!--<li><a href="<? //=VPATH?>dashboard/tracker/" target="_blank"><i class="zmdi zmdi-time"></i> Track time with the desktop app</a></li>-->
                                <li><a href="<?= VPATH ?>findjob/"><i class="zmdi zmdi-search"></i> Browse jobs</a></li>
                                <li><a href="<?php echo base_url('favourite'); ?>"><i class="zmdi zmdi-favorite"></i>
                                        Favourite Projects</a></li>
                                <li><a href="<?php echo base_url('dashboard/profile_professional'); ?>"><i
                                                class="zmdi zmdi-account"></i> View my profile</a></li>
                                <li><i class="zmdi zmdi-money"></i> Amount
                                    Earned: <?php echo CURRENCY; ?> <?php echo $this->clientdetails_model->get_total_earning($curr_user[0]->user_id); ?>
                                </li>
                                <li><i class="zmdi zmdi-money"></i>
                                    Over <?php echo CURRENCY; ?> <?php echo $this->clientdetails_model->get_total_expenditure($curr_user[0]->user_id); ?>
                                    Total Spent
                                </li>
                                <!--<li><a href="#"><i class="fa fa-handshake-o"></i> Hiring Headquarters</a></li>
                                <li><span>20 Hire, 6 Active</span></li>
                                <li>$10.50/hr Avg Hourly Rate Paid</li>
                                <li>100 Hours</li>-->
                            </ul>
                        </div>
                    </div>

                    <ul class="cat">
                        <li><a href="#" class="list-group-item active">My Job Feed</a></li>
                        <li style="display:none;"><a href="#" class="list-group-item">Recommended</a></li>
                    </ul>
                    <h4 class="title-sm">My Skills</h4>
                    <ul class="list-group">
                      <?php
                      $this->load->model('dashboard/dashboard_model');
                      $user_skill = $this->dashboard_model->getUserSkills($user_id);
                      if (count($user_skill)) {
                        foreach ($user_skill as $k => $v) {
                          ?>
                            <li>
                                <a href="<?php echo base_url('findtalents/browse') . '/' . $this->auto_model->getcleanurl($v['parent_skill_name']) . '/' . $v['parent_skill_id'] . '/' . $this->auto_model->getcleanurl($v['skill']) . '/' . $v['skill_id']; ?>">
                                  <?php echo $v['skill']; ?>
                                </a></li>
                          <?php

                        }
                      } else {
                        ?>
                          <li><a href="#">Skill Not Set Yet</a></li>
                        <?php
                      }
                      ?>
                      <?php
                      /*$skill_list=$this->auto_model->getFeild("skills_id","user_skills","user_id",$user_id);
                      if($skill_list!=""){
                        $skill_list=  explode(",",$skill_list);

                        foreach($skill_list as $key => $s){
                            $lnk=$this->auto_model->getFeild("skill_name","skills","id",$s);

                    ?>
                    <li><a href='<?php echo VPATH;?>jobfeed/filterjob/<?php echo str_replace('&','_',$lnk);?>/<?php echo $ptype."/".$minb."/".$maxb."/".$post_with."/".$coun."/".$ct."/".$featured."/".$environment."/".$uid."/";?>'><?php echo $lnk;?></a></li>
                    <?php }
                    } */ ?>

                    </ul>
                </div>
            </aside>


            <aside class="col-md-9 col-sm-12 col-xs-12">
                <h4 class="title-sm">My Job Feed</h4>
                <div class="searchbox">
                    <form>
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" id="srch" onkeyup="catdtls(this.id);"
                                   placeholder="Enter Job Name to Search">
                            <span class="input-group-addon" id="basic-addon1"><button type="submit"
                                                                                      class="btn btn-site"><i
                                            class="zmdi zmdi-search"></i> Search</button></span>
                        </div>
                    </form>

                </div>

                <div class="listing">
                    <div id="prjct">
                      <?php if (count($projects) > 0) {
                        foreach ($projects as $key => $val) {
                          $skill = explode(",", $val['skills']);
                          ?>
                            <div class="media">
                                <div class="media-body">
                                    <p class="designation"><a
                                                href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl($val['title']); ?>/"> <?php echo ucwords($val['title']); ?></a>
                                      <?php if (in_array($val['project_id'], $favourite_project)) { ?><a
                                              href="javascript:void(0);" class="pull-right"><img
                                                  src="<?php echo IMAGE; ?>favourite-icon.png" alt=""/></a><?php } ?>
                                    </p>

                                    <p class="bio"><?php if ($val['project_type'] == 'F') {
                                        echo "Fixed";
                                      } else {
                                        echo "Hourly";
                                      } ?>- Price: Entry
                                        Level <?php echo '(' . CURRENCY . ') '; ?> <?php echo $val['buget_min']; ?> Est.
                                        Budget : <?php echo '(' . CURRENCY . ') '; ?><?php echo $val['buget_max']; ?>-
                                        Posted <?php echo date('M d, Y', strtotime($val['post_date'])); ?></p>

                                  <?php
                                  //////////////////////For Email/////////////////////////////
                                  $pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
                                  $replacement = "[*****]";
                                  $val['description'] = preg_replace($pattern, $replacement, $val['description']);
                                  /////////////////////Email End//////////////////////////////////

                                  //////////////////////////For URL//////////////////////////////
                                  $pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
                                  $replacement = "[*****]";
                                  $val['description'] = preg_replace($pattern, $replacement, $val['description']);
                                  /////////////////////////URL End///////////////////////////////

                                  /////////////////////////For Bad Words////////////////////////////
                                  $healthy = explode(",", BAD_WORDS);
                                  $yummy = array("[*****]");
                                  $val['description'] = str_replace($healthy, $yummy, $val['description']);
                                  /////////////////////////Bad Words End////////////////////////////

                                  /////////////////////////// For Mobile///////////////////////////////

                                  $pattern = "/(?:1-?)?(?:\(\d{3}\)|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}/x";
                                  $replacement = "[*****]";
                                  $val['description'] = preg_replace($pattern, $replacement, $val['description']);

                                  ////////////////////////// Mobile End////////////////////////////////
                                  ?>


                                    <p><?php echo substr($val['description'], 0, 250); ?><a
                                                href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl($val['title']); ?>/">more</a>
                                    </p>
                                </div>
                                <ul class="skills">
                                    <li>Skills:</li>
                                  <?php foreach ($skill as $v) { ?>
                                      <li><a href="#"><?php echo $v; ?></a></li>
                                  <?php } ?>

                                </ul>
                            </div>
                        <?php }
                      } else { ?>
                          <p>No Projects Found.</p>
                      <?php } ?>
                    </div>


                    <div class="media" style="display:none;">
                        <div class="media-body">
                            <p class="designation"><a href="#">OpenCart Template developer needed</a></p>
                            <p class="bio">Looking for experienced OpenCart 2 Template developer to modify purchased
                                commercial template to our needs. We have an OpenCart 2 websites, commercial templates
                                and we need someone who will be able to adapt in a timely manner template's HTML/CSS/PHP
                                code to our needs ... <a href="#">more</a></p>
                        </div>
                        <ul class="skills">
                            <li>Skills:</li>
                            <li><a href="#">Web Design</a></li>
                            <li><a href="#">Adobe Photoshop</a></li>
                            <li><a href="#">Bootstrap</a></li>
                            <li><a href="#">HTML5</a></li>
                            <li><a href="#">CSS3</a></li>
                        </ul>
                    </div>

                </div>


              <?php if ($user = $this->session->userdata('user')) { ?>

                  <!--ProfileRight Start-->
                  <div class="profile_right">

                      <div class="client_pro" style="width:100%">

                          <div id="prjct">
                              <div class="editprofile" style="display:none;">
                                  <div class="col-xs-12">
                                      <!--<div class="subdcribe-bar"></div>-->
                                    <?php /*?><ul class="subdcribe-bar-left"><li> (<?php echo $total;?> Results)</li><li class="rss margtop"><a title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="Rss" href="<?php echo VPATH;?>rssfeed/index/<?php echo str_replace('&','_',$cat);?>/<?php echo $ptype."/".$minb."/".$maxb."/".$post_with."/".$coun."/".$ct."/".$featured."/".$environment."/".$uid."/";?>" target="_blank"><img src="<?php echo ASSETS;?>images/rss_icon.png"></a></li></ul><?php */ ?>

                                  </div>

                                <?php
                                if ($total > 0) {
                                  foreach ($projects as $key => $val) {
                                    $skill = explode(",", $val['skills']);
                                    ?>
                                      <div class="search-job-content">
                                        <?php
                                        if ($val['featured'] == 'Y') {
                                          ?>
                                            <div class="featuredimg"><img
                                                        src="<?php echo VPATH; ?>assets/images/featured_vr.png" alt=""
                                                        title="Featured"></div>
                                        <?php } ?>
                                          <div class="asd">
                                              <a href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl($val['title']); ?>/">
                                                  <h4 style="float:left"> <?php echo ucwords($val['title']); ?> <br>
                                                  </h4></a>
                                            <?php
                                            if ($val['visibility_mode'] == 'Private') {
                                              ?>
                                                <input type="button" value="Private: bidding by invitation only"
                                                       class="logbtn2" name="tt"
                                                       style="float:right;margin-right: 50%;margin-top: -4%;">
                                              <?php
                                            }
                                            ?>
                                          </div>
                                          <div class="addthis_sharing_toolbox"
                                               data-url="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>"
                                               style="float: right;margin-top: 8px;"></div>

                                          <ul style="float:left" class="search-job-content-minili">
                                              <li><?php if ($val['project_type'] == 'F') {
                                                  echo "Fixed";
                                                } else {
                                                  echo "Hourly";
                                                } ?> Price:
                                                  <b>Between <?php echo CURRENCY; ?> <?php echo $val['buget_min']; ?>
                                                      and <?php echo CURRENCY; ?> <?php echo $val['buget_max']; ?> </b>
                                              </li>
                                              <li> Posted:
                                                  <b><?php echo date('M d, Y', strtotime($val['post_date'])); ?></b>
                                              </li>
                                              <li> Ends: <b>
                                                      &nbsp;<?php echo floor((strtotime($val['expiry_date']) - strtotime(date('Y-m-d'))) / (60 * 60 * 24)); ?>
                                                      &nbsp;days&nbsp;Left&nbsp;</b></li>
                                            <?php
                                            $totalbid = $this->jobdetails_model->gettotalbid($val['project_id']);
                                            ?>
                                              <li class="bor-right"><b><?php echo $totalbid; ?></b> Proposals</li>
                                          </ul>
                                        <?php
                                        //////////////////////For Email/////////////////////////////
                                        $pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
                                        $replacement = "[*****]";
                                        $val['description'] = preg_replace($pattern, $replacement, $val['description']);
                                        /////////////////////Email End//////////////////////////////////

                                        //////////////////////////For URL//////////////////////////////
                                        $pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
                                        $replacement = "[*****]";
                                        $val['description'] = preg_replace($pattern, $replacement, $val['description']);
                                        /////////////////////////URL End///////////////////////////////

                                        /////////////////////////For Bad Words////////////////////////////
                                        $healthy = explode(",", BAD_WORDS);
                                        $yummy = array("[*****]");
                                        $val['description'] = str_replace($healthy, $yummy, $val['description']);
                                        /////////////////////////Bad Words End////////////////////////////

                                        /////////////////////////// For Mobile///////////////////////////////

                                        $pattern = "/(?:1-?)?(?:\(\d{3}\)|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}/x";
                                        $replacement = "[*****]";
                                        $val['description'] = preg_replace($pattern, $replacement, $val['description']);

                                        ////////////////////////// Mobile End////////////////////////////////
                                        ?>
                                          <div class="jobtext">
                                              <p><?php echo substr($val['description'], 0, 250); ?> ...</p>
                                          </div>
                                          <ul class="skills">
                                              <li><b>Skills:</b></li>
                                            <?php
                                            foreach ($skill as $v) {
                                              ?>
                                                <li><a href="#"><?php echo $v; ?></a></li>
                                            <?php } ?>
                                              </p>
                                          </ul>
                                        <?php
                                        if ($cat != 'All') {
                                          if (in_array($val['category'], $cate)) {
                                            $lnki = $category;
                                          } else {
                                            $lnki = $category . "-" . $val['category'];
                                          }
                                        } else {
                                          $lnki = $val['category'];
                                        }
                                        ?>
                                          <ul class="skills">
                                              <li><b>Category:</b></li>
                                              <li>
                                                  <a href="<?php echo VPATH; ?>jobfeed/filterjob/<?php echo str_replace('&', '_', $lnki); ?>/<?php echo $ptype . "/" . $minb . "/" . $maxb . "/" . $post_with . "/" . $coun . "/" . $ct . "/" . $featured . "/" . $environment . "/" . $uid . "/"; ?>"><?php echo $val['category']; ?></a>
                                              </li>
                                          </ul>
                                          <p>

                                              Posted by: <a style=" color: #205691;text-decoration: none;
"
                                                            href="<?php echo VPATH; ?>employerdetails/showdetails/<?php echo $val['user_id']; ?>"><?php echo $val['user']->fname; ?></a>,<?php if ($val['user_city'] != "") {
                                              echo "&nbsp;&nbsp;" . $val['user_city'] . ", ";
                                            } ?>&nbsp;&nbsp;<?php echo $val['user_country']; ?> &nbsp;&nbsp;
                                            <?php
                                            $code = strtolower($this->auto_model->getFeild('code2', 'country', 'Name', $val['user_country']));
                                            ?>
                                              <img src="<?php echo VPATH; ?>assets/images/cuntryflag/<?php echo $code; ?>.png">
                                              &nbsp;&nbsp;
                                            <?php
                                            if ($val['project_type'] == 'F') {
                                              ?>
                                                <img src="<?php echo VPATH; ?>assets/images/fixed.png">
                                              <?php
                                            } else {
                                              ?>
                                                <img src="<?php echo VPATH; ?>assets/images/hourly.png">
                                              <?php
                                            }
                                            ?>
                                            <?php
                                            if ($val['environment'] == 'ON') {
                                              ?>
                                                <img src="<?php echo VPATH; ?>assets/images/onlineicon.png">
                                              <?php
                                            } else {
                                              ?>
                                                <img src="<?php echo VPATH; ?>assets/images/offlineicon.png">
                                              <?php
                                            }
                                            ?>

                                          </p>
                                          <!--<a style="float: right;" href="javascript:void(0)" data-reveal-id="exampleModal" onclick="setaction(<?php echo $val['project_id']; ?>)">
         <input type="button" value="Invite Friends to Bid" class="logbtn2" name="invite" ></a>-->
                                        <?php
                                        if ($this->session->userdata('user')) {
                                          ?>
                                            <a href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl($val['title']); ?>/"
                                               class="logbtn2">Select this job</a>
                                          <?php
                                        } else {
                                          ?>
                                            <a href="<?php echo VPATH; ?>login?refer=jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl($val['title']); ?>/"
                                               class="logbtn2">Select this job</a>
                                          <?php
                                        }
                                        ?>
                                      </div>
                                    <?php
                                  }
                                } else {
                                  echo "<p>No jobs found</p>";
                                }
                                ?>

                                  <!--Tab1 End-->


                              </div>

                          </div>
                          <!--ActiveProject End-->
                      </div>
                      <div class="side_bar_right">
                        <?php
                        /*if($this->session->userdata('user')){ if($user[0]->account_type == 'freelancer') { ?>
                        <?php echo $leftpanel;?>

                        <?php } else { ?>
                        <style>.client_pro{width:100%;}</style>
                        <?php
                        } } */ ?>
                      </div>

                  </div>


                  <!--ProfileRight Start-->
                  <div class="pagination" id="pagi">

                    <?php
                    if (isset($links)) {
                      echo $links;
                    }
                    ?>
                  </div>


              <?php } else { ?>
                  <!--ProfileRight Start-->
                  <div class="profile_right">


                      <!-- /input-group -->
                      <!--<div class="topcontrol_box">
                      <div class="topcbott"></div>
                      <input type="text" class="topcontrol" id="srch" onkeyup="catdtls(this.id);" placeholder="Enter Job Name to Search"></div>-->
                      <div class="input-group">
                          <!--<input type="text" class="form-control" id="srch" onkeyup="catdtls(this.id);" placeholder="Enter Job name, Job description to search">-->
                          <div class="input-group-btn">
                              <!--<button type="button" class="btn btn-default" disabled="disabled">Search</button>-->
                              <!--<ul class="dropdown-menu pull-right">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li class="divider"></li>
                              <li><a href="#">Separated link</a></li>
                              </ul>-->
                          </div>
                          <!-- /btn-group -->
                      </div>
                      <!-- /input-group -->
                      <br>
                      <!--ActiveProject Start-->
                      <div id="prjct">
                          <div class="editprofile" style=" border:#F00 0px solid;">
                              <div class="subdcribe-bar">
                                  <ul class="subdcribe-bar-left">
                                      <li>All Jobs (<?php echo $total; ?> Results)</li>
                                      <li class="rss margtop"><a title="" data-toggle="tooltip" style="cursor: pointer;"
                                                                 data-original-title="Rss"
                                                                 href="<?php echo VPATH; ?>rssfeed/index/<?php echo str_replace('&', '_', $cat); ?>/<?php echo $ptype . "/" . $minb . "/" . $maxb . "/" . $post_with . "/" . $coun . "/" . $ct . "/" . $featured . "/" . $environment . "/" . $uid . "/"; ?>"
                                                                 target="_blank"><img
                                                      src="<?php echo ASSETS; ?>images/rss_icon.png"></a></li>
                                  </ul>
                                  <div class="subdcribe-bar-right"></div>
                                  <div class="clr"></div>
                              </div>


                              <!--Tab1 Start-->

                            <?php
                            if ($total > 0) {
                              foreach ($projects as $key => $val) {
                                $skill = explode(",", $val['skills']);
                                ?>
                                  <div class="search-job-content clearfix">
                                    <?php
                                    if ($val['featured'] == 'Y') {
                                      ?>
                                        <div class="featuredimg"><img
                                                    src="<?php echo VPATH; ?>assets/images/featured_vr.png" alt=""
                                                    title="Featured"></div>
                                    <?php } ?>
                                      <div class="asd">
                                          <a href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl($val['title']); ?>/">
                                              <h4 style="float:left"> <?php echo ucwords($val['title']); ?> <br></h4>
                                          </a>
                                        <?php
                                        if ($val['visibility_mode'] == 'Private') {
                                          ?>
                                            <input type="button" value="Private: bidding by invitation only"
                                                   class="logbtn2" name="tt"
                                                   style="float:right;margin-right: 50%;margin-top: -4%;">
                                          <?php
                                        }
                                        ?>
                                      </div>
                                      <div class="addthis_sharing_toolbox"
                                           data-url="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>"
                                           style="float: right;margin-top: 8px;"></div>

                                      <ul style="float:left" class="search-job-content-minili">
                                          <li><?php if ($val['project_type'] == 'F') {
                                              echo "Fixed";
                                            } else {
                                              echo "Hourly";
                                            } ?> Price:
                                              <b>Between <?php echo CURRENCY; ?> <?php echo $val['buget_min']; ?>
                                                  and <?php echo CURRENCY; ?> <?php echo $val['buget_max']; ?> </b></li>
                                          <li> Posted:
                                              <b><?php echo date('M d, Y', strtotime($val['post_date'])); ?></b></li>
                                          <li> Ends: <b>
                                                  &nbsp;<?php echo floor((strtotime($val['expiry_date']) - strtotime(date('Y-m-d'))) / (60 * 60 * 24)); ?>
                                                  &nbsp;days&nbsp;Left&nbsp;</b></li>
                                        <?php
                                        $totalbid = $this->jobdetails_model->gettotalbid($val['project_id']);
                                        ?>
                                          <li class="bor-right"><b><?php echo $totalbid; ?></b> Proposals</li>
                                      </ul>
                                    <?php
                                    //////////////////////For Email/////////////////////////////
                                    $pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
                                    $replacement = "[*****]";
                                    $val['description'] = preg_replace($pattern, $replacement, $val['description']);
                                    /////////////////////Email End//////////////////////////////////

                                    //////////////////////////For URL//////////////////////////////
                                    $pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
                                    $replacement = "[*****]";
                                    $val['description'] = preg_replace($pattern, $replacement, $val['description']);
                                    /////////////////////////URL End///////////////////////////////

                                    /////////////////////////For Bad Words////////////////////////////
                                    $healthy = explode(",", BAD_WORDS);
                                    $yummy = array("[*****]");
                                    $val['description'] = str_replace($healthy, $yummy, $val['description']);
                                    /////////////////////////Bad Words End////////////////////////////

                                    /////////////////////////// For Mobile///////////////////////////////

                                    $pattern = "/(?:1-?)?(?:\(\d{3}\)|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}/x";
                                    $replacement = "[*****]";
                                    $val['description'] = preg_replace($pattern, $replacement, $val['description']);

                                    ////////////////////////// Mobile End////////////////////////////////
                                    ?>
                                      <div class="jobtext">
                                          <p><?php echo substr($val['description'], 0, 250); ?> ...</p>
                                      </div>
                                      <ul class="skills">
                                          <li><b>Skills:</b></li>
                                        <?php
                                        foreach ($skill as $v) {
                                          ?>
                                            <li><a href="#"><?php echo $v; ?></a></li>
                                        <?php } ?>
                                      </ul>
                                      <p>
                                        <?php
                                        if ($cat != 'All') {
                                          if (in_array($val['category'], $cate)) {
                                            $lnki = $category;
                                          } else {
                                            $lnki = $category . "-" . $val['category'];
                                          }
                                        } else {
                                          $lnki = $val['category'];
                                        }
                                        ?>
                                      <ul class="skills">
                                          <li><b>Category:</b></li>
                                          <li>
                                              <a href="<?php echo VPATH; ?>jobfeed/filterjob/<?php echo str_replace('&', '_', $lnki); ?>/<?php echo $ptype . "/" . $minb . "/" . $maxb . "/" . $post_with . "/" . $coun . "/" . $ct . "/" . $featured . "/" . $environment . "/" . $uid . "/"; ?>"><?php echo $val['category']; ?></a>
                                          </li>
                                      </ul>
                                      <p>

                                          Posted by: <a style=" color: #205691;text-decoration: none;
"
                                                        href="<?php echo VPATH; ?>employerdetails/showdetails/<?php echo $val['user_id']; ?>"><?php echo $val['user']->fname; ?></a>,<?php if ($val['user_city'] != "") {
                                          echo "&nbsp;&nbsp;" . $val['user_city'] . ", ";
                                        } ?>&nbsp;&nbsp;<?php echo $val['user_country']; ?> &nbsp;&nbsp;
                                        <?php
                                        $code = strtolower($this->auto_model->getFeild('code2', 'country', 'Name', $val['user_country']));
                                        ?>
                                          <img src="<?php echo VPATH; ?>assets/images/cuntryflag/<?php echo $code; ?>.png">
                                          &nbsp;&nbsp;
                                        <?php
                                        if ($val['project_type'] == 'F') {
                                          ?>
                                            <img src="<?php echo VPATH; ?>assets/images/fixed.png">
                                          <?php
                                        } else {
                                          ?>
                                            <img src="<?php echo VPATH; ?>assets/images/hourly.png">
                                          <?php
                                        }
                                        ?>
                                        <?php
                                        if ($val['environment'] == 'ON') {
                                          ?>
                                            <img src="<?php echo VPATH; ?>assets/images/onlineicon.png">
                                          <?php
                                        } else {
                                          ?>
                                            <img src="<?php echo VPATH; ?>assets/images/offlineicon.png">
                                          <?php
                                        }
                                        ?>

                                      </p>
                                      <!--<a style="float: right;" href="javascript:void(0)" data-reveal-id="exampleModal" onclick="setaction(<?php echo $val['project_id']; ?>)">
         <input type="button" value="Invite Friends to Bid" class="logbtn2" name="invite" ></a>-->
                                    <?php
                                    if ($this->session->userdata('user')) {
                                      ?>
                                        <a href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl($val['title']); ?>/"
                                           class="logbtn2">Select this job</a>
                                      <?php
                                    } else {
                                      ?>
                                        <a href="<?php echo VPATH; ?>login?refer=jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl($val['title']); ?>/"
                                           class="logbtn2">Select this job</a>
                                      <?php
                                    }
                                    ?>
                                  </div>
                                <?php
                              }
                            } else {
                              echo "<p>No jobs found</p>";
                            }
                            ?>

                              <!--Tab1 End-->


                          </div>

                      </div>
                      <!--ActiveProject End-->


                  </div>
                  <!--ProfileRight Start-->
                  <div class="pagination" id="pagi">

                    <?php
                    if (isset($links)) {
                      echo $links;
                    }
                    ?>
                  </div>


              <?php } ?>
            </aside>
        </div>
    </div>
</section>

<div class="clearfix"></div>
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
          <a href="<?php echo $url; ?>" target="_blank"><img src="<?= ASSETS ?>ad_image/<?php echo $image; ?>" alt=""
                                                             title=""/></a>
      </div>
    <?php
  }
}

?>
<div class="clearfix"></div>

<!-- Main Content end-->
<div id="exampleModal" class="reveal-modal" style="width:70%;margin-left: -35%;">
    <h3> Invite Friends To this Project</h3>
    <div class="editprofile" style="padding-bottom: 14px;padding-top: 14px;">
        <form name="invitefriend" id="invitefriend" action="" method="post">
            <div class="mainacount" id="login_frm">
                <input type="hidden" id="div_count" value="3">
                <div id="jbinvite">
                    <div class="invite_form" id="fname_div1">
                        <input type="text" value="" name="fname[]" id="fname" class="invite-input"
                               placeholder="Friend's Name">
                        <div class="error-invite" id="fnameError"><?php echo form_error('fname'); ?></div>
                    </div>

                    <div class="invite_form" id="femail_div1">
                        <img src="<?php echo ASSETS ?>images/close-icon.png"
                             style="float: right;margin-top: 10px;margin-bottom: -3px;position: absolute;right: 51px;"
                             id="close1" onclick="removeMore(1)">
                        <input type="text" id="femail" name="femail[]" value="" class="invite-input"
                               placeholder="Friend's Email">

                        <div class="error-invite" id="femailError"><?php echo form_error('femail'); ?></div>
                    </div>
                    <div class="invite_form" id="fname_div2">
                        <input type="text" value="" name="fname[]" id="fname" class="invite-input"
                               placeholder="Friend's Name">
                        <div class="error-invite" id="fnameError"><?php echo form_error('fname'); ?></div>
                    </div>

                    <div class="invite_form" id="femail_div2">
                        <img src="<?php echo ASSETS ?>images/close-icon.png"
                             style="float: right;margin-top: 10px;margin-bottom: -3px;position: absolute;right: 51px;"
                             id="close2" onclick="removeMore(2)">
                        <input type="text" id="femail" name="femail[]" value="" class="invite-input"
                               placeholder="Friend's Email">
                        <div class="error-invite" id="femailError"><?php echo form_error('femail'); ?></div>
                    </div>

                    <div class="invite_form" id="fname_div3">
                        <img src="<?php echo ASSETS ?>images/close-icon.png"
                             style="float: right;margin-top: 10px;margin-bottom: -3px;position: absolute;right: 51px;"
                             id="close3" onclick="removeMore(3)">
                        <input type="text" value="" name="fname[]" id="fname" class="invite-input"
                               placeholder="Friend's Name">
                        <div class="error-invite" id="fnameError"><?php echo form_error('fname'); ?></div>
                    </div>

                    <div class="invite_form" id="femail_div3">
                        <input type="text" id="femail" name="femail[]" value="" class="invite-input"
                               placeholder="Friend's Email">
                        <div class="error-invite" id="femailError"><?php echo form_error('femail'); ?></div>
                    </div>

                </div>

                <div class="invite_form">
                    <input type="text" value="" name="myname" id="myname" class="invite-input" placeholder="Your Name">
                    <div class="error-invite" id="mynameError"><?php echo form_error('myname'); ?></div>
                </div>

                <div class="invite_form">
                    <input type="text" id="mymail" name="mymail" value="" class="invite-input" placeholder="Your Email">
                    <div class="error-invite" id="mymailError"><?php echo form_error('mymail'); ?></div>
                </div>
                <div class="invite_form" style="width: 22% !important;">
                    <div class="masg3">
                        <input type="button" class="btn-normal btn-color submit bottom-pad2 invitebott "
                               value="Add More" onClick="return addMore();">
                    </div>
                </div>

                <div class="invite_form" style="float: right;width: 14% !important;">
                    <div class="masg3">
                        <input type="submit" name="invite" class="btn-normal btn-color submit bottom-pad2 invitebott "
                               value="Invite" onClick="return invitecheck();">
                    </div>
                </div>

            </div>
        </form>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>

<?php /*
<script src="<?php echo ASSETS;?>js/app.js"></script>
<script src="<?php echo ASSETS;?>js/jquery.reveal.js"></script>
*/ ?>

<script>
  function catdtls(id) {
    var cat = $('#' + id).val();
    if (cat == '') {
      cat = '_';
    }
    //alert(cat);die();
    var category = '<?php echo str_replace('&', '_', $cat);?>';
    //alert(category);die():
    var ptype = '<?php echo $ptype;?>';
    var minb = '<?php echo $minb;?>';
    var maxb = '<?php echo $maxb;?>';
    var post_with = '<?php echo $post_with;?>';
    var coun = '<?php echo $coun;?>';
    var ct = '<?php echo $ct;?>';
    var featured = '<?php echo $featured;?>';
    var environment = '<?php echo $environment;?>';
    var uid = '<?php echo $uid;?>';

    var dataString = 'cid=' + cat + '&category=' + category + '&ptype=' + ptype + '&minb=' + minb + '&maxb=' + maxb + '&post_with=' + post_with + '&coun=' + coun + '&ct=' + ct + '&featured=' + featured + '&environment=' + environment;
    $.ajax({
      type: "POST",
      data: dataString,
      url: "<?php echo base_url();?>jobfeed/getsrch/" + cat + "/" + category + "/" + ptype + "/" + minb + "/" + maxb + "/" + post_with + "/" + coun + "/" + ct + "/" + featured + "/" + environment,
      success: function (return_data) {
        $("#pagi").hide();
        //alert(return_data);
        $('#prjct').html('');
        $('#prjct').html(return_data);
      }
    });
  }
</script>
<script>
  function searchbyCat(id) {
    //alert(id);
    var cat = id;

    var dataString = 'cid=' + cat;
    $.ajax({
      type: "POST",
      data: dataString,
      url: "<?php echo base_url();?>jobfeed/serachproject/category/" + cat,
      success: function (return_data) {
        //alert(return_data);
        $('#prjct').html('');
        $('#prjct').html(return_data);
      }
    });
  }

  function hdd() {
    var minb = $('#budget_min').val();
    var maxb = $('#budget_max').val();
    //alert(minb+','+maxb);
    window.location.href = '<?php echo VPATH;?>jobfeed/filterjob/<?php echo str_replace('&', '_', $cat);?>/<?php echo $ptype;?>/' + minb + '/' + maxb + '/<?php echo $post_with . "/" . $coun . "/" . $ct . "/";?>';
  }

  function setaction(v) {
    $("#invitefriend").attr('action', "<?php echo VPATH;?>jobdetails/invitefriend/" + v);
  }

  function addMore() {

    var c = parseInt($("#div_count").val()) + 1;
    $("#div_count").val(parseInt(c));

    var v = "<div class='invite_form' id='fname_div" + c + "'><input type='text' value='' name='fname[]' id='fname' class='invite-input' placeholder='Friend&rsquo;s Name' ><div class='error-invite' id='fnameError'><?php echo form_error('fname');?></div></div><div class='invite_form' id='femail_div" + c + "'><img src='<?php echo ASSETS?>images/close-icon.png' style='float: right;margin-top: 10px;margin-bottom: -3px;position: absolute;right: 51px;' id='close" + c + "' onclick='removeMore(" + c + ")'><input type='text' id='femail' name='femail[]' value='' class='invite-input' placeholder='Friend&rsquo;s Email' ><div class='error-invite' id='femailError'><?php echo form_error('femail');?></div></div>";
    $("#jbinvite").append(v);
  }

  function removeMore(v) {
    var c = parseInt($("#div_count").val());
    if (c > 1) {
      $("#fname_div" + v).remove();
      $("#femail_div" + v).remove();
      $("#close" + v).remove();
      c = parseInt($("#div_count").val() - 1);
      $("#div_count").val(parseInt(c));
    }
  }

  function invitecheck() {

    var fmail = $('#femail').val();
    var fname = $('#fname').val();
    var mymail = $('#mymail').val();
    var myname = $('#myname').val();
    var f = true;

    var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (fmail == '') {
      $('#femailError').html('Friends Email cant be left blank');
      $('#femail').focus();
      f = false;
    }
    if (fmail != '') {
      if (!re.test(fmail)) {
        $('#femailError').html('Please Enter a Valid Email');
        $('#femail').focus();
        f = false;
      }
    }
    if (fname == '') {
      $('#fnameError').html('Friends Name cant be left blank');
      $('#fname').focus();
      f = false;
    }
    if (mymail == '') {
      $('#mymailError').html('Your Email cant be left blank');
      $('#mymail').focus();
      f = false;
    }
    if (mymail != '') {
      if (!re.test(mymail)) {
        $('#mymailError').html('Please Enter a Valid Email');
        $('#mymail').focus();
        f = false;
      }
    }


    if (myname == '') {
      $('#mynameError').html('Your name cant be left blank');
      $('#myname').focus();
      f = false;
    }
    return f;
  }

</script>
<script>
  function shwcat(id) {
    $('#sub_' + id).toggle();
    if ($('#h1_' + id).hasClass('active')) {
      $('#h1_' + id).removeAttr('class', 'true');
    } else {
      $('#h1_' + id).attr('class', 'active');
    }

  }
</script>

<script>
  jQuery(document).ready(function () {
    console.log('working');
  });
</script>
<!--  <script src="<?php echo VPATH; ?>assets/js/jquery.mousewheel.js"></script>
    <script src="<?php echo VPATH; ?>assets/js/perfect-scrollbar.js"></script>
    <link href="<?php echo VPATH; ?>assets/css/perfect-scrollbar.css" rel="stylesheet">

    <style>
      #country_ul {
        border: 1px solid gray;
        height:150px;
        width: 400px;
        overflow: hidden;
        position: absolute;
      }
    </style>
    <script type="text/javascript">
      $(document).ready(function ($) {
        $('#country_ul').perfectScrollbar({
          wheelSpeed: 20,
          wheelPropagation: false
        });
      });
    </script>
-->

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <form action="" method="post" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="$('#myModal').modal('hide');">
                        &times;
                    </button>
                    <h4 class="modal-title">Edit availablity in week</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label>Hour/week:</label>
                            <input type="number" name="available_week" class="form-control"
                                   value="<?php echo !(empty($available_hr)) ? number_format($available_hr) : ''; ?>"/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-site btn-block" name="submit" value="edit_hour">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
