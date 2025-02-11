
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>
<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script>
<?php echo $breadcrumb; ?> 
<section id="mainpage">
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
	<?php $this->load->view('dashboard/dashboard-left'); ?>
</div>
<div class="col-md-10 col-sm-9 col-xs-12"> 
    <div class="row">
    <aside class="col-md-9 col-xs-12">

    <!-- Nav tabs -->
    <?php $this->load->view('freelancer_tab'); ?>
    
    <!-- Tab panes -->
    <div class="tab-content">    
    <div role="tabpanel" class="tab-pane active" id="overview">
    
        <?php if(!$is_scheduled){ ?>
        
        <div class="row">
        
        <?php if($is_requested){ 
        $status = '';
        switch($request['status']){
            case 'P' : 
            $status = '<span class="grey-text">'.__('pending','Pending').'</span>';
            break;
            
            case 'A' : 
            $status = '<span class="green-text">'.__('approved','Approved').'</span>';
            break;
            
            case 'R' : 
            $status = '<span class="red-text">'.__('rejected','Rejected').'</span>';
            break;
        }
        ?>
            <div class="col-sm-12">
            <h4><?php echo __('request','Request')?></h4>
            <table class="table table-responsive">
            <tbody>
                <tr>
                   <td><?php echo __('projectdashboard_you_have_requested_to_start_this_project_on','You have requested to start this project on')?> <b><?php echo date('d M , Y', strtotime($request['start_date']));?></b> </td>
                   <td><?php echo $status; ?></td>
                   <td><?php if($request['status'] == 'P' || $request['status'] == 'R'){ ?><a href="javascript:void(0)" class="btn btn-xs btn-site" onclick="$('#request_form_wrapper').removeClass('hidden');"><?php echo __('edit','Edit')?></a><?php } ?></td>
                </tr>    
            </tbody>
            </table>
            </div>
        <?php } ?>
        
        <div class="<?php echo $is_requested ? 'hidden' : '';?>" id="request_form_wrapper">
        <article class="col-sm-5 col-xs-12">
            <h4><?php echo __('projectdashboard_when_would_you_like_to_start_the_project','When would you like to start the project?')?></h4>
            <form class="form-horizontal" onsubmit="requestDate(this, event)" action="<?php echo base_url('projectdashboard_new/request_date_ajax'); ?>">
            <div class="form-group">
            <div class="col-xs-12">
                <div class='input-group datepicker'>
                <input type='text' class="form-control" id="datepicker_from" name="start_date" size="15" value="<?php echo !empty($request['start_date']) ? $request['start_date'] : ''; ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <textarea rows="4" class="form-control" placeholder="<?php echo __('comments','Comments')?>" name="comment"><?php echo !empty($request['comment']) ? $request['comment'] : ''; ?></textarea>
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>
                    <input type="hidden" name="request_id" value="<?php echo !empty($request['request_id']) ? $request['request_id'] : ''; ?>"/>
                </div>
            </div>
            
            <button class="btn btn-site"><?php echo __('send_request','Send Request')?></button>
            </form>
        </article>
        <article class="col-sm-7 col-xs-12">
            <h4>&nbsp;</h4>
            <div class="alert alert-info text-left">        	
                <h4><?php echo __('about_job','About Job')?></h4>
                <p><?php echo !empty($project_detail['description']) ? $project_detail['description'] : '' ; ?></p>
            </div>
        </article>
        </div>
        
        </div>
        <?php }else{  
            $is_project_running = 1;
        ?>
        
        <?php if($project_schedule['is_project_start'] == 0){ $is_project_running = 0; ?>
            <div class="alert alert-info">        	
                <p><?php echo __('projectdashboard_the_project_will_be_started_on','The project will be started on')?>: <?php echo date('d M , Y', strtotime($project_schedule['project_start_date']));?></p>            
            </div>
        <?php } ?>
        
        <?php if(($project_schedule['is_project_paused'] == 1) && ($project_schedule['is_contract_end'] == 0)){ $is_project_running = 0; ?>
            <div class="alert alert-info">        	
                <p><?php echo __('projectdashboard_this_project_is_paused_for_now','This project is paused for now')?></p>
            </div>
        <?php } ?>
        
        <?php if($project_schedule['is_contract_end'] == 1){ $is_project_running = 0; ?>
            <div class="alert alert-info">        	
                <p><?php echo __('projectdashboard_contract_ended','Contract Ended')?></p>            
            </div>
        <?php } ?>
        
        <?php if($is_project_running == 1){ ?>
        
        <!-- Everyting is OK -->
        
        <?php if($project_detail['status'] == 'PS'){ ?>
            <div class="alert alert-warning">        	
                <p><?php echo __('projectdashboard_this_project_is_paused_for_now','Project is paused for now.')?></p>            
            </div>
        <?php } ?>
        
        <?php if($project_detail['status'] == 'C'){ ?>
            <div class="alert alert-warning">        	
                <p><?php echo __('projectdashboard_project_completed_and_is_being_closed','Project Completed and is being closed')?></p>            
            </div>
        <?php } ?>
        
        <?php if($project_detail['status'] == 'S'){ ?>
            <div class="alert alert-warning">        	
                <p><?php echo __('projectdashboard_project_stop_because_employer_does_not_have_enough_balance_in_the_deposit','Project Stop because employer does not have enough balance in the deposit')?></p>            
            </div>
        <?php } ?>
        
        
        
        <?php } ?>
        
        
        
        <div class="row">
            <div class="col-sm-6">
            <h4><?php echo __('summary','Summary')?></h4>
                <?php
                    $total_deposit = get_project_deposit($project_id);
                    $total_release = get_project_release_fund($project_id);
                    $total_pending = get_project_pending_fund($project_id);
                    $remaining_bal = $total_deposit - $total_release - $total_pending;
                ?>
                <ul class="list-group">
                    <li class="list-group-item"><?php echo __('projectdashboard_total_deposited_amount','Total Deposited Amount')?> <span class="badge pull-right"><?php echo CURRENCY.$total_deposit; ?></span></li>
                    <li class="list-group-item"><?php echo __('projectdashboard_total_fund_release','Total Fund Release')?> <span class="badge pull-right"><?php echo CURRENCY.$total_release; ?></span></li>
                    <li class="list-group-item"><?php echo __('projectdashboard_total_fund_pending','Total Fund Pending')?> <span class="badge pull-right"><?php echo CURRENCY.$total_pending; ?></span></li>
                    <li class="list-group-item"><b><?php echo __('projectdashboard_remaining_balance','Remaining Balance')?> </b><span class="badge pull-right"><?php echo CURRENCY.$remaining_bal; ?></span></li>
                </ul>
            </div>
            <div class="col-sm-6">
                
                <?php if($project_schedule['manual_request_enable'] == 1){ ?>
            
                <h4><?php echo __('projectdashboard_project_activity','Project Activity')?>: </h4>
                <?php 
                $f_id = $user_id;
                $activity =$this->db->select('a.*,au.approved')->from('project_activity a')->join('project_activity_user au', 'au.activity_id=a.id', 'INNER')->where("a.project_id = '{$project_detail['project_id']}' AND au.assigned_to = '$f_id'")->get()->result_array();
                ?>
                <ul class="list-group activityLOG" style="overflow: visible;">
                    <?php if(count($activity) > 0){foreach($activity as $k => $v){ ?>
                    <li class="list-group-item" style="width:100%;text-align:left; padding:10px;"><?php echo $v['task']; ?>
                    <a href="javascript:void(0)" class="pull-right" rel="infopop" data-toggle="popover" title="Description" data-placement="left" data-content="<?php echo !empty($v['desc']) ? $v['desc'] : __('n/a','N/A'); ?>"><i class="fa fa-lg fa-info-circle"></i></a>
                    <?php if($v['approved'] == 'N'){ ?>
                        <a href="<?php echo base_url('projectdashboard/approve_activity/'.$v['id']).'?next=projectdashboard_new/freelancer/overview/'.$project_detail['project_id'].'&project='.$project_detail['project_id'];?>" class="pull-right" style="padding: 0px 8px;"><?php echo __('approved','Approve')?></a>
                        
                        <a href="<?php echo base_url('projectdashboard/deny_activity/'.$v['id']).'?next=projectdashboard_new/freelancer/overview/'.$project_detail['project_id'].'&project='.$project_detail['project_id'];?>" class="pull-right" style="padding: 0px 8px;"><?php echo __('deny','Deny')?></a>
                        
                    <?php }else{ ?>
                        <span class="pull-right" style="padding: 0px 8px;"><i class="zmdi zmdi-thumb-up"></i></span>
                    <?php } ?>
                    </li>
                    <?php } }else{ ?>
                        <div class="whiteBg" style="padding:10px 15px"><?php echo __('no_activity','No activity')?> </div>
                    <?php  } ?>
                </ul>
                <?php } ?>
            </div>
        </div>
        
        <h4><?php echo __('Employer','Employer')?></h4>
            <?php
            $work_status = $project_status = '' ;
            $allow_action = true;
            $employer_fname = getField('fname', 'user', 'user_id', $project_detail['user_id']);
            $employer_lname = getField('lname', 'user', 'user_id', $project_detail['user_id']);
            $employer_name = $employer_fname.' '.$employer_lname;
            if(!empty($project_schedule)){
                
                if($project_schedule['is_project_start'] == 0){
                    $work_status = '<span class="orange-text">'.__('pending','Pending').'</span>';
                    $allow_action = false;
                }
                
                if($project_schedule['is_project_start'] == 1){
                    $work_status = '<span class="green-text">'.__('active','Active').'</span>';
                }
                
                if($project_schedule['is_project_paused'] == 1){
                    $work_status = '<span class="orange-text">'.__('paused','Paused').'</span>';
                    $allow_action = false;
                }
                
                if($project_schedule['is_contract_end'] == 1){
                    $work_status = '<span class="red-text">'.__('ended','Ended').'</span>';
                    $allow_action = false;
                }
            }
            
            if(!empty($project_detail)){
                if($project_detail['status'] == 'P'){
                    $project_status = '<span class="green-text">'.__('active','Active').'</span>';
                }
                
                if($project_detail['status'] == 'PS'){
                    $project_status = '<span class="orange-text">'.__('paused','Paused').'</span>';
                    $allow_action = false;
                }
                
                if($project_detail['status'] == 'C'){
                    $project_status = '<span class="red-text">'.__('completed','Completed').'</span>';
                    $allow_action = false;
                }
                
                
            }
            
            $employer_public_feedback = $employer_given_public_feedback = $employer_given_private_feedback = array();
            
            /* if(!empty($feedback['private'][$v['freelancer_id']])){
                $freelancer_private_feedback = $feedback['private'][$v['freelancer_id']];
            } */
            
            $is_employer_feedback_done = false;
            
            if(!empty($feedback['public'][$user_id.'|'.$project_detail['user_id']])){
                $employer_public_feedback = $feedback['public'][$user_id.'|'.$project_detail['user_id']];
            }
            
            if(!empty($feedback['public'][$project_detail['user_id'].'|'.$user_id])){
                $employer_given_public_feedback =$feedback['public'][$project_detail['user_id'].'|'.$user_id];
                $is_employer_feedback_done=true;
            }
            
            if(!empty($feedback['private'][$project_detail['user_id'].'|'.$user_id])){
                $employer_given_private_feedback =$feedback['private'][$project_detail['user_id'].'|'.$user_id];
                $is_employer_feedback_done=true;
            }
            
            
            ?>
            <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                    <th><?php echo __('Employer','Employer')?> </th><th><?php echo __('request','Requests')?></th><th><?php echo __('projectdashboard_sectop_project_status','Project Status')?></th> <th><?php echo __('work_status','Work Status')?></th><th><?php echo __('action','Action')?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                   <td><?php echo $employer_detail['fname']; ?></td>
                   <td>
                    <?php if($is_employer_feedback_done){ ?>
                        <a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($employer_given_public_feedback); ?>' data-private-feedback='<?php echo json_encode($employer_given_private_feedback); ?>' data-name="<?php echo $employer_name; ?>"><?php echo __('projectdashboard_view_employer_feedback','View Employer Feedback')?></a>
                    <?php }else{ echo ' - ';} ?>
                   </td>
                   <td><?php echo $project_status; ?></td>
                   <td><?php echo $work_status; ?></td>
                   <td>
                    <?php if($allow_action){ ?>
                    <a href="<?php echo base_url('message/browse/'.$project_id.'/'.$project_detail['user_id']); ?>"><i class="zmdi zmdi-email-open zmdi-18x"></i></a>
                    <?php } ?>
                    
                    <?php if($project_schedule['is_contract_end'] == 1){ ?>
                        
                        <?php if(!empty($employer_public_feedback)){ ?>
                        <a href="javascript:void(0);" title="<?php echo __('update_feedback','Update Feedback')?>" onclick="updateFeedback(this)" data-employer-id="<?php echo $project_detail['user_id']; ?>" data-name="<?php echo $employer_name; ?>" data-public-feedback='<?php echo json_encode($employer_public_feedback);?>'><i class="zmdi zmdi-star zmdi-18x"></i></a>
                        <?php }else{ ?>
                            <a href="javascript:void(0);" title="<?php echo __('given_feedback','Given Feedback')?>" onclick="newFeedbackOpen(this)" data-employer-id="<?php echo $project_detail['user_id']; ?>" data-name="<?php echo $employer_name; ?>"><i class="zmdi zmdi-star zmdi-18x"></i></a>
                        <?php } ?>
                    <?php } ?>
                   </td>
                </tr>
                
            </tbody>
            </table>
            </div>
            
        
        <!--/ -->
        
        
        
        <?php } ?>
        
            
    </div>        
    </div>    
    </aside>
    <aside class="col-md-3 col-xs-12">
        <?php $this->load->view('right-section'); ?>
    </aside>
    </div>
