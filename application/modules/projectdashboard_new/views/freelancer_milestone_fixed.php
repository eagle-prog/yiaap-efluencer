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
.invalid {
    border: 2px solid red;
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
    <?php $this->load->view('freelancer_tab'); ?>
    
    <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="overview">
    
    <h4><?php echo __('projectdashboard_tab_milestone','Milestones')?></h4>	
    <div class="table-responsive">
    
    <!-- working area -->
        <table class="table">
        <thead>
        <tr>
            <th><?php echo __('projectdashboard_milestone_no','Milestone No')?></th><th><?php echo __('projectdashboard_milestone_amount','Amount')?>(<?php echo CURRENCY;?>)</th><th><?php echo __('projectdashboard_milestone_project','Project')?></th><th><?php echo __('date','Date')?></th><th><?php echo __('title','Title')?></th><th><?php echo __('projectdashboard_milestone_payment_request','Payment Request')?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($set_milestone_list as $key=>$val)
        {
            
        $is_escrowed = 0;
        $escrow_row = $this->db->where('milestone_id', $val['id'])->get('escrow_new')->row_array();
        if(!empty($escrow_row)){
            $is_escrowed = 1;
        }
        $project_name=$this->auto_model->getFeild("title","projects","project_id",$val['project_id']);
        ?>
        
        <tr>
        <td><?=$val['milestone_no']?></td>
        <td><?=$val['amount']?></td>
        <td><?=$project_name?></td>
        <td><?php echo $val['mpdate'] != '0000-00-00' ? $this->auto_model->date_format($val['mpdate']) : __('at_project_ends','At Project Ends') ;?></td>
        <td><?=$val['title']?></td>
        <?php
        if($val['client_approval']=='N'){
        echo "<td>".__('not_pprove','Not Approve')."</td>";
        }
        elseif($val['client_approval']=='Y')
        {
        if($val['fund_release']=='P'){
            $str = '';
            if($val['approval']=='N'){
                $str = '<a href="javascript:void(0)" onclick="sendRequest('.$val['id'].')">'.__('send_request','Send Request').'</a>';
            }else if($val['approval']=='P'){
                $str = __('approval_pending','Approval pending');
            }else if($val['approval']=='R'){
                $str = 'Rejected | <a href="javascript:void(0)" onclick="sendRequest('.$val['id'].')">'.__('send_request','Send Request').'</a>';
            }else{
                $str = '<a href="javascript:void(0);" class="one_click" data-href="'.VPATH.'dashboard/FundRequest/'.$val['id'].'?next=projectdashboard_new/freelancer/milestone/'.$val['project_id'].'" style="float:none">'.__('send_invoice','Send Invoice').'</a>';
            }
        ?>
        <td><?php echo $str;?></td>
        <?php
        }
        elseif($val['fund_release']=='R' && $val['release_payment'] == 'R'){
            $today = strtotime(date('Y-m-d'));
            $last_check = strtotime("+7 days", strtotime($val['requested_date']));
        ?>
        <td>
        <?php if($today > $last_check){ ?>
        <button onclick="sendRemainder('<?php echo $val['id']?>');" class="btn btn-xs btn-danger"><?php echo __('send_remainder','Send Remainder')?></button>
        <?php } ?>
        <?php echo __('unpaid','Unpaid')?> | <?php if($val['invoice_id'] > 0){ ?><a href="<?php echo base_url('/invoice/detail/'.$val['invoice_id'].'/'.'F')?>" target="_blank"><?php echo __('invoice','Invoice')?></a><?php }else{ echo __('n/a','N/A'); } ?>
        <?php if(($is_escrowed == 1 ) && ($escrow_row['status'] == 'D')){ ?>
        <?php echo __('disputed','Disputed')?> | <a href="#"><?php echo __('view','View')?></a>
        <?php } ?>
        </td>
        <?php
        }else if($val['fund_release']=='R' && $val['release_payment'] == 'D'){ ?>
        
        <td>
        <?php if(($is_escrowed == 1 ) && ($escrow_row['status'] == 'D')){ ?>
            <?php echo __('disputed','Disputed')?> | <a href="<?php echo base_url('projectdashboard/dispute_room/'.$val['id'].'/'.$val['project_id']); ?>"><?php echo __('view','View')?></a>
        <?php } ?>
        </td>
        
        <?php
            
        }elseif($val['fund_release']=='A'){
        
        ?>    
        <td><i class="zmdi zmdi-check-circle f16 green-text" title="Fund Approve"></i> | <?php if($val['invoice_id'] > 0){?><a href="<?php echo base_url('/invoice/detail/'.$val['invoice_id'].'/'.'F')?>" target="_blank"><?php echo __('invoice','Invoice')?></a><?php }else{ echo __('n/a','N/A');}?> | <?php if($val['commission_invoice_id'] > 0){?><a href="<?php echo base_url('/invoice/detail/'.$val['commission_invoice_id'].'/'.'F')?>" target="_blank"><?php echo __('commission_invoice','Commission invoice')?></a><?php }else{ echo 'N/A';}?></td>
        <?php
        }else if($val['release_payment']=='C'){
            echo '<td>Cancelled <a href="javascript:void(0);" class="one_click" data-href="'.VPATH.'dashboard/FundRequest/'.$val['id'].'?next=projectdashboard_new/freelancer/milestone/'.$val['project_id'].'">'.__('resend','Resend').'</a> | ';
			if($val['invoice_id'] > 0){
				echo '<a href="'.base_url('/invoice/detail/'.$val['invoice_id'].'/'.'F').'" target="_blank">'.__('invoice','Invoice').'</a></td>';
			}else{
				echo __('n/a','N/A');
			}
        }
        
        }
        ?>
        </tr>
        <?php } ?>
        </tbody>
        </table>
        
    
    <!-- working area -->
    
    </div>
    
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

<!-- Modal -->
<div id="requestModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#requestModal').modal('hide');">&times;</button>
        <h4 class="modal-title"><?php echo __('send_request','Send Request')?></h4>
      </div>
      <div class="modal-body">
        <form id="requestForm">
			<input type="hidden" name="milestone_id" value="0" id="milestone_id"/>
			<div id="hidden_attachments"></div>
			<div class="form-group">
				<label><?php echo __('add_comment','Add Comment')?></label>
				<textarea name="request_comment" class="form-control" placeholder="Add your comment here.."></textarea>
			</div>
			<div class="form-group">
				<label><?php echo __('attachments','Attachment')?></label> (<?php echo __('allowed_files_types','Allowed files types')?> : <b>jpg, png, gif, doc, txt, pdf</b>)
				<input type="file" onchange="uploadFiles(this)"/>
				<div id="attachmentsError"></div>
			</div>
			<div class="file_list"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-site" id="sendRequestBtn"><?php echo __('send','Send')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#requestModal').modal('hide');"><?php echo __('close','Close')?></button>
      </div>
    </div>

  </div>
</div>


<script>

$('#sendRequestBtn').click(function(){
	var fdata = $('#requestForm').serialize();
	if($('#requestForm').find('[name="request_comment"]').val().trim() == ''){
		$('#requestForm').find('[name="request_comment"]').addClass('invalid');
		return false;
	}
	
	$('.invalid').removeClass('invalid');
	$(this).attr('disabled', 'disabled');
	$.ajax({
		url : '<?php echo base_url('projectdashboard_new/milestone_request_ajax')?>',
		data: fdata,
		type: 'post',
		dataType: 'json',
		success:function(res){
			if(res.status == 1){
				location.reload();
			}
			
		}
	});
});


function sendRemainder(milestone_id){
	$.ajax({
		url: '<?php echo base_url('projectdashboard_new/send_remainder')?>',
		data: {milestone_id: milestone_id},
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}
		}
	});
}


