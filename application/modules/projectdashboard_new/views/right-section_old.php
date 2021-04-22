<?php
$p_user_image = '';

if($project_user['logo']!=''){
	$p_user_image = base_url('assets/uploaded/'.$project_user['logo']) ;
if(file_exists('assets/uploaded/cropped_'.$project_user['logo'])){
	$p_user_image = base_url('assets/uploaded/cropped_'.$project_user['logo']) ;
}
}else{
	$p_user_image = base_url('assets/images/user.png'); 
}

$this->load->model('jobdetails/jobdetails_model');
$this->load->model('dashboard/dashboard_model');
$user_totalproject = $this->jobdetails_model->gettotaluserproject($project_user['user_id']);
$rating_employer = $this->dashboard_model->getrating_new($project_user['user_id']);
?>

<div class="right_panel panel" id="sticky_panel">
<div class="panel-body">
<div class="profile media">
  <div class="profile_pic media-left">
  	<span><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $project_detail['user_id'];?>"><img src="<?php echo $p_user_image;?>" class="media-object"></a></span>
  </div>

<div class="profile-details media-body">
    <h4><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $project_detail['user_id'];?>"><?php echo !empty($project_user['fname'])? $project_user['fname'].' '.$project_user['lname'] : ''; ?></a></h4>
    <h4>
	<?php
		if($rating_employer[0]['num']>0){
			$avg_rating=$rating_employer[0]['avg']/$rating_employer[0]['num'];
			for($i=1; $i<=5; $i++){
				if($i <= $avg_rating){
					echo '<i class="zmdi zmdi-star"></i>';
				}else{
					echo '<i class="zmdi zmdi-star-outline"></i>';
				}
			}
			
			
		}else{
			echo '<i class="zmdi zmdi-star-outline"></i> <i class="zmdi zmdi-star-outline"></i> <i class="zmdi zmdi-star-outline"></i> <i class="zmdi zmdi-star-outline"></i> <i class="zmdi zmdi-star-outline"></i>';
		
		}
		?>
    </h4>
	
    <p><img src="<?php echo ASSETS;?>images/cuntryflag/<?php echo !empty($cityCountry['Code2'])? strtolower($cityCountry['Code2']) : ''; ?>.png"> <span><?php echo !empty($cityCountry['city_name']) ? $cityCountry['city_name'] : ''; ?></span> , <?php echo !empty($cityCountry['Name'])? $cityCountry['Name'] : ''; ?></p>
    
    <p><i class="zmdi zmdi-case"></i> <?php echo $user_totalproject; ?> Jobs Posted</p>
    <p><i class="zmdi zmdi-money-box"></i> <?php echo CURRENCY;?><?php echo round(get_project_spend_amount($project_detail['user_id']));?> <?php echo __('jobdetails_total_spent','Total Spent'); ?></p>
</div>
</div>

<h4><?php echo !empty($project_detail['title'])? $project_detail['title'] : ''; ?></h4>

<table class="table">
<tbody>
    <tr>
        <th><?php echo __('projectdashboard_sectop_posted_on','Posted on'); ?> : </th><td><?php echo !empty($project_detail['post_date'])? date('d M, Y', strtotime($project_detail['post_date'])) : ''; ?></td>
    </tr>
    <tr>
        <th> <?php echo __('projectdashboard_sectop_budget','Budget'); ?>: </th><td><?php echo CURRENCY; ?><?php echo !empty($project_detail['buget_min'])? $project_detail['buget_min'] : ''; ?> - <?php echo CURRENCY; ?><?php echo !empty($project_detail['buget_max'])? $project_detail['buget_max'] : ''; ?></td>
    </tr>
    <tr>
        <th><?php echo __('projectdashboard_sectop_status','Status'); ?>: </th>
		<td>
		<?php
			switch($project_detail['status']){
				case 'O':
						echo __('projectdashboard_sectop_open','Open');
						break;
				case 'C':
						echo __('projectdashboard_sectop_complete','Complete');
						break;
				case 'P':
						echo __('projectdashboard_sectop_active','Active');
						break;
				case 'F':
						echo __('projectdashboard_sectop_pending','Pending');
						break;
				case 'E':
						echo __('projectdashboard_sectop_expired','Expired');
						break;
				case 'PS':
						echo __('projectdashboard_sectop_paused','Paused');
						break;
				case 'CNL':
						echo __('projectdashboard_sectop_cancelled','Cancelled');
						break;
			}
			
			if($project_detail['user_id'] == $user_id && $project_detail['status'] != 'C'){
				echo ' &nbsp; <a href="javascript:void(0)" data-toggle="modal" data-target="#active_project_Modal">Edit</a>';
			}
			?>
		</td>
    </tr>
