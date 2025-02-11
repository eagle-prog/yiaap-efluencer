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
    
    <h4>Invoices </h4>	
    <div class="table-responsive">
    
    <!-- working area -->
        <table class="table">
        <thead>
        <tr>
            <th>Invoice Number</th> <th>Invoice type</th> <th>Date</th><th>From/To</th><th>Status</th><th>Action</th><th>Invoice</th>
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
			   echo 'Pending';
		   }elseif($is_deleted == 1){
			   echo 'Deleted';
		   }elseif($is_paid == 1){
			   echo 'Paid';
		   }
		   
		   ?>
		   </td>
		   <td>
		   <?php if(($is_pending == 1) && ($v['receiver_id'] == $user_id)){ ?>
		   
			<?php if($project_type == 'H'){ ?>
		   <a href="javascript:void(0)" onclick="accept_invoice(this)" data-invoice-id="<?php echo $v['invoice_id']; ?>" data-project-type="<?php echo $project_type; ?>" data-project-id="<?php echo $project_id; ?>">Accept</a> |
		   <a href="javascript:void(0)" onclick="deny_invoice(this)" data-invoice-id="<?php echo $v['invoice_id']; ?>" data-project-type="<?php echo $project_type; ?>" data-project-id="<?php echo $project_id; ?>">Deny</a> 
		   <?php } ?>
		   
		   <?php 
		   
		   if($project_type == 'F'){ 
			$milestone_id = getField('id', 'project_milestone', 'invoice_id', $v['invoice_id']);
			
		   ?>
		   <a href="javascript:void(0);" onclick="milestone_action('<?php echo VPATH;?>myfinance/releaseFund/<?php echo $milestone_id;?>/A/?next=projectdashboard_new/invoices/<?php echo $project_id; ?>', 'release')">Accept</a> | 
		   <a href="javascript:void(0);" onclick="milestone_action('<?php echo VPATH;?>myfinance/cancelpayment/<?php echo $milestone_id;?>', 'cancel')">Deny</a>
		   
		   <?php } ?>
		   
		   <?php } ?>
		   </td>
         
		   <td><a href="<?php echo base_url('invoice/detail/'.$v['invoice_id'])?>" target="_blank">View</a></td>
        </tr>
		<?php } }else{   ?>
		<tr>
			<td colspan="10" style="text-align:left;">No records</td>
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
        <a type="button" class="btn btn-primary" id="release-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_accept','Accept'); ?></a>
        <a type="button" class="btn btn-primary" id="cancel-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_cancel','Cancel'); ?></a>
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
        <h4 class="modal-title">Request</h4>
      </div>
      <div class="modal-body">
        <div id="commentB">
			<h4>Comment: </h4>
			<div id="commentV"></div>
		</div>
        <div id="attachmentB">
			
		</div>
		<input type="hidden" id="choosen_milestone_id" value="0"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-site" onclick="milestoneRequestAction('A')">Approve</button>
        <button type="button" class="btn btn-danger" onclick="milestoneRequestAction('R')">Reject</button>
      </div>
    </div>

  </div>
</div>


<script>

function accept_invoice(ele){
	var invoice_id = $(ele).data('invoiceId');
	var project_type = $(ele).data('projectType');
	var project_id = $(ele).data('projectId');
	if(invoice_id == '' || project_type == ''){
		return false;
	}
	$(ele).parent().html('Processing...');
	$.ajax({
		url: '<?php echo base_url('projectdashboard_new/process_invoice');?>',
		data: {invoice_id: invoice_id, project_type: project_type, cmd: 'accept', project_id: project_id},
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}
		}
	});
}

function deny_invoice(ele){
	var invoice_id = $(ele).data('invoiceId');
	var project_type = $(ele).data('projectType');
	var project_id = $(ele).data('projectId');
	if(invoice_id == '' || project_type == ''){
		return false;
	}
	$(ele).parent().html('Processing...');
	$.ajax({
		url: '<?php echo base_url('projectdashboard_new/process_invoice');?>',
		data: {invoice_id: invoice_id, project_type: project_type, cmd: 'deny', project_id: project_id},
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}
		}
	});
}



</script>


<script>
function milestone_action(link, action){
	if(action == 'release'){
		$('#release-action-btn').attr('href', link);
		$('#release-action-btn').show();
		$('#cancel-action-btn').hide();
		$('#dispute-action-btn').hide();
		$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_relese_payment','Are you sure to release payment ?'); ?>');
	}else if(action == 'cancel'){
		$('#cancel-action-btn').attr('href', link);
		$('#cancel-action-btn').show();
		$('#release-action-btn').hide();
		$('#dispute-action-btn').hide();
		$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_cancel_payment','Are you sure to cancel payment ?'); ?>');
	}else if(action == 'dispute'){
		$('#dispute-action-btn').attr('href', link);
		$('#dispute-action-btn').show();
		$('#release-action-btn').hide();
		$('#cancel-action-btn').hide();
		$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_dispute_payment','Are you sure to dispute payment ?'); ?>');
	}
	$('#infoModal').modal('show');
}


function viewRequestData(ele, milestone_id){
	var req_data = $(ele).data('request');
	var comment = req_data.comments;
	var attachments = req_data.attachments;
	
	var attachment_str =  comment_str = '';
	
	$('#choosen_milestone_id').val(milestone_id);
	
	if(comment.length > 0){
		comment_str = comment;
	}else{
		comment_str = '<i>No comments</i>';
	}
	
	console.log(req_data);
	
	if(attachments.length > 0){
		attachment_str += '<h4>Attachments</h4>';
		for(var i in attachments){
			attachments[i] = JSON.parse(attachments[i]);
			var ATTACHMENT_URL = '<?php echo ASSETS;?>'+'attachments/'+attachments[i].filename;
			attachment_str += '<p><a href="'+ATTACHMENT_URL+'" target="_blank">'+attachments[i].org_filename+'</a></p>';
		}
	}
	
	$('#commentV').html(comment_str);
	$('#attachmentB').html(attachment_str);
	
	$('#requestModal').modal('show');
	
}

function milestoneRequestAction(action){
	var m_id = $('#choosen_milestone_id').val();
	$.ajax({
		url: '<?php echo base_url('projectdashboard_new/milestone_request_action')?>',
		data: {milestone_id: m_id, action: action},
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}
		}
	});
}

</script>
