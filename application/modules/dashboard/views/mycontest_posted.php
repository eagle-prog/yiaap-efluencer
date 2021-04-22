
<script src="<?=JS?>mycustom.js"></script>
<?php echo $breadcrumb;?>
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script> 

<section id="mainpage">  
<div class="container-fluid">
<div class="row">

  <div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard-left'); ?>
</div> 

<div class="col-md-10 col-sm-9 col-xs-12">  
<div class="spacer-20"></div>

<div>
	<div class="pull-left">
		<h4><?php echo __('contests','CONTESTS')?></h4>
	</div>
	<div class="pull-right">
		<a href="<?php echo base_url('contest/post_contest'); ?>" class="btn btn-default"><?php echo __('dashboard_add_contests','Add Contest')?></a>
	</div>
</div>


<div class="profile_right">
	<div class="" id="editprofile">
        <table id="example" class="table responsive table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th><?php echo __('dashboard_contest_ID','Contest ID')?></th>
              <th><?php echo __('contest','Contest')?></th>
              <th><?php echo __('dashboard_budget','Budget')?></th>
              <th><?php echo __('dashboard_entries','Entries')?></th>
              <th><?php echo __('dashboard_posted','Posted')?></th>
              <th><?php echo __('dashboard_ended','Ended')?></th>
              <th><?php echo __('dashboard_status','Status')?></th>
             
            </tr>
          </thead>
			<tbody>
				<?php if(count($active_contest) > 0){foreach($active_contest as $k => $v){ ?>
				<tr>
					<td><?php echo $v['contest_id']; ?></td>
					<td><a href="<?php echo base_url('contest/contest-detail/'.$v['contest_id'].'-'.seo_string($v['title'])); ?>"><?php echo $v['title']; ?></a></td>
					<td><?php echo CURRENCY. $v['budget']; ?></td>
					<td><?php echo $v['total_entries']; ?></td>
					<td><?php echo date('d M, Y', strtotime($v['posted'])); ?></td>
					<td><?php echo date('d M, Y', strtotime($v['ended'])); ?></td>
					<td>
					<?php
					switch($v['status']){
						case 'Y' : 
							echo __('running','Running');
						break;
						case 'N' :
							echo __('ended','Ended');
						break;
						case 'C':
							echo __('completed','Completed');
						break;
					}
					?>
					</td>
				</tr>
				<?php } }else{  ?>
				<tr>
					<td colspan="10"><?php echo __('no_record_found','No records found')?></td>
				</tr>
				<?php } ?>
            </tbody>
		</table>
         <?php echo $links; ?>  
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