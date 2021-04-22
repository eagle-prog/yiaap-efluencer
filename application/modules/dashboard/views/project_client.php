<?php echo $breadcrumb; ?>

<script src="<?= JS ?>mycustom.js"></script>

<div class="clearfix"></div>

<section id="mainpage" class="dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <?php $this->load->view('dashboard-left'); ?>
            </div>
            <div class="col-md-10 col-sm-9 col-xs-12">
                <h4 class="title-sm"><?php echo __('dashboard_myproject_client_open_projects', 'Open Projects'); ?></h4>
              <?php
              echo $this->session->flashdata('invite_success');
              ?>

                <!--ProfileRight Start-->
              <?php
              if ($this->session->flashdata('succ_job')) {
                ?>
                  <div class="success alert-success alert"><?php echo $this->session->flashdata('succ_job'); ?></div>
                <?php
              }
              ?>
                <!--<link rel="stylesheet" type="text/css" href="<//?=CSS?>datatable/bootstrap.min.css">-->
                <link rel="stylesheet" type="text/css" href="<?= CSS ?>datatable/dataTables.responsive.css">
                <link rel="stylesheet" type="text/css" href="<?= CSS ?>datatable/dataTables.bootstrap.css">
                <script type="text/javascript" language="javascript"
                        src="<?= CSS ?>datatable/jquery.dataTables.min.js"></script>
                <script type="text/javascript" language="javascript"
                        src="<?= CSS ?>datatable/dataTables.responsive.min.js"></script>
                <script type="text/javascript" language="javascript"
                        src="<?= CSS ?>datatable/dataTables.bootstrap.js"></script>
                <script type="text/javascript" charset="utf-8">
                  $(document).ready(function () {

                    projectsTabs($("#P")); // load on first time //

                    $('#example').dataTable();

                  });
                </script>
                <div class="profile_right profile-modifiy" id="profile_right">

                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table class="table table-dashboard table-middle">
                            <thead>
                            <tr>
                                <th style="width:30%"><?php echo __('dashboard_myproject_client_project_name', 'Project Name'); ?></th>
                                <th align="center"><?php echo __('dashboard_myproject_client_project_type', 'Project Type'); ?></th>
                                <th align="center"><?php echo __('dashboard_myproject_client_status', 'Status'); ?></th>
                                <th align="center"><?php echo __('dashboard_myproject_client_bid_placed', 'Bid Placed'); ?></th>
                                <th align="center"><?php echo __('dashboard_myproject_client_action', 'Action'); ?></th>
                                <th><?php echo __('dashboard_myproject_posted_date', 'Posted date'); ?></th>
                            </tr>
                            </thead>
                            <tbody>


                            <?php

                            if (count($projects) > 0) {
                              foreach ($projects as $key => $val) {
                                $val = filter_data($val);
                                ?>
                                  <tr>
                                    <?php
                                    $visibility = "";
                                    if ($val['visibility_mode'] == "Private") {
                                      $visibility = __('dashboard_myproject_private_job', 'Private Job');
                                    } else {
                                      $visibility = __('dashboard_myproject_public_job', 'Public Job');
                                    }
                                    ?>

                                      <td>
                                          <a href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>"><?php echo $val['title'] . " (" . $visibility . ")" ?></a>
                                      </td>
                                      <td align="center">
                                        <?php if ($val['project_type'] == "F") {
                                          echo "<div class='hourly' title='" . __('dashboard_myproject_fixed', 'Fixed') . "''><i class='zmdi zmdi-lock' data-toggle='tooltip' data-placement='top' title='" . __('dashboard_myproject_fixed', 'Fixed') . "'></i></div>";
                                        } else {
                                          echo "<div class='hourly' title='" . __('dashboard_myproject_hourly', 'Hourly') . "'><i class='zmdi zmdi-time' data-toggle='tooltip' data-placement='bottom' title='" . __('dashboard_myproject_hourly', 'Hourly') . "'></i></div>";
                                        } ?></td>

                                      <td align="center"><?php if ($val['project_status'] == 'Y') {
                                          echo "<div class='hourly' data-toggle='tooltip' data-placement='top' title='" . __('dashboard_myproject_active', 'Active') . "'><i class='fa fa-check-circle'></i></div>";
                                        } else {
                                          echo "<div class='hourly' title='" . __('dashboard_myproject_waiting_for_admin_approval', 'Awaiting admin approval') . "'><i class='fa fa-spinner'></i></div>";
                                        } ?></td>
                                      <td align="center"><?php echo $val['bidder_details'] ?></td>

                                      <td align="center">
                                          <div class="icon-set">
                                            <?php
                                            if ($val['expiry_date_extend'] != "Y") {
                                              ?>
                                                <a class="hidden" href="javascript:void(0);"
                                                   onclick="actionPerform('EX',<?php echo $val['id']; ?>)"
                                                   data-toggle="tooltip"
                                                   title="<?php echo __('dashboard_myproject_extend', 'Extend'); ?>"><i
                                                            class="fa fa-arrows"></i></a>
                                              <?php
                                            }
                                            ?>
                                            <?php
                                            /*if($val['bidder_details'] >0){
                                            ?>
                                            <a href="javascript:void(0);" data-toggle="tooltip" onclick="actionPerform('SF',<?php echo $val['id'];?>)" title="<?php echo __('dashboard_myproject_select_freelancer','Select Freelancer'); ?>"><i class="fa fa-gift"></i></a>
                                            <?php
                                            }*/
                                            ?>
                                              <a href="javascript:void(0);"
                                                 onclick="actionPerform('E',<?php echo $val['id']; ?>)"
                                                 data-toggle="tooltip"
                                                 title="<?php echo __('dashboard_myproject_edit', 'Edit'); ?>"><i
                                                          class="fa fa-edit"></i></a>
                                              <a href="javascript:void(0);"
                                                 onclick="actionPerform('C',<?php echo $val['id']; ?>)"
                                                 data-toggle="tooltip"
                                                 title="<?php echo __('dashboard_myproject_close', 'Close'); ?>"><i
                                                          class="fa fa-ban"></i></a>
                                              <!--<a href="javascript:void(0);" onclick="actionPerform('IB',<?php echo $val['id']; ?>)" data-toggle="tooltip" title="Invite Freelancer"><i class="fa fa-user"></i></a>-->
                                            <?php /*?><a href="javascript:void(0);" onclick="actionPerform('PC',<?php echo $val['id'];?>)" data-toggle="tooltip" title="Pause Contract"><i class="fa fa-pause"></i></a>
<a href="javascript:void(0);" onclick="actionPerform('M',<?php echo $val['id'];?>)"  data-toggle="tooltip" title="Message"><i class="fa fa-envelope-alt"></i></a>
<a href="javascript:void(0);" onclick="actionPerform('VF',<?php echo $val['id'];?>)" data-toggle="tooltip" title="View Profile"><i class="fa fa-dashboard"></i></a>
<a href="javascript:void(0);" onclick="actionPerform('GB',<?php echo $val['id'];?>)" data-toggle="tooltip" title="Give Bonus"><i class="fa fa-money"></i></a>
<a href="javascript:void(0);" onclick="actionPerform('EC',<?php echo $val['id'];?>)" data-toggle="tooltip" title="End Contractor"><i class=" fa fa-user"></i></a><?php */
                                            ?>
                                          </div>

                                          <span id="extend_span<?php echo $val['id']; ?>" style="display: none;">

<input type="hidden" name="eid" id="eid<?php echo $val['id']; ?>" value="<?php echo $val['id']; ?>">
<input type="text" class="form-control input-sm" style="display:inline-block; width:auto" name="extend_day"
       id="extend_day<?php echo $val['id']; ?>" value="" placeholder="No of Days (Max: 15 Days)"
       onkeypress="return isNumberKey(event)">
<input type="button" class="btn btn-success btn-sm" name="submit" value="<?php echo __('set', 'Set') ?>"
       onclick="setextend('<?php echo $val['id']; ?>')">
<input type="button" class="btn btn-warning btn-sm" name="cancel" value="<?php echo __('cancel', 'Cancel') ?>"
       onclick="hideextend('<?php echo $val['id']; ?>')">
</span>

                                          <select class="form-control input-sm"
                                                  style="width:auto; display:none; margin-top:px"
                                                  id="action_select<?php echo $val['id']; ?>"
                                                  onchange="actionPerform(this.value,<?php echo $val['id']; ?>)">
                                              <option value=""><?php echo __('select', 'Select') ?></option>
                                            <?php
                                            if ($val['bidder_details'] > 0) {
                                              ?>
                                                <option value="SP"><?php echo __('select_a_freelancer', 'Select a Freelancer') ?></option>
                                              <?php
                                            }
                                            ?>

                                            <?php
                                            if ($val['expiry_date_extend'] != "Y") {
                                              ?>
                                                <option value="EX"><?php echo __('extend', 'Extend') ?></option>
                                              <?php
                                            }
                                            ?>

                                              <option value="E"><?php echo __('edit', 'Edit') ?></option>
                                              <option value="C"><?php echo __('close', 'Close') ?></option>
                                              <option value="IB"><?php echo __('invite_freelancer', 'Invite Freelancer') ?></option>
                                              <option value="PC"><?php echo __('pause_contract', 'Pause contract') ?></option>
                                              <option value="M"><?php echo __('message', 'Message') ?></option>
                                              <option value="VF"><?php echo __('view_Profile', 'View Profile') ?></option>
                                              <option value="GB"><?php echo __('give_bonus', 'Give Bonus') ?></option>
                                              <option value="GB"><?php echo __('end_contractor', 'End Contractor') ?></option>
                                          </select>
                                          <a href="javascript:void(0)" data-reveal-id="exampleModal"
                                             onclick="$('#priject_id').val(<?php echo $val['id']; ?>)" style="
float: left;  display: none;"><?php echo __('dashboard_invite_guest_freelancer', 'Invite Guest Freelancer') ?></a>
                                          <div style="display: none;font-size:13px">
                                              <a id="spa_<?php echo $val['id']; ?>"
                                                 href="<?php echo VPATH; ?>dashboard/selectprovider/<?php echo $val['project_id']; ?>"> <?php echo __('select_a_freelancer', 'Select a Freelancer') ?></a>
                                              <a id="eidta_<?php echo $val['id']; ?>"
                                                 href="<?php echo VPATH; ?>postjob/editjob/<?php echo $val['id']; ?>"> <?php echo __('edit', 'Edit') ?></a>
                                              |
                                              <a id="closea_<?php echo $val['id']; ?>"
                                                 href="<?php echo VPATH; ?>dashboard/projectclose/<?php echo $val['id']; ?>"><?php echo __('close', 'Close') ?></a>
                                              |

                                            <?php
                                            /*$skill_id="";
                                            if(strstr($val['skills'],','))
                                            {
                                                $skills=explode(",",$val['skills']);
                                                foreach($skills as $key=>$value)
                                                {
                                                    $id=$this->auto_model->getFeild('id','skills','skill_name',$value,'','','');

                                                    $skill_id.=$id."-";
                                                }
                                                $skill_id=rtrim($skill_id,"-");
                                            }
                                            else
                                            {
                                                $skill_id=$this->auto_model->getFeild('id','skills','skill_name',$val['skills'],'','','');
                                            }*/
                                            ?>
                                            <?php /*<a id="iba_<?php echo $val['id'];?>" href="<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $val['id'];?>/<?php echo $skill_id;?>/All/">Invite Freelancers</a> |  */
                                            ?>

                                              <a id="pc_<?php echo $val['id']; ?>"
                                                 href="<?php echo VPATH; ?>dashboard/selectprovider/<?php echo $val['id']; ?>"><?php echo __('pause_contract', 'Pause contract') ?></a>
                                              |

                                              <a id="m_<?php echo $val['id']; ?>"
                                                 href="<?php echo VPATH; ?>message/"><?php echo __('message', 'Message') ?></a>
                                              |
                                              <a id="vp_<?php echo $val['id']; ?>"
                                                 href="<?php echo VPATH; ?>dashboard/profile_client/"><?php echo __('view_Profile', 'View Profile') ?></a>
                                              |


                                          </div>

                                      </td>
                                      <td><?php echo $this->auto_model->date_format($val['posted_date']); ?></td>
                                  </tr>
                                <?php
                              }
                            } else {
                              echo '<tr><td colspan="10" style="text-align:center;">' . __('no_records_found', 'No Open Projects Found.') . '</td></tr>';
                            }

                            ?>
                            <? /*?>
<div class="notiftext"><h4>Project Name</h4><h4>Project Type</h4><h4>Status</h4><h4>Bid Placed</h4><h4>Action</h4><h4>Posted date</h4></div>
<div class="notiftext"><h4>Project Name</h4><h4>Project Type</h4><h4>Status</h4><h4>Bid Placed</h4><h4>Action</h4><h4>Posted date</h4></div>
<?php
if(count($projects)>0)
{
foreach($projects as $key=>$val)
{
?>
<div class="methodbox">
<?php
$visibility="";
if($val['visibility_mode']=="Private"){
$visibility="Private Job";
}
else{
$visibility="Public Job";
}
?>

<div class="methodtext1"><h2><strong><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>"><?php echo $val['title']." (".$visibility.")"?></a></strong></h2></div>

<div class="methodtext1"><h2><strong><?php if($val['project_type']=="F") { echo "Fixed";} else {
echo "Hourly"; }?></strong></h2></div>

<div class="methodtext1"><h2><strong><?php if($val['project_status']=='Y'){echo "Active";}else{echo "Awaiting admin approval";}?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo $val['bidder_details']?></strong></h2></div>
<div class="methodtext1"><h2>
<strong>


<span id="extend_span<?php echo $val['id'];?>" style="display: none;">

<input type="hidden" name="eid" id="eid<?php echo $val['id'];?>" value="<?php echo $val['id'];?>">
<input type="text" name="extend_day" id="extend_day<?php echo $val['id'];?>" value="" placeholder="No of Days (Max: 15 Days)" onkeypress="return isNumberKey(event)">
<input type="button" name="submit" value="Set" onclick="setextend('<?php echo $val['id'];?>')"> &nbsp;
<input type="button" name="cancel" value="Canel" onclick="hideextend('<?php echo $val['id'];?>')">

</span> &nbsp;

<select style="margin-top: -11%;width: 100%; margin-bottom: 4px;" id="action_select<?php echo $val['id'];?>" onchange="actionPerform(this.value,<?php echo $val['id'];?>)">
    <option value="">Select</option>
    <?php
        if($val['bidder_details'] >0){
    ?>
      <option value="SP">Select a Freelancer</option>
    <?php
        }
?>

     <?php
        if($val['expiry_date_extend']!="Y"){
     ?>
          <option value="EX">Extend</option>
     <?php
        }
     ?>

    <option value="E">Edit</option>
    <option value="C">Close</option>
    <option value="IB">Invite Freelancer</option>
</select>
<a href="javascript:void(0)" data-reveal-id="exampleModal" onclick="$('#priject_id').val(<?php echo $val['id'];?>)" style="width: 145px;
float: left;" >Invite Guest Freelancer</a>
<div style="display: none;">
    <a id="spa_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/selectprovider/<?php echo $val['project_id'];?>"> Select a Freelancer</a>
    <a id="eidta_<?php echo $val['id'];?>" href="<?php echo VPATH;?>postjob/editjob/<?php echo $val['id'];?>"> Edit</a> |
    <a id="closea_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/projectclose/<?php echo $val['id'];?>">Close</a> |
    <?php
    $skill_id="";
    if(strstr($val['skills'],','))
    {
        $skills=explode(",",$val['skills']);
        foreach($skills as $key=>$value)
        {
            $id=$this->auto_model->getFeild('id','skills','skill_name',$value,'','','');
            $skill_id.=$id."-";
        }
        $skill_id=rtrim($skill_id,"-");
    }
    else
    {
        $skill_id=$this->auto_model->getFeild('id','skills','skill_name',$val['skills'],'','','');
    }
    ?>
    <a id="iba_<?php echo $val['id'];?>" href="<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $val['id'];?>/<?php echo $skill_id;?>/All/">Invite Freelancers</a> |
</div>

</strong></h2></div>
<div class="methodtext1"><h2><?php echo $this->auto_model->date_format($val['posted_date']);?></strong></h2></div>
</div>
<?php
}
}
else
{
?>
<div class="myprotext"><p><strong>No active jobs to display</strong></p></div>
<?php
}*/
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!--EditProfile End-->
                    <h4 class="title-sm"><?php echo __('dashboard_myproject_contracts', 'Contracts'); ?></h4>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="javascript:void(0)" aria-controls="active"
                                                                  role="tab" data-toggle="tab" id="P"
                                                                  onClick="projectsTabs(this);"><?php echo __('dashboard_myproject_active', 'Active'); ?></a>
                        </li>
                        <li role="presentation"><a href="javascript:void(0)" aria-controls="pending" role="tab"
                                                   data-toggle="tab" id="F"
                                                   onClick="projectsTabs(this);"><?php echo __('dashboard_myproject_pending', 'Pending'); ?></a>
                        </li>
                        <li role="presentation"><a href="javascript:void(0)" aria-controls="pause" role="tab"
                                                   data-toggle="tab" id="PS"
                                                   onClick="projectsTabs(this);"><?php echo __('dashboard_myproject_pause', 'Pause'); ?></a>
                        </li>
                        <li role="presentation"><a href="javascript:void(0)" aria-controls="expired" role="tab"
                                                   data-toggle="tab" id="E"
                                                   onClick="projectsTabs(this);"><?php echo __('dashboard_myproject_expired', 'Expired'); ?></a>
                        </li>
                        <li role="presentation"><a href="javascript:void(0)" aria-controls="completed" role="tab"
                                                   data-toggle="tab" id="C"
                                                   onClick="projectsTabs(this);"><?php echo __('dashboard_myproject_completed', 'Completed'); ?></a>
                        </li>
                        <li role="presentation"><a href="javascript:void(0)" aria-controls="completed" role="tab"
                                                   data-toggle="tab" id="S"
                                                   onClick="projectsTabs(this);"><?php echo __('dashboard_myproject_stopped', 'Stopped'); ?></a>
                        </li>
                    </ul>


                </div>

                <div class="clearfix"></div>
                <!---  custom ProjectTabs Div-->

                <div class="profile_rightTabs" id="profile_rightTabs" style="height: 600px;"></div>

                <!---  custom ProjectTabs Div Ends Here-->

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
            <!-- Left Section End -->
        </div>
    </div>

