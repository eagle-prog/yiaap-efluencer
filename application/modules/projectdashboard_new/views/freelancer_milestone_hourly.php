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
	
		<?php if($is_scheduled){  $is_project_running = 1; ?>
		
		<?php if($project_schedule['is_project_start'] == 0){ $is_project_running = 0; ?>
			<div class="alert alert-info">        	
				<p><?php echo __('projectdashboard_the_project_will_be_started_on','The project will be started on')?>: <?php echo date('d M,Y', strtotime($project_schedule['project_start_date'])); ?></p>            
			</div>
		<?php } ?>
		
		<?php if(($project_schedule['is_project_paused'] == 1) && ($project_schedule['is_contract_end'] == 0)){ $is_project_running = 0; ?>
		<div class="alert alert-info">        	
        	<p><?php echo __('projectdashboard_this_project_is_paused_for_now','This project is paused for now')?></p>            
        </div>
		<?php } ?>
		
		<?php if($project_schedule['is_contract_end'] == 1){ $is_project_running = 0; ?>
			<div class="alert alert-info">        	
				<p><?php echo __('projectdashboard_contract_ended','Contract Ended')?></p>            
			</div>
		<?php } ?>
	    
		<h4 class="pull-left"><?php echo __('projectdashboard_work_record','Work Record')?></h4>
		
		<button class="btn btn-primary pull-right" id="send_invoice_btn" disabled><?php echo __('projectdashboard_send_invoice','Send Invoice')?></button>
		
		<?php if(($project_detail['status'] == 'P') && ($is_project_running == 1) && ($project_schedule['manual_request_enable'] == 1)){ ?> <a href="javascript:void(0)" class="btn btn-site pull-right" data-toggle="modal" data-target="#manualHourModal" style="margin-right: 5px;"><?php echo __('projectdashboard_request_manual_hour','Request Manual Hour')?></a> <?php } ?> 
		
		<div class="clearfix"></div>
		<div class="table-responsive">
		<form onsubmit="return false;" id="trackerForm">
		<input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>
        <table class="table">
         <thead>
			<tr>
				<th><input type="checkbox" class="check_all" data-target-class="check_tracker"/></th>
				<th><?php echo __('projectdashboard_start_date','Start Date')?></th>
				<th><?php echo __('projectdashboard_end_date','End Date')?></th>
				<th><?php echo __('duration','Duration')?></th>
				<th><?php echo __('hourly_rate','Hourly Rate')?></th>
				<th><?php echo __('cost','Cost')?></th>
				<th><?php echo __('type','Type')?></th>
				<th><?php echo __('action','Action')?></th>
				<th><?php echo __('payment_status','Payment Status')?></th>
			</tr>
		 </thead>
        <tbody>
			<?php
			if(count($tracker_details)>0){  foreach($tracker_details as $keys=>$vals){ 
			if($vals['worker_id']==$user_id){
			
			 $total_cost_new = 0;
			 $data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$vals['worker_id'])));
			$client_amt = $data['total_amt'];
			
			if($vals['minute'] > 0){
				$minute_cost_min = ($client_amt/60);
				$total_min_cost = $minute_cost_min *floatval($vals['minute']);
				$total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
				$total_hours = floatval($vals['hour']);
				$total_mins = floatval($vals['minute']);
			}else{
				
			/* 	$seconds_new = 0;
				$days_new    = 0;
				$hours_new   = 0;
				$minutes_new = 0;
				$total_cost_new = 0;
				
				$seconds_new = strtotime($vals['stop_time']) - strtotime($vals['start_time']);
				$days_new    = floor($seconds_new / 86400);
				$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
				$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
				$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
				$total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
				
				$total_hours = ($days_new*24)+$hours_new;
				$total_mins = $minutes_new;
				 */
				$minute_cost_min = ($client_amt/60);
				$total_min_cost = 0; // 0 minutes 
				$total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
				$total_hours = floatval($vals['hour']);
				$total_mins = floatval($vals['minute']);
				
				
			}
			
			if(round($total_cost_new,2) == 0){
				continue;
			}
	
			
			/* $total_min_cost = $minute_cost_min *floatval($vals['minute']);
            $total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
			$minute_cost_min = ($client_amt/60); */
            if($vals['payment_status']=='N') {
				
                $payment='<span class="orange-text">'.__('projectdashboard_not_invoiced','Not invoiced').'</span>';
				
            }elseif($vals['payment_status']=='I') {
				
                $payment='<span class="blue-text">'.__('projectdashboard_invoiced','Invoiced').'</span>';
				
            }elseif($vals['payment_status']=='C') {
				
                $payment='<span class="blue-text">'.__('projectdashboard_milestone_cancelled','Canceled').'</span>';
				
            }  elseif($vals['payment_status']=='P'){
				
                $payment='<span class="green-text">'.__('projectdashboard_milestone_paid','Paid').'</span>';
				
            }elseif($vals['payment_status']=='D'){
				
               $payment='<span class="green-text">'.__('projectdashboard_milestone_disputed','Disputed').'</span>';
				
            }
			
			$edit_request = !empty($vals['employer_request']) ? (array) json_decode($vals['employer_request']) : array() ;
			
			
			?>
			<tr>
				<td><?php if(($vals['payment_status'] == 'N') || ($vals['payment_status'] == 'C')){?><input type="checkbox" class="check_tracker" name="tracker_id[]" value="<?php echo $vals['id']; ?>"/><?php } ?></td>
				<td><?php echo date('d F, Y',strtotime($vals['start_time']));?></td>
				<td><?php echo date('d F, Y',strtotime($vals['stop_time']));?></td>
				<td> <?php echo $total_hours;?> <?php echo __('hours','hours')?> <?php echo $total_mins;?> <?php echo __('minutes','minutes')?></td>
				<td class="text-center"><?php echo CURRENCY;?><?php echo $client_amt;?></td> 
				<td><?php echo CURRENCY; ?><?php echo round($total_cost_new,2);?></td>
				<td>
					<?php 
					if($vals['is_manual'] == 0){ 
						echo __('auto','Auto');
					}else{
						echo __('manual','Manual');
					}
					?>
					
					</td>
				<td>
				<?php /*if($vals['payment_status']!='P'){  ?>
				
				<?php if(!empty($edit_request)){ ?>
					<a href="javascript:void(0);" onclick="showRequest(this)" data-request='<?php echo json_encode($edit_request);?>'><i class="fa fa-lg fa-info-circle"></i></a>
						<a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="editHourTracker('<?php echo $vals['id']; ?>', this)" data-prevdata='<?php echo json_encode($vals); ?>'>Edit Hours</a>
						
				<?php } ?>
				<?php  }*/ ?>
				
				<?php if($vals['is_manual'] == 0){ ?>
				<a href="<?php echo base_url('projectdashboard_new/screenshot/'.$vals['id'])?>" class="btn btn-xs btn-info"><?php echo __('projectdashboard_view_screenshots','View Screenshots')?></a>
				<?php } ?>
				</td>
				
				<td><?php echo $payment;?></td>
			</tr>
			<?php } } }else{ ?>
			<tr>
				<td colspan="10" style="text-align:left;"><?php echo __('no_results_found','No data found!!')?></td>
			</tr>
			<?php } ?>
      
        </tbody>
        </table>
		</form>
        </div>
		
		<?php }else{  ?>
		
		<h4 class="pull-left"><?php echo __('projectdashboard_work_record','Work Record')?></h4>
		<div class="clearfix"></div>
		<div class="table-responsive">
		 <table class="table">
		  <thead>
			<tr>
				<th><input type="checkbox" class="check_all"/></th>
				<th><?php echo __('projectdashboard_start_date','Start Date')?></th>
				<th><?php echo __('projectdashboard_end_date','End Date')?></th>
				<th><?php echo __('duration','Duration')?></th>
				<th><?php echo __('hourly_rate','Hourly Rate')?></th>
				<th><?php echo __('cost','Cost')?></th>
				<th><?php echo __('type','Type')?></th>
				<th><?php echo __('action','Action')?></th>
				 <th><?php echo __('payment_status','Payment Status')?></th>
			</tr>
		 </thead>
		 <tbody>
			<tr>
				<td colspan="10" style="text-align:left;"><?php echo __('no_results_found','No data found!!')?></td>
			</tr>
		 </tbody>
		 </table>
		 </div>
		<?php } ?>
		
		
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

