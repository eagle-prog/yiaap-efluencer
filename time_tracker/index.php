<?php
error_reporting(1);
include("load.php");
/* while($i<5000000){
  $i=$i+1;
  } */

$DB = rqDB();
$R_Q = $_REQUEST;
$ACT = isset($R_Q['action']) ? $R_Q['action'] : "";


//========Start appsetting  ========//
if ($ACT == "appsetting") {
    //Output                
    $XML = '<?xml version="1.0" encoding="utf-16"?>
                        <List>
                         <appsetting>
                                <forgot>https://www.vipleyo.com/edesk/forgot_pass</forgot>
                                <about>https://www.vipleyo.com/edesk/information/info/about_us/</about>
                                <newaccount>https://www.vipleyo.com/edesk/</newaccount>
                                <help>https://www.vipleyo.com/edesk/faq_help/</help>
                                <watermark>eDesk</watermark>
                         </appsetting>
                        </List>';
    ob_start();
	 ob_clean();
	echo $XML;
	
    die();
}

//========End appsetting ========//
function getEmployerName($id) {
    $r = mysql_fetch_assoc(mysql_query("select username,fname,lname from serv_user where user_id='" . $id . "'"));
    $name = ucfirst($r['fname']) . " " . ucfirst($r['lname']);
    if (trim($name) == '') {
        $name = $r['username'];
    }
    return $name;
}

function getProjectID($id) {
    $r = mysql_fetch_assoc(mysql_query("select project_id from serv_project_tracker where id=(select project_tracker_id from serv_project_tracker_snap where id=" . $id . ")"));
    return $r['project_id'];
}

$pid = $R_Q['pid'];


