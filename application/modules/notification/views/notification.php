<?php echo $breadcrumb;?>      
<script src="<?=JS?>mycustom.js"></script>
<section id="mainpage">  
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard/dashboard-left'); ?>
</div> 
<div class="col-md-10 col-sm-9 col-xs-12">
<div class="editprofile">
<h4><b><?php echo __('notification_notification','Notifications'); ?></b>  <span><?php echo __('notification_date','Date'); ?></span></h4>
<?php 
if(!empty($notification)){
foreach($notification as $key=>$val)
{
?>
<input type="hidden" name="notif_id[]" class="notifid <?php if($val['read_status']=='N'){?> <?php echo __('notification_unread','unread'); ?> <? }?>" value="<?php echo $val['id'];?>"/>
<div class="notifbox <?php if($val['read_status']=='N'){?>notif_active<?php }?>">
	<p>
		<a class="rmv_notof" href="javascript:void(0)" onclick="javascript: if(confirm('<?php echo __('notification_are_u_sure_want_to_delete','Are you sure want to delete?'); ?>')){window.location.href='<?php echo VPATH.'notification/delete/'.$val['id'];?>'}"><i class="zmdi zmdi-close"></i></a>
		<a href="<?php echo base_url($val['link']);?>"><?php echo strip_tags(html_entity_decode($this->auto_model->parseNotifcation($val['notification'])));?></a>
	</p>
	<span><?php echo date('d M, Y',strtotime($val['add_date']));?></span>
</div>
<?php
}}else{
?>

<div class="notifbox notif_active">
<p><a class="rmv_notof" href="javascript:void(0)"><img src="<?php echo ASSETS;?>images/bid_icon.png" /></a>
<?php echo __('notification_no_notifivation_found','No Notifications found !!!'); ?></p>
<span>--</span>
</div>
<?php } ?>
</div>

<?php 
echo $links;
?>
                      

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
<div class="addbox">
<?php 
echo $code;
?>
</div>                      
<?php                      
}
elseif($type=='B'&& $image!="")
{
?>
<div class="addbox">
<a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
</div>
<?php  
}
}

?>
 </div>
</div>
</div>
</section>
<style>
.zmdi-close {
	color:#f00;
}
</style>