</tbody>
</table>

<?php if($project_detail['is_completed'] == 'R'){echo __('projectdashboard_sectop_requested_for_complete','Requested for complete'); } ?>
<?php if($project_detail['is_cancelled'] == 'R'){echo __('projectdashboard_sectop_requested_for_cancel','Requested for canclelled'); } ?>

</div>
</div>

<!-- Modal -->
<div class="modal fade" id="active_project_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<form id="project_status_form">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('projectdashboard_sectop_project_status','Project status'); ?></h4>
      </div>
      <div class="modal-body">
		<input type="hidden" name="project_id" value="<?php echo $project_detail['project_id']; ?>"/>
		<?php 
		
		if($project_detail['status'] == 'P' && $project_detail['is_completed'] == 'N' && $project_detail['is_cancelled'] == 'N'){ ?>
		
		<?php if($project_detail['project_type'] != 'H'){ ?>
		<div class="radio">
          <input type="radio" class="magic-radio" id="CNL" name="status" value="CNL"/>
          <label for="CNL"><?php echo __('projectdashboard_sectop_cancelled','Cancelled'); ?></label>
        </div>
		<?php } ?>
		
		<?php if($project_detail['status'] == 'P'){ ?>
		<div class="radio">
          <input type="radio" class="magic-radio" id="C" name="status" value="C"/>
          <label for="C"><?php echo __('projectdashboard_sectop_complete','Complete'); ?></label>
        </div>
		<?php } ?>
		
		<div class="radio">
          <input type="radio" class="magic-radio" id="PS" name="status" value="PS"/>
          <label for="PS"><?php echo __('projectdashboard_sectop_paused','Pause'); ?></label>
        </div>
		
		
		<?php }else  if($project_detail['status'] == 'PS' && $project_detail['is_completed'] == 'N' && $project_detail['is_cancelled'] == 'N'){ ?>
		<div class="radio">
          <input type="radio" class="magic-radio" id="P" name="status" value="P"/>
          <label for="P"><?php echo __('projectdashboard_sectop_resume','Resume'); ?></label>
        </div>
		
		
		<?php }else if($project_detail['status'] == 'F' && $project_detail['is_completed'] == 'N' && $project_detail['is_cancelled'] == 'N'){ ?>
		
		 <div class="radio">
          <input type="radio" class="magic-radio" id="CNL" name="status" value="CNL"/>
          <label for="CNL">"><?php echo __('projectdashboard_sectop_cancelled','Cancelled'); ?></label>
        </div>
		
		<?php }else if($project_detail['status'] == 'C'){
			echo '<p>'.__('projectdashboard_sectop_complete','Complete').'</p>';
		}else if($project_detail['status'] == 'CNL'){
			echo '<p>'.__('projectdashboard_sectop_cancelled','Cancelled').'</p>';
		}else{  ?>
		<p><?php echo __('projectdashboard_sectop_no_action_can_be_performed','No action can be performed.'); ?></p>
		<?php } ?>
		
		<?php if($project_detail['is_completed'] == 'R'){
			echo "<p>".__('projectdashboard_sectop_requested_for_complete','Requested for complete')."</p>";
		}else if($project_detail['is_cancelled'] == 'R'){
			echo "<p>".__('projectdashboard_sectop_requested_for_cancel','Requested for canclelled')."</p>";
		}?>
		
		
      </div>
	  <div id="pending_payment_cError"></div>
      <div class="modal-footer">
        <button type="button" onclick="change_project_status()" class="btn btn-site"><?php echo __('projectdashboard_sectop_save','Save'); ?></button>
      </div>
    </div>
	</form>
	
  </div>
</div>

<script>
function change_project_status(){
	var f = $('#project_status_form'),
		fdata = f.serialize();
	$.ajax({
		url: '<?php echo base_url('dashboard/project_action_status'); ?>',
		data: fdata,
		dataType: 'json',
		type: 'POST',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}else{
				var error = res.errors;
				for(var i in error){
					$('#'+i+'Error').html(error[i]);
				}
			}
		}
	});
}
</script>