</div>
</div>
</div>
</section>


<!-- modal -->

<!-- End Contract Modal -->
<div class="modal fade" id="readReviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	 <div class="modal-header">
        <button type="button" class="close" onclick="$('#readReviewModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Feedback By Vk Bishu</h4>
      </div>
      <div class="modal-body" style="background-color:#f5f5f5">
		<div class="feedback" id="private_feedback_readonly_box">
		 <h4><?php echo __('projectdashboard_private_feedback','Private Feedback'); ?></h4>
		 <div class="row">
			<div class="col-sm-6"><?php echo __('projectdashboard_reason_for_ending_contract','Reason for ending contract'); ?></div>
			<div class="col-sm-6"><span id="reason_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6"><?php echo __('projectdashboard_recommend_to_friend','Recommend to friend'); ?></div>
			<div class="col-sm-6"><span id="recommend_to_friend_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6"><?php echo __('projectdashboard_your_strength','Your strength'); ?></div>
			<div class="col-sm-6"><span id="strength_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6"><?php echo __('projectdashboard_english_proficiency','English proficiency'); ?></div>
			<div class="col-sm-6"><span id="english_proficiency_readonly"></span></div>
		 </div>
		 
		</div>
		
		<div class="feedback" id="public_feedback_readonly_box">
        <h4><?php echo __('projectdashboard_public_feedback','Public Feedback'); ?></h4>
        <div class="form-group">
        <div class="col-xs-12">
        <div class='rating-widget'>
          <div class='rating-stars'>  
			<table class="table-rating">
				<tr>
					<td><div id="rating_skills_readonly"></div></td>
					<td><?php echo __('projectdashboard_Skills','Skills'); ?></td>
				</tr>
				<tr>
					<td><div id="rating_quality_readonly"></div></td>
					<td><?php echo __('projectdashboard_Quality_of_works','Quality of works'); ?></td>
				</tr>
				<tr>
					<td><div id="rating_availablity_readonly"></div></td>
					<td><?php echo __('projectdashboard_Availability','Availability'); ?></td>
				</tr>
				<tr>
					<td><div id="rating_communication_readonly"></div></td>
					<td><?php echo __('projectdashboard_Communication','Communication'); ?></td>
				</tr>
				<tr>
					<td><div id="rating_cooperation_readonly"></div></td>
					<td><?php echo __('projectdashboard_Cooperation','Cooperation'); ?></td>
				</tr>
			</table>
			
          </div>
	   </div>
		</div>
        </div>
		
		<div class="clearfix"></div>
		
        <div class="form-group">
        <div class="col-xs-12">
			<div id="comment_readonly"></div>
        </div>
        </div>
        
        </div>
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="$('#readReviewModal').modal('hide');"><?php echo __('close','Close')?></button>
      </div>
	
    </div>
  </div>
