<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>
<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script>
<!-- End Contract Modal -->
<div class="modal fade" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	
	 <form class="form-horizontal" onsubmit="submitEndContractForm(this, event)" action="<?php echo base_url('projectdashboard_new/end_contract')?>" id="endContractForm">
		
		<input type="hidden" name="freelancer_id" value=""/>
		<input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>

	 <div class="modal-header">
        <button type="button" class="close" onclick="$('#contractModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">End contract with VK Bishu </h4>
      </div>
      <div class="modal-body" style="background-color:#f5f5f5">
		<?php
		$this->config->load('rating_reviews', TRUE);
		$reason = $this->config->item('reason', 'rating_reviews');
		$strength = $this->config->item('strength', 'rating_reviews');
		$english_proficiency = $this->config->item('english_proficiency', 'rating_reviews');
		?>
        <p><?php echo __('projectdashboard_share_your_experience','Share your experience'); ?></p>
        <div class="feedback">
			<h4><?php echo __('projectdashboard_private_feedback','Private Feedback'); ?></h4>
			<h6><?php echo __('projectdashboard_never_share_feedback_directly','Never share feedback directly'); ?></h6>
			<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo __('projectdashboard_reason_for_ending_contract','Reason for ending contract'); ?>:</label>
				<select class="form-control" name="private[reason]">
					<?php if(count($reason) > 0){foreach($reason as $k => $v){ ?>
					<option value="<?php echo $v['val'];?>"><?php echo $v['text'];?></option>
					<?php } } ?>
				</select>
			</div>
			</div>
			<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo __('projectdashboard_how_likely_you_recommended_to_your_friends','How likely you recommended to your friends'); ?>:</label>
				<h6><?php echo __('projectdashboard_very_unlikely','Very Unlikely'); ?> <span class="pull-right"><?php echo __('projectdashboard_very_likely','Very Likely'); ?></span></h6>
				<div class="btn-group btn-group-justified" data-toggle="buttons">
					<?php for($i=1; $i<=10; $i++){ 
					if($i <= 3){
						$class = 'danger';
					}else if($i > 3 && $i <= 7){
						$class = 'warning';
					}else{
						$class = 'success';
					}
					?>
					<label class="btn btn-<?php echo $class; ?>">
					  <input type="radio" name="private[recommend_to_friend]" value="<?php echo $i; ?>"> <?php echo $i; ?> 
					</label>
					<?php } ?>
				  </div>
			</div>        
			</div>
			<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo __('projectdashboard_what_do_you_think_are_their_strengths','What do you think are their strengths?'); ?></label>
				<?php if(count($strength) > 0){foreach($strength as $k => $v){ ?>
				<div class="checkbox checkbox-inline">
					<input type="checkbox" class="magic-checkbox" id="strength_<?php echo $k+1;?>" name="private[strength][]" value="<?php echo $v['val'];?>"/>
					<label for="strength_<?php echo $k+1;?>"><?php echo $v['text'];?></label>
				</div>
				<?php } } ?>
			</div>        
			</div>
			
			<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo __('projectdashboard_rate_their_english_proficiency','Rate their english proficiency'); ?>:</label>
				<?php if(count($english_proficiency) > 0){foreach($english_proficiency as $k => $v){ ?>
				<div class="radio radio-inline">
					<input type="radio" class="magic-radio" name="private[english_proficiency]" id="rate_<?php echo $k+1; ?>" value="<?php echo $v['val'];?>" <?php echo $k == 0 ? 'checked="checked"' : '';?>/>
					<label for="rate_<?php echo $k+1; ?>"><?php echo $v['text'];?></label>
				</div>
				<?php } } ?>
			</div>
			</div>
		</div>   
		
        <div class="feedback">
			<h4><?php echo __('projectdashboard_public_feedback','Public Feedback'); ?></h4>
            <h6><?php echo __('projectdashboard_this_feedback_share_worldwide','This feedback share worldwide'); ?></h6>
        <div class="form-group">
        <div class="col-xs-12">
        <label><?php echo __('projectdashboard_feedback_to_freelancer','Feedback to Freelancer'); ?></label>
        <div class='rating-widget'>
          <div class='rating-stars'>  
			<table class="table-rating">
				<tr>
					<td><div id="rating_skills"></div></td>
					<td><?php echo __('projectdashboard_Skills','Skills'); ?></td>
				  </tr>
				  <tr>
					<td><div id="rating_quality"></div></td>
					<td><?php echo __('projectdashboard_Quality_of_works','Quality of works'); ?></td>
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
			
            
			<input type="hidden" name="public[skills]" value="0" id="rating_skills_input"/>
			<input type="hidden" name="public[quality_of_work]" value="0" id="rating_quality_input"/>
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
        
		<div id="freelancer_payment_endError"></div>
		
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
				  <td><div id="rating_behaviour_readonly"></div></td>
				  <td><?php echo __('projectdashboard_Behavior','Behavior'); ?></td>
				</tr>
				<tr>
				  <td><div id="rating_payment_readonly"></div></td>
				  <td><?php echo __('projectdashboard_Payment','Payment'); ?></td>
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

