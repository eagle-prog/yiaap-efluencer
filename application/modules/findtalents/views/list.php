<script type="text/javascript" src="<?php echo JS; ?>jQuery-plugin-progressbar.js"></script>
<link href="<?php echo CSS; ?>jQuery-plugin-progressbar.css" rel="stylesheet" type="text/css">
<?php $lang = $this->session->userdata('lang'); ?>

<?php //echo $breadcrumb; ?>

<section class="sec secFindTalent">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <h2 class="title"><?php echo __('findtalents_freelancers', 'Freelancers'); ?></h2>
            </div>
            <div class="col-md-8">
                <div class="searchbox">
                    <form>
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control"
                                   placeholder="<?php echo __('findtalents_find_talents_by_name', 'Find talents by name'); ?>..."
                                   aria-describedby="basic-addon1" name="q"
                                   value="<?php echo !empty($srch_param['q']) ? $srch_param['q'] : ''; ?>">
                            <span class="input-group-addon" id="basic-addon1">
              <button type="submit" class="btn btn-site"><?php echo __('findtalents_search', 'Search'); ?></button>
              </span></div>
                    </form>
                    <p class="text-right" style="display:none;"><a
                                href="#"><?php echo __('findtalents_advanced_search', 'Advanced Search'); ?></a></p>
                </div>
            </div>


        </div>

    </div>
    <div class="spacer-30"></div>
    <div class="container">
        <div class="row">
          <?php $this->load->view('left_sidebar'); ?>

            <aside class="col-md-8 col-sm-12 col-xs-12">
                <div class="listing findtalent" id="talent">
                    <span class="panel-title">Freelancers</span>
                    <!--<span class="found-results">( <?php /*echo $total_freelancers;*/ ?> ) results</span>-->
                  <?php


                  if (count($freelancers)) {


                    foreach ($freelancers as $row) {
                      $previouscon = in_array($row['user_id'], $previousfreelancer);
                      ?>
                      <?php
                      if ($this->session->userdata('user')) {
                        $user = $this->session->userdata('user');
                        $account_type = $user[0]->account_type;
                        if ($user[0]->user_id == $row['user_id']) {
                          $lnk = VPATH . "dashboard/profile_professional";
                        } else {
                          $lnk = VPATH . "clientdetails/showdetails/" . $row['user_id'] . "/" . $this->auto_model->getcleanurl($row['fname'] . " " . $row['lname']) . "/";
                        }
                      } else {
                        $lnk = VPATH . "clientdetails/showdetails/" . $row['user_id'] . "/" . $this->auto_model->getcleanurl($row['fname'] . " " . $row['lname']) . "/";
                      }
                      ?>
                        <div class="media">
                            <div class="media-left"><a href="<?php echo $lnk; ?>">
                                <?php
                                if ($row['logo'] != "") {

                                  if (file_exists('assets/uploaded/cropped_' . $row['logo'])) {
                                    $logo = "cropped_" . $row['logo'];
                                  } else {
                                    $logo = $row['logo'];
                                  }

                                  ?>
                                    <img src="<?php echo VPATH . "assets/uploaded/" . $logo; ?>" class="media-object"/>
                                  <?php
                                } else {
                                  ?>
                                    <img src="<?php echo VPATH; ?>assets/images/people.png" class="media-object"/>
                                  <?php
                                }
                                ?>
                                </a></div>
                            <div class="media-body">
                              <?php
                              $membership_logo = "";
                              $membership_logo = $this->auto_model->getFeild('icon', 'membership_plan', 'id', $row['membership_plan']);
                              $membership_title = $this->auto_model->getFeild('name', 'membership_plan', 'id', $row['membership_plan']);

                              ?>
                              <?php
                              $contry_info = "";

                              if ($row['city'] != "") {
                                $contry_info .= $this->auto_model->getFeild('Name', 'city', 'id', $row['city']) . ", ";
                              }
                              $contry_info .= $this->auto_model->getFeild('Name', 'country', 'Code', $row['country']);

                              ?>
                              <?php
                              $code = strtolower($this->auto_model->getFeild('code2', 'country', 'Code', $row['country']));
                              $slogan = $this->auto_model->getFeild('slogan', 'user', 'user_id', $row['user_id']);
                              $overview = $this->auto_model->getFeild('overview', 'user', 'user_id', $row['user_id']);
                              ?>
                                <h4 class="media-heading">
                                    <a href="<?php echo $lnk; ?>"><?php echo $row['fname'] . " " . $row['lname'] ?></a>
                                  <?php if ($row['verify'] == 'Y') { ?>
                                      <i class="zmdi zmdi-shield-check verified-check ml-5"></i></a><?php } ?>
                                </h4>
                                <p class="bio"><i class="zmdi zmdi-map"></i> &nbsp;&nbsp; <?php echo $contry_info; ?>
                                    &nbsp;&nbsp;<img
                                            src="<?php echo VPATH; ?>assets/images/cuntryflag/<?php echo $code; ?>.png">
                                </p>
                                <p class="designation"><a href="<?php echo $lnk; ?>"><?php echo $slogan; ?></a></p>
                                <p><?php echo strlen(strip_tags($overview)) > 200 ? substr(strip_tags($overview), 0, 200) . '... <a href="' . $lnk . '">' . __('findtalents_more', 'more') . '</a>' : strip_tags($overview); ?> </p>
                            </div>
                            <div class="media-right">
                                <h4>
                                  <?php
                                  if ($row['rating'][0]['num'] > 0) {

                                    $avg_rating = $row['rating'][0]['avg'] / $row['rating'][0]['num'];

                                    if ($avg_rating > 0) {
                                      $rounded_mark = round($avg_rating, 1);
                                      $rounded_mark = number_format($rounded_mark, 1);
                                    } else {
                                      $rounded_mark = 0;
                                    }
                                    echo "<span class='avg-star-mark'>$rounded_mark</span>";
                                    for ($i = 1; $i <= 5; $i++) {
                                      if ($i <= $avg_rating) {

                                        echo ' <i class="zmdi zmdi-star"></i> ';
                                      } else {
                                        echo ' <i class="zmdi zmdi-star-outline"></i> ';
                                      }
                                    }

                                  } else { ?>
                                      <!--            <span class='avg-star-mark'>No reviews</span>-->
                                      <i class="zmdi zmdi-star-outline"></i>
                                      <i class="zmdi zmdi-star-outline"></i>
                                      <i class="zmdi zmdi-star-outline"></i>
                                      <i class="zmdi zmdi-star-outline"></i>
                                      <i class="zmdi zmdi-star-outline"></i>
                                  <?php } ?>

                                </h4>
                              <?php
                              $row['total_project'] = $row['total_project'] == 0 ? 1 : $row['total_project'];
                              $success_prjct = (int)$row['com_project'] * 100 / (int)$row['total_project'];


                              ?>
                                <div style="display: none" class="circle-bar position"
                                     data-percent="<?php echo round($success_prjct, 2); ?>" data-duration="1000"
                                     data-color="#dedede,#0c0"></div>
                                <p class="job-success">
                                  <?php echo "Job Success: " . round($success_prjct, 2) . "%"; ?>
                                  <?php /*echo CURRENCY;?> <b>
                      <?php echo $row['hourly_rate'];?>/<?php echo __('findtalents_hr','hr'); ?></b><br>
                <?php //echo $row['com_project'];?> <?php echo __('findtalents_compleated_projects','Completed Project'); */
                                  ?>
                                </p>

                            </div>
                            <ul class="skills">
                                <li><?php echo __('findtalents_skills', 'Skills'); ?>:</li>
                              <?php
                              $skill_list = $row['skills'];

                              if (count($skill_list)) {
                                foreach ($skill_list as $k => $v) {

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
                                    <li>
                                        <a href="<?php echo base_url('findtalents/browse') . '/' . $this->auto_model->getcleanurl($v['parent_skill_name']) . '/' . $v['parent_skill_id'] . '/' . $this->auto_model->getcleanurl($v['skill']) . '/' . $v['skill_id']; ?>"> <?php // echo $v['skill'];
                                          ?>
                                          <?php echo $skill_name; ?> </a></li>
                                  <?php

                                }
                              } else {
                                ?>
                                  <li>
                                      <a href="javascript:void(0);"><?php echo __('findtalents_skills_not_set_yet', 'Skill Not Set Yet'); ?></a>
                                  </li>
                                <?php
                              }
                              ?>
                            </ul>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="pull-left completed-projects">
                                      <?php
                                      echo $row['com_project'] . " ";
                                      echo __('findtalents_compleated_projects', 'Completed Project');
                                      ?>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="pull-left completed-projects">
                                      <?php echo __('myprofile_emp_availability', 'Availability'); ?>:
                                      <?php if ($row['available_hr'] > 0) { ?>
                                        <?php echo $row['available_hr']; ?><?php echo __('myprofile_emp_hr_per_week', 'hr/week'); ?>
                                      <?php } else { ?>
                                          Not Available
                                      <?php } ?>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="pull-right hour-rate">
                                      <?php
                                      echo CURRENCY . " ";
                                      echo $row['hourly_rate'] . "/";
                                      echo __('findtalents_hr', 'hr');
                                      ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                      <?php
                    }

                  } else {
                    echo "<div class='alert alert-danger'>" . __('findtalents_no_record_found', 'No record found') . "</div>";
                  }
                  ?>
                </div>
                <nav aria-label="Page navigation" id="nav_bar">
                  <?php
                  $user = $this->session->userdata('user');
                  if (isset($user[0]->user_id) && isset($links)) { ?>
                    <?php
                    echo $links;
                    ?>
                    <?php
                  } else {
                    echo "<div class='show-pagination'><a href='" . site_url() . "login'>Login</a> to see more results</div>";
                  }
                  ?>
                </nav>
            </aside>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<script type="text/javascript">
  <?php $srch_url = !empty($srch_param) ? '?' . http_build_query($srch_param, '', '&') . '&' : '?';?>
  var srch_url = '<?php echo base_url('findtalents/ajaxsearch') . $srch_url;?>';

  $(document).ready(function () {
    $('#srch').keyup(function () {
      var val = $(this).val();
      $.get(srch_url + 'q=' + val, function (res, status) {
        $('#talent').html(res);
        $('#pagi_span').hide();
      });
    });
  });

  $(".circle-bar").loading();

</script>
