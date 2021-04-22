<!--<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
 <script crossorigin src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>-->
<style type="text/css">
.chat_scroll {
	height: 450px;
	width:100%;
	overflow: auto;
    border-left: 1px solid #e1e1e1;
    border-right: 1px solid #e1e1e1;
}
.shadow_1 .chat-body {
	height: 465px;
	overflow: auto;
}

</style>

 <?php
	$receiver_user = '';
	$project_title = getField('title','projects', 'project_id', $milestone_detail['project_id']);
	if($login_user_id == $owner_id){
		$receiver_user = $freelancer_detail['fname'].' '.$freelancer_detail['lname'];
	}else{
		$receiver_user = $owner_detail['fname'].' '.$owner_detail['lname'];
	}
 ?>

<section id="mainpage">
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard/dashboard-left'); ?>
</div> 
<aside class="col-md-10 col-sm-9 col-xs-12">
	<div class="spacer-20"></div>  

    <div class="row">
	
        <div class="col-md-8 col-sm-8 col-xs-12 pad0">
		
			<div class="chat-section">
				<div class="top-setting-bar">
				<h3><?php echo $receiver_user;?></h3> 
				<p class="mb-0"><?php echo $project_title;?></p>
				                       
				</div>
				<div class="chat-body chat_scroll scrollbar-inner" id="chat_msg_body">
				
				<p class="chat_date text-center hidden">25 dec, 2017 5:30 AM</p>
				
				<div class="conversation_loop media other hidden">
				
					<div class="media-left">
					<figure class="profile-imgEc">
					<img src="<?php echo IMAGE;?>user.png" alt="">
						<div class="online-sign" style="background:#ddd"></div>
					 </figure>
					</div>
				
					
					<div class="media-body">
						<div class="info-conversation">            
							<div class="messge_body" id="txt_msg">
								<p>Hi, friend message here</p> 
							</div>
						</div>
					</div>
					
					<div class="media-right media-middle">
						
						<i class="fa fa-star-o add_fav" data-msg-id="<?php echo $val['id']?>"></i>
					
					</div>
				
				</div>
				
				<div class="conversation_loop media me hidden">
				
					<div class="media-body">
						<div class="info-conversation">            
							<div class="messge_body" id="txt_msg">
								<p>Hi, friend message here</p> 
							</div>
						</div>
					</div>
					
					<div class="media-right media-middle">
						
						<i class="fa fa-star-o add_fav" data-msg-id="<?php echo $val['id']?>"></i>
					
					</div>
				
				</div>
			  
				<div class="clearfix"></div>
				</div>
			</div>
			
			<?php 
			$is_dispute = 0;
			$send_to_admin = $milestone_detail['send_to_admin'];
			if($milestone_detail['release_payment'] == 'D'){
				$is_dispute = 1;
			}
			if($is_dispute && $send_to_admin == 'N'){ ?>
			<div class="acount_form inputBox" id="msg_input_container">
			<form onsubmit="App.sendMsg(this, event)"  id="message_form">
				<div class="input-group">				
				<textarea id="message" name="message" class="form-control" placeholder="Write your message here"></textarea>
				<input type="hidden" name="milestone_id" value="<?php echo $milestone_id;?>"/>
				<input type="hidden" name="project_id" value="<?php echo $project_id;?>"/>
				<input type="hidden" name="sender_id" value="<?php echo $user_id;?>"/>
				<input type="hidden" name="receiver_id" value="<?php echo $user_id == $owner_id ? $freelancer_id : $owner_id;?>"/>
				<span class="input-group-btn">
					<span class="btn btn-default btn-file"><i class="fa fa-paperclip"></i>
						<input type="file" name="attachment" onchange="App.sendFile()">
						<span id="filecount" class="badge" style="hidden"></span>
					</span>
				</span>
				<span class="input-group-btn">
					<button type="submit" name="submit" id="newsubmit" class="btn btn-default" title=""><i class="fa fa-paper-plane"></i></button>
				</span>
				</div> 
			</form>			
            </div> 
			<?php }else{  ?>
			<div class="alert alert-info mb-0">Chat closed</div>
			<?php } ?>			
        </div>
        
        <div class="col-md-4 col-sm-4 col-xs-12 dpl-0">
        	<div class="whiteBg shadow_1">
            <div class="top-setting-bar">
            	<h4 style="margin:16.5px 0">Dispute History</h4>
            </div>
			
			<?php
			$milestone_amount = $milestone_detail['amount'];
			$commission = (($milestone_amount * SITE_COMMISSION) / 100);
			$amount_to_distribute = $milestone_amount -  $commission;
			?>
			
            <div class="chat-body">
                <p><b>Disputed Amount  : </b><?php echo CURRENCY. ' '.$milestone_detail['amount'];?></p>
                <p><b>Commission  : </b><?php echo CURRENCY. ' '.$commission;?></p>
                <p><b>Net Amount   : </b><?php echo CURRENCY. ' '.$amount_to_distribute;?></p>
				
				<?php if($send_to_admin == 'N' && $is_dispute){ ?>
                <a href="javascript:void(0)" onclick="App.sendToAdmin('<?php echo $project_id; ?>', '<?php echo $milestone_id;?>')" class="btn btn-info btn-block">Send to Admin</a>
				<?php } ?>
                <hr />
				
				<?php if(!empty($owner_detail) && !empty($freelancer_detail) && $is_dispute && $send_to_admin == 'N'){ ?>
                <div class="moneyRequest">
                <p><b>Settlement:</b></p>
				
				 
				<form onsubmit="App.handleDispute(this, event)"> 
                <label><?php echo $owner_detail['fname'].' '.$owner_detail['lname']?> <?php if($owner_id == $login_user_id){ ?> (Requester) <?php } ?></label>
				<input type="hidden" name="employer_id" value="<?php echo $owner_id; ?>"/>
                <input type="text" class="form-control" placeholder="Amount" name="employer_amount"/>
				<div id="employer_amountError" class="rerror"></div>
                <br />
                <label><?php echo $freelancer_detail['fname'].' '.$freelancer_detail['lname']?>  <?php if($freelancer_id == $login_user_id){ ?> (Requester) <?php } ?></label>
				<input type="hidden" name="worker_id" value="<?php echo $freelancer_id; ?>"/>
                <input type="text" class="form-control" placeholder="Amount" name="worker_amount"/>
				<div id="worker_amountError" class="rerror"></div>
				<input type="hidden" name="milestone_id" value="<?php echo $milestone_id;?>"/>
				<input type="hidden" name="project_id" value="<?php echo $project_id;?>"/>
				<input type="hidden" id="max_div_amount" value="<?php echo $amount_to_distribute; ?>"/>
				
				<div id="milestone_idError" class="rerror"></div>
				
				<button type="submit" class="btn btn-info btn-block mb-10">Send Request</button>
				</form>
                </div>
				<?php }elseif($send_to_admin == 'Y'){ ?>
				<p>Sent to admin</p>
				<?php } ?>
				
				<?php //get_print($dispute_history, false); ?>
				<?php if(count($dispute_history) > 0){foreach($dispute_history as $k => $v){ ?>
				<ul class="list-group" id="dispute_<?php echo $v['id'];?>">
					
					<?php if($v['status'] == 'A'){ ?>
					<li class="list-group-item"><b><i>Settled as :</i></b></li>
					<?php } ?>
					
                	<li class="list-group-item"><?php echo $v['employer_info']['fname'].' '.$v['employer_info']['lname'];?><span class="pull-right"><?php echo CURRENCY.' '.$v['employer_amount'];?></span></li>
					
                    <li class="list-group-item"><?php echo $v['freelancer_info']['fname'].' '.$v['freelancer_info']['lname'];?> <span class="pull-right"><?php echo CURRENCY.' '.$v['worker_amount'];?></span></li>
					
					<li class="list-group-item">
						<div class="row-5">
							<?php if($v['status'] == 'P'){ ?>
							
							<?php if(($login_user_id != $v['requested_by']) && $is_dispute){ ?>
							
							<article class="col-xs-6">
								<button class="btn btn-success btn-sm btn-block" onclick="App.acceptDisputeRequest('<?php echo $v['id'];?>', this)">Accept</button>
							</article>
							
							<article class="col-xs-6">
								<button class="btn btn-danger btn-sm btn-block" onclick="App.denyDisputeRequest('<?php echo $v['id'];?>', this)">Deny</button>
							</article>
							
							<?php }else{  ?>
							<article class="col-xs-12 text-center">
								<b><i>Pending</i></b>
							</article>
							<?php } ?>
							
							<?php }else if($v['status'] == 'A'){  ?>
							
							<article class="col-xs-6">
								<b><i>Approved</i></b>
							</article>
							
							<?php }else {  ?>
							<article class="col-xs-6">
								<b><i>Denied</i></b>
							</article>
							<?php } ?>
							
						</div>
					</li>
                </ul> 
				<?php } } ?>
                   
          
            </div>
            </div>
        </div>
    
	</div>    
			
  </div>
  </div>  
  </div>
