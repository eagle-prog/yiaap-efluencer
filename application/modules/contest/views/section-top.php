<script>
    $(window).load(function(){
      $("#sticky_panel").sticky({ topSpacing: 65});
    });
</script>
<style type="text/css">
.heading {
    font-weight: 500;
    font-size: 17px;
    padding: 10px 0px;
    border-bottom: 1px solid #ddd;
}
.header-bottom {
	background-color: #2AC8E3;
	color: #fff;
    width: 100%;
    z-index: 99;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
    background-color: transparent;
    border: none;
    border-bottom: 3px solid #fff;
}
.nav-tabs {
    border-bottom: none
}
.nav-tabs > li a {
	display: block;
	color: white;
}
.nav-tabs > li {
	margin-bottom:0
}
.nav-tabs > li.active a, .nav-tabs > li.active > a:hover {
    color:#fff
}
</style>
<section id="autogenerate-breadcrumb-id-contest"  class="breadcrumb-classic">
   <div class="container" style="margin-top:15px">
      <div class="row">
		 <aside class="col-sm-8 col-xs-12">
			<h3><?php echo $details['title']; ?> <span class="pull-right"><?php echo CURRENCY.' '.$details['budget']; ?></span></h3>
		 </aside>
		 <aside class="col-sm-4 col-xs-12">         	
			<ol class="breadcrumb text-right">								
				<li><a href="<?php echo base_url();?>"><?php echo __('home','Home')?></a></li><li class="active"><?php echo __('post_contest','Post Contest')?></li></ol>
         </aside>					
      </div>	      			  				  
   </div>			   
</section>
<div class="text-right caption-text">
    <div class="container">
        <h5><?php echo __('end','Ended')?>: <?php echo date('d M , Y', strtotime($details['ended'])); ?></h5>
    </div>
</div>
<div class="header-bottom" id="sticky_panel">
   <div class="container">
    <div class="row">
        <div class="col-sm-8">
	
            <ul class="nav nav-tabs inline-block-list">
                <li class="<?php echo $active_tab == 'detail' ? 'active' : '';?>"><a href="<?php echo base_url('contest/contest-detail/'.$details['contest_id'].'-'.seo_string($details['title'])); ?>"><?php echo __('description','Description')?></a></li>
                <li class="<?php echo $active_tab == 'entries' ? 'active' : '';?>"><a href="<?php echo base_url('contest/entries/'.$details['contest_id'].'-'.seo_string($details['title'])); ?>"><?php echo __('entries','Entries')?></a></li>
            </ul>
        </div>
        <div class="col-sm-4">
            <?php if(($details['user_id'] != $login_user_id) && ($details['status'] == 'Y')){ ?>
            <div style="text-align: right">
				<?php
					$usernew = $this->session->userdata('user');
					$verify_new = getField('verify', 'user', 'user_id', $usernew[0]->user_id);
					if($verify_new == 'N'){
					?>
					<button class="btn btn-site" style="margin-bottom:12px" id="bid_no_button" data-toggle="modal" data-target="#no_bid"> <?php echo __('upload_entry','Upload an Entry')?></button>
					<?php
					}
					else{
					?>
					<a class="btn btn-site" href="<?php echo base_url('contest/contest_entry/'.$details['contest_id']); ?>" style="margin-top:5px"><?php echo __('upload_entry','Upload an Entry')?></a>
					<?php
					}
					?>
            </div>
            <?php } ?>
        </div>
	</div>
    </div>   
    </div>
	
	
<div id="no_bid" class="modal fade" style="overflow: hidden">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" onclick="$('#no_bid').modal('hide');">&times;</button>
		</div>
		<div class="modal-body">
		  <div class="row">
			<div class="col m12 s12">
				<h4 style="margin-top: 30px; text-align: center;"><?php echo __('contest_cant_upload','You can\'t upload an entry until your account has not verified by admin')?>.</h4>
			</div>
		  </div>
		</div>
	
		<div class="modal-footer">
			<button type="button" class="btn" onclick="$('#no_bid').modal('hide');"><?php echo __('close','Close')?></button>
		</div>
	</div>
  </div>
</div>