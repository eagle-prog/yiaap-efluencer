<?php 

function check_query($key='' , $arr=array()){
	if(is_array($key)){
		foreach($key as $v){
			if(array_key_exists($v , $arr)){
			unset($arr[$v]);
		}
		}
	}else{
		if(array_key_exists($key , $arr)){
			unset($arr[$key]);
		}
	}
	return count($arr) > 0 ? http_build_query($arr).'&' : '';
}

$lang=$this->session->userdata('lang');

?>
<aside class="col-md-3 col-sm-12 col-xs-12 left-sidebar-freelancer">
    <div class="left_sidebar">
    <h4 class="title-sm"><?php echo __('findtalents_sidebar_skills','Skills'); ?>:</h4>
    <ul class="list-group scroll-bar">
		<?php foreach($parent_skills as $key =>$val){ 
		
		switch($lang){
				case 'arabic':
					$parentSkillName = !empty($val['arabic_skill_name'])? $val['arabic_skill_name'] : $val['skill_name'];
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$parentSkillName = !empty($val['spanish_skill_name'])? $val['spanish_skill_name'] : $val['skill_name'];
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$parentSkillName = !empty($val['swedish_skill_name'])? $val['swedish_skill_name'] : $val['skill_name'];
					break;
				default :
					$parentSkillName = $val['skill_name'];
					break;
			}
		
		?>
		
		<li <?php echo (!empty($srch_param['skill_id']) AND $srch_param['skill_id'] == $val['id']) ? 'class="active"' : '';?>><a href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($val['skill_name']).'/'.$val['id'];?>" id="parent_<?php echo $val['id']?>" data-child="<?php echo $val['id']?>"><span class="checkmark"></span><?php // echo $val['skill_name'];?><?php echo $parentSkillName;?></a></li>

		<?php } ?>
	</ul>
	
<?php if(!empty($srch_param['skill_id'])){ ?>
	<h4 class="title-sm"><?php echo __('findtalents_sidebar_sub_skills','Sub Skills'); ?>:</h4>
	<ul class="list-group scroll-bar">
		<?php foreach($child_skills as $key =>$val){ 
		
		switch($lang){
			case 'arabic':
				$childSkillName = !empty($val['arabic_skill_name'])? $val['arabic_skill_name'] : $val['skill_name'];
				break;
			case 'spanish':
				//$categoryName = $val['spanish_cat_name'];
				$childSkillName = !empty($val['spanish_skill_name'])? $val['spanish_skill_name'] : $val['skill_name'];
				break;
			case 'swedish':
				//$categoryName = $val['swedish_cat_name'];
				
				$childSkillName = !empty($val['swedish_skill_name'])? $val['swedish_skill_name'] : $val['skill_name'];
				break;
			default :
				$childSkillName = $val['skill_name'];
				break;
		}
		
		
		?>
		<li <?php echo (!empty($srch_param['sub_skill_id']) AND $srch_param['sub_skill_id'] == $val['id']) ? 'class="active"' : '';?>><a href="<?php echo base_url('findtalents/browse').'/'.$srch_param['skill'].'/'.$srch_param['skill_id'].'/'.$this->auto_model->getcleanurl($val['skill_name']).'/'.$val['id'];?>" id="child_<?php echo $val['cat_id']?>" data-child="<?php echo $val['id'];?>"><span class="checkmark"></span><?php // echo $val['skill_name'];?><?php echo $childSkillName;?></a></li>
		<?php } ?>
	</ul>
<?php } ?>
		
		
	<h4 class="title-sm hide"><?php echo __('findtalents_sidebar_membership_plan','Membership Plan'); ?>:</h4>
	<?php $url = !empty($srch_string) ? '?'.check_query('memplan' , $srch_string)  : '?'; ?>
    <ul class="list-group shadow_1 hide">
        <li <?php echo (!empty($srch_param['memplan']) AND $srch_param['memplan'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'memplan=All';?>"><span class="checkmark"></span><?php echo __('findtalents_sidebar_all','All'); ?></a></li>
		<?php
			foreach($all_plans as $key=>$val)
			{
			?>
			 <li <?php echo (!empty($srch_param['memplan']) AND $srch_param['memplan'] == $val['id']) ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'memplan='.$val['id'];?>"><span class="checkmark"></span><?php echo $val['name'];?></a></li>
			<?php
			}
			?>
    </ul>
	
		<h4 class="title-sm"><?php echo __('findtalents_sidebar_country','Country'); ?>:</h4>
			<?php $url = !empty($srch_string) ? '?'.check_query(array('ccode' , 'country' , 'city') , $srch_string) : '?'; ?>
		<ul class="list-group scroll-bar">
			<li <?php echo (!empty($srch_param['ccode']) AND $srch_param['ccode'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'country=All&ccode=All';?>"><span class="checkmark"></span><?php echo __('findtalents_sidebar_all','All'); ?></a></li>
			
			<?php foreach($countries as $key=>$val) { ?>
			<li <?php echo (!empty($srch_param['ccode']) AND $srch_param['ccode'] == $val['Code']) ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'country='.$this->auto_model->getcleanurl($val['Name']).'&ccode='.$val['Code'];?>"><span class="checkmark"></span><?php echo $val['Name'];?></a></li>
			<?php } ?>       
		</ul> 
	
		<?php if(!empty($srch_param['ccode']) AND $srch_param['ccode'] != 'All'){ ?>
		<h4 class="title-sm"><?php echo __('findtalents_sidebar_city','City'); ?>:</h4>
			<?php $url = !empty($srch_string) ? '?'.check_query('city' , $srch_string) : '?'; ?>
		<ul class="list-group scroll-bar">
			<li <?php echo (!empty($srch_param['city']) AND $srch_param['city'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'city=All';?>"><span class="checkmark"></span><?php echo __('findtalents_sidebar_all','All'); ?></a></li>
			
			<?php foreach($cities as $key=>$val) { ?>
			<li <?php echo (!empty($srch_param['city']) AND $srch_param['city'] == $val['ID']) ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'city='.$val['ID'];?>"><span class="checkmark"></span><?php echo $val['Name'];?></a></li>
			<?php } ?>       
		</ul>    
		
		<?php } ?>
		
    </div>
</aside>


<script src="<?php echo JS;?>jquery.nicescroll.min.js"></script>
<script>
  $(document).ready(function() {  	    
	$(".scroll-bar").niceScroll();
  });
</script>






