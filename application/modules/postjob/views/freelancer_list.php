<?php if(count($list) > 0){foreach($list as $k => $v){ 
if(!empty($v['logo'])){
	$img = $v['logo'];
}else{
	$img = 'useruser.png';
}
?>
<div class="item" id="freelancer_row_<?php echo $v['user_id']?>" onclick="setActive(this);" data-user="<?php echo $v['user_id'];?>">
  <img class="avatar" src="<?php echo VPATH.'assets/uploaded/'.$img; ?>" width="50" height="50">
  <?php echo $v['fname'].' '.$v['lname']?>
  <p><span class="hourly_rate">$  <?php echo $v['hourly_rate'];?>/<?php echo __('hr','hr'); ?></span>
 <span style="display:none;"> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i></span>
  </p>
  <a href="<?php echo base_url('clientdetails/showdetails').'/'.$v['user_id']; ?>" class="btn btn-sm btn-site"><?php echo __('postjob_view_profile','View profile'); ?></a>
  
</div>
<?php } } ?>