<div class="modal fade" id="manualHourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" onclick="$('#manualHourModal').modal('hide');" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('projectdashboard_send_your_work_duration','Send your work duration')?></h4>
      </div>
      <div class="modal-body">     
       
       <div id="enquiry_form">
			<form onsubmit="sendManualHour(this , event)" action="<?php echo VPATH?>projectdashboard_new/add_manual_hour/<?php echo $project_id;?>" method="post" class="form-horizontal">            
           
            <div class="form-group">
                <label class="col-sm-4"><?php echo __('projectdashboard_start_date','Start Date')?>:</label>
                <div class="col-sm-8 col-xs-12">
                <div class='input-group datepicker'>
                    <input type='text' class="form-control" placeholder="<?php echo __('projectdashboard_start_date','Start Date')?>" required name="start_date" id="tracker_from" value="" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
            </div>                       
                        
            <div class="form-group">
            	<label class="col-sm-4"><?php echo __('projectdashboard_end_date','End Date')?>:</label>
                <div class="col-sm-8 col-xs-12">
                <div class='input-group datepicker'>
                    <input type='text' class="form-control" placeholder="<?php echo __('projectdashboard_end_date','End Date')?>" required name="to_date" id="tracker_to" value="" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>                
                </div>
            </div>              
            
            <div class="form-group">
                <label class="col-sm-4"><?php echo __('total','Total')?> <?php echo __('duration','Duration')?>:</label>       
				<div class="col-sm-4 col-xs-12">
                	<input type="number" class="form-control" placeholder="<?php echo __('total','Total')?> <?php echo __('hour','hour')?>" required name="duration" value=""  max="<?php echo $bid_detail['available_hr']; ?>" onblur="checkRequestHour(this);" min="0"/>
               </div>
			   <div class="col-sm-4 col-xs-12">
			   <select class="form-control" name="minute">
			   <option value="0"><?php echo __('minutes','minutes')?></option>
			    <?php for($i=5;$i<60;$i++){ 
				if($i%5 == 0){
				?>
				
				 <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } } ?>
			   </select>
			  
                
               </div>
            </div> 

			<div class="form-group">
			<?php
			
			$activity =$this->db->select('*')->from('project_activity')->where("project_id = '$project_id' AND id IN(select activity_id from serv_project_activity_user where assigned_to = '$user_id' AND approved = 'Y')")->get()->result_array();
			
			?>
            <label class="col-sm-4">Choose activity:</label>          
			<div class="col-sm-8 col-xs-12">
					<?php if(count($activity) > 0){foreach($activity as $k => $v){ ?>
					<label><input type="checkbox" class="" placeholder="Total hour" name="activity[]" value="<?php echo $v['id'];?>"/> <?php echo $v['task']; ?> </label> <a href="#" class="pull-right" data-toggle="popover" title="Description" data-placement="left" data-content="<?php echo !empty($v['desc']) ? $v['desc'] : __('n/a','N/A'); ?>"><i class="fa fa-lg fa-info-circle"></i></a><br/>
					<?php } }else{
						echo __('n/a','N/A');
					  } ?>
				</div>
			
            </div> 			
			
			 <div class="form-group">
                 <label class="col-sm-4"><?php echo __('comments','Comments')?>:</label>      
                 <div class="col-sm-8 col-xs-12"><textarea name="comment" class="form-control"></textarea></div>
             </div> 
			
            <div class="form-group">           
                <div class="col-sm-8 col-sm-offset-4 col-xs-12">
                    <input type="submit" class="btn btn-site" value="<?php echo __('submit','Submit')?>" name="submit" />
                    <button type="button" class="btn btn-default pull-right" onclick="$('#manualHourModal').modal('hide');"><?php echo __('close','Close')?></button>  
                </div>
            </div>
            </form>
	   </div>                       
      </div>      
    </div>
  </div>
