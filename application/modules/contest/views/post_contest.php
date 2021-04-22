<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>
<link href="<?php echo CSS;?>select2.min.css" rel="stylesheet"/>
<script src="<?php echo JS;?>select2.min.js"></script>
<script>
    $(window).load(function(){
      $("#sticky_panel").sticky({ topSpacing: 105 , bottomSpacing: 485});
    });
</script>

<style>
input.invalid, select.invalid, textarea.invalid{
	border: 1px solid red;
	border-bottom: 2px solid red;
}
</style>
<?php echo $breadcrumb; ?> 
<section class="sec sec-gray">
    <h2 class="title">Post Contest</h2>
<div class="container">
<?php $lang = $this->session->userdata('lang');?>
		<div class="row">

			<aside class="col-sm-8 col-xs-12">
      		<div class="whiteBg shadow_1 p-15">
				
				<form onsubmit="ajaxSubmit(this, event);">
				
				<h4><?php echo __('contest_what_work_do_you_require','What work do you require')?>?</h4>

				<div class="form-group">
					<select class="form-control" name="category_id" onchange="categorylist(this.value)">
						<option value=""><?php echo __('contest_choose_category','Choose category')?></option>
						<?php if(count($categories) > 0){foreach($categories as $k => $v){ ?>
						<option value="<?php echo $v['id'];?>"><?php echo ($lang == 'estonia') ? $v['swedish_skill_name'] : $v['skill_name'];?></option>
						<?php } } ?>
					</select>
				</div>

				
				<!-- <div class="form-group">
					<select class="form-control">
						<option>Select a job</option>
					</select>
				</div> -->

				<h4><?php echo __('contest_tell_us_more_about_the_contest','Tell us more about the contest')?>?</h4>

				<div class="form-group">
				<label><?php echo __('contest_contest_name','Contest Name')?>: </label>
					<input type="text" name="title" class="form-control" placeholder="<?php echo __('contest_what_is_the_contest_title','What is the contest title')?>?">
				</div>

				<div class="form-group">
				<label><?php echo __('contest_skill','Enter some skills that relate to the contest')?>: </label>
					<!--<select class="form-control inputtag" name="skills[]" multiple></select>-->
					<select class="form-control select2" name="skills[]" multiple id="selectsklls">
						<option><?php echo __('contest_select_a_skill','Select a Skill'); ?></option>
						<?php
						$result = $this->db->select('id, skill_name, swedish_skill_name')->from('skills')->get()->result_array();
						foreach($result as $k => $v){
						?>
						<option value="<?php echo $v['id'];?>"><?php echo ($lang == 'estonia') ? $v['swedish_skill_name'] : $v['skill_name'];?></option>
						<?php
						}
						?>
					</select>
				</div>

				<div class="form-group">
				<label><?php echo __('contest_describe_your_contest_in_detail','Describe your contest in detail')?>: </label>
					<textarea class="form-control" placeholder="<?php echo __('contest_describe_your_contest_here','Describe your contest here')?>..." rows="6" name="description"></textarea>
				</div>

				<div class="form-group">
				
				<div>
					<label><?php echo __('contest_add_file','Add File')?>: </label>
                    <div class="input-group">
                    	<label class="input-group-btn">
                        <span class="btn btn-info">
                            <?php echo __('contest_browse','Browse')?>&hellip; <input type="file" onchange="uploadFiles(this);" style="display: none;">
                        </span>
                    	</label>
                        <input type="text" class="form-control" readonly>
                    </div>
				</div>
				<ul class="list-group" id="attachments_list_group">
				  
				</ul>
				
				</div>

				<h4><?php echo __('contest_what_your_budget','What\'s your budget')?>?</h4>

				<div class="form-group input-group col-sm-6">
				  <span class="input-group-addon"><?php echo CURRENCY; ?></span>
				  <input type="text" class="form-control" placeholder="<?php echo __('contest_budget','Budget')?>" name="budget">
				</div>

				<label><?php echo __('contest_run_your_contest_for','Run your contest for')?>: </label>

				<div class="input-group col-sm-6">
				
				  <span class="input-group-addon"><?php echo __('contest_days','Days')?></span>
				  <input type="text" class="form-control" placeholder="" name="days_run">
				</div>



				<div class="clearfix spacer-10"></div>


				<h4><?php echo __('contest_get_the_most_from_your_contest','Get the most from your contest ! (optional)')?> </h4>

				<table class="table">
					<tr>
						<td><div class="checkbox m-0"><input type="checkbox" class="magic-checkbox" name="is_guranteed" id="is_guranteed" value="1" checked /><label for="is_guranteed">&nbsp;</label></div></td>
						<td><span class="label label-success"><?php echo __('contest_guranteed','GURANTEED')?></span></td>
						<td><?php echo __('contest_gurantee_text','Gurantee freelancers that a winner will be chosen and awarded the prize. This will attract better entries from more freelancers. Money back gurantee is not applicable if a contest has a guaranteed upgrade')?>.</td>
						<td> <b><?php echo __('contest_free','FREE')?> </b></td>
					</tr>


					<tr>
						<td><div class="checkbox m-0"><input type="checkbox" class="magic-checkbox" id="is_featured" name="is_featured" value="1"/><label for="is_featured">&nbsp;</label></div></td>
						<td><span class="label label-warning"><?php echo __('contest_featured','FEATURED')?></span></td>
						<td><?php echo __('contest_featured_text','Attract more freelancers with a prominent placement in our Featured Jobs and Contest\'s page')?>.</td>
						<td><b><?php echo CURRENCY.'&nbsp;'.CONTEST_FEATURED_PRICE;?>  </b></td>
					</tr>
					
					<tr>
						<td><div class="checkbox m-0"><input type="checkbox" class="magic-checkbox" id="is_sealed" name="is_sealed" value="1"/><label for="is_sealed">&nbsp;</label></div></td>
						<td><span class="label label-info"><?php echo __('contest_sealed','SEALED')?></span></td>
						<td><?php echo __('contest_sealed_text','Only you can see individual entries')?></td>
						<td><b><?php echo CURRENCY.'&nbsp;'.CONTEST_SEALED_PRICE;?>  </b></td>
					</tr>
					

				</table>


				<div class="form-group">
					<button class="btn btn-site"><?Php echo __('contest_get_entries_now','Get Entries Now')?></button>
				</div>
				
				</form>

			</div>
			</aside>

			<aside class="col-sm-4 col-xs-12">
      		
				<div class="whiteBg shadow_1 p-15" id="sticky_panel">
				<ol class="counter-list">
					<li><?php echo __('contest_li_1','Post a contest and put up a prize for work required')?></li>
					<li><?php echo __('contest_li_2','Freelancers complete by submitting hundreds of ideas')?></li>
					<li><?php echo __('contest_li_3','Award your prize to the best entry')?>!</li>
				</ol>
				</div>
			</aside>
		</div>

	</div>
