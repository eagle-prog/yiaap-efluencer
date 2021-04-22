<!-- Main Content start-->
<section id="autogenerate-breadcrumb-id-knowledgebase" class="breadcrumb-classic">
  <div class="container">
    <div class="row">
    <aside class="col-sm-6 col-xs-12">
		<h3>Knowledge Base Articles</h3>
    </aside>
    <aside class="col-sm-6 col-xs-12">
	<ol class="breadcrumb text-right">
      <li><a href="<?php echo base_url();?>">Home</a></li>
      <li class="active">Knowledge Base Articles</li>
    </ol>
    </aside>            
    </div>
	</div>       
</section>

<section class="sec">
  <div class="container">

      <div class="posts-block">        
          <div class="post-content"> 
             <!-- 2 Column Testimonials -->

        <!--<div class="accordionMod panel-group">-->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <?php foreach($faq_question_parent  as $key=> $val){?>
            <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $key?>" aria-expanded="true" aria-controls="collapseOne">
                  <i class="zmdi zmdi-plus"></i> <?=$val['name']?>
                </a>
              </h4>
            </div>
            <!--<h4 class="accordion-toggle">
            
             
            </h4>
            <section class="accordion-inner panel-body">-->
            <div id="collapse_<?php echo $key?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_">
      		<div class="panel-body">
              <p>
              <div class="inner_cont">
                <p>
                  <?php foreach($val['sub_title']  as $key=> $show){?>
                  <div class="qstn">
                  <?=$show['title']?>
                  </div>
                  <div class="ans">
                  <?php echo html_entity_decode($show['content']);?></div>
                  <?php }?>
                </p>
              </div>
              </p>
            </div>
            </div>
          </div>
          <?php }?>
        </div>

    <!-- contact box end End-->
          </div>
      </div>
      <!-- Left Section End --> 
    <?php 
  
  if(isset($ad_page)){ 
    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
  if($type=='A') 
  {
   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
  else
  {
   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
        
      if($type=='A'&& $code!=""){ 
?>
    <div class="addbox2">
      <?php 
   echo $code;
 ?>
    </div>
    <?php                      
      }
   elseif($type=='B'&& $image!="")
   {
  ?>
    <div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
    <?php  
 }
  }

?>
  </div>
</section>
<!-- Main Content end--> 
<script>
$(document).ready(function(){
$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".zmdi-plus").removeClass("zmdi-plus").addClass("zmdi-minus");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".zmdi-minus").removeClass("zmdi-minus").addClass("zmdi-plus");
});
});
</script>