</div>

<div id="activityModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#activityModal').modal('hide');">&times;</button>
        <h4 class="modal-title"><?php echo __('activity','Activity')?></h4>
      </div>
      <div class="modal-body">
	  
       <div id="activity_ajax"></div>
	   <b><?php echo __('comments','Comments')?> : </b>
	   <div id="activity_cmt"></div>
	   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#activityModal').modal('hide');"><?php echo __('close','Close')?></button>
      </div>
    </div>

  </div>
</div>

<div id="infoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#infoModal').modal('hide');">&times;</button>
        <h4 class="modal-title"><?php echo __('info','Info')?></h4>
      </div>
      <div class="modal-body">
	 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#infoModal').modal('hide');"><?php echo __('close','Close')?></button>
      </div>
    </div>

  </div>
</div>

<div id="editHourModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#editHourModal').modal('hide');">&times;</button>
        <h4 class="modal-title"><?php echo __('projectdashboard_edit_hour_request','Edit Hour Request')?></h4>
      </div>
      <div class="modal-body">
		<form id="editHourForm" class="form-horizontal" onsubmit="editHourSubmit(this, event)" action="<?php echo base_url('projectdashboard_new/hour_edit_ajax'); ?>">
			<input type="hidden" name="manual_tracker_id" value=""/>
			<div class="form-group">
                <label class="col-sm-4"><?php echo __('total','Total')?> <?php echo __('duration','Duration')?>:</label>       
				<div class="col-sm-4 col-xs-12">
                	<input type="number" class="form-control" placeholder="<?php echo __('total','Total')?> <?php echo __('hours','hours')?>" required name="hour" value="" onblur="checkRequestHour(this)" max="<?php echo $bid_detail['available_hr']; ?>"/>
               </div>
			   <div class="col-sm-4 col-xs-12">
			   <select class="form-control" name="minute">
			   <option value="0"><?php echo __('minutes','minutes')?></option>
			    <?php for($i=5;$i<60;$i++){ 
				if($i%5 == 0){?>
				 <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } } ?>
			   </select>
			  
               </div>
            </div>
			
			<div class="form-group">           
                <div class="col-sm-8 col-sm-offset-4 col-xs-12">
                    <input type="submit" class="btn btn-site" value="<?php echo __('update','Update')?>" name="submit">
                    <button type="button" class="btn btn-default pull-right" onclick="$('#editHourModal').modal('hide');"><?php echo __('close','Close')?></button>  
                </div>
            </div>
			
		</form>
      </div>
    </div>

  </div>
