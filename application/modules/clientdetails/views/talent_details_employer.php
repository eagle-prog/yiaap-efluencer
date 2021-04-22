<style>
.icon-round{
	margin-left: 10px;
}
.panel-body .list-group {
	margin-bottom:0
}
.panel-body .list-group-item {
    border-left: none;
	border-right:none
}
@media (min-width: 992px) {
.modal-sm {
    width: 400px;
}
}
</style>

<script src="<?=JS?>mycustom.js"></script>
<script src="<?=JS?>jquery.lightbox.min.js"></script>
<!--<nav class="navbar navbar-default navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="navigation-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">My Dashboard <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Membership</a></li>
        <li class="active"><a href="#">Profile</a></li>
        <li><a href="#">Disputes</a></li>
        <li><a href="#">My Projects</a></li> 
        <li><a href="#">Resources</a></li>
        <li><a href="#">Feedback</a></li>       
      </ul>
    </div>
  </div>
</nav>-->

<div class="clearfix"></div>
<!--<div class="parallax-banner-sm" style="background-image:url(<?php echo ASSETS;?>images/parallax1.jpg)">
	<div class="container">
	</div>
</div>-->
<div class="clearfix"></div>

<section class="sec sec-gray employerPublicProfile">
<div class="container">
<div class="profile-section">
<div class="clearfix">
	<aside class="col-md-9 col-sm-12 col-xs-12">
        <div class="row" style="margin-top:15px">
            <?php $this->load->view('left_sidebar'); ?>
			<div class="col-md-8 col-sm-12 col-xs-12">
                <div class="row">

                <h4 class="col-md-5 pull-left">
                    <span class="full-name">
                        <?php echo $fname." ".$lname;?>
                    </span>

                    <span class="location">
                        <?php
                        $flag=$this->auto_model->getFeild("code2","country","Code",$country);
                        $flag=  strtolower($flag).".png";
                        // echo $city.", ".$country;
                        if(is_numeric($city)){
                            $city = getField('Name', 'city', 'ID', $city);
                        }
                        $c = getField('Name', 'country', 'Code',$country);
                        ?>
                        <?php if($verify=='Y'){ ?> <a class="btn-approved" style="opacity:1;border-radius:15px" title="<?php echo strtoupper(__('clientdetails_sidebar_approved','APPROVED')); ?>"><i class="zmdi zmdi-star-circle"></i> Verifed</a><?php }  ?>
                        <span>&nbsp;</span>
                    <img src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>" alt=""> &nbsp;<span><?php echo $city; ?>,</span> <?php echo $c; ?>

                    </span>

                </h4>
                <h4 class="col-md-4 pull-right rate-info">
                    <?php

                    if($rating[0]['num']>0)
                    {

                        $avg_rating=$rating[0]['avg']/$rating[0]['num'];


                        for($i=1;$i <= $avg_rating;$i++)
                        {
                            ?>
                            <i class="zmdi zmdi-star"></i>
                            <?php
                        }
                        for($i=0;$i < (5-$avg_rating);$i++)
                        {
                            ?>
                            <i class="zmdi zmdi-star-outline"></i>
                            <?
                        }
                        echo "<span class='average-mark-profile'>".number_format($avg_rating, 2)."</span>";
                    }
                    else
                    {
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

                </div>
                <div class="col-md-12 profile-overview">
				<?php echo $overview;?>
                </div>
            </div>
        </div>
    </aside>
    <aside class="col-md-3 col-sm-12 col-xs-12 pull-right secondary_info">
    <div class="profileEdit">

     <?php
			$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user_id)));
			if($this->session->userdata('user')){
				$userid=$this->session->userdata('user');
				$user_login=$userid[0]->user_id;
				$u_acc_type =  $userid[0]->account_type;
			}

		?>


        <br />