</div>



<!-- End Contract Modal -->
<div class="modal fade" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	
	 <form class="form-horizontal" onsubmit="submitEndContractForm(this, event)" action="<?php echo base_url('projectdashboard_new/end_contract')?>" id="endContractForm">
		
		<input type="hidden" name="employer_id" value="<?php echo $project_detail['user_id']; ?>"/>
		<input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>

	 <div class="modal-header">
        <button type="button" class="close" onclick="$('#contractModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">End contract with VK Bishu </h4>
      </div>
      <div class="modal-body" style="background-color:#f5f5f5">
		<p><?php echo __('projectdashboard_share_your_experience','Share your experience'); ?></p>
        <div class="feedback">
        <h4><?php echo __('projectdashboard_public_feedback','Public Feedback'); ?></h4>
        <h6><?php echo __('projectdashboard_this_feedback_share_worldwide','This feedback share worldwide'); ?></h6>
        <div class="form-group">
        <div class="col-xs-12">
        <label><?php echo __('projectdashboard_feedback_to_employer','Feedback to Employer'); ?></label>        
        <div class='rating-widget'>
          <div class='rating-stars'>  
			<table class="table-rating">
				<tr>
					<td><div id="rating_behaviour"></div></td>
					<td><?php echo __('projectdashboard_Behavior','Behavior'); ?></td>
				</tr>
				<tr>
					<td><div id="rating_payment"></div></td>
					<td><?php echo __('projectdashboard_Payment','Payment'); ?></td>
				</tr>
				<tr>
					<td><div id="rating_availablity"></div></td>
					<td><?php echo __('projectdashboard_Availability','Availability'); ?></td>
				</tr>
				<tr>
					<td><div id="rating_communication"></div></td>
					<td><?php echo __('projectdashboard_Communication','Communication'); ?></td>
				</tr>
				<tr>
					<td><div id="rating_cooperation"></div></td>
					<td><?php echo __('projectdashboard_Cooperation','Cooperation'); ?></td>
				</tr>
			</table>
			
            
			<input type="hidden" name="public[behaviour]" value="0" id="rating_behaviour_input"/>
			<input type="hidden" name="public[payment]" value="0" id="rating_payment_input"/>
			<input type="hidden" name="public[availablity]" value="0" id="rating_availablity_input"/>
			<input type="hidden" name="public[communication]" value="0" id="rating_communication_input"/>
			<input type="hidden" name="public[cooperation]" value="0" id="rating_cooperation_input"/>
			<input type="hidden" name="public[average]" value="0" id="rating_average_input"/>
          </div>
	   </div>
		
        <h4><?php echo __('projectdashboard_total_score','Total Score'); ?>: <span id="avg_rating_view">0</span></h4>
		
		<div id="review_id_field"></div>
		<div id="feedback_id_field"></div>
		
        </div>
        </div>
        <div class="form-group">
        <div class="col-xs-12">
        <label><?php echo __('comments','Comments'); ?>:</label>
        <textarea rows="4" class="form-control"  name="public[comment]" placeholder="<?php echo __('projectdashboard_type_your_comment_here','Type your comment here')?>..."></textarea>
        </div>
        </div>
        
		<div id="freelancer_payment_end"></div>
		
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="$('#contractModal').modal('hide');"><?php echo __('cancel','Cancel')?></button>
        <button type="submit" class="btn btn-site"><?php echo __('end_contract','End Contract')?></button>
      </div>
	</form>
    </div>
  </div>
