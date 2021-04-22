
<?php 
if(!function_exists('get_file_icon')){
	
	
	function get_file_icon($file_name=''){
		
		$icons = array(
			'doc' => DOC_ICON,
			'docx' => DOC_ICON,
			'pdf' => PDF_ICON,
			'txt' => TXT_ICON,
		);
		$default_file_icon = COMMON_ICON;
		
		$file_part = explode('.', $file_name);
		$file_ext = trim(end($file_part));
		
		if(!empty($icons[strtolower($file_ext)])){
			$file_icon = $icons[strtolower($file_ext)];
		}else{
			$file_icon = $default_file_icon;
		}
		
		return $file_icon;
		
	}
	
}

$sender_logo=$this->auto_model->getFeild('logo','user','user_id',$sendID);

if($sender_logo && file_exists('assets/uploaded/cropped_'.$sender_logo)){
	$sender_logo = 'cropped_'.$sender_logo;
}

$logo=($sender_logo)?'uploaded/'.$sender_logo:'images/user.png';
$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$sendID);     
$status=((time()-60) > $last_seen)?false:true;
?>
<div class="top-setting-bar">
<div class="media">
    <div class="media-left">
    <figure class="profile-imgEc pull-left">
    <img src="<?php echo ASSETS.$logo?>" alt="" width="48px" height="48">
    <?php if($status){ ?>
    <div class="online-sign"></div>
    <?php } else{ ?>
    <div class="online-sign" style="background:#ddd"></div>
    <?php } ?>
    </figure>
    </div>
    <div class="media-body">
        <h3><a href="javascript:void(0)" class="backArrow" onclick="showListFragment()"><i class="fas fa-arrow-left"></i></a> <?php echo ucfirst($sender_fname)." ".ucfirst($sender_lname);?> <span class="star-style"><i class="fa fa-star"></i></span><br>
        <small> <a href="<?php echo $p_link; ?>"><?php echo $project_name;?> </a></small>
        </h3>
    </div>
</div>	
	<ul class="pull-right hide">
		<li class="mar-lft-10"><a title="<?php echo __('message_files','Files'); ?>" style="cursor: pointer;" class="toggle_file"><i class="fa fa-file"></i></a></li>
		<li class="mar-lft-10"><a title="<?php echo __('message_people','People'); ?>" style="cursor: pointer;" class="toggle_user"><i class="fa fa-user"></i></a></li>
	</ul>
</div>

<!--ProfileRight Start-->
<div class="profile_right profile_right_mofify">
<div class="row">
<div class="col-sm-8 col-xs-12" id="msg_wrap">
<!--MessageDetais Start-->

<div class="editprofile whiteBg" id="output">
<div class="leftWidth">
<?php
$fav_msg = array();
$msg = $this->auto_model->get_results('serv_fav_msg' , array('user' => $user_id) , 'msg_id');
if(count($msg) > 0){
	foreach($msg as $k => $v){
		$fav_msg[] = $v['msg_id'];
	}
	unset($msg);
}
$lst_date = '';
if(count($messageOne)>0){
	
$this->db->where(array('project_id' => $projectid, 'recipient_id' => $user_id))->update('message' ,array('read_status' => 'Y'));
foreach($messageOne as $key=>$val)
{
$sender_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$sendID));
$sender_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$sendID));    
$sender_logo=$this->auto_model->getFeild('logo','user','user_id',$val['sender_id']);

if($sender_logo && file_exists('assets/uploaded/cropped_'.$sender_logo)){
	$sender_logo = 'cropped_'.$sender_logo;
}

$logo=($sender_logo)?'uploaded/'.$sender_logo:'images/user.png';

$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$val['sender_id']);     
$status=((time()-60) > $last_seen)?false:true;
$reciever_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$user_id));
$reciever_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$user_id)); 

$attachment  = array();
if(!empty($val['attachment'])){
	$attachment  = (array) json_decode($val['attachment']);
	
}
 
if($lst_date != date('Y-m-d', strtotime($val['add_date']))){
 	$lst_date = date('Y-m-d', strtotime($val['add_date']));
	echo '<p class="chat_date"><span>'.date('d M, Y', strtotime($val['add_date'])).'</span></p>';
}

?>

<div class="conversation_loop <?php echo $val['sender_id'] == $user_id ? 'me' : 'other';?>">

<div class="flex-body">

<?php if(!empty($attachment)){ ?>
 <div class="file_attach">
	<?php if($attachment['is_image'] == 1){ ?>
	<img src="<?php echo ASSETS.'question_file/'.$attachment['file_name'];?>" class="materialboxed responsive-img" style="max-width:200px"/>
	<?php }else{  ?>
	<a href="<?php echo ASSETS.'question_file//'.$attachment['file_name'];?>" target="_blank"><img src="<?php echo get_file_icon($attachment['file_name']);?>" alt=""> <?php echo $attachment['org_file_name'];?></a> <a href="<?php echo ASSETS.'question_file/'.$attachment['file_name'];?>" target="_blank" download><i class="zmdi zmdi-download zmdi-20x"></i></a>
	<div class=""><small><?php echo round($attachment['file_size']);?> KB</small></div>
	
	<?php } ?>
 </div>
<?php } ?>
 
<p>
<?php echo $val['message'];?>

<span class="msgTime">
<?php echo ucwords(date('h:i A',strtotime($val['add_date'])));?> 
<?php if($val['sender_id']==$user_id){ ?>
<?php echo $val['read_status'] == 'Y' ? '<i class="zmdi zmdi-check-all site-text msg_seen_icon"></i>' : '<i class="zmdi zmdi-check grey-text msg_unseen_icon"></i>'; ?>
<?php } ?>
</span>
</p> 


<span class="starred">
<?php
if(!in_array($val['id'] , $fav_msg)){
?>
<i class="fa fa-star add_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
<?php
}else{
?>
<i class="fa fa-star remove_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
<?php	
}
?>
</span>
</div>
</div>
<?php
}
}else{
echo "<div id='no_msg_element'>No conversation yet..</div>";	
}
?>
</div>
</div>

<div class="loaded " style="display:none;text-align: right;padding: 5px;position: absolute;right: 0px;margin-top: 10px;margin-right: 90px;z-index: 99;"><i class="fa fa-spinner fa-spin "></i></div>

<div class="editprofile editprofile-form">
<form method="post" name="uploadmessage" id="myform">

<input type="hidden" name="recipient_id" id="recipient_id" value="<?php echo $sendID;?>">

<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $user_id;?>">

<input type="hidden" name="project_id" id="project_id" value="<?php echo $projectid;?>">
<div class="acount_form inputBox">
<div class="input-group">
<textarea id="message" name="message" class="form-control" placeholder="<?php echo __('message_write_your_message_here','Write your message here')?>"></textarea>
<span class="input-group-btn">
    <span class="btn btn-default btn-file"><i class="fa fa-paperclip"></i>
    <input type="file" name="attachment" id="file_chooser">
    </span>
</span>
<span class="input-group-btn">
    <button type="submit" name="submit" id="newsubmit" class="btn btn-site" title=""><i class="fa fa-paper-plane"></i></button>
</span>
</div>

<div class="error-msg2"></div>

  
</div>
</form>
</div>
</div>

<!--MessageDetais End-->
<div class="col-sm-4 col-xs-12 hidden-xs hide" id="more_people">
<div class="col-3-outer">
<h3><?php echo __('message_people','People'); ?> <span class="pull-right"><a style="cursor: pointer;"></a></span></h3>
<div id="roompeople"></div>
<div class="conversation_loop">

<?php 
$rec_logo=$this->auto_model->getFeild('logo','user','user_id',$user_id);

if($rec_logo && file_exists('assets/uploaded/cropped_'.$rec_logo)){
	$rec_logo = 'cropped_'.$rec_logo;
}

$r_logo = ($rec_logo)?'uploaded/'.$rec_logo:'images/user.png'; 
$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$user_id);     
$status=((time()-60) > $last_seen)?false:true;
?>

<div class="media">
<div class="media-left">
	<figure class="profile-imgEc pull-left">
	<img src="<?php echo ASSETS.$r_logo;?>" alt="">
	<?php if($status){ ?>
	<div class="online-sign"></div>
	<?php } else { ?>
	<div class="online-sign" style="background:#ddd"></div> 
	<?php } ?>
	</figure>
</div>
<div class="media-body media-middle">
	<?php echo $reciever_fname . " ". $reciever_lname; ?><br>
</div>
</div>


</div>

<?php 
$sen_logo=$this->auto_model->getFeild('logo','user','user_id',$sendID);

if($sen_logo && file_exists('assets/uploaded/cropped_'.$sen_logo)){
	$sen_logo = 'cropped_'.$sen_logo;
}

$s_logo = ($sen_logo)?'uploaded/'.$sen_logo:'images/user.png'; 
$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$sendID);     
$status=((time()-60) > $last_seen)?false:true;
?>

<div class="conversation_loop">

<div class="media">
	<div class="media-left">
		<figure class="profile-imgEc pull-left">
		<img src="<?php echo ASSETS.$s_logo;?>" alt="">
		<?php if($status){ ?>
		<div class="online-sign"></div>
		<?php } else { ?>
		<div class="online-sign" style="background:#ddd"></div> 
		<?php } ?>
		</figure>
	</div>


	<div class="media-body media-middle">
		<?php echo $sender_fname . " ". $sender_lname; ?><br>
	</div>
</div>

</div>


</div>

<!--MessageDetais End-->

</div>


<?php 
$files = $this->db->where('project_id' , $projectid)->get('message')->result_array();
?>

<div class="col-sm-4 col-xs-12 hidden-xs" id="files_list">
<div class="col-3-outer">
<h3><?php echo __('message_files','Files'); ?></h3>
<div class="attachment_sec">
<?php 
if(count($files) > 0){
	foreach($files as $k => $v){
		if(!empty($v['attachment'])){
			$attachment = (array) json_decode($v['attachment']);
			echo '<p><a href="'.base_url().'/assets/question_file/'.$attachment['file_name'] .'" target="_blank">'.$attachment['org_file_name'].'</a></p>';
		}
		
	}
}else{
	
}
?>
</div>
</div>
</div>
</div>
</div>
<!-- end of article -->