</section>
<script>
  $(document).ready(function() {  	    
    $(".chat_scroll").niceScroll();
	$(".shadow_1 .chat-body").niceScroll();
  });
</script>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Activity</h4>
      </div>
      <div class="modal-body">
     
      </div>
    </div>
  </div>
</div>

<script type="text/template" id="chat_msg_template">
<div class="conversation_loop media {MSG_CLASS}" id="message_row_{MESSAGE_ID}">

		{AVATAR}
		
		<div class="media-body">
			<div class="info-conversation">            
				<div class="messge_body" id="txt_msg">
					<div class="file_attach">{ATTACHMENT}</div>
					<p>{MESSAGE}</p> 
				</div>
			</div>
		</div>
		
		<div class="media-right media-middle">
		</div>

</div>
</script>

<script type="text/template" id="avatar_template">

<div class="media-left">
	<figure class="profile-imgEc">
	<img src="{USER_IMAGE}" alt="">
		<div class="online-sign" style="background:#ddd"></div>
	 </figure>
	</div>

</script>

<script type="text/template" id="msg_input_template">

	<form onsubmit="App.sendMsg(this, event)" id="message_form">
		<div class="input-group">
		
		<textarea id="message" name="message" class="form-control"></textarea>
		<input type="hidden" name="milestone_id" value="<?php echo $milestone_id;?>"/>
		<input type="hidden" name="project_id" value="<?php echo $project_id;?>"/>
		<input type="hidden" name="sender_id" value="<?php echo $user_id;?>"/>
		<input type="hidden" name="receiver_id" value="<?php echo $user_id == $owner_id ? $freelancer_id : $owner_id;?>"/>
		<span class="input-group-btn">
			<span class="btn btn-default btn-file"><i class="fa fa-paperclip"></i>
				<input type="file" name="attachment" onchange="App.sendFile()">
				<span id="filecount" class="badge" style="hidden"></span>
			</span>
		</span>
		<span class="input-group-btn">
			<button type="submit" name="submit" id="newsubmit" class="btn btn-site" title="" style="height:44px;"><i class="fa fa-paper-plane"></i></button>
		</span>
		</div> 
	</form>			