</div>

<script>
 $(function () {
	 
	$("#rating_behaviour").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_behaviour_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_payment").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_payment_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_availablity").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_availablity_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_communication").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_communication_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_cooperation").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_cooperation_input').val(rating);
			check_total_rating();
		}
	});
	
	/* read only star */
	
	$("#rating_skills_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
	});
	
	$("#rating_quality_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_availablity_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_communication_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_cooperation_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$('.activityLOG').popover({
		 selector: '[rel=infopop]',
         trigger: "click",
		}).on("show.bs.popover", function(e){
		$("[rel=infopop]").not(e.target).popover("destroy");
		$(".popover").remove();                    
	});
	

});
 </script>


<script type="text/javascript">

function check_total_rating(){
	var rating_behaviour_input = parseInt($('#rating_behaviour_input').val());
	var rating_payment_input = parseInt($('#rating_payment_input').val());
	var rating_availablity_input = parseInt($('#rating_availablity_input').val());
	var rating_communication_input = parseInt($('#rating_communication_input').val());
	var rating_cooperation_input = parseInt($('#rating_cooperation_input').val());
	
	var avg = ((rating_behaviour_input + rating_payment_input + rating_availablity_input + rating_communication_input + rating_cooperation_input) / 5); 
	$('#rating_average_input').val(avg);
	$('#avg_rating_view').html(avg);
}