</section>

<div class="modal fade" id="givebonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="top:5%">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('give_bonus', 'Give Bonus') ?></h4>
            </div>
            <div class="modal-body">
                <div id="bonusmessage" class="login_form"></div>
                <form action="" name="givebonusform" class="form-horizontal givebonusform" method="POST">
                    <input type="hidden" name="bonus_freelancer_id" id="bonus_freelancer_id" value="0"/>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <label><?php echo __('amount', 'Amount') ?>: </label>
                            <input type="text" class="form-control" size="30" value="0" name="bonus_amount"
                                   id="bonus_amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label><?php echo __('reason', 'Reason') ?>: </label>
                            <textarea type="text" class="form-control" name="bonus_reason"
                                      id="bonus_reason"> </textarea>
                        </div>
                    </div>
                    <button type="button" onclick="sendbonus()" id="sbmt"
                            class="btn btn-site btn-sm"><?php echo __('send', 'Send') ?></button>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div id="exampleModal" class="reveal-modal" style="width:70%;margin-left: -35%;">
    <h3> <?php echo __('dashboard_invite_friends_to_this_project', 'Invite Friends To this Project') ?></h3>
    <div class="editprofile" style="padding-bottom: 14px;padding-top: 14px;">
        <form name="invitefriend" action="<?php echo VPATH; ?>invitetalents/inviteGuestFreelancer" method="post">
            <div class="mainacount" id="login_frm">
                <input type="hidden" name="priject_id" id="priject_id" value="">

                <div class="acount_form">
                    <p><?php echo __('dashboard_friends_email', 'Friend\'s Email') ?> :</p>
                    <input type="text" id="femail" name="femail[]" value="" class="acount-input">
                    <div class="error-msg3" id="femailError"><?php echo form_error('femail'); ?></div>
                </div>
                <div class="acount_form">
                    <p><?php echo __('dashboard_friends_name', 'Friend\'s Name') ?> :</p>
                    <input type="text" value="" name="fname[]" id="fname" class="acount-input">
                    <div class="error-msg3" id="fnameError"><?php echo form_error('fname'); ?></div>
                </div>

                <div id="add_more_div">

                </div>

                <input type="button" class="btn btn-sm btn-site" value="Add More"
                       style="float: right;margin-right: 95px;" onClick="addFRM()">

                <div class="acount_form">
                    <div class="masg3">
                        <input type="submit" name="invite" class="btn btn-sm btn-site"
                               value="<?php echo __('invite', 'Invite') ?>" onClick="return invitecheck();">

                    </div>
                </div>
            </div>
        </form>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>