</script>

<script>


function get_file_icon(file_name){
	var icons = {
		'doc' : '<?php echo DOC_ICON; ?>',
		'docx' : '<?php echo DOC_ICON ; ?>',
		'pdf' : '<?php echo PDF_ICON ; ?>',
		'txt' : '<?php echo TXT_ICON ; ?>',
	};
	var default_file_icon = '<?php echo COMMON_ICON; ?>';
	
	var file_part = file_name.split('.');
	var file_ext = file_part.pop().trim().toLowerCase();
	var file_icon = '';
	
	if(typeof icons[file_ext] != 'undefined'){
		file_icon = icons[file_ext];
	}else{
		file_icon = default_file_icon;
	}
	
	return file_icon;
}

	
	
var  messages = <?php echo json_encode($messages)?>;	
	
var App = (function(){
	
	var sending_url = '<?php echo base_url('projectdashboard/send_dispute_message')?>';
	
	var msg_container = $('#chat_msg_body');
	var msg_input_container = $('#msg_input_container');
	
	var login_user_id = <?php echo $user_id?>;
	
	var msg_date = '';
	
	var request_on_hold = 0;
	
	var ret = {};
	
	ret.messages = messages;
	
	
	var _init = function(){
		
		_loadMsg();
		
	};
	
	
	var _loadMsg = function(){
		
		if(ret.messages.length > 0){
			
			for(var i in ret.messages){
				
				var msg_one = ret.messages[i];
				
				_pushMsg(msg_one);
				
				
			}
			
		}
		
	};
	
	
	var _pushMsg = function(msg, cmd){
		
		var msg_one = msg;
		var attachment = msg.attachment ? JSON.parse(msg.attachment) : null ;
		cmd = cmd ? cmd : 'append';
		
		var msg_class = msg_one['sender']['sender_id'] ==  login_user_id ? 'me' : 'other';
		
		var avatar = '';
		var attachment_html = '';
		
		if(attachment){
			if(attachment.is_image == 1){
				attachment_html = '<img src="<?php echo ASSETS.'attachments';?>/'+attachment.file_name+'" class="materialboxed img-responsive" style="max-width:250px"/>';
			}else{
				attachment_html = '<a href="<?php echo ASSETS.'attachments';?>/'+attachment.file_name+'" target="_blank"><img src="'+get_file_icon(attachment.file_name)+'" alt=""> '+attachment.org_file_name+'</a> <a href="<?php echo ASSETS.'attachments';?>/'+attachment.file_name+'" target="_blank" download><i class="fas fa-download"></i></a><div class=""><small>'+Math.round(attachment.file_size)+' KB</small></div>';
			}
		}
		
	
		if( msg_one['sender']['sender_id'] != login_user_id){
			
			avatar = $('#avatar_template').html();
			
			avatar = avatar.replace(/{USER_IMAGE}/g,  msg_one['sender']['image']);
		}
		
		var html = $('#chat_msg_template').html();
		
		html = html.replace(/{MSG_CLASS}/g, msg_class);
		html = html.replace(/{MESSAGE_ID}/g, msg_one['message_id']);
		html = html.replace(/{AVATAR}/g, avatar);
		html = html.replace(/{MESSAGE}/g, msg_one['message']);
		html = html.replace(/{ATTACHMENT}/g, attachment_html);
		
		var lst_msg_id = msg_one['message_id'];
		
		
		if(msg_date != msg_one['date']){
			msg_date = msg_one['date'];
			msg_container.append('<p class="chat_date text-center">'+msg_date+'</p>');
		}
		
		if(cmd == 'return'){
			
			return html;
			
		}else if(cmd == 'insert'){
			
			msg_container.html(html);
			
		}else if(cmd == 'append'){
			
			msg_container.append(html);
			
		}
		
		
	};
	
	var _renderMessageForm = function(){
		var html = $('#msg_input_template').html();
		msg_input_container.html(html);
	};
	
	ret.sendMsg = function(f, e){
		e.preventDefault();
		var fdata = $(f).serialize();
		
		var msg = $('#message').val();
		
		if(msg != ''){
			
			$.ajax({
				url : sending_url,
				data: fdata,
				type: 'POST',
				dataType: 'json',
				beforeSend: function(){
					$(f).find('button').attr('disabled', 'disabled');
				},
				success: function(res){
					
					if(res.status == 1){
						
						_pushMsg(res.data);
						ret.messages.push(res.data);
						
						_renderMessageForm();
						
						scrollToBottom();
					}
				}
			});
		}
		
		
	};
	
	
	ret.handleDispute = function(f, e){
		e.preventDefault();
		
		var validForm = true;
		
		var emp_amount = $(f).find('[name="employer_amount"]').val();
		var worker_amount = $(f).find('[name="worker_amount"]').val();
		var milestone_id = $(f).find('[name="milestone_id"]').val();
		var max_amount = $('#max_div_amount').val();
		
		if(emp_amount == '' || isNaN(emp_amount)){
			$('#employer_amountError').html('Invalid input');
			validForm = false;
		}else{
			$('#employer_amountError').html('');
		}
		
		if(worker_amount == '' || isNaN(worker_amount)){
			$('#worker_amountError').html('Invalid input');
			validForm = false;
		}else{
			$('#worker_amountError').html('');
		}
		
		
		if(milestone_id == ''){
			$('#milestone_idError').html('Invalid input');
			validForm = false;
		}else{
			$('#milestone_idError').html('');
		}
		
		if(max_amount != (parseFloat(worker_amount) + parseFloat(emp_amount))){
			$('#milestone_idError').html('Distribution amount must be equal to '  + max_amount);
			validForm = false;
		}else{
			$('#milestone_idError').html('');
		}
		
		var fdata = $(f).serialize();
		
		if(validForm){
			
			$.ajax({
				url : '<?php echo base_url('projectdashboard/send_dispute_amount')?>',
				data: fdata,
				type: 'POST',
				dataType: 'json',
				beforeSend: function(){
					$(f).find('button').attr('disabled', 'disabled');
				},
				success: function(res){
					
					if(res.status == 1){
						
						location.reload();
						
					}else{
						$(f).find('button').removeAttr('disabled', 'disabled');
					}
					
				}
			});
		}
		
		
	};
	
	ret.acceptDisputeRequest = function(id, ele){
		if(!id){
			return false;
		}
		if(typeof ele != undefined){
			$(ele).attr('disabled', 'disabled');
		}
		$.ajax({
			url : '<?php echo base_url('projectdashboard/accept_dispute_request')?>',
			data: {id: id},
			dataType: 'json',
			type: 'post',
			success: function(res){
				
				if(res.status == 1){
					location.reload();
				}
			}
		});
	};
	
	ret.denyDisputeRequest = function(id, ele){
		
		if(!id){
			return false;
		}
		if(typeof ele != undefined){
			$(ele).attr('disabled', 'disabled');
		}
		$.ajax({
			url : '<?php echo base_url('projectdashboard/deny_dispute_request')?>',
			data: {id: id},
			dataType: 'json',
			type: 'post',
			success: function(res){
				
				if(res.status == 1){
					location.reload();
				}
			}
		});
		
	};
	
	ret.sendToAdmin = function(project_id, milestone_id){
		
		if(request_on_hold > 0){
			return false;
		}
		
		request_on_hold++;
		
		if(project_id && milestone_id){
			$.ajax({
				url : '<?php echo base_url('projectdashboard/send_to_admin')?>',
				data: {project_id: project_id, milestone_id: milestone_id},
				type: 'POST',
				dataType: 'json',
				success: function(res){
					if(res.status == 1){
						location.reload();
					}
				}
			});
		}
	};
	
	ret.sendFile = function(){
		$('.error').html('');
		var f = $('#message_form');
		var fdata = new FormData($(f)[0]);
		
		$.ajax({
			url: '<?php echo base_url('projectdashboard/send_attachment')?>',
			data: fdata,
			type: 'POST',
			dataType: 'JSON',
			contentType: false,
			processData: false,
			cache: false,
			
			success: function(res){
				
				if(res.status == 0){
					if(res.attachmentError != ''){
						$('#fileTypeError').html(res.attachmentError);
						return;
					}
				}else{
					
					_pushMsg(res.data);
					ret.messages.push(res.data);
					
					_renderMessageForm();
					
					scrollToBottom();
					
				}
				
				
				
			}
		});
		
	};

	
	
	_init();
	
	return ret;
	
})();


	
</script>