function requestDate(f, e){
	
	$(f).find('button').attr('disabled', 'disabled');
	
	ajaxSubmit(f, e , function(res){
		if(res.status == 1){
			location.reload();
		}
		$(f).find('button').removeAttr('disabled');
	});
}


function ajaxSubmit(f, e , callback){
	
	$('.invalid').removeClass('invalid');
	e.preventDefault();
	var fdata = $(f).serialize();
	var url = $(f).attr('action');
	$.ajax({
		url : url,
		data: fdata,
		dataType: 'json',
		type: 'POST',
		success: function(res){
			if(res.errors){
				for(var i in res.errors){
					i = i.replace('[]', '');
					$('[name="'+i+'"]').addClass('invalid');
					$('#'+i+'Error').html(res.errors[i]);
				}
				
				var offset = $('.invalid:first').offset();
				
				if(offset){
					$('html, body').animate({
						scrollTop: offset.top
					});
				}
				
				
			}
			
			if(typeof callback == 'function'){
				callback(res);
			}
		}
	});
}

function newFeedbackOpen(ele){
	var f_id = $(ele).data('employerId');
	var name = $(ele).data('name');
	
	//$('#endContractForm').find('[name="employer_id"]').val(f_id);
	$('#endContractForm').find('button[type="submit"]').html('<?php echo __('projectdashboard_submit_feedback','Submit Feedback')?>');
	$('#endContractForm').attr('action', '<?php echo base_url('projectdashboard_new/update_review_employer')?>');
	
	$('#contractModal').find('.modal-title').html('<?php echo __('projectdashboard_give_feedback_to','Give feedback to')?> ' + name);
	$('#contractModal').modal('show');
	
	resetPublicData();
}

