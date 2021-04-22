<script type="text/javascript">
							
$('[data-toggle="tooltip"]').tooltip();
function onchangeOption(v,i){
// alert(v);alert(i);

if(v=="VF"){ 
window.location.href=$("#vf_"+i).attr('href');
}

else if(v=="WR"){
window.location.href=$("#wr_"+i).attr('href');

}
else if(v=="PC"){

window.location.href=$("#pc_"+i).attr('href');

}
else if(v=='M'){

window.location.href=$("#m_"+i).attr('href');

}
else if(v=='GB'){

window.location.href=$("#gb_"+i).attr('href');

}
else if(v=='EC'){

window.location.href=$("#ec_"+i).attr('href');

}
else if(v=='VP'){

window.location.href=$("#vp_"+i).attr('href');

}
}
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();   
});		
</script>
<style>
.extratext{
width:100%;
float:left;
}
</style>

<div class="clearfix"></div>

<table id="exampleTabs" class="table table-dashboard">
<thead><tr>
<th><?php echo __('dashboard_myproject_client_project_name','Project Name'); ?></th>
<th class="text-center"><?php echo __('dashboard_myproject_client_project_type','Project Type'); ?></th>
<th class="text-center"><?php echo __('dashboard_myproject_client_bids','Bids'); ?></th>
<th class="text-center"><?php echo __('dashboard_myproject_client_workroom','Workroom'); ?></th>
<th class="text-center"><?php echo __('dashboard_myproject_posted_date','Posted date'); ?></th>
<th><?php echo __('dashboard_myproject_client_action','Action'); ?></th>
</tr>
</thead>
<tbody>
<?php
if(count($projects) > 0){foreach($projects as $k => $v){ 
$v = filter_data($v);
if($v['project_type'] == 'H' AND $v['multi_freelancer'] == 'Y'){
	$project_type='<i class="zmdi zmdi-time" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.__('dashboard_myproject_hourly','Hourly').'"></i>';
}else{
	$project_type='<i class="zmdi zmdi-lock" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.__('dashboard_myproject_fixed','Fixed').'"></i>';
}

?>
<tr>
	<td><a href="<?php echo VPATH."jobdetails/details/".$v['project_id'];?>"><?php echo $v['title'];?></a></td>
	<td align="center"><?php echo $project_type;?></td>
	<td align="center"><?php echo $v['bidder_details']; ?></td>
	<td align="center"> <a href="<?php echo base_url('projectdashboard_new/employer/overview/'.$v['project_id']); ?>" data-toggle="tooltip" title="<?php echo __('dashboard_myproject_client_workroom','Work Room'); ?>"><i class="fa fa-home"></i></a></td>
	<td align="center"><?php echo date('d M,Y',strtotime($v['posted_date']));?></td>
	<td>
		<?php if($status == 'C'){

		}else{
			if($v['is_completed'] == 'R'){
				echo __('dashboard_myproject_client_request_for_complete','Requested for complete');
			}else{
		?>
		<select class="form-control" data-project-id="<?php echo $v['project_id']; ?>" onchange="triggerAction(this)">
			<option value=""><?php echo __('dashboard_myproject_client_choose_action','choose action'); ?> </option>
			<?php if($status=='P'){ ?>
			<?php if($v['project_type'] == 'F'){ ?>
			<option value="C"><?php echo __('dashboard_myproject_client_completed','Completed'); ?></option>
			<option value="CNL"><?php echo __('dashboard_myproject_client_cancelled','Cancelled'); ?></option>
			<?php } ?>
			<option value="PS"><?php echo __('dashboard_myproject_client_pause','Pause'); ?></option>
			<?php }else if($status=='F'){ ?>
			<?php if($v['project_type'] == 'F'){ ?>
			<option value="CNL"><?php echo __('dashboard_myproject_client_cancelled','Cancelled'); ?></option>
			<?php } ?>
			
			<?php }else if($status=='PS'){ ?>
			<option value="P"><?php echo __('dashboard_myproject_client_resume','Resume'); ?></option>
			<?php if($v['project_type'] == 'F'){ ?>
			<option value="CNL"><?php echo __('dashboard_myproject_client_cancelled','Cancelled'); ?></option>
			<?php } ?>
			<?php } ?>
		</select>
		<?php } } ?>
	</td>
</tr>

<?php } } ?>

</tbody>
</table>

<script>
	function triggerAction(e){
		
		var p_id = $(e).attr('data-project-id');
		var val = $(e).val();
		if(val != ''){
			$.ajax({
				url : '<?php echo base_url('dashboard/project_action_status');?>',
				type: 'post',
				data: {status: val, project_id: p_id},
				dataType: 'json',
				success: function(res){
					if(res.status == 1){
						location.reload();
					}
				}
			});
		}
	}
</script>