<script>
/* Global function */

function scrollToBottom(){
	var chat_scroll_height = $('.chat_scroll')[0].scrollHeight;
	var chat_main_height = $('.chat_scroll')[0].clientHeight;
	
	if(chat_scroll_height > chat_main_height){
		$('.chat_scroll').scrollTop(chat_scroll_height - chat_main_height);
	}
}


</script>

<script>
	$(document).ready(function(){
		
		scrollToBottom();
		
	});
</script>

<!--
<script type="text/babel">

var all_messages = <?php // echo json_encode($messages); ?>;


class App extends React.Component {
   constructor(props) {
      super(props);
		
      this.state = {
		title : 'Dispute Chat Room'
      }
   }
   render() {
      return (
         <div className="chat-section">
			<Header name={this.state.title}/>
           <Content login_user_id="<?php echo $user_id;?>"/>
         </div>
      );
   }
}


class Header extends React.Component{
	render() {
	  return (
		 <div>
		 <div className="top-setting-bar">
            <h3>{this.props.name} <br/> <small>dipute room</small>
            
            </h3>                        
        	</div>
		 </div>
	  );
	}
	
}


class Content extends React.Component{
	constructor() {
      super();
		
      this.state = {
		textmsg : '',
		msg: all_messages,
      }
	  
	  
	   this.sendMessage = this.sendMessage.bind(this);
	   this.onTextChange = this.onTextChange.bind(this);
	 
	  
   }
   
   
   onTextChange(e){
	    this.setState({textmsg: e.target.value});
   }
   
