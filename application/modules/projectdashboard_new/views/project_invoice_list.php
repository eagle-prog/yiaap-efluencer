<style>
.file_list .list-container{
	padding: 10px;
	border: 1px solid #ddd;
}

.file_list .list-container:not(:first-child){
	border-top: 0px;
}

.file_list .list-container a.rem{
	float: right;
	
}
</style>
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
	<?php
	if(is_employer($user_id, $project_id)){
		$this->load->view('employer_tab');
	}
	
	if(is_bidder($user_id, $project_id)){
		$this->load->view('freelancer_tab');
	}
	?>
    
    
    <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="overview">
    
    <h4><?php echo __('projectdashboard_tab_invoices','Invoices')?> </h4>	
    <div class="table-responsive">
    
    <!-- working area -->
        <table class="table">
        <thead>
        <tr>
            <th><?php echo __('projectdashboard_invoice_number','Invoice Number')?></th> <th><?php echo __('projectdashboard_invoice_type','Invoice type')?></th> <th><?php echo __('date','Date')?></th><th><?php echo __('from','From')?>/<?php echo __('to','To')?></th><th><?php echo __('status','Status')?></th><th><?php echo __('action','Action')?></th><th><?php echo __('invoice','Invoice')?></th>
        </tr>
        </thead>
        <tbody>
		<?php if(count($invoice_list) > 0){foreach($invoice_list as $k => $v){
		if($v['sender_id'] == $user_id){
			$user_info = getField('fname', 'user', 'user_id', $v['receiver_id']);
		}else{
			if($v['sender_id']  > 0){
				$user_info = getField('fname', 'user', 'user_id', $v['sender_id']);
			}else{
				$user_info = SITE_TITLE;
			}
			
		}
		
		$is_paid = $is_deleted = $is_pending = 0;
		
		if($v['is_paid'] != '0000-00-00 00:00:00'){
			
			$is_paid = 1;
			
		}else if($v['is_deleted'] != '0000-00-00 00:00:00'){
			$is_deleted = 1;
		}else{
			$is_pending = 1;
		}
		?>
		<tr>
           <td><?php echo $v['invoice_number']; ?></td>
           <td><?php echo $v['type']; ?></td>
           <td><?php echo $v['invoice_date']; ?></td>
           <td><?php echo $user_info; ?></td>
		     <td>
		   <?php 
		   
		   if($is_pending == 1){
			   echo __('pending','Pending');
		   }elseif($is_deleted == 1){
			   echo __('deleted','Deleted');
		   }elseif($is_paid == 1){
			   echo __('paid','Paid');
		   }
		   
		   ?>
		   </td>
		   <td>
		   <?php if(($is_pending == 1) && ($v['receiver_id'] == $user_id)){ ?>
		   
			
		   <a href="javascript:void(0)" onclick="confirm_first(this, 'accept')" data-invoice-id="<?php echo $v['invoice_id']; ?>" data-project-type="<?php echo $project_type; ?>" data-project-id="<?php echo $project_id; ?>"><?php echo __('accept','Accept')?></a> |
		   <a href="javascript:void(0)" onclick="confirm_first(this, 'cancel')" data-invoice-id="<?php echo $v['invoice_id']; ?>" data-project-type="<?php echo $project_type; ?>" data-project-id="<?php echo $project_id; ?>"><?php echo __('deny','Deny')?></a> 
		
		   <?php } ?>
		   
		   <?php if(!empty($v['comment'])){ ?>
		   <a href="javascript:void(0)" rel="infopop" data-toggle="popover" data-original-title="Reason" data-content="<?php echo $v['comment']; ?>"><i class="fa fa-lg fa-info-circle"></i></a>
		   <?php } ?>
		   </td>
         
		   <td><a href="<?php echo base_url('invoice/detail/'.$v['invoice_id'])?>" target="_blank"><?php echo __('view','View')?></a></td>
        </tr>
		<?php } }else{   ?>
		<tr>
			<td colspan="10" style="text-align:left;"><?php echo __('no_record_found','No records')?></td>
		</tr>
		<?php }   ?>
		
        </tbody>
        </table>
        
    
		
	
    <!-- working area -->
    
    </div>
    <?php echo $links; ?>
    </div>
    
    
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