<script>
 $(function () {
	 
	$("#rating_skills").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_skills_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_quality").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_quality_input').val(rating);
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
	
	$("#rating_behaviour_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
	});
	
	$("#rating_payment_readonly").rateYo({
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
	

});
 </script>

 
<script type="text/javascript">

function check_total_rating(){
	var rating_skills_input = parseInt($('#rating_skills_input').val());
	var rating_quality_input = parseInt($('#rating_quality_input').val());
	var rating_availablity_input = parseInt($('#rating_availablity_input').val());
	var rating_communication_input = parseInt($('#rating_communication_input').val());
	var rating_cooperation_input = parseInt($('#rating_cooperation_input').val());
	
	var avg = ((rating_skills_input + rating_quality_input + rating_availablity_input + rating_communication_input + rating_cooperation_input) / 5); 
	$('#rating_average_input').val(avg);
	$('#avg_rating_view').html(avg);
}

function ajaxSubmit(f, e , callback){
	
	$('.invalid').removeClass('invalid');
	$('.error-bx').empty();
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
					$('#'+i+'Error').html(res.errors[i]).addClass('error-bx');
				}
				
				var offset = $('.invalid:first').offset();
				
				if(offset){
					$('html, body').animate({
						scrollTop: offset.top - 150
					});
				}
				
				
			}
			
			if(typeof callback == 'function'){
				callback(res);
			}
		}
	});
}

function readComment(ele){
	var msg = $(ele).data('msg');
	if(msg == ''){
		msg = '<i>No comments</i>';
	}
	$('#msgModal').find('.modal-body').html('<p>'+msg+'</p>');
	$('#msgModal').modal('show');
	
}

function confirmRequest(req_id, action){
	if(req_id && action){
		$.ajax({
			url : '<?php echo base_url('projectdashboard_new/confirm_request')?>',
			data: {request_id: req_id, action: action},
			dataType: 'json',
			type: 'POST',
			success: function(res){
				if(res.status == 1){
					location.reload();
				}
			}
		});
	}
	
	
}



function submitEndContractForm(f , e){
	ajaxSubmit(f , e , function(res){
		if(res.status == 1){
			location.reload();
		}
	});
}

function endContractOpen(ele){
	var f_id = $(ele).data('freelancerId');
	var name = $(ele).data('name');
	
	$('#endContractForm').find('[name="freelancer_id"]').val(f_id);
	$('#endContractForm').find('button[type="submit"]').html('<?php echo __('end_contract','End contract')?>');
	$('#endContractForm').attr('action', '<?php echo base_url('projectdashboard_new/end_contract')?>');
	
	$('#contractModal').find('.modal-title').html('<?php echo __('end_contract','End contract')?> <?php echo __('with','with')?> ' + name);
	$('#contractModal').modal('show');
	
	resetPrivateData();
	resetPublicData();
}


function updateFeedback(ele){
	var f_id = $(ele).data('freelancerId');
	var name = $(ele).data('name');
	
	var private_feedback = $(ele).data('privateFeedback');
	var public_feedback = $(ele).data('publicFeedback');
	
	if(private_feedback){
		setPrivateData(private_feedback);
	}
	
	if(public_feedback){
		setPublicData(public_feedback);
	}
	
	$('#endContractForm').find('[name="freelancer_id"]').val(f_id);
	$('#endContractForm').find('button[type="submit"]').html('<?php echo __('update_feedback','Update Feedback')?>');
	$('#endContractForm').attr('action', '<?php echo base_url('projectdashboard_new/upateReview')?>');
	
	$('#contractModal').find('.modal-title').html('<?php echo __('update_feedback','Update Feedback')?> <?php echo __('of','of')?> ' + name);
	$('#contractModal').modal('show');
}