   sendMessage(e){	  
		var fdata = $(e.target).serialize();
		
		e.preventDefault();
		
		console.log(fdata);
		var n_msg = {
			sender : 16,
			message : this.state.textmsg,
			date : '25 Dec, 2017 05:30 AM'
		};
		
		this.state.msg.push(n_msg);
		
		this.setState({msg: this.state.msg, textmsg: ''});
		
		$.ajax({
			url:  '<?php echo base_url('projectdashboard/send_dispute_message')?>',
			data: fdata,
			type: 'post',
			dataType: 'json',
			success: function(res){
				console.log(res);
			}
		});
		

   }
   
	render() {
	  return (
		 <div>
			<div className="chat-body chat_scroll">
				{
					this.state.msg.map(function(dynamicComponent, i){
						console.log(this.props.login_user_id);
						return ( <Message key = {i} messageData = {dynamicComponent} cname={dynamicComponent.sender_id == 15 ? 'me' : 'other'} login_user_id="15" /> );
					})
				}
			
               
            </div>
			
			<Footer sendMessage={this.sendMessage} onTextChange={this.onTextChange} inputMessage={this.state.textmsg}/>
			
		 </div>
	  );
	}
	
}

function Message(props){
	var cname = 'conversation_loop media ' + props.cname;
	var styleNm = {
		backgroundColor:'#ddd',
	};
	
	var img = '';
	
	if(props.messageData.sender_id == props.login_user_id){
		img =  <div className="media-left">
					<figure className="profile-imgEc">
					<img src="<?php echo IMAGE;?>user.png" alt=""/>
					<div className="online-sign" style={styleNm}></div>
				 </figure>
				</div>
	}
	return (
		<div className={cname}>
			
            {img}
            
            <div className="media-body">
            <div className="info-conversation">            
            <div className="messge_body" id="txt_msg">
            <p>{props.messageData.message}</p> 
            </div>
            </div>
            </div>
            <div className="media-right media-middle">
				
				<i className="fa fa-star-o add_fav"></i>
			
			</div>
			
		</div>
	
	);
}

function Footer(props){
	return (
		
		<div className="acount_form inputBox">
			<form onSubmit={props.sendMessage}>
				<div className="input-group">
				
				<textarea id="message" name="message" className="form-control" onChange={props.onTextChange} value={props.inputMessage}></textarea>
				<input type="hidden" name="sender_id" value="<?php echo $user_id; ?>"/>
				<input type="hidden" name="receiver_id" value="<?php echo $user_id == $owner_id ? $freelancer_id : $owner_id; ?>"/>
				<input type="hidden" name="milestone_id" value="<?php echo $milestone_id; ?>"/>
				<span className="input-group-btn">
					<span className="btn btn-default btn-file"><i className="fa fa-paperclip"></i>
						<input type="file" name="userfile" />
						<span id="filecount" className="badge"></span>
					</span>
				</span>
				<span className="input-group-btn">
					<button type="submit" name="submit" id="newsubmit" className="btn btn-site" style={{height: '44px'}}><i className="fa fa-paper-plane"></i></button>
				</span>
				</div>     
			</form>			
		</div>
	);
}

ReactDOM.render(<App/>, document.getElementById('app'));
   
</script>
-->