//========Start User Login ========//
if ($ACT == "login") {
    $user = isset($R_Q['user']) ? $R_Q['user'] : "";
    $password = isset($R_Q['password']) ? md5($R_Q['password']) : "";
   $sql = "SELECT * FROM  serv_user WHERE  (`email` ='".mysql_real_escape_string($user)."' or username='".mysql_real_escape_string($user)."') AND  `password` = '".mysql_real_escape_string($password)."' ";
    $REC = $DB->select($sql);
    if (isset($REC[0][0])) {
        $REC = $REC[0];
        //Output		
        $XML = '<?xml version="1.0" encoding="utf-16"?>
			<List>
			 <userinfo>
				<user_id>' . $REC['user_id'] . '</user_id>
				<user>' . $REC['fname'] . '</user>
				<username>' . $REC['username'] . '</username>
				<eamil>' . $REC['email'] . '</eamil>
                                <report>https://www.vipleyo.com/edesk/dashboard/myproject_working</report>
                                <profile>https://www.vipleyo.com/edesk/dashboard</profile>
			 </userinfo>
			</List>';
        echo $XML;
    }
    die();
}
//========End  User Login ========//
//========Start Project List ========//
if ($ACT == "project") {
    $user_id = isset($R_Q['uid']) ? $R_Q['uid'] : "";
    if ($user_id != "") {
        //$sql = "SELECT * FROM  serv_projects WHERE find_in_set('".$user_id."',bidder_id) and !find_in_set('".$user_id."',end_contractor) and `status`='P' and project_type='H' ";
		$sql = "SELECT * 
				FROM  `serv_projects` p
				INNER JOIN serv_project_schedule ps ON ps.project_id = p.project_id
				WHERE p.status =  'P'
				AND ps.is_project_start =1
				AND ps.is_project_paused =0
				AND ps.is_contract_end =0
				AND ps.freelancer_id =".$user_id."
				";


        $REC = $DB->select($sql);
        //$REC=mysql_fetch_assoc(mysql_query($sql));
        //OutPut
        $XML = '<?xml version="1.0" encoding="utf-16"?>';
        $XML.='<List>';
        if (isset($REC[0][0])) {
            foreach ($REC as $R) {
                $details = '';
                $sql1 = "SELECT * FROM  serv_bids WHERE `bidder_id`='" . $user_id . "' and `project_id`='" . $R['project_id'] . "'";
                $RECC = $DB->select($sql1);
                foreach ($RECC as $RR){
                    $details="Start Date: ".date('F d, Y', strtotime($RR['add_date']))."\n";
                    $details.="Duration: ".$RR['days_required']." days\n";
                    $details.="Rate: ".$RR['total_amt']." per hr\n";
                }
                $XML.=
                        '<projectinfo>
					<project_id>' . $R['project_id'] . '</project_id>
					<project_title>' . $R['title'] . '</project_title>
					<project_by>' . "Employer: " . getEmployerName($R['user_id']) . '</project_by>
                    <project_desc>' . $details . '</project_desc>
					<project_capt>600</project_capt>
					<project_caph>900</project_caph>
					<project_capw>1024</project_capw>
				</projectinfo>';
            }
        } else {
            $XML.=
                    '<projectinfo>
					<project_id>0</project_id>
					<project_title>0</project_title>
					<project_by>0</project_by>
                                        <project_desc>0</project_desc>
					<project_capt>0</project_capt>
					<project_caph>0</project_caph>
					<project_capw>0</project_capw>
				</projectinfo>';
        }

        $XML.='</List>';
        echo $XML;
    }
    die();
}
//========End Project List ========//
//========Start ProjectWork ========//
if ($ACT == "prowork") {
    $user_id = isset($R_Q['uid']) ? $R_Q['uid'] : "";
    $project_id = isset($R_Q['pid']) ? $R_Q['pid'] : "";
    $type = isset($R_Q['type']) ? $R_Q['type'] : "";
    $note = isset($R_Q['note']) ? $R_Q['note'] : "";
    if ($user_id != "" && $project_id != "" && $type != "") {
        if ($type != "0") {
            $pwid = isset($R_Q['pwid']) ? $R_Q['pwid'] : "";
            $backnote = isset($R_Q['backnote']) ? $R_Q['backnote'] : "";
            if ($pwid != "") {
                $str_time = mysql_fetch_assoc(mysql_query("select start_time from serv_project_tracker where project_id='" . $R_Q['pid'] . "' order by start_time desc limit 1"));
                $sql = "UPDATE serv_project_tracker` SET  `stop_time`=NOW(), `note`='" . $backnote . "' WHERE `project_id` ='" . $R_Q['pid'] . "' and start_time='" . $str_time['start_time'] . "' ";
                run_quary($sql);
            }
        }

        $sql = "INSERT INTO serv_project_tracker (`project_id`, `worker_id`, `start_time`, `note`, `work_type`) VALUES ('$project_id', '$user_id', NOW(), '$note', '$type');";
        run_quary($sql);
        $idd = mysql_insert_id();
        if ($idd != "") {
            $XML = '';
            $XML.=
                    '<?xml version="1.0" encoding="utf-16"?>
				<List>
					<projectwork>
						<projectwork_id>' . $idd . '</projectwork_id>
					</projectwork>
				</List>';
        }
        echo $XML;
    }
    die();
}

if ($ACT == "proworkstop") {
    $note = isset($R_Q['note']) ? $R_Q['note'] : "";
    $projectwork_id = isset($R_Q['pwid']) ? $R_Q['pwid'] : "";
    if ($projectwork_id != "") {
        $esq = "";
        if ($note != "") {
            $esq = ",`note`='$note' ";
        }
        /* 		$sql2="select start_time from jobstask_project_tracker where id='$projectwork_id' order by start_time desc limit 1";

          $REC2=$DB->select($sql2);
          foreach($REC2 as $r2){
          $str_time=$r2['start_time'];
          }
         */
        //$sql="UPDATE jobstask_project_tracker SET  `stop_time`='".NOW()."'".$esq." WHERE `project_id` ='".getProjectID($projectwork_id)."' and start_time='".$str_time."'";

        $sql = "UPDATE serv_project_tracker SET  `stop_time`=NOW() $esq WHERE `id` ='$projectwork_id'";

        run_quary($sql);
		
		$r = mysql_fetch_assoc(mysql_query("select * from serv_project_tracker where id=".$projectwork_id));
		
		$seconds_new = strtotime($r['stop_time']) - strtotime($r['start_time']);
		$days_new    = floor($seconds_new / 86400);
		$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
		$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
		$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
		$total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
		
		$total_hrs =  ($days_new*24)+$hours_new;
		$total_min = $minutes_new;
		
		$sql = "UPDATE `serv_project_tracker` SET hour=".$total_hrs." , minute=".$total_min." WHERE `id` =".$projectwork_id;
        run_quary($sql);
		

        $XML = '';
        $XML.=
                '<?xml version="1.0" encoding="utf-16"?>
				<List>
				<projectwork>
					<projectwork_id>' . $project_id . '</projectwork_id>
				</projectwork>
				</List>';
        echo $XML;
    }
    die();
}


