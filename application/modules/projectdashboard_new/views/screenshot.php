<!--<script>
    $(window).load(function(){
      $("#sticky_panel").sticky({ topSpacing: 105 , bottomSpacing: 485});
    });
</script>-->
<?php echo $breadcrumb; ?>
<section id="mainpage">
<div class="container-fluid">
<div class="row">
    <div class="col-md-2 col-sm-3 col-xs-12">
        <?php $this->load->view('dashboard/dashboard-left'); ?>
    </div>
	<div class="col-md-10 col-sm-9 col-xs-12">
	<div class="row">
    <aside class="col-md-9 col-xs-12">
    
    <!-- Nav tabs -->
    <?php if($user_type == 'freelancer'){ $this->load->view('freelancer_tab'); }?>
    <?php if($user_type == 'employer'){ $this->load->view('employer_tab'); } ?>
    
    <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="overview">
        <h4><?php echo __('screen_shots','Screen Shots')?> <span class="port_time"><?php echo date('d F, Y',strtotime($screenshot_date));?></span></h4>
        <div class="row-10">
        <ul id="lightgallery" class="lightgallery">
            <?php 
            foreach($tracker_details as $key=>$val){
            $image_name=$pid."_".$val['id'].".jpg";
            ?>
             
            <li class="col-xs-6 col-sm-4 col-md-3" data-src="<?php echo base_url();?>time_tracker/mediafile/<?php echo $image_name;?>">
            <div>
            <h5><?php echo date('d F, Y h:i:s',strtotime($val['project_work_snap_time']));?></h5>
            <a href="javascript:void(0)"><img src="<?php echo base_url();?>time_tracker/mediafile/<?php echo $image_name;?>" alt="<?php echo date('d F, Y h:i:s',strtotime($val['project_work_snap_time']));?>" class="img-responsive" /></a>
            </div>
            </li>                                   		                           
            <?php	
            }
            ?>                
    </ul>
    </div>
    </div>
    <?php echo "<div class='pagin'>".$links."</div>"; ?>
    
    </div>
    </aside>
    <aside class="col-md-3 col-xs-12">
        <?php $this->load->view('right-section'); ?>
    </aside>
</div>
	</div>
</div>
</div>
</section>
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/lightbox/lightgallery.min.css"/>

<script src="<?php echo ASSETS;?>plugins/lightbox/lightgallery-all.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#lightgallery").lightGallery(); 
    });
</script>