<!--        <h4>Verifications</h4>-->
        <ul class="list-group">
        <li class="list-group-item hidden"><i class="zmdi zmdi-facebook-box"></i>
     <?php echo __('talentdetails_facebook_connected','Facebook Connected'); ?> <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-shield-check" title="<?php echo __('talentdetails_verified','Verified'); ?>" style="color:#0c0;line-height:20px"></i></span></li>
        <li class="list-group-item hidden"><i class="zmdi zmdi-smartphone"></i> <?php echo __('talentdetails_facebook_payment_verified','Payment Verified'); ?>
          <?php if($u_row['payment_verified'] == 'Y'){ echo '<span class="pull-right f-12">'.__('talentdetails_verified','Verified').'</span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-close-circle-o" title="<?php echo __('talentdetails_unverified','Unverify'); ?>" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
        <li class="list-group-item">
        <i class="zmdi zmdi-email"></i> <?php echo __('talentdetails_email_verified','Email Verified'); ?>
          <?php if($u_row['email_verified'] == 'Y'){ echo '<span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-shield-check" title="'.__('talentdetails_verified','Verified').'" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-close-circle-o" title="<?php echo __('talentdetails_unverified','Unverify'); ?>" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
        <li class="list-group-item">
    	<i class="zmdi zmdi-smartphone"></i> <?php echo __('talentdetails_phone_verified','Phone Verified'); ?>
          <?php if($u_row['phone_verified'] == 'Y'){ echo '<span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-shield-check" title="'.__('talentdetails_verified','Verified').'" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-close-circle-o" title="<?php echo __('talentdetails_unverified','Unverify'); ?>" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
      </ul>

      </div>
    </aside>
</div>
</div>

<div class="row">
    <aside class="col-sm-8 col-xs-12">

        <article class="block panel panel-default">
        <div class="panel-heading">
        	<h4 class="block-title"><?php echo __('talentdetails_emp_job_history','Job History'); ?> </h4>
        </div>
        <div class="panel-body">
			<h4><?php echo __('talentdetails_emp_completed_project','Completed project'); ?></h4>
			<table class="table">
				<?php if(count($completed_projects) > 0){foreach($completed_projects as $k => $v){ ?>
				<tr>
					<td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>
					<td><?php echo $v['project_type'] == 'F' ? __('fixed','Fixed') : __('hourly','Hourly'); ?></td>
					<td><?php echo __('talentdetails_emp_posted_on','Posted on'); ?> : <?php echo date('d M, Y', strtotime($v['post_date'])); ?></td>

				</tr>
				<?php } }else{  ?>
				<tr>
					<td colspan="10"><?php echo __('talentdetails_emp_no_completed_projects','No completed project'); ?></td>
				</tr>
				<?php } ?>

			</table>
			<h4><?php echo __('talentdetails_emp_open_projects','Open project'); ?></h4>
			<table class="table">
				<?php if(count($open_projects) > 0){foreach($open_projects as $k => $v){ ?>
				<tr>
					<td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>
					<td><?php echo $v['project_type'] == 'F' ? __('fixed','Fixed') : __('hourly','Hourly'); ?></td>
					<td><?php echo __('talentdetails_emp_posted_on','Posted on'); ?> : <?php echo date('d M, Y', strtotime($v['post_date'])); ?></td>

				</tr>
				<?php } }else{  ?>
				<tr>
					<td colspan="10"><?php echo __('ntdetails_emp_no_open_projects','No open project'); ?></td>
				</tr>
				<?php } ?>

			</table>
		</div>
        </article>

		<article class="panel panel-default block">
        <div class="panel-heading">
			<h4 class="block-title"><?php echo __('talentdetails_emp_reviews_and_rating','Reviews & Ratings'); ?></h4>
        </div>
        <div class="panel-body">
        <?php
        if(count($review)>0){
		//get_print($review);
        ?>

        <!--Rating Review-->
        <?php
        foreach($review as $key => $val){

            $username=$this->auto_model->getFeild('username','user','user_id',$val['review_to_user']);
            $given_name=$this->auto_model->getFeild('username','user','user_id',$val['review_by_user']);

        ?>
        <div class="ratingreview">
       <div class="row">
        <aside class="col-sm-9 col-xs-12">
        <div class="ratingtext">
        <h4><?php
          echo $this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
        ?></h4>
            <div class="rating-average">
                <?php
                for($i=1; $i<=5; $i++){
                    if($i <= $val['average']){
                        echo ' <i class="zmdi zmdi-star"></i>';
                    }else{
                        echo ' <i class="zmdi zmdi-star-outline"></i>';
                    }
                }
                ?>

                <span class="average-mark"><?php echo number_format($val['average'], 2); ?></span>
                <?php //var_dump($review)?>
                <span class="rating-date"><?php echo date('d M,Y',strtotime($val['added_date']));?></span>
            </div>
	        <div class="spacer-10"></div>
            <span class="details-more" onclick="toggleRatingInfo('<?php echo $val['project_id']; ?>')">more...</span>
            <div class="rating-detail" data-related-prj="<?php echo $val['project_id']; ?>" style="display: none">
	   <p>
           <span>
            <?php echo __('clientdetails_behaviour','Behaviour')?> :
            </span>
           <span>
               <?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['behaviour']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
           </span>

       </p>

	    <p>

            <span>
		<?php echo __('clientdetails_payment','Payment')?> :
            </span>
            <span>
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['payment']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
            </span>
        </p>

	   <p>
           <span>
		<?php echo __('clientdetails_availability','Availability')?> :
           </span>
           <span>
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['availablity']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
           </span>
       </p>

	   <p>

           <span>
		<?php echo __('clientdetails_communication','Communication')?> :
                          </span>
           <span>
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['communication']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
          </span>

	   </p>

	    <p>

            <span>
		<?php echo __('clientdetails_cooperation','Cooperation')?> :
             </span>
            <span>
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['cooperation']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
            </span>
	   </p>
            </div>

	   <div class="spacer-20"></div>

        <p><?php echo $val['comment'];?></p>
        </div>
        </aside>

		 <aside class="col-sm-3 col-xs-12">
		  <div class="text-right">
            <p><?php echo ucwords( $given_name);?><br />
            <span><?php echo date('d M,Y',strtotime($val['added_date']));?></span></p>
        </div>
		</aside>

        </div>
        </div>
		<hr />
        <!--Rating Review End-->



        <?php
          }
        } else{
             ?>
        <!--Rating Review-->
        <div class="ratingreview">
        	<p class="text-muted"><?php echo __('myprofile_no_review_yet','No Review Yet.'); ?></p>
        </div>
            <?php
        }

        ?>
        </div>

        </article>

    </aside>
    <aside class="col-sm-4 col-xs-12">
	<div class="panel panel-default hidden">
        <div class="panel-heading">
            <h4>Certifications</h4>
        </div>
        <div class="panel-body">
            <a class="btn btn-site btn-block"><?php echo __('talentdetails_emp_get_certificate','Get Certified'); ?></a>
            <br>
            <p><?php echo __('talentdetails_emp_you_do_not_have_any_certificate','You do not have any certifications.'); ?></p>
        </div>
    </div>

    <div class="panel panel-default hidden">
        <div class="panel-heading">
            <h4><?php echo __('talentdetails_emp_my_top_skills','My Top Skills'); ?></h4>
        </div>
        <div class="panel-body" style="padding:0; margin:-1px 0 0">
            <ul class="list-group">
				<?php
				if(!empty($user_skill)){

				foreach($user_skill as $key => $val){
				?>
				<li class="list-group-item"><a href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($val['parent_skill_name']).'/'.$val['parent_skill_id'].'/'.$this->auto_model->getcleanurl($val['skill']).'/'.$val['skill_id'];?>"><?php echo $val['skill'];?></a> <span class="badge hidden">100</span></li>
				<?php
				}
				}else{
				?>
				<li class="list-group-item"><?php echo __('talentdetails_emp_no_skills_found','No Skills found'); ?></li>
				<?php } ?>
            </ul>
        </div>
    </div>
	</aside>
</div>
</div>
</section>
<!-- Content End -->
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="$('#inviteModal').modal('hide');">&times;</span></button> -->
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="window.location.reload()">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('talentdetails_send_a_private_message','Send a private message')?></h4>
    </div>
    <div class="modal-body">
		<?php
			$usr = $this->session->userdata('user');
			$user_project=$this->findtalents_model->getprojects($usr[0]->user_id);

		?>
		<form class="form-horizontal" id="project_invitation_form">
		<input type="hidden" name="freelancer_id" value="<?php echo $user_id;?>"/>
		<input type="hidden" name="employer_id" value="<?php echo $usr[0]->user_id;?>"/>
        <textarea rows="4" name="message" class="form-control" style="margin-bottom:10px"><?php echo __('hi','Hi')?> <?php echo $fname; ?>, <?php echo __('talentdetails_msg_text','I noticed your profile and would like to offer you my project. We can discuss any details over chat')?>.</textarea>



        <select id="choosen_project" class="form-control" style="margin-bottom:10px" name="project_id" onchange="check_project_type();">
		<option value=""><?php echo __('talentdetails_choose_project','Choose project')?></option>
			<?php if(count($user_project) > 0){foreach($user_project as $k => $v){ ?>
				<option value="<?php echo $v['project_id'];?>" data-project-type="<?php echo $v['project_type'];?>"><?php echo $v['title']; ?></option>
			<?php } }  ?>

		</select>
		<input type="hidden" name="project_type" id="project_type" value=""/>
        <div class="clearfix"></div>
        <!--<h5>My Budget (Minimum: <i class="fa fa-inr hide"></i> ₹ 600)</h5>-->

		<div id="invitation_price_type">
			<div class="checkbox radio-inline" style="margin:0; display:none;" id="fixed_rate">
			<input type="radio" class="magic-radio" id="1" checked="">
			<label for="1"> <?php echo __('talentdetails_set_fixed_price','Set Fixed Price')?></label>
			</div>

			<div class="checkbox radio-inline" style="margin:0 ; display:none;" id="hourly_rate">
			<input type="radio" class="magic-radio" id="2" checked="">
			<label for="2"> <?php echo __('talentdetails_set_an_hourly_rate','Set An Hourly Rate')?></label>
			</div>
		</div>
        <div class="spacer-15"></div>

        <div class="form-group row-5">

            <div class="col-sm-7 col-xs-12" id="invitation_amount_fixed" style="display:none;">
            <div class="input-group">
              <span class="input-group-addon"><?php echo CURRENCY?></span>
              <input type="number" class="form-control" name="amount_fixed" value="" style="padding-right:0" placeholder="150" />
              <span class="input-group-addon" style="padding:0; background:none"><select style="height:32px; border:none; padding:0 6px"><option><?php echo CURRENCY?></option></select></span>
            </div>
            </div>

            <div class="col-sm-5 col-xs-12" id="invitation_amount_hourly" style="display:none;">
            <div class="input-group">
            <input type="number" class="form-control" name="amount_hourly" value="" style="padding-right:0" placeholder=" 10"/>
            <span class="input-group-addon"><?php echo CURRENCY?>/<?php echo __('hr','Hr')?></span>
            </div>
            </div>
        </div>

        <div class="checkbox checkbox-inline">
            <input class="magic-checkbox" name="condition" id="confirm" value="Y" type="checkbox">
            <label for="confirm" style="font-size:12px"><?php echo __('talentdetails_send_msg_text_2','Please send me bids from other freelancers if my project is not accepted')?>.</label>
        </div>
        <button type="button" onclick="invite_user();" class="btn btn-success btn-block" style="margin:5px 0"><?php echo __('talentdetails_hire_now','Hire Now')?></button>
        <p style="font-size:12px"><?php echo __('talentdetails_term_cond','By clicking the button, you have read and agree to our Terms &amp; Conditions and Privacy Policy')?>.</p>
		</form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('clientdetails_sidebar_select_your_project_to_invite_freelancer','Select Your project to invite freelancer'); ?></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="freelancer_id" id="freelancer_id" value=""/>
        <div id="allprojects"></div>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        <button type="button" onclick="hdd()" id="sbmt" class="btn btn-primary"><?php echo __('clientdetails_sidebar_invite','Invite'); ?></button>
      </div>
    </div>
  </div>
</div>



<script>

function invite_user(){
	var f = $('#project_invitation_form'),
		fdata = f.serialize();

	if(f.find('select[name="project_id"]').val() != ''){
		$.ajax({
			url : '<?php echo base_url('clientdetails/invite_user');?>',
			data: fdata,
			type: 'POST',
			dataType: 'JSON',
			success: function(res){
				if(res['status'] == 1){
					$('#inviteModal').find('.modal-body').html('<p><?php echo __('clientdetails_invitation_successfully_send','Invitation successfully send')?></p>');
				}
			}
		});
	}else{
		alert('<?php echo __('clientdetails_please_choose_a_project_first','Please choose a project first')?>');
	}
}
function check_project_type(){

	var val = $('#choosen_project').val(),
		p_type = $('#choosen_project :selected').attr('data-project-type');
		$('#project_type').val(p_type);
		if(p_type == 'H'){
			$('#invitation_price_type').find('#fixed_rate').hide();
			$('#invitation_price_type').find('#hourly_rate').show();
			$('#invitation_amount_fixed').hide();
			$('#invitation_amount_hourly').show();
		}else{
			$('#invitation_price_type').find('#fixed_rate').show();
			$('#invitation_price_type').find('#hourly_rate').hide();
			$('#invitation_amount_fixed').show();
			$('#invitation_amount_hourly').hide();
		}
}


function setProject(user_id,project_user)
{
	//alert(user_id+' '+project_user);
	jQuery("#freelancer_id").val(user_id);
	var datastring="user_id="+project_user;
	jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/getProject",
		success:function(return_data){
			//alert(return_data);
				if(return_data!=0)
				{
					jQuery("#allprojects").html('');
					jQuery("#allprojects").html(return_data);
					jQuery("#sbmt").show();
				}
				else
				{
					jQuery("#allprojects").html('<b><?php echo __('clientdetails_sidebar_you_dont_have_any_open_projects_to_invite','You dont have any open projects to invite'); ?></b>');
					jQuery("#sbmt").hide();
				}
			}
		});
}
function hdd()
{
	var free_id=jQuery("#freelancer_id").val();
	var project_id=jQuery(".prjct").val();
	var page='clientdetails';
	window.location.href='<?php echo VPATH;?>invitetalents/invitefreelancer/'+free_id+'/'+project_id+'/'+'/'+page+'/';
}
/*
function setProject2(user_id,project_user)
{
	//alert(user_id+' '+project_user);
	jQuery("#freelancer_id2").val(user_id);
	var datastring="user_id="+project_user;
	jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/getProject",
		success:function(return_data){
			//alert(return_data);
				if(return_data!=0)
				{
					jQuery("#allprojects2").html('');	
					jQuery("#allprojects2").html(return_data);
					jQuery("#sbmt2").show();
				}
				else
				{
					jQuery("#allprojects2").html('<b>You dont have any open projects to invite</b>');	
					jQuery("#sbmt2").hide();	
				}
			}
		});
}
*/
function hdd2()
{
	var free_id=jQuery("#freelancer_id2").val();
	var project_id=jQuery(".prjct").val();
	var message=jQuery("#msg_details").val();
	if(message=='')
	{
		jQuery("#detailsError").css("display", "block");
		setTimeout( "jQuery('#detailsError').hide();",3000 );
	}
	else
	{
		var datastring="freelancer_id="+free_id+"&projects_id="+project_id+"&message="+message;
		jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/sendMessagenew",
		success:function(return_data){
			window.location.href='<?php echo VPATH;?>clientdetails/showdetails/'+free_id+'/';
			}
		});
		//window.location.href='<?php echo VPATH;?>clientdetails/sendMessage/'+free_id+'/'+project_id+'/'+'/'+encodeURI(message)+'/';
	}
}
</script>


