<section id="autogenerate-breadcrumb-id-faq" class="breadcrumb-classic">
  <div class="container">
    <div class="row">
    <aside class="col-sm-6 col-xs-12">
		<h3>Frequently Asked Questions</h3>
    </aside>
    <aside class="col-sm-6 col-xs-12">
	<ol class="breadcrumb pull-right">
      <li><a href="<?php echo base_url();?>">Home</a></li>
      <li class="active">FAQ</li>
    </ol>
    </aside>            
    </div>
	</div>       
</section>
<section class="sec">
<div class="container">      
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <?php foreach($faq_question_parent as $key=> $val){?>
          <div class="accordion-item panel panel-default">
            <div class="panel-heading">
            <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $key?>" aria-expanded="true">
			<i class="zmdi zmdi-plus"></i> <?=$val['name']?></a></h4>            
            </div>
            <div id="collapse_<?php echo $key?>" class="panel-collapse collapse">             
            <div class="accordion-inner panel-body">
            <div class="inner_cont">
                <p><?php foreach($val['sub_title']  as $key=> $show){?>
                <h4 class="qstn"><?=$show['faq_question']?></h4>                
                <div class="ans"><?php echo html_entity_decode($show['faq_answers']);?></div>
                <?php }?>
                </p>
              </div>
            </div>
            </div>
          </div>
          <?php }?>
	</div>
      
    <?php 
  
  if(isset($ad_page)){ 
    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M","status"=>"Y"));
  if($type=='A') 
  {
   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M","status"=>"Y")); 
  }
  else
  {
   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M","status"=>"Y"));
    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M","status"=>"Y")); 
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
    <div class="clearfix"></div>
  </div>
</section>
<style>
ul, li, ol {
	list-style:inside disc;
}
.panel-title {
    font-size: 18px;
}
</style>