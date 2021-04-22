
<script src="<?=JS?>mycustom.js"></script>
<?php echo $breadcrumb;?>
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script> 
<script type="text/javascript" charset="utf-8">	$(document).ready(function() {		$('#example').dataTable({			searching: false,			bLengthChange:false,			ordering:false,			"language": {				"info": '<?php echo __('pagination_showing_page','Showing')?>'+" _PAGE_ "+'<?php echo __('pagination_of','of')?>'+" _PAGES_",				"emptyTable": '<?php echo __('no_records_found','No Records Available')?>',				"paginate": {				  "previous": '<?php echo __('pagination_previous','Previous')?>',				  "first": '<?php echo __('pagination_first','First')?>',				  "next": '<?php echo __('pagination_next','Nest')?>',				  "last": '<?php echo __('pagination_last','Last')?>'				}			}		});	} );</script>
<section id="mainpage">  
<div class="container-fluid">
<div class="row">

  <div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard-left'); ?>
</div> 
     
<div class="col-md-10 col-sm-9 col-xs-12">  
<div class="spacer-20"></div>
<div class="profile_right">
	<ul class="tab">
        <li><a href="<?php echo VPATH?>dashboard/myproject_professional"><?php echo __('dashboard_my_bid','My Bid')?></a></li>
        <li><a href="<?php echo VPATH?>dashboard/myproject_working"><?php echo __('dashboard_active_projects','Active Projects')?></a></li>
        <li><a class="selected" href="<?php echo VPATH?>dashboard/myproject_completed"><?php echo __('dashboard_completed_projects','Completed Projects')?></a></li>
		 <li><a href="<?php echo VPATH?>dashboard/mycontest_entry"><?php echo __('dashboard_my_contests','My Contests')?></a></li>
    </ul>  
    <div class="" id="editprofile">
        <table id="example" class="table responsive table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th><?php echo __('dashboard_project_name','Project Name')?></th>
              <th><?php echo __('dashboard_myproject_client_project_type','Project Type')?></th>
              <th><?php echo __('dashboard_posted_by','Posted By')?></th>
              <th><?php echo __('posted_date','Posted date')?></th>
              <th><?php echo __('action','Action')?></th>
            </tr>
          </thead>
          <tbody>
            <?php
if(count($working_projects)>0)
{
foreach($working_projects as $key=>$val)
{
$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
$username=$this->auto_model->getFeild('username','user','user_id',$val['user_id']);
$bidder_name=$this->auto_model->getFeild('username','user','user_id',$val['bidder_id']);
$count_review=$this->dashboard_model->countReview($val['project_id'],$user_id,$val['user_id']);
$type="";
if($val['project_type']=="F")
{
$type=__('fixed',"Fixed");
}
else
{
$type=__('hourly',"Hourly");
}
?>
                <tr>
                  <td><?php echo $project_name;?></td>
                  <td><?php echo $type;?></td>
                  <td><?php echo $username;?></td>
                  <td><?php echo $this->auto_model->date_format($val['post_date']);?></td>
                  <td>
				  <a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a>
				  <?php 
		/* if($count_review>0)
		{
		echo "<a href='".VPATH."dashboard/viewfeedback/".$val['project_id']."/".$val['user_id']."/".$project_name."'>View Feedback</a>";	
		}
		else
		{
		echo "<a href='".VPATH."dashboard/rating/".$val['project_id']."/".$val['user_id']."/".$project_name."'>Give Feedback</a>";	
		} */
		
?></td>
                </tr>
                <?php
}
}

?>
              </tbody>
		</table>
           
</div>
          
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
      <div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
      <?php  
}
}

?>
      <div class="clearfix"></div>
    </div>
    
  </div>
</div>
</div>
</section>