function updateFeedback(ele){
	var f_id = $(ele).data('employerId');
	var name = $(ele).data('name');
	
	var public_feedback = $(ele).data('publicFeedback');

	if(public_feedback){
		setPublicData(public_feedback);
	}
	
	//$('#endContractForm').find('[name="freelancer_id"]').val(f_id);
	$('#endContractForm').find('button[type="submit"]').html('<?php echo __('update_feedback','Update Feedback')?>');
	$('#endContractForm').attr('action', '<?php echo base_url('projectdashboard_new/update_review_employer')?>');
	
	$('#contractModal').find('.modal-title').html('<?php echo __('update_feedback','Update Feedback')?> <?php echo __('of','of')?> ' + name);
	$('#contractModal').modal('show');
}

function setPublicData(data){
	
	var f = $('#endContractForm');
	var review_id = data.review_id;
	
	$('#review_id_field').html('<input type="hidden" name="review_id" value="'+review_id+'"/>');
	
	f.find('[name="public[behaviour]"]').val(data.behaviour);
	f.find('[name="public[payment]"]').val(data.payment);
	f.find('[name="public[availablity]"]').val(data.availablity);
	f.find('[name="public[communication]"]').val(data.communication);
	f.find('[name="public[cooperation]"]').val(data.cooperation);
	f.find('[name="public[average]"]').val(data.average);
	f.find('[name="public[comment]"]').val(data.comment);
	
	$("#rating_behaviour").rateYo("rating", data.behaviour);
	$("#rating_payment").rateYo("rating", data.payment);
	$("#rating_availablity").rateYo("rating", data.availablity);
	$("#rating_communication").rateYo("rating", data.communication);
	$("#rating_cooperation").rateYo("rating", data.cooperation);
	
}

