<?php $this->load->view('section-top'); ?>

<section class="sec dashboard">

	<div class="container">
		<div class="row">
			
			<div class="col-sm-8">

				<div class="panel panel-default panel-details">

		          <div class="panel-heading">
		            <p style="display: inline-block;"><b><?php echo __('description','Description')?></b> 
					
						<div class="pull-right">
						<?php if(!empty($details['is_featured']) && $details['is_featured'] == 1){ ?>
						<span class="label label-warning"><?php echo __('contest_featured','FEATURED')?></span>
						<?php } ?>
						
						<?php if(!empty($details['is_guranteed']) && $details['is_guranteed'] == 1){ ?>
						<span class="label label-success"><?php echo __('contest_guranteed','GURANTEED')?></span>
						<?php } ?>
						<?php if(!empty($details['is_sealed']) && $details['is_sealed'] == 1){ ?>
						<span class="label label-info"><?php echo __('contest_sealed','SEALED')?></span>
						<?php } ?>
						</div>
					
					</p>
		          </div>

		          <div class="panel-body">

		          <div class="info">
		        	   <?php echo nl2br($details['description']);?>

					</div>

				<div class="attachment">
					<div class="heading"><?php echo __('file_attached','Files Attached')?></div>
					<?php
					$attachment =  !empty($details['attachment']) ? (array) json_decode($details['attachment']) : array();
					
					?>
					<ul class="list-group">
						<?php if(!empty($attachment['filename'])){ ?>
						<li class="list-group-item">
						
						<a href="<?php echo ASSETS.'attachments/'.$attachment['filename'];?>" target="_blank"><?php echo !empty($attachment['org_filename']) ? $attachment['org_filename'] : $attachment['filename']; ?></a>
						
						</li>
						<?php } ?>
					</ul>
				</div>

				<div class="info">
					<div class="heading"><?php echo __('supported','Supported Submission Files Types')?></div>
					JPG, PNG, GIF

				</div>

		          </div>

        		</div>

        		<div class="panel panel-default panel-details">

        		<div class="panel-heading"> <?php echo __('contest_skill','Recommended Skills')?> </div>

        		 <div class="panel-body">
					<?php if(count($details['skills']) > 0){foreach($details['skills'] as $k => $v){ ?>
					<span class="label label-primary"><?php echo getField('skill_name', 'skills', 'id', $v['skill_id']);?></span>
					<?php } } ?>
        		 </div>

        		</div>

			</div>

			<div class="col-sm-4">
				
				<div class="panel panel-default panel-details">

        		<div class="panel-heading"> <?php echo __('about_emp','About The Employer')?> </div>

        		 <div class="panel-body">
				
        		 	<div class="row">
        		 		<div class="col-sm-3">
						<?php
						$logo = '';
						
						if(!empty($details['employer_detail']['logo'])){
							$logo = base_url('assets/uploaded/'.$details['employer_detail']['logo']);
							
							if(file_exists('./assets/uploaded/cropped_'.$details['employer_detail']['logo'])){
								$logo = base_url('assets/uploaded/cropped_'.$details['employer_detail']['logo']);
							}
						}else{
							$logo = base_url('assets/images/user.png');
						}
						?>
        		 			<img src="<?php echo $logo;?>" height="60" width="60">
        		 		</div>
        		 		<div class="col-sm-9">
        		 			<p><b><?php echo __('member_since','Member since')?>: </b> <?php echo date('F , Y', strtotime($details['employer_detail']['reg_date'])); ?></p>
        		 			<p><b><?php echo __('location','Location')?>: </b> <?php echo getField('Name', 'country', 'Code', $details['employer_detail']['country']); ?></p>
        		 		</div>
        		 	</div>
        		 </div>

        		</div>

			</div>

		</div>
		
	</div>

</section>

