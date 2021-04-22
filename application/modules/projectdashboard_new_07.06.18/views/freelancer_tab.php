<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class="<?php echo $active_tab == 'overview' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard_new/freelancer/overview/'.$project_id);?>">Overview</a></li>
<li role="presentation" class="<?php echo $active_tab == 'milestone' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard_new/freelancer/milestone/'.$project_id);?>">Milestones</a></li>
<li role="presentation" class="hidden <?php echo $active_tab == 'question' ? 'active' : '';?>"><a href="#faq">Q & A</a></li>
</ul>