if ($ACT == "uploadSnap") {
    $pic_data = isset($R_Q['pic_data']) ? $R_Q['pic_data'] : "";
    $projectwork_id = isset($R_Q['pwid']) ? $R_Q['pwid'] : "";
    if ($projectwork_id != "") {

        //$sql = "UPDATE `serv_project_tracker` SET  stop_time=NOW() WHERE `project_id` ='getProjectID($projectwork_id)'";
        $sql = "UPDATE `serv_project_tracker` SET  stop_time=NOW() WHERE `id` ='$projectwork_id'";
        run_quary($sql);
        $sql = "INSERT INTO `serv_project_tracker_snap` (`project_tracker_id`, `project_work_snap_time`) VALUES ('$projectwork_id', NOW());";
        run_quary($sql);
		
		$idd = mysql_insert_id();
		
		$r = mysql_fetch_assoc(mysql_query("select * from serv_project_tracker where id=".$projectwork_id));
		
		$seconds_new = strtotime($r['stop_time']) - strtotime($r['start_time']);
		$days_new    = floor($seconds_new / 86400);
		$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
		$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
		$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
		$total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
		
		$total_hrs =  ($days_new*24)+$hours_new;
		$total_min = $minutes_new;
		
		$sql = "UPDATE `serv_project_tracker` SET hour=".$total_hrs." , minute=".$total_min." WHERE `id` =".$projectwork_id;
        run_quary($sql);
		
        
        $output_file = "";

        $pro_id = getProjectID($idd);

        $output_file = MEDPATH . $pro_id . "_" . $idd . ".jpg";
        $data = $pic_data;
        $data = explode(",", $data);
        $string = implode(array_map("chr", $data));
        $ifp = fopen($output_file, "wb");
        fwrite($ifp, $string);
        fclose($ifp);
        echo $idd;
    }

    die();
}
if($ACT=="uploadSnap2"){
	$pic_data=$_FILES['pic_data'];
	$projectwork_id=isset($R_Q['pwid'])?$R_Q['pwid']:"";
	if($projectwork_id!=""){
		//$sql = "UPDATE `serv_project_tracker` SET  `stop_time`=NOW() WHERE `project_id` ='getProjectID($projectwork_id)'";
		$sql = "UPDATE `serv_project_tracker` SET  stop_time=NOW() WHERE `id` ='$projectwork_id'";
		run_quary($sql);
		$sql = "INSERT INTO `serv_project_tracker_snap` (`project_tracker_id`, `project_work_snap_time`) VALUES ('$projectwork_id', NOW());";
		run_quary($sql);
		$idd=mysql_insert_id();
		
		$r = mysql_fetch_assoc(mysql_query("select * from serv_project_tracker where id=".$projectwork_id));
		
		$seconds_new = strtotime($r['stop_time']) - strtotime($r['start_time']);
		$days_new    = floor($seconds_new / 86400);
		$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
		$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
		$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
		$total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
		
		$total_hrs =  ($days_new*24)+$hours_new;
		$total_min = $minutes_new;
		
		$sql = "UPDATE `serv_project_tracker` SET hour=".$total_hrs." , minute=".$total_min." WHERE `id` =".$projectwork_id;
        run_quary($sql);
		
 		$pro_id = getProjectID($idd);
	


		$output_file = MEDPATH . $pro_id . "_" . $idd . ".jpg";
		move_uploaded_file($pic_data['tmp_name'], $output_file);
		echo $idd;
	}
die();	
}

//========End ProjectWork ========//
?>