<style>
.header_tr {
	background-color:#61adff;
	color:#fff;
    font-size: 16px;
    font-weight: 500;
}
</style>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Api Settings</a> </li>
      </ol>
    </nav>
    <div class="container-fluid">
      <?php

            if ($this->session->flashdata('succ_msg')) {

                ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
        <?= $this->session->flashdata('succ_msg') ?>
      </div>
      <?php

            }

            if ($this->session->flashdata('error_msg')) {

                ?>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
        <?= $this->session->flashdata('error_msg') ?>
      </div>
      <?php

            }

            ?>
 
          <div class="panel panel-blank">
            <div class="panel-heading">              
            <h5><i class="la la-edit"></i> API Settings</h5>
            <a href="#" class="minimize2"></a> </div>
            <!-- End .panel-heading -->
			
            <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
			
			<?php if(count($api_services) > 0){ ?>
			
            <form id="validate" action="" class="form-horizontal"  role="form" name="settings" method="post">
                
                <div class="form-group">
				
					<?php foreach($api_services as $service){ 
					$service_fields = get_results(array('select' => '*', 'from' => 'api_setting', 'where' => array('service_id' => $service['service_id'])));
					$service_name = strtolower($service['name']);
					?>
					<table class="table">
						<tbody>
						  <tr class="header_tr">
							<td height="25">&nbsp;<?php echo $service['label']; ?></td>
							<td height="25">&nbsp;<button class="btn btn-success btn-sm" type="button" onclick="addField('<?php echo $service['service_id']; ?>', '<?php echo $service_name; ?>')" hidden>Add Field</button></td>
						  </tr>
						  
						   <?php if(count($service_fields) > 0){foreach($service_fields as $k => $v){ ?>
						   <tr bgcolor="#ffffff" class="lnk">
							<th valign="middle" width="25%"><?php echo $v['label']; ?></th>
							<td><input type="text" class="form-control" name="service[<?php echo $v['service_id'];?>][<?php echo $v['service_key'];?>]" value="<?php echo $v['service_value'];?>" style="">
							  <?php echo form_error('fix_featured_charge', '<label class="error" for="required">', '</label>'); ?></td>
						  </tr>
						  <?php } } ?>
						  
						</tbody>
				   </table>
					<?php } ?>
					
                  </div>
				  
                <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                <!-- End .form-group  -->
                
              </form>
			  <?php } ?>
            
            <!-- End .panel-body --> 
            
          </div>
                
    </div>
    <!-- End .container-fluid  --> 
    
  </div>
  <!-- End .wrapper  --> 
  
</section>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	   <h4 class="modal-title">Add <span id="addFieldTitle"></span> field</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
      <div class="modal-body">
	    <div id="fieldError" class="text-danger"></div>
       <form id="addFieldForm">
			<input type="hidden" name="service_id" value="" id="service_id_filed"/>
			<div class="form-group">
				<label>Field Label</label>
				<input type="text" class="form-control" id="field_label" name="label"/>
			</div>
			<div class="form-group">
				<label>Field Name</label>
				<input type="text" class="form-control" id="field_name" name="service_key"/>
			</div>
			<div class="form-group">
				<label>Field Value</label>
				<input type="text" class="form-control" id="field_value" name="service_value"/>
			</div>
			
	   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addFieldBtn">Add</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script>
function addField(service_id, title){
	if(!service_id || !title){
		return false;
	}
	$('#addFieldForm')[0].reset();
	$('#addFieldBtn').html('Add');
	$('#addFieldBtn').removeAttr('disabled');
	$('#addFieldTitle').html(title);
	$('#service_id_filed').val(service_id);
	$('#myModal').modal('show');
	
}

$('#addFieldBtn').click(function(){
	$('#fieldError').html('');
	var field_label = $('#field_label').val();
	var field_name = $('#field_name').val();
	var field_value = $('#field_value').val();
	var fdata = $('#addFieldForm').serialize();
	var submitForm = true;
	if(field_label.trim() == ''){
		$('#field_label').addClass('error');
		submitForm = false;
	}else{
		$('#field_label').removeClass('error');
	}
	
	if(field_name.trim() == ''){
		$('#field_name').addClass('error');
		submitForm = false;
	}else{
		$('#field_name').removeClass('error');
	}
	
	
	if(!submitForm){
		return false;
	}
	
	$(this).attr('disabled', 'disabled');
	$(this).html('Adding...');
	
	$.ajax({
		url : '<?php echo base_url('settings/addServiceField')?>',
		data: fdata,
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}else{
				$('#fieldError').html(res.msg);
				$('#addFieldBtn').html('Add');
				$('#addFieldBtn').removeAttr('disabled');
			}
		}
	});
	
	
});
</script>