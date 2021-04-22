
<script src="<?=JS?>mycustom.js"></script>
<?php echo $breadcrumb;?>
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script> 

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#example').dataTable({
			searching: false,
			bLengthChange:false,
			ordering:false,
			"language": {
				"info": '<?php echo __('pagination_showing_page','Showing')?>'+" _PAGE_ "+'<?php echo __('pagination_of','of')?>'+" _PAGES_",
				"emptyTable": '<?php echo __('no_records_found','No Records Available')?>',
				"paginate": {
				  "previous": '<?php echo __('pagination_previous','Previous')?>',
				  "first": '<?php echo __('pagination_first','First')?>',
				  "next": '<?php echo __('pagination_next','Nest')?>',
				  "last": '<?php echo __('pagination_last','Last')?>'
				}
			}
		});
	} );
</script>

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
        <li><a href="<?php echo VPATH?>dashboard/myproject_completed"><?php echo __('dashboard_completed_projects','Completed Projects')?></a></li>
        <li><a class="selected" href="<?php echo VPATH?>dashboard/mycontest_entry"><?php echo __('dashboard_my_contests','My Contests')?></a></li>
    </ul>  
    <div class="" id="editprofile">
        <table id="example" class="table responsive table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th><?php echo __('dashboard_my_contests_entry_ID','Entry ID')?></th>
              <th><?php echo __('dashboard_my_contests_contest','Contest')?></th>
              <th><?php echo __('dashboard_my_contests_sale_price','Sale Price')?></th>
              <th><?php echo __('dashboard_my_contests_contest_status','Contest Status')?></th>
              <th><?php echo __('dashboard_my_contests_entry_status','Entry Status')?></th>
              <th><?php echo __('view','View')?></th>
            </tr>
          </thead>
			<tbody>
				<?php if(count($active_contest) > 0){foreach($active_contest as $k => $v){ ?>
				<tr>
					<td><?php echo $v['entry_id']; ?></td>
					<td><a href="<?php echo base_url('contest/contest_detail/'.$v['contest_id'].'-'.seo_string($v['contest_title'])); ?>"><?php echo $v['contest_title']; ?></a></td>
					<td><?php echo CURRENCY. $v['sale_price']; ?></td>
					<td>
					<?php
					switch($v['contest_status']){
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
					<td>
					<?php
					if($v['contest_status'] == 'C' && $v['is_awarded'] == 1){
						echo __('awarded','Awarded');
					}else if($v['contest_status'] == 'Y'){
						echo __('running','Running');
					}else{
						if($v['is_sealed'] == 1){
							echo __('on_hold','On Hold');
						}else{
							echo __('lost','Lost');
						}
						
					}
					?>
					</td>
					<td><a href="<?php echo base_url('contest/entries/'.$v['contest_id'].'-'.seo_string($v['contest_title']))?>"><?php echo __('view','View')?></a></td>
				</tr>
				<?php } } ?>
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