<!--<script src="<? //php echo ASSETS;?>js/jquery.min.js"></script>
<script src="<? //php echo ASSETS;?>js/app.js"></script>-->
<script src="<?php echo ASSETS; ?>js/jquery.reveal.js"></script>
<script>
  function projects(type) {
    //alert(type);
    var dataString = "status=" + type;
    //alert(dataString);
    $.ajax({
      type: "POST",
      data: dataString,
      url: "<?php echo VPATH;?>dashboard/project_frozen",
      success: function (return_data) {
        //alert(return_data);
        $('#profile_right').html('');
        $('#profile_right').fadeOut("slow");
        $('#profile_right').fadeIn("slow");
        $('#profile_right').html(return_data);

        $('#example1').dataTable();

        $('#example1').wrap('<div class="table-responsive"></div>');
      }
    });

  }

  // custom  tab  Projects

  function projectsTabs(id) {
    var type = $(id).attr("id");
    $('.myfclass').removeClass('selected');
    $(id).addClass("selected");


    //alert(type);
    var dataString = "status=" + type;
    //alert(dataString);
    $.ajax({
      type: "POST",
      data: dataString,
      url: "<?php echo VPATH;?>dashboard/project_frozen",
      success: function (return_data) {

        //alert(return_data);
        $('#profile_rightTabs').html('');
        $('#profile_rightTabs').fadeOut(0);
        $('#profile_rightTabs').fadeIn(0);
        $('#profile_rightTabs').html(return_data);

        $('#exampleTabs').dataTable({searching: false, bLengthChange: false, ordering: false});
        $('#exampleTabs').wrap('<div class="tab-content"></div>');
        $('#exampleTabs_wrapper > .row:first-child').remove();
      }
    });
  }