function setPrivateData(data){
	var f = $('#endContractForm');
	var strength = data.strength;
	if(strength){
		strength = JSON.parse(strength);
	}else{
		strength = [];
	}
	
	var feedback_id = data.feedback_id;
	
	$('#feedback_id_field').html('<input type="hidden" name="feedback_id" value="'+feedback_id+'"/>');
	
	f.find('[name="private[reason]"]').val(data.reason);
	f.find('[name="private[strength][]"]').val(strength);
	f.find('[name="private[recommend_to_friend]"]').filter('[value="'+data.recommend_to_friend+'"]').attr('checked', 'checked').parent().addClass('active');
	f.find('[name="private[english_proficiency]"]').filter('[value="'+data.english_proficiency+'"]').attr('checked', 'checked');
	
}

function resetPrivateData(){
	var f = $('#endContractForm');
	
	$('#feedback_id_field').html('');
	
	f.find('[name="private[reason]"]').val('');
	f.find('[name="private[strength][]"]').val([]);
	f.find('[name="private[recommend_to_friend]"]').removeAttr('checked').parent().removeClass('active');
	f.find('[name="private[english_proficiency]"]').filter('[value="difficult"]').attr('checked', 'checked');
	
}


function setPublicData(data){
	
	var f = $('#endContractForm');
	var review_id = data.review_id;
	
	$('#review_id_field').html('<input type="hidden" name="review_id" value="'+review_id+'"/>');
	
	f.find('[name="public[skills]"]').val(data.skills);
	f.find('[name="public[quality_of_work]"]').val(data.quality_of_work);
	f.find('[name="public[availablity]"]').val(data.availablity);
	f.find('[name="public[communication]"]').val(data.communication);
	f.find('[name="public[cooperation]"]').val(data.cooperation);
	f.find('[name="public[average]"]').val(data.average);
	f.find('[name="public[comment]"]').val(data.comment);
	
	$("#rating_skills").rateYo("rating", data.skills);
	$("#rating_quality").rateYo("rating", data.quality_of_work);
	$("#rating_availablity").rateYo("rating", data.availablity);
	$("#rating_communication").rateYo("rating", data.communication);
	$("#rating_cooperation").rateYo("rating", data.cooperation);
	
}

function resetPublicData(){
	var f = $('#endContractForm');
	
	$('#review_id_field').html('');
	
	f.find('[name="public[skills]"]').val(0);
	f.find('[name="public[quality_of_work]"]').val(0);
	f.find('[name="public[availablity]"]').val(0);
	f.find('[name="public[communication]"]').val(0);
	f.find('[name="public[cooperation]"]').val(0);
	f.find('[name="public[average]"]').val(0);
	f.find('[name="public[comment]"]').val('');
	
	$("#rating_skills").rateYo("rating", 0);
	$("#rating_quality").rateYo("rating", 0);
	$("#rating_availablity").rateYo("rating", 0);
	$("#rating_communication").rateYo("rating", 0);
	$("#rating_cooperation").rateYo("rating", 0);
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
	
	if(!$.isEmptyObject(private_feedback)){
		
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
			
		
		}else{
			$('#private_feedback_readonly_box').find('#strength_readonly').html('');
		}
		
		$('#private_feedback_readonly_box').find('#recommend_to_friend_readonly').html(private_feedback.recommend_to_friend);
		
	}else{
		$('#private_feedback_readonly_box').hide();
	}
	
	$("#rating_behaviour_readonly").rateYo("rating", public_feedback.behaviour);
	$("#rating_payment_readonly").rateYo("rating", public_feedback.payment);
	$("#rating_availablity_readonly").rateYo("rating", public_feedback.availablity);
	$("#rating_communication_readonly").rateYo("rating", public_feedback.communication);
	$("#rating_cooperation_readonly").rateYo("rating", public_feedback.cooperation);
	$('#comment_readonly').html(public_feedback.comment);
	$('#readReviewModal').find('.modal-title').html('<?php echo __('feedback_by','Feedback by')?> ' +  name);
	$('#readReviewModal').modal('show');
	
}
</script>