</div>


<div id="editHourModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#editHourModal2').modal('hide');">&times;</button>
        <h4 class="modal-title"><?php echo __('projectdashboard_edit_hour_request','Edit Hour Request')?></h4>
      </div>
      <div class="modal-body">
		<form id="editHourFormTracker" class="form-horizontal" onsubmit="editHourSubmit(this, event)" action="<?php echo base_url('projectdashboard_new/hour_auto_edit_ajax'); ?>">
			<input type="hidden" name="tracker_id" value=""/>
			<div class="form-group">
                <label class="col-sm-4"><?php echo __('total','Total')?> <?php echo __('duration','Duration')?>:</label>       
				<div class="col-sm-4 col-xs-12">
                	<input type="number" class="form-control" placeholder="<?php echo __('total','Total')?> <?php echo __('hours','hours')?>" required name="hour" value="" />
               </div>
			   <div class="col-sm-4 col-xs-12">
			   <select class="form-control" name="minute">
			   <option value="0"><?php echo __('minutes','minutes')?></option>
			    <?php for($i=5;$i<60;$i++){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			   </select>
			  
               </div>
            </div>
			
			<div class="form-group">           
                <div class="col-sm-8 col-sm-offset-4 col-xs-12">
                    <input type="submit" class="btn btn-site" value="<?php echo __('update','Update')?>" name="submit">
                    <button type="button" class="btn btn-default pull-right" onclick="$('#editHourModal2').modal('hide');"><?php echo __('close','Close')?></button>  
                </div>
            </div>
			
		</form>
      </div>
    </div>

  </div>
</div>

<script id="employerRequestTemp" type="text/template">
	<div>
		<p><b><?php echo __('projectdashboard_requested_hour_to_edit','Requested hour to edit')?> :</b>  {HOUR_EDIT} <?php echo __('hr','hr')?></p>
		<p><b><?php echo __('projectdashboard_requested_minute_to_edit','Requested minute to edit')?> :</b>  {MINUTE_EDIT} <?php echo __('min','min')?></p>
		<p> {COMMENT} </p>
	</div>

</script>
<script type="text/javascript">

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});
	
function loadActivity(act, ele){
	var cmt = $(ele).data('comment');
	if(cmt == ''){
		cmt = 'N/A';
	}
	$('#activity_cmt').html(cmt);
	$.get('<?php echo base_url('projecthourly/getactivity?activity=')?>'+act, function(res){
		$('#activity_ajax').html(res);
		
	});
	$('#activityModal').modal('show');
	
}