</section>
<script>
function categorylist(category)
{
	var dataString = 'cid='+category;
	$.ajax({
		type:"POST",
		data:dataString,
		url:"<?php echo base_url();?>postjob/getcategoryskill/"+category,
		success:function(return_data)
		{
			//alert(return_data); 
			$('#selectsklls').html('');
			$('#selectsklls').html(return_data);
		}
    });
}
</script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
	/* $('.inputtag').tokenize2({
		placeholder: "<?php echo __('postjob_select_a_skill','Select a Skill'); ?>",
		dataSource: function(search, object){
			$.ajax({
				url : '<?php echo base_url('contest/get_skills')?>',
				data: {search: search},
				dataType: 'json',
				success: function(data){
					var $items = [];
					$.each(data, function(k, v){
						$items.push(v);
					});
					object.trigger('tokenize:dropdown:fill', [$items]);
				}
			});
		}
	}); */
	
	function ajaxSubmit(f, e){
		$('.invalid').removeClass('invalid');
		e.preventDefault();
		var fdata = $(f).serialize();
		$.ajax({
			url : '<?php echo base_url('contest/post_contest_ajax')?>',
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
					
					
				}else{
					location.href = '<?php echo base_url('contest/contest_detail')?>/'+res.data.contest_id;
				}
			}
		});
	}
	
	function uploadFiles(ele){
		var files = $(ele)[0].files;
		var fdata = new FormData();
		fdata.append('file', files[0]);
		
		var key = Date.now();
		
		var html = '<li class="list-group-item" id="file_'+key+'"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="sr-only">0% </span></div></div></li>';
		
		$('#attachments_list_group').html(html);
		
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
			url : '<?php echo base_url('contest/upload_attachment')?>',
			data: fdata,
			dataType: 'JSON',
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(res){
				console.log(res);
				if(res.status == 1){
					html = res['data']['org_filename']+'<input type="hidden" name="attachment" value=\''+res['data']['file_str']+'\'/> <a href="javascript:void(0);" onclick="removeAttachment('+key+')" class="pull-right"><i class="zmdi zmdi-delete red-text"></i></a>';
					$('#file_'+key).html(html);
				}else{
					$('#file_'+key).html(res.errors['file']);
				}
			}
		});
		
	}
	
	function removeAttachment(key){
		$('#file_'+key).remove();
	}
	
</script>