<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="portfolioModal" tabindex="-1" role="dialog" aria-labelledby="portmyModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#portfolioModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="portmyModalLabel"><?php echo $val['title'];?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <img src="<?php echo ASSETS;?>portfolio/Hydrangeas.jpg" alt="" class="img-responsive" id="port_big_img" style="width:100%;">
            </div>
            <div class="col-sm-4 col-xs-12">
            <div class="profile_pic pic-sm">
              <span>
                <?php

                if($logo!='' && file_exists('assets/uploaded/cropped_'.$logo))

                {

                ?>
                <img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo 'cropped_'.$logo;?>"  class="img-circle">
                <?php

                }

                else

                {

                ?>
                <img alt="" src="<?php echo VPATH;?>assets/images/face_icon.gif"  class="img-circle">
                <?php } ?>
                </span>
            </div>
        	<div class="pull-left">
			<?php
			   $flag=$this->auto_model->getFeild("code2","country","Code",$country);
			   $flag=  strtolower($flag).".png";
			   // echo $city.", ".$country;
			   if(is_numeric($city)){
				   $city = getField('Name', 'city', 'ID', $city);
			   }
			   $c = getField('Name', 'country', 'Code',$country);
			?>

            	<h4><?php echo $fname." ".$lname;?></h4>
                <p><img src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>" alt=""> &nbsp;<span><?php echo (is_numeric($city)) ? getField('Name', 'city', 'ID', $city) : $city ; ?>,</span> <?php echo $c; ?></p>
            </div>

			<?php if($account_type == 'F'){ ?>
            <a href="#" onclick="$('#portfolioModal').modal('hide');" data-target="#inviteModal" data-toggle="modal" class="btn btn-site btn-lg btn-block"><i class="zmdi zmdi-account"></i> Hire</a>
			<?php } ?>
            <div class="spacer-10"></div>
            <p class="hidden"><b><?php echo __('clientdetails_sidebar_hourly_rate','Hourly Rate'); ?>:</b> <?php echo CURRENCY;?><?php echo $rate;?></p>
            <h5><?php echo __('clientdetails_about_the_project','About the project'); ?></h5>
            <ul class="skills hidden">
                <li><a href="#">Graphic Design</a></li>
            </ul>
            <p id="port_dscr"><?php echo $val['description'];?>.</p>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.show_big').click(function(e){
			var img = $(this).attr('data-image');
			var dscr = $(this).find('p.port_dscr').text();
			var title =  $(this).find('h5.port_title').text();
			$('#port_big_img').attr('src' , img);
			$('#port_dscr').html(dscr);
			$('#portmyModalLabel').html(title);
		});
	});

    function toggleRatingInfo(e){
        $('.rating-detail[data-related-prj="'+e+'"]').toggle('slow');
    }

</script>