function sendManualHour(f, e){
	$(f).find('[type="submit"]').attr('disabled', 'disabled');
	ajaxSubmit(f, e , function(res){
		if(res.status == 1){
			location.reload();
		}
		$(f).find('[type="submit"]').removeAttr('disabled');
	});
}


function ajaxSubmit(f, e , callback){
	
	$('.invalid').removeClass('invalid');
	e.preventDefault();
	var fdata = $(f).serialize();
	var url = $(f).attr('action');
	$.ajax({
		url : url,
		data: fdata,
		dataType: 'json',
		type: 'POST',
		success: function(res){
			if(res.errors){
				for(var i in res.errors){
					i = i.replace('[]', '');
					$('[name="'+i+'"]').addClass('invalid');
					$('#'+i+'Error').html(res.errors[i]);
				}
				
				var offset = $('.invalid:first').offset();
				
				if(offset){
					$('html, body').animate({
						scrollTop: offset.top
					});
				}
				
				
			}
			
			if(typeof callback == 'function'){
				callback(res);
			}
		}
	});
}


function checkRequestHour(ele){
	var max = parseInt($(ele).attr('max'));
	var val = parseInt($(ele).val());
	
	if(max <= val){
		$('select[name="minute"]').find('option:not([value="0"])').hide();
		$('select[name="minute"]').val(0);
	}else{
		$('select[name="minute"]').find('option').show();
	}
	
}

function showRequest(ele){
	var req_data = $(ele).data('request');
	var temp_html = $('#employerRequestTemp').html();
	
	
	temp_html = temp_html.replace(/{HOUR_EDIT}/g, req_data.duration);
	temp_html = temp_html.replace(/{MINUTE_EDIT}/g, req_data.minute);
	temp_html = temp_html.replace(/{COMMENT}/g, req_data.comment);
	
	
	$('#infoModal').find('.modal-body').html(temp_html);
	
	$('#infoModal').modal('show');
}


function editHour(id, ele){
	var prev_data = $(ele).data('prevdata');
	prev_data.minute = prev_data.minute.replace('.00', '');
	prev_data.hour = prev_data.hour.replace('.00', '');
	
	$('#editHourForm').find('[name="manual_tracker_id"]').val(id);
	$('#editHourForm').find('[name="hour"]').val(prev_data.hour);
	$('#editHourForm').find('[name="minute"]').val(prev_data.minute);
	
	$('#editHourModal').modal('show');
	
}

function editHourTracker(id, ele){
	var prev_data = $(ele).data('prevdata');
	prev_data.minute = prev_data.minute.replace('.00', '');
	prev_data.hour = prev_data.hour.replace('.00', '');
	
	$('#editHourFormTracker').find('[name="tracker_id"]').val(id);
	$('#editHourFormTracker').find('[name="hour"]').val(prev_data.hour);
	$('#editHourFormTracker').find('[name="minute"]').val(prev_data.minute);
	
	$('#editHourModal2').modal('show');
	
}

function editHourSubmit(f , e){
	ajaxSubmit(f , e, function(res){
		if(res.status == 1){
			location.reload();
		}
	});
}


$(document).ready(function(){
	
	$('.check_all').change(function(){
		var is_check = $(this).prop('checked');
		var target = $(this).data('targetClass');
		if(is_check){
			$('.'+target).prop('checked', true);
		}else{
			$('.'+target).prop('checked', false);
		}
		
		checkCount();
	});
	
	$('.check_tracker').change(function(){
		checkCount();
	});
	
	$('#send_invoice_btn').click(function(){
		var fdata = $('#trackerForm').serialize();
		$.ajax({
			url: '<?php echo base_url('projectdashboard_new/create_invoice_hourly')?>',
			data: fdata,
			type: 'POST',
			dataType: 'JSON',
			success: function(res){
				if(res.status == 1){
					location.reload();
				}
			}
		});
	});
	
});

function checkCount(){
	var checked_ele = $('.check_tracker:checked').length;
	if(checked_ele > 0){
		$('#send_invoice_btn').removeAttr('disabled');
	}else{
		$('#send_invoice_btn').attr('disabled', 'disabled');
	}
}
</script>