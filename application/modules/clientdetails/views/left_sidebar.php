<?php
$user = $this->session->userdata('user');
$last_seen = $this->auto_model->getFeild('last_seen', 'user', 'user_id', $user_id);
$status = (time() - 60) < $last_seen;
?>

<aside class="col-md-3 col-sm-12 col-xs-12">
    <div class="left_sidebar">
        <!--<h4 class="title-sm">My Professional Profile</h4>-->
        <div class="u_details">
            <div class="profile">
                <div class="user-avatar">
                    <div class="avatar-container">
                        <div class="avatar-image">
                          <?php if ($logo != '') {
                            if (file_exists('assets/uploaded/cropped_' . $logo)) {
                              $logo = 'cropped_' . $logo;
                            } ?>
                              <img alt="" src="<?php echo VPATH; ?>assets/uploaded/<?php echo $logo; ?>"
                                   class="img-circle">
                          <?php } else { ?>
                              <img alt="" src="<?php echo VPATH; ?>assets/images/user.png" class="img-circle">
                          <?php } ?>
                        </div>
                      <?php if ($status) { ?>
                          <div class="online-sign"></div>
                      <?php } else { ?>
                          <div class="online-sign" style="background:#ddd"></div>
                      <?php } ?>
                    </div>
                </div>

            </div>

            <div class="profile-details">


              <?php
              if ($this->session->userdata('user')) {
                $userid = $this->session->userdata('user');
                $user_login = $userid[0]->user_id;
                $u_acc_type = $userid[0]->account_type;
                ?>

                <?php if ($user_id == $user_login) { ?><a
                      href="<?php echo base_url('dashboard/editprofile_professional') ?>" class="pull-right"><i
                              class="zmdi zmdi-edit"></i> <?php echo __('clientdetails_sidebar_edit', 'Edit'); ?>
                      </a> <?php } ?>

              <?php } ?>

                <!--        <h4 class="text-center">--><?php //echo $fname." ".$lname;?><!--</h4>-->


              <?php
              if ($this->session->userdata('user')) {
                $userid = $this->session->userdata('user');
                $user_login = $userid[0]->user_id;
                if ($user_id != $user_login && $account_type == 'F') {?>
                    <a class="btn btn-site btn-block" data-toggle="modal" data-target="#myModal2"
                       style="cursor: pointer;"
                       onclick="setProject2('<?php echo $user_id; ?>','<?php echo $user_login; ?>')">
                        <i class="fa fa-user-plus"></i> <?php echo __('clientdetails_sidebar_send_message', 'Send Message'); ?>
                    </a>

                  <?php
                }
              }
              ?>
            </div>


        </div>

    </div>