function resetPublicData(){
	var f = $('#endContractForm');
	
	$('#review_id_field').html('');
	
	f.find('[name="public[behaviour]"]').val(0);
	f.find('[name="public[payment]"]').val(0);
	f.find('[name="public[availablity]"]').val(0);
	f.find('[name="public[communication]"]').val(0);
	f.find('[name="public[cooperation]"]').val(0);
	f.find('[name="public[average]"]').val(0);
	f.find('[name="public[comment]"]').val('');
	
	$("#rating_behaviour").rateYo("rating", 0);
	$("#rating_payment").rateYo("rating", 0);
	$("#rating_availablity").rateYo("rating", 0);
	$("#rating_communication").rateYo("rating", 0);
	$("#rating_cooperation").rateYo("rating", 0);
}

function submitEndContractForm(f , e){
	ajaxSubmit(f , e , function(res){
		if(res.status == 1){
			location.reload();
		}
	});
}

function ReadFeedback(ele){
	
	<?php
		$this->config->load('rating_reviews', TRUE);
		$reason = $this->config->item('reason', 'rating_reviews');
		$strength = $this->config->item('strength', 'rating_reviews');
		$english_proficiency = $this->config->item('english_proficiency', 'rating_reviews');
		$reason_arr = $strength_arr = $english_proficiency_arr = array();
		if(count($reason) > 0){
			foreach($reason as $k => $v){
				$reason_arr[$v['val']] = $v['text'];
			}
		}
		
		if(count($strength) > 0){
			foreach($strength as $k => $v){
				$strength_arr[$v['val']] = $v['text'];
			}
		}
		
		if(count($english_proficiency) > 0){
			foreach($english_proficiency as $k => $v){
				$english_proficiency_arr[$v['val']] = $v['text'];
			}
		}
	?>
	
	var reason , strength , english_proficiency;
	reason = <?php echo json_encode($reason_arr);?>;
	strength = <?php echo json_encode($strength_arr);?>;
	english_proficiency = <?php echo json_encode($english_proficiency_arr);?>;
	
	var public_feedback = $(ele).data('publicFeedback');
	var private_feedback = $(ele).data('privateFeedback');
	var name = $(ele).data('name');
	
	if(reason[private_feedback.reason]){
		$('#private_feedback_readonly_box').find('#reason_readonly').html(reason[private_feedback.reason]);
	}else{
		$('#private_feedback_readonly_box').find('#reason_readonly').html('');
	}
	
	if(english_proficiency[private_feedback.english_proficiency]){
		$('#private_feedback_readonly_box').find('#english_proficiency_readonly').html(english_proficiency[private_feedback.english_proficiency]);
	}else{
		$('#private_feedback_readonly_box').find('#english_proficiency_readonly').html('');
	}
	
	
	if(private_feedback.strength){
		
		var strength_text_arr = [];
		var strength_arr = JSON.parse(private_feedback.strength);
	
		for(var i=0; i<strength_arr.length;i++){
			var st_txt = strength[strength_arr[i]] || '';
			
			strength_text_arr.push(st_txt);
		}
		
		$('#private_feedback_readonly_box').find('#strength_readonly').html(strength_text_arr.join(', '));
		console.log(strength_text_arr.join(','));
		console.log(strength_text_arr);
		
	}else{
		$('#private_feedback_readonly_box').find('#strength_readonly').html('');
	}
	
	$('#private_feedback_readonly_box').find('#recommend_to_friend_readonly').html(private_feedback.recommend_to_friend);
	
	
	
	$("#rating_skills_readonly").rateYo("rating", public_feedback.skills);
	$("#rating_quality_readonly").rateYo("rating", public_feedback.quality_of_work);
	$("#rating_availablity_readonly").rateYo("rating", public_feedback.availablity);
	$("#rating_communication_readonly").rateYo("rating", public_feedback.communication);
	$("#rating_cooperation_readonly").rateYo("rating", public_feedback.cooperation);
	$('#comment_readonly').html(public_feedback.comment);
	$('#readReviewModal').find('.modal-title').html('<?php echo __('feedback_by','Feedback by')?> ' +  name);
	$('#readReviewModal').modal('show');
	
}


</script>