function sendRequest(milestone_id){
	$('#requestForm').find('#milestone_id').val(milestone_id);
	$('#requestModal').modal('show');
}

function uploadFiles(ele){
		var allowed_type = ["image/jpg", "image/jpeg", "image/png", "image/gif","application/pdf", "application/docx","text/plain", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
		var files = $(ele)[0].files;
		console.log(files);
		var fdata = new FormData();
		fdata.append('file', files[0]);
		
		if(allowed_type.indexOf(files[0]['type']) < 0){
			$('#attachmentsError').html('<?php echo __('please_upload_a_valid_file','Please upload a valid file')?>');
			return false;
		}else{
			$('#attachmentsError').html('');
		}
		
		var key = Date.now();
		
		var html = '<div class="list-container" id="file_'+key+'"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="sr-only">0% </span></div></div></div>';
		
		$('.file_list').prepend(html);
		
		$.ajax({
			 xhr: function() {
				var xhr = new window.XMLHttpRequest();

				xhr.upload.addEventListener("progress", function(evt) {
				  if (evt.lengthComputable) {
					
					var percentComplete = evt.loaded / evt.total;
					percentComplete = parseInt(percentComplete * 100);
					$('#file_'+key).find('.progress-bar').css('width', percentComplete+'%').attr('aria-valuenow', percentComplete);
					$('#file_'+key).find('.sr-only').html(percentComplete+'%');

				  }
				}, false);

				return xhr;
			},
			url : '<?php echo base_url('projectdashboard_new/upload_attachment')?>',
			data: fdata,
			dataType: 'JSON',
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(res){
				if(res.status == 1){
				
					html = '<div class="at_f">'+res['data']['org_filename']+'<a class="rem" href="javascript:void(0)" onclick="removeAttachment('+key+')"><?php echo __('remove','Remove')?></a></div>';
					
					var html2 = '<input type="hidden" class="file_input_'+key+'" name="attachments[]" value=\''+res['data']['file_str']+'\'/>';
					
					$('#file_'+key).html(html);
					
					$('#hidden_attachments').append(html2);
				}else{
					$('#file_'+key).html(res.errors['file']);
				}
			}
		});
		
	}
	
	
	function removeAttachment(key){
		$('#file_'+key).remove();
		$('.file_input_'+key).remove();
	}
	
	$('.one_click').click(function(){
		var href = $(this).attr('data-href');
		if(href){
			$(this).replaceWith('Processing... ');
			location.href = href;
		}
		
	});
	
</script>
