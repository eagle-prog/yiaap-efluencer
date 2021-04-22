<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>
<?php
$lang = $this->session->userdata('lang');
?>
<?php //echo $breadcrumb; ?>
<section class="sec findContest">
  <div class="container">
      <div class="row">
          <div class="col-md-3">
              <h2 class="title">Find Contest</h2>
          </div>
          <div class="col-md-8">
              <div class="searchbox">
                  <form id="srchForm">
                      <div class="input-group input-group-lg">
                          <input type="text" class="form-control" placeholder="<?php echo __('search_title','Search contest by title')?>..." name="term" value="<?php echo !empty($srch['term']) ? $srch['term'] : ''; ?>" autocomplete="off">
                          <span class="input-group-addon" id="basic-addon1">
                            <button type="submit" class="btn btn-site"> <?php echo __('search','Search')?></button>
                          </span>
                      </div>
                      <div class="input-group advanced-search">
                          Advanced Search
                      </div>
                      <div class="spacer-10"></div>
                      <div class="advanced-form form-group" style="display: none">
                          <select class="form-control inputtag" name="skills[]" multiple>
                              <?php if(count($selected_skills) > 0){foreach($selected_skills as $k => $v){ ?>
                                  <option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['skill_name']; ?></option>
                              <?php } } ?>
                          </select>
                      </div>

                  </form>
              </div>
          </div>
      </div>
    <div class="row">
      <aside class="col-md-3 col-sm-12 col-xs-12">
        <div class="left_sidebar">
          <h4 class="title-sm">Category:</h4>
          <ul class="list-group scroll-bar">
            <?php if(count($categories) > 0){foreach($categories as $k => $v){ ?>
            <li><a href="<?php echo base_url('contest/browse/'.$v['id'].'/'.seo_string($v['skill_name'])); ?>"><span class="checkmark"></span><?php echo ($lang == 'estonia') ? $v['swedish_skill_name'] : $v['skill_name']; ?></a></li>
            <?php } } ?>
          </ul>

		  <br/>

		  <h4 class="title-sm"><?php echo __('contest_skill','Skills')?>:</h4>
          <ul class="list-group scroll-bar">
            <?php if(count($skills) > 0){foreach($skills as $k => $v){ ?>
            <li><a href="<?php echo base_url().$srch_url.'?skills%5B%5D='.$v['id'].'/'.seo_string($v['skill_name']); ?>"><span class="checkmark"></span><?php echo ($lang == 'estonia') ? $v['swedish_skill_name'] : $v['skill_name']; ?></a></li>
            <?php } } ?>
          </ul>

		  <br/>

		  <h4 class="title-sm"><?php echo __('contest_sidebar_city','City'); ?>:</h4>
			<?php $url = !empty($srch_string) ? '?'.check_query(array('ID' , 'city') , $srch_string) : '?'; ?>
			<ul class="list-group scroll-bar">
				<li <?php echo (!empty($srch_param['ID']) AND $srch_param['ID'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'CountryCode=EST';?>"><span class="checkmark"></span><?php echo __('all','All'); ?></a></li>

				<?php foreach($cities as $key=>$val) { ?>
				<li <?php echo (!empty($srch_param['ID']) AND $srch_param['ID'] == $val['ID']) ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'city_id='.$val['ID'];?>"><span class="checkmark"></span><?php echo $val['Name'];?></a></li>
				<?php } ?>
			</ul>
        </div>
      </aside>
      <aside class="col-md-8 col-sm-12 col-xs-12">
        <div class="topcontrol_box" style="display:none">
          <div class="topcbott"></div>
        </div>
          <span class="panel-title">Contests</span><!--<span class="found-results">( <?php /*echo count($contest_list);*/?> ) result</span>-->
        <div class="listing">
          <?php if(count($contest_list) > 0){foreach($contest_list as $k => $v){ ?>
          <div class="listBox">
            <p class="designation"><a href="<?php echo base_url('contest/contest-detail/'.$v['contest_id'].'-'.seo_string($v['title'])); ?>"><?php echo $v['title']; ?></a></p>
            <div class="pull-left"><p> <b><?php echo $v['total_entries'];?></b> <?php echo __('entries','Entries')?></p></div>
            <div class="pull-right">
			<?php if($v['is_featured'] == 1){ ?><span class="label-tag label-warning"><i class="zmdi zmdi-star"></i> <?php echo __('contest_featured','FEATURED')?></span> <?php } ?>
			<?php if($v['is_sealed'] == 1){ ?><span class="label-tag label-info"><i class="zmdi zmdi-shield-security"></i> <?php echo __('contest_sealed','SEALED')?></span> <?php } ?>
			<?php if($v['is_guranteed'] == 1){ ?><span class="label-tag label-success"><i class="zmdi zmdi-thumb-up"></i> <?php echo __('contest_guranteed','GURANTEED')?></span> <?php } ?>
			</div>
            <div class="clearfix"></div>
            <p><?php echo strlen($v['description']) > 200 ? substr($v['description'], 0, 200).'...' : $v['description']; ?></p>
            <ul class="skills">
              <li><?php echo __('contest_skill','Skills')?>: </li>
              <?php if(count($v['skills']) > 0){foreach($v['skills'] as $skill){ ?>
              <li><a href="javascript:void(0);"><?php echo $skill['skill_name']; ?></a> </li>
              <?php } } ?>
            </ul>
            <p> <span class="border-tag border-tag-success"><?php echo __('started',
			'Started')?>: <?php echo date('d M , Y', strtotime($v['posted'])); ?></span> &nbsp; <span class="border-tag border-tag-danger"><?php echo __('end','End')?> : <?php echo date('d M , Y', strtotime($v['ended'])); ?></span> <a href="<?php echo base_url('contest/contest-detail/'.$v['contest_id'].'-'.seo_string($v['title'])); ?>" class="btn btn-site btn-sm pull-right"><?php echo __('view_contest','View Contest')?></a> </p>
          </div>
          <?php } }else{  ?>
          <p><?php echo __('sorry_no_results_found','Sorry , No Results Found')?></p>
          <?php  } ?>
            <nav aria-label="Page navigation" id="nav_bar">
              <?php
              $user = $this->session->userdata('user');
              if (isset($user[0]->user_id) && isset($links)) { ?>
                <?php
                echo $links;
                ?>
                <?php
              } else {
                echo "<div class='show-pagination'><a href='".site_url()."login'>Login</a> to see more results</div>";
              }
              ?>
            </nav>
      </aside>
    </div>
  </div>
</section>

<script>
$('.inputtag').tokenize2({
	placeholder: "<?php echo __('contest_select_a_skill','Select a Skill'); ?>",
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
});

$('.inputtag').on('tokenize:tokens:add', function(o){
	$('#srchForm').submit();
});

$('.inputtag').on('tokenize:tokens:remove', function(o){
	$('#srchForm').submit();
});
</script>
<script src="<?php echo JS;?>jquery.nicescroll.min.js"></script>
<script>
  $(document).ready(function() {
	$(".scroll-bar").niceScroll();
  });

  // show advance search
  $('.advanced-search').click(function(){
      $('.advanced-form').toggle('slow');
  });

  if((location.href).indexOf('&skills') !== -1){
      $('.advanced-form').show();
  }

</script>
