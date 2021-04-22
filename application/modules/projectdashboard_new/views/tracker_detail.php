<div class="captionDay">
	<a href="<?php echo base_url('projectdashboard_new/view_tracker/'.$project_id.'/'.$freelancer_id.'?show_date='.$prev_day);?>"><i class="zmdi zmdi-chevron-left zmdi-hc-2x" style="position: relative; top: 5px;"></i></a> &nbsp; 
	<b><?php echo date('D , M d , Y', $curr_day);?></b> &nbsp; 
	<?php if($next_day <= strtotime(date('Y-m-d'))){ ?>
	<a href="<?php echo base_url('projectdashboard_new/view_tracker/'.$project_id.'/'.$freelancer_id.'?show_date='.$next_day);?>"><i class="zmdi zmdi-chevron-right zmdi-hc-2x" style="position: relative; top: 5px;"></i></a>
	<?php } ?>
</div>
<div class="table-responsive" style="box-shadow: none;">
	<table class="table" style="border: 1px solid #ddd;">
		<?php if(count($tracker_group) > 0){foreach($tracker_group as $time => $items){ ?>
		<tr>
			<td style="vertical-align:middle; width:60px"><?php echo $time; ?></td>
			<td class="lightgallery">
			<?php if(is_array($items) && count($items) > 0){foreach($items as $k => $v){ 
			$image_name=base_url('time_tracker/mediafile').'/'.$project_id."_".$v['id'].".jpg";
			?>
			<div class="tracker_item" data-src="<?php echo $image_name; ?>">            
                <a href="javascript:void(0)"><img src="<?php echo $image_name; ?>" class="img-responsive" alt="<?php echo date('d F, Y h:i:s',strtotime($v['project_work_snap_time']));?>"></a>
                <div class="t_foot">
                    <p><?php echo date('g:i A', strtotime($v['project_work_snap_time']));?></p>
                </div>
			</div>
			<?php } } ?>
			</td>
		</tr>
		<?php } }else{  ?>
		<tr>
			<td colspan="2"> <?php echo __('no_record_found','No records found')?></td>
		</tr>
		<?php  } ?>
	</table>
</div>
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/lightbox/lightgallery.min.css"/>

<script src="<?php echo ASSETS;?>plugins/lightbox/lightgallery-all.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".lightgallery").lightGallery(); 
    });
</script>