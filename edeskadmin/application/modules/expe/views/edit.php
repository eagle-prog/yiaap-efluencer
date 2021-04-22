<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>expe/page">Experience Level List</a></li>
        <li class="breadcrumb-item active">Edit Level</a></li>
      </ol>
    </nav>        
        <div class="container-fluid">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><i class="la la-edit"></i> Edit Experience Level Management</h5>
            </div>
            <!-- End .panel-heading -->
            <div class="panel-body">
                <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
                <form id="validate" action="<?php echo base_url(); ?>expe/edit/<?php echo $id;?>" class="form-horizontal" role="form" name="expe" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    
                    <div class="row">
						<label class="col-lg-2 col-md-3 col-form-label">Name</label>
						<div class="col-lg-10 col-md-9">
							<input class="form-control" id="name" value="<?php echo $name; ?>" name="name" type="text" />
						</div>
                    </div>
					<div class="row">
						<label class="col-lg-2 col-md-3 col-form-label">Arabic Name</label>
						<div class="col-lg-10 col-md-9">
							<input class="form-control" id="arb_name" value="<?php echo $arb_name; ?>" name="arb_name" type="text" />
						</div>
                    </div>

                    <!-- End .control-group  -->
					<div class="row">
						<label class="col-lg-2 col-md-3 col-form-label">Description</label>
						<div class="col-lg-10 col-md-9">
							<textarea class="form-control" id="description" name="description" ><?php echo $description;?></textarea>
						</div>
                    </div>
                    <div class="row">
						<label class="col-lg-2 col-md-3 col-form-label">Arabic Description</label>
						<div class="col-lg-10 col-md-9">
							<textarea class="form-control" id="arb_description" name="arb_description" ><?php echo $arb_description;?></textarea>
						</div>
                    </div>

                    <!-- End .control-group  -->
                    <div class="row">
                        <label class="col-lg-2 col-md-3 col-form-label">Status</label>
                        <div class="col-lg-10 col-md-9">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status" name="status" value="Y" <?php if($status=='Y'){?>checked="checked"<?php }?>>
                          <label class="custom-control-label" for="status">Online</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if($status=='N'){?>checked="checked"<?php }?>>
                          <label class="custom-control-label" for="status_2">Offline</label>
                        </div>                                                
                        </div>             
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-2 col-md-3">&nbsp;</div>
			  			<div class="col-lg-10 col-md-9">
                                <input type="submit" class="btn btn-primary" name="submit" value="Save"/>&nbsp;
                                <button type="button" onclick="redirect_to('<?php echo base_url() . 'banner'; ?>');" class="btn btn-secondary">Cancel</button>
                            </div>                        
                    </div>
                    <!-- End .row  -->
                </form>
            </div>
            <!-- End .panel-body -->
        </div>
                    <!-- End .widget -->
                
            <!-- End .row-fluid  -->
        </div>
        <!-- End .container-fluid  -->
    </div>
    <!-- End .wrapper  -->
</section>
<script>