<!-- modals -->
<div id="infoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#infoModal').modal('hide');">&times;</button>
      </div>
      <div class="modal-body" id="infoContent">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#infoModal').modal('hide');"><?php echo __('projectdashboard_milestone_close',''); ?></button>
        <button type="button" class="btn btn-primary" id="release-action-btn" style="display:none" onclick="action_perform('yes')"><?php echo __('projectdashboard_milestone_accept','Accept'); ?></button>
        <button type="button" class="btn btn-primary" id="cancel-action-btn" style="display:none"  onclick="action_perform('no')"><?php echo __('projectdashboard_milestone_cancel','Cancel'); ?></button>
        <a type="button" class="btn btn-primary" id="dispute-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_dispute','Dispute'); ?></a>
      </div>
    </div>

  </div>
</div>


<!-- Modal -->
<div id="requestModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#requestModal').modal('hide');">&times;</button>
        <h4 class="modal-title"><?php echo __('request','Request'); ?></h4>
      </div>
      <div class="modal-body">
        <div id="commentB">
			<h4><?php echo __('comments','Comments'); ?>: </h4>
			<div id="commentV"></div>
		</div>
        <div id="attachmentB">
			
		</div>
		<input type="hidden" id="choosen_milestone_id" value="0"/>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-site" onclick="milestoneRequestAction('A')"><?php echo __('projectdashboard_milestone_accept','Accept'); ?></button>
        <button type="button" class="btn btn-danger" onclick="milestoneRequestAction('R')"><?php echo __('reject','Reject'); ?></button>
      </div>
    </div>

  </div>
</div>


<script>

var confirm_data = {};

function confirm_first(ele, action){
	
	var invoice_id = $(ele).data('invoiceId');
	var project_type = $(ele).data('projectType');
	var project_id = $(ele).data('projectId');
	
	if(!action || invoice_id == '' || project_type == '' || project_id == ''){
		return false;
	}
	
	confirm_data.invoice_id = invoice_id;
	confirm_data.project_type = project_type;
	confirm_data.project_id = project_id;
	
	if(action == 'accept'){
		$('#release-action-btn').show();
		$('#cancel-action-btn').hide();
		$('#dispute-action-btn').hide();
		$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_relese_payment','Are you sure to release payment ?'); ?>');
	}else if(action == 'cancel'){
		var comment_field = '<div id="reason_wrapper"><label>Reason for cancel :</label><textarea class="form-control" id="reason_input"></textarea></div>';
		$('#cancel-action-btn').show();
		$('#release-action-btn').hide();
		$('#dispute-action-btn').hide();
		$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_cancel_payment','Are you sure to cancel payment ?'); ?> ' + comment_field);
	}
	$('#infoModal').modal('show');
}


function action_perform(cmd){
	if(cmd == 'yes'){
		$('#release-action-btn').html('Processing..');
		$('#release-action-btn').attr('disabled', 'disabled');
		accept_invoice();
	}
	if(cmd == 'no'){
		deny_invoice();
	}
}

function accept_invoice(){
	
	if(Object.keys(confirm_data).length == 0){
		return false;
	}
	
	var f_data = confirm_data;
	f_data.cmd = 'accept';
	
	$.ajax({
		url: '<?php echo base_url('projectdashboard_new/process_invoice');?>',
		data: f_data,
		type: 'POST',
		dataType: 'json',
		success: function(res){
			confirm_data = {};
			if(res.status == 1){
				location.reload();
			}
		}
	});
}

function deny_invoice(){
	
	if(Object.keys(confirm_data).length == 0){
		return false;
	}
	
	var comment = $('#reason_input').val();
	if(comment.trim() == ''){
		$('#reason_input').css('border', '1px solid red');
		return false;
	}else{
		$('#reason_input').css('border', '1px solid #ddd');
	}
	
	$('#cancel-action-btn').html('Processing..');
	$('#cancel-action-btn').attr('disabled', 'disabled');
	
	var f_data = confirm_data;
	f_data.cmd = 'deny';
	f_data.reason_comment = comment;
	$.ajax({
		url: '<?php echo base_url('projectdashboard_new/process_invoice');?>',
		data: f_data,
		type: 'POST',
		dataType: 'json',
		success: function(res){
			confirm_data = {};
			if(res.status == 1){
				location.reload();
			}
		}
	});
}

$(document).ready(function(){
	$('.table').popover({
		selector: '[rel=infopop]',
		trigger: "click",
		}).on("show.bs.popover", function(e){
		$("[rel=infopop]").not(e.target).popover("destroy");
		$(".popover").remove();                    
	});
	
});


$('body').click(function(e){
	var target = $(e.target);
	if(!target.is('i')){
		$("[rel=infopop]").popover("destroy");
		$(".popover").remove(); 
	}
	
});

	
</script>