// custom  tab  project  ends  here


  function repost_job(id) {
    $.ajax({
      type: "POST",
      data: 'action=repostjob&jobid=' + id,
      url: "<?php echo VPATH;?>dashboard/repostjob/",
      success: function (return_data) {
        // alert(return_data);
        window.location.href = '<?php echo VPATH;?>postjob/editjob/' + id;
        //location.reload();
      }
    });
  }

  function showextend(i) {
    $("#extend_span" + i).show();
    $("#action_select" + i).hide();
  }

  function hideextend(i) {
    $("#extend_span" + i).hide();
    // $("#action_select"+i).show();
  }

  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

    return true;
  }


  function setextend(i) {
    var id = $("#eid" + i).val();
    var extday = $("#extend_day" + i).val();
    if (extday < 16) {
      window.location.href = "<?php echo VPATH;?>dashboard/projectextend/" + id + "/" + extday;
    } else {
      alert('<?php echo __('please_enter_a_value_less_or_equal_to_15', 'Please enter a value less or equal to 15')?>');
    }

  }

  function addFRM() {
    $("#add_more_div").append("<div class='acount_form'><p><?php echo __('dashboard_friends_email', 'Friend\'s Email')?> :</p><input type='text' id='femail' name='femail[]' value='' class='acount-input' ></div><div class='acount_form'><p><?php echo __('dashboard_friends_name', 'Friend\'s Name')?> :</p><input type='text' value='' name='fname[]' id='fname' class='acount-input' ><div class='error-msg3' id='fnameError'><?php echo form_error('fname');?></div></div>");
  }

  function actionPerform(v, i) {
    // alert(v);alert(i);
    if (v == "E") {
      window.location.href = $("#eidta_" + i).attr('href');
    } else if (v == "C") {
      if (confirm('<?php echo __('are_you_sure_to_close_this_job', 'Are you sure to close this job?')?>')) {
        window.location.href = $("#closea_" + i).attr('href');
      }
    } else if (v == "IB") {
      window.location.href = $("#iba_" + i).attr('href');
    } else if (v == "PC") {
      window.location.href = $("#pc_" + i).attr('href');
    } else if (v == "SF") {
      window.location.href = $("#spa_" + i).attr('href');
    } else if (v == "M") {
      window.location.href = $("#m_" + i).attr('href');
    } else if (v == "VP") {
      window.location.href = $("#vp_" + i).attr('href');
    } else if (v == "SP") {
      window.location.href = $("#spa_" + i).attr('href');
    } else if (v == "IBG") {
      $('#priject_id').val(i);
    } else if (v == "EX") {
      showextend(i);
    } else if (v == "GB") {
      givebonus(i);
    }
  }

  function givebonus(user_id) {
    $("#givebonus div.modal-footer button#sbmt").css('display', 'inline-block');
    $("#bonus_freelancer_id").val(user_id);
    $(".givebonusform").css('display', 'block');
    $("#givebonus").modal();

  }

  function sendbonus() {
    $("#bonusmessage").html('Wait...');
    var requestbonis = $(".givebonusform").serialize();

    $.ajax({
      data: $(".givebonusform").serialize(),
      type: "POST",
      dataType: "json",
      url: "<?php echo VPATH;?>findtalents/givebonus",
      success: function (response) {

        if (response['status'] == 'OK') {

          $("#bonusmessage").html('<div style="color:green;margin-bottom: 23px;font-size: 20px;">' + response['msg'] + '</div>');
          $(".givebonusform").css('display', 'none');
          $("#givebonus div.modal-footer button#sbmt").css('display', 'none');
          $(".givebonusform")[0].reset();

        } else {

          $("#bonusmessage").html('<div style="color:red;margin-bottom: 23px;font-size: 20px;">' + response['msg'] + '</div>');

        }
      }
    });
  }
</script>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<style>
    @media screen and (min-width: 768px) {
        .modal-dialog {
            right: auto;
            left: 50%;
            width: 600px;
            padding-top: 30px;
            padding-bottom: 30px;
            position: initial;
        }

        .zmdi-lock {
            font-size: 19px;
        }
    }
</style>