</aside>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="top:5%">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"
                    id="myModalLabel"><?php echo __('clientdetails_sidebar_select_your_project_to_invite_freelancer', 'Select Your project to invite freelancer'); ?></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="freelancer_id" id="freelancer_id" value=""/>
                <div id="allprojects"></div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal').modal('hide');">Close</button>-->
                <button type="button" onclick="hdd()" id="sbmt"
                        class="btn btn-site"><?php echo __('clientdetails_sidebar_invite', 'Invite'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="top:5%">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                                  onclick="$('#myModal2').modal('hide');">&times;</span>
                </button>
                <h4 class="modal-title"
                    id="myModalLabel"><?php echo __('clientdetails_sidebar_send_message_to_freelancer', 'Send message to freelancer'); ?></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="freelancer_id2" id="freelancer_id2" value=""/>

                <div class="cost_timing">
                    <div class="cost_form_box">
                        <label id="select_project_label"><?php echo __('clientdetails_sidebar_select_your_project', 'Select Your Project'); ?></label>
                        <div id="allprojects2"></div>
                    </div>

                </div>
                <div class="divide15"></div>
                <div class="cost_timing" id="message_wrapper">
                    <div class="cost_form_box">
                        <label><?php echo __('clientdetails_sidebar_your_message', 'Your Message'); ?></label>
                        <textarea rows="4" cols="" name="msg_details" id="msg_details"
                                  class="cost_input form-control"></textarea>
                        <span id="detailsError" class="rerror"
                              style="float: left; display:none; color:red"><?php echo __('clientdetails_sidebar_enter_your_message_first', 'Enter Your Message First'); ?></span>
                    </div>

                </div>

            </div>
            <div class="modal-footer" style="border-top:none !important">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal2').modal('hide');">Close</button>-->
                <button type="button" onclick="hdd2()" id="sbmt2"
                        class="btn btn-site"><?php echo __('clientdetails_sidebar_send_message', 'Send Message'); ?></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
  jQuery(document).ready(function ($) {
    $("a[id^='parent_']").click(function (e) {
      e.preventDefault();
      var parent = $(this).attr('data-child');
      $('#child_' + parent).toggle();
    });
  });


  function setProject(user_id, project_user) {
    //alert(user_id+' '+project_user);
    jQuery("#freelancer_id").val(user_id);
    var datastring = "user_id=" + project_user;
    jQuery.ajax({
      data: datastring,
      type: "POST",
      url: "<?php echo VPATH;?>clientdetails/getProject",
      success: function (return_data) {
        //alert(return_data);
        if (return_data != 0) {
          jQuery("#allprojects").html('');
          jQuery("#allprojects").html(return_data);
          jQuery("#sbmt").show();
          jQuery("#message_wrapper").show();
        } else {
          jQuery("#allprojects").html('<b><?php echo __('clientdetails_sidebar_you_dont_have_any_open_projects_to_invite', 'You dont have any open projects to invite'); ?></b>');
          jQuery("#sbmt").hide();
          jQuery("#message_wrapper").hide();
        }
      }
    });
  }

  function setProject2(user_id, project_user) {
    //alert(user_id+' '+project_user);
    jQuery("#freelancer_id2").val(user_id);
    var datastring = "user_id=" + project_user;
    jQuery.ajax({
      data: datastring,
      type: "POST",
      url: "<?php echo VPATH;?>clientdetails/getProject",
      success: function (return_data) {
        //alert(return_data);
        if (return_data != 0) {
          jQuery("#allprojects2").html('');
          jQuery("#allprojects2").html(return_data);
          jQuery("#sbmt2").show();
          jQuery("#message_wrapper").show();
          jQuery("#select_project_label").show();
        } else {
          jQuery("#allprojects2").html("<b><?php echo __('clientdetails_sidebar_you_dont_have_any_open_projects_to_send_message', 'You don\'t have any open project to send message'); ?></b>");
          jQuery("#sbmt2").hide();
          jQuery("#message_wrapper").hide();
          jQuery("#select_project_label").hide();
        }
      }
    });
  }


  function hdd2() {
    var free_id = jQuery("#freelancer_id2").val();
    var project_id = jQuery(".prjct").val();
    var message = jQuery("#msg_details").val();
    if (message == '') {
      jQuery("#detailsError").css("display", "block");
      setTimeout("jQuery('#detailsError').hide();", 3000);
    } else {
      var datastring = "freelancer_id=" + free_id + "&projects_id=" + project_id + "&message=" + message;
      jQuery.ajax({
        data: datastring,
        type: "POST",
        url: "<?php echo VPATH;?>clientdetails/sendMessagenew",
        success: function (return_data) {
          window.location.href = '<?php echo VPATH;?>clientdetails/showdetails/' + free_id + '/';
        }
      });
      //window.location.href='<?php echo VPATH;?>clientdetails/sendMessage/'+free_id+'/'+project_id+'/'+'/'+encodeURI(message)+'/';
    }
  }


  function hdd() {
    var free_id = jQuery("#freelancer_id").val();
    var project_id = jQuery(".prjct").val();
    var page = 'clientdetails';
    window.location.href = '<?php echo VPATH;?>invitetalents/invitefreelancer/' + free_id + '/' + project_id + '/' + '/' + page + '/';
  }


  function fetch_project(project_user) {
    jQuery.ajax({
      data: datastring,
      type: "POST",
      url: "<?php echo VPATH;?>clientdetails/getProject",
      success: function (return_data) {
        //alert(return_data);
        if (return_data != 0) {

          jQuery("#allprojects2").html(return_data);

        } else {
          jQuery("#allprojects2").html("<b><?php echo __('clientdetails_sidebar_you_dont_have_any_projects', 'You dont have any open project'); ?></b>");

        }
      }
    });
  }


</script>









