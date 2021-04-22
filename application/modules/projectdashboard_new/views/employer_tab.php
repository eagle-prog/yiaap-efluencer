<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class="<?php echo $active_tab == 'overview' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard_new/employer/overview/'.$project_id);?>"><?php echo __('projectdashboard_tab_overview','Overview')?></a></li>
<li role="presentation" class="<?php echo $active_tab == 'milestone' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard_new/employer/milestone/'.$project_id);?>"><?php echo __('projectdashboard_tab_milestone','Milestones')?></a></li>
<li role="presentation" class="<?php echo $active_tab == 'invoices' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard_new/invoices/'.$project_id);?>"><?php echo __('projectdashboard_tab_invoices','Invoices')?></a></li>
</ul>