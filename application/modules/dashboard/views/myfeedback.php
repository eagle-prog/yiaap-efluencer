<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>
<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script>
<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>
<section id="mainpage">
<div class="container-fluid">
<div class="row">

<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard-left'); ?>
</div> 
<!-- Sidebar End -->
<div class="col-md-10 col-sm-9 col-xs-12">
<h4><?php echo __('dashboard_feedback','Feedback')?></h4>

<div class="" id="editprofile">
<div class="table-responsive">
<table class="table table-dashboard">
<thead>
	<tr>
	<th><?php echo __('date','Date')?></th><th><?php echo __('dashboard_project_name','Project name')?></th><th><?php echo __('dashboard_feedback_given_by','Given by')?></th><th><?php echo __('action','Action')?></th>
    </tr>
</thead>
<tbody>
<?php
if(count($allfeedback)>0)
{
foreach($allfeedback as $key=>$val)
{
$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
$username=$this->auto_model->getFeild('username','user','user_id',$val['review_by_user']);
$employer_fname = $this->auto_model->getFeild('fname','user','user_id',$val['review_by_user']);
$employer_lname = $this->auto_model->getFeild('lname','user','user_id',$val['review_by_user']);
$employer_name = $employer_fname.' '.$employer_lname;
$private_feedback = get_row(array('select' => '*', 'from' => 'feedback', 'where' => array('project_id' => $val['project_id'], 'feedback_by_user' => $val['review_by_user'], 'feedback_to_user' => $val['review_to_user'])));

$u_type = getField('account_type','user','user_id',$val['review_by_user']);

?>
<tr>
<td><?php echo date('d M,Y',strtotime($val['added_date']));?></td>
<td><?php echo ucwords($project_name);?></td>
<td><?php echo ucwords($username);?></td>
<td><!--<a href="<?php echo VPATH;?>dashboard/feedbackdetails/<?php echo $val['project_id']?>/<?php echo $val['given_user_id'];?>/<?php echo $project_name;?>">View Feedback</a>--> 

<a href="javascript:void(0)"  onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($val); ?>' data-private-feedback='<?php echo json_encode($private_feedback); ?>' data-user-type="<?php echo $u_type;?>" data-name="<?php echo $employer_name; ?>"><?php echo __('dashboard_view_feedback','View Feedback')?></a>

</td>
</tr>
<?php
}
}
else
{
?>
<tr><td colspan="4"><p class="text-center"><?php echo __('dashboard_no_feedback_to_display','No feedback to display')?></p></td></tr>
<?php
}
?>	 

</tbody>
</table>
</div>
</div>                   

<div class="clearfix"></div>
<?php 

if(isset($ad_page)){ 
$type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
if($type=='A') 
{
$code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
}
else
{
$image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
$url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
}
    
  if($type=='A'&& $code!=""){ 
?>
<div class="addbox2">
<?php 
echo $code;
?>
</div>                      
<?php                      
  }
elseif($type=='B'&& $image!="")
{
?>
    <div class="addbox2">
    <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
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

<!-- View Feedback Modal -->
<div class="modal fade" id="readReviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	 <div class="modal-header">
        <button type="button" class="close" onclick="$('#readReviewModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Feedback By Vk Bishu</h4>
      </div>
      <div class="modal-body" style="background-color:#f5f5f5">
		<div class="feedback" id="private_feedback_readonly_box">
		 <h4><?php echo __('dashboard_feedback_private_feedback','Private Feedback')?></h4>
		 <div class="row">
			<div class="col-sm-6"><?php echo __('dashboard_feedback_reason_for_ending_contract','Reason for ending contract')?></div>
			<div class="col-sm-6"><span id="reason_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6"><?php echo __('dashboard_feedback_recommend_to_friend','Recommend to friend')?></div>
			<div class="col-sm-6"><span id="recommend_to_friend_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6"><?php echo __('dashboard_feedback_your_strength','Your strength')?></div>
			<div class="col-sm-6"><span id="strength_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6"><?php echo __('dashboard_feedback_english_proficiency','English proficiency')?></div>
			<div class="col-sm-6"><span id="english_proficiency_readonly"></span></div>
		 </div>
		 
		</div>
		
		<div class="feedback" id="public_feedback_readonly_box">
        <h4><?php echo __('dashboard_feedback_public_feedback','Public Feedback')?></h4>
        <div class="form-group">
        <div class="col-xs-12">
        <div class='rating-widget'>
          <div class='rating-stars'>  
			<table class="table-rating">
				<tr class="F_show">
					<td><div id="rating_behaviour_readonly"></div></td>
					<td><?php echo __('dashboard_feedback_behavior','Behavior')?></td>
				</tr>
				<tr class="F_show">
					<td><div id="rating_payment_readonly"></div></td>
					<td><?php echo __('dashboard_feedback_payment','Payment')?></td>
				</tr>
				
				<tr class="E_show">
					<td><div id="rating_skills_readonly"></div></td>
					<td><?php echo __('dashboard_feedback_skills','Skills')?></td>
				</tr>
				<tr class="E_show">
					<td><div id="rating_quality_readonly"></div></td>
					<td><?php echo __('dashboard_feedback_quality_of_works','Quality of works')?></td>
				</tr>
				<tr>
					<td><div id="rating_availablity_readonly"></div></td>
					<td><?php echo __('dashboard_feedback_availability','Availability')?></td>
				</tr>
				<tr>
					<td><div id="rating_communication_readonly"></div></td>
					<td><?php echo __('dashboard_feedback_communication','Communication')?></td>
				</tr>
				<tr>
					<td><div id="rating_cooperation_readonly"></div></td>
					<td><?php echo __('dashboard_feedback_cooperation','Cooperation')?></td>
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

 
<script>

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
	var u_type = $(ele).data('userType');
	
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
			console.log(strength_text_arr.join(','));
			console.log(strength_text_arr);
			
		}else{
			$('#private_feedback_readonly_box').find('#strength_readonly').html('');
		}
		
		$('#private_feedback_readonly_box').find('#recommend_to_friend_readonly').html(private_feedback.recommend_to_friend);
		
	}else{
		$('#private_feedback_readonly_box').hide();
	}
	
	if(u_type == 'E'){
		$('.E_show').show();
		$('.F_show').hide();
		$("#rating_skills_readonly").rateYo("rating", public_feedback.skills);
		$("#rating_quality_readonly").rateYo("rating", public_feedback.quality_of_work);
	}else{
		$('.F_show').show();
		$('.E_show').hide();
		$("#rating_behaviour_readonly").rateYo("rating", public_feedback.behaviour);
		$("#rating_payment_readonly").rateYo("rating", public_feedback.payment);
	}

	$("#rating_availablity_readonly").rateYo("rating", public_feedback.availablity);
	$("#rating_communication_readonly").rateYo("rating", public_feedback.communication);
	$("#rating_cooperation_readonly").rateYo("rating", public_feedback.cooperation);
	$('#comment_readonly').html(public_feedback.comment);
	$('#readReviewModal').find('.modal-title').html('<?php echo __('dashboard_feedback_by','Feedback by')?> ' +  name);
	$('#readReviewModal').modal('show');
	
}

</script>                