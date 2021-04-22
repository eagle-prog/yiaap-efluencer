         <!-- Content Start -->
         <div id="main">
            <!-- Title, Breadcrumb Start-->
                 <?php echo $breadcrumb;?>      

		<script src="<?=JS?>mycustom.js"></script>
            <!-- Main Content start-->
            <div class="content">
               <div class="container">
                  <div class="row">
                        <?php echo $leftpanel;?> 
                     <!-- Sidebar End -->
                     <div class="posts-block col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <article class="post hentry">
                        
<!--ProfileRight Start-->
<div class="profile_right">
<h1>
<a class="selected" href="<?php echo VPATH?>dashboard/myproject_professional"><?php echo __('dashboard_my_bid','My Bid')?></a>
</h1> <h1>
<a href="<?php echo VPATH?>dashboard/myproject_working"><?php echo __('dashboard_active_projects','Active Projects')?></a>
</h1> <h1>
<a href="<?php echo VPATH?>dashboard/myproject_completed"><?php echo __('dashboard_completed_projects','Completed Projects')?></a>
</h1> 
<!--EditProfile Start-->
<div class="editprofile" id="editprofile">
<div class="notiftext"><h4><?php echo __('dashboard_project_name','Project Name')?></h4><h4><?php echo __('dashboard_myproject_client_project_type','Project Type')?></h4>	<h4><?php echo __('dashboard_bid_amount','Bid Amount')?></h4> 	<h4><?php echo __('duration','Duration')?></h4> 	<h4><?php echo __('posted_date','Posted date')?></h4> 	<h4><?php echo __('status','Status')?></h4></div>
<?php
if(count($proposals)>0)
{
foreach($proposals as $key=>$val)
{
	$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
	$status=$this->auto_model->getFeild('status','projects','project_id',$val['project_id']);
	
	$bidder_id=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$val['project_id']));
	$chosen_id=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$val['project_id']));
	
	$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$val['project_id']);
	$type="";
	if($project_type=="F")
	{
		$type=__('fixed',"Fixed");
	}
	else
	{
		$type=__('hourly',"Hourly");
	}
?>
<div class="methodbox">
<div class="methodtext1"><h2><strong><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>"><?php echo $project_name;?></a></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo $type;?></strong></h2></div>
<div class="methodtext1"><h2><strong> <?php echo CURRENCY;?> <?php echo $val['bidder_amt'];?><?php if($project_type=='H'){ ?>/hr <?php } ?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php if($project_type=='F'){?><?php echo $val['days_required'];?> <?php echo __('days','days')?> <?php }else{ echo __('n/a',"N/A");}?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo $this->auto_model->date_format($val['add_date']);?></strong></h2></div>
<div class="methodtext1"><h2><strong>
<?php
if($bidder_id && in_array($user_id,$bidder_id) && $status!='O')
{
	echo __('bid_won',"Bid Won");
}
elseif($chosen_id && in_array($user_id,$chosen_id) && $status=='F')
{
?>
<a href="javascript:void(0);" onclick="accept_offer('<?php echo $val['project_id'];?>')"><?php echo __('accept_offer','Accept offer')?></a> | <a href="javascript:void(0);" onclick="decline_offer('<?php echo $val['project_id'];?>')"><?php echo __('decline_offer','Decline offer')?></a>
<?php
}
elseif($bidder_id && !in_array($user_id,$bidder_id) && $status!='O' && $status!='F')
{
	echo __('bid_lost',"Bid Lost");
}
else
{
	echo __('offer_waiting',"Offer Waiting");
}
?>
</strong></h2></div>
</div>
<?php
}
}
else
{
?>
<div class="myprotext"><p><strong><?php echo __('no_active_jobs_to_display','No active jobs to display')?></strong></p></div>
<?php
}
?>	 
</div>
<!--EditProfile End-->
<h1><a class="selected" href="<?php echo VPATH;?>dashboard/myproject_professional"><?php echo __('back','Back')?></a></h1>
</div>                       
<!--ProfileRight Start-->                       
                       
</article>
<div style="clear:both;"></div>
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
<div style="clear:both;"></div>
                     </div>
                     <!-- Left Section End -->
                  </div>
               </div>
            </div>
            <!-- Main Content end-->
         </div>
         <!-- Content End -->
<script>
function accept_offer(project_id)
{
    
        var pid=project_id;
		//alert(pid); die();
		var dataString = 'userid='+<?php echo $user_id?>+'&projectid='+pid;
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/acceptoffer",
			 success:function(return_data)
			 {
				$('#editprofile').html();
				$('#editprofile').html(return_data);
			 }
		});
}
function decline_offer(project_id)
{
    
        var pid=project_id;
		//alert(pid); die();
		var dataString = 'userid='+<?php echo $user_id?>+'&projectid='+pid;
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/declineoffer",
			 success:function(return_data)
			 {
				$('#editprofile').html();
				$('#editprofile').html(return_data);
			 }
		});
}
</script>