<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Findtalents_model extends BaseModel
{

  public function __construct()
  {
    return parent::__construct();

  }


  public function list_freelancer($srch_param = array(), $limit = 0, $offset = 40, $for_list = TRUE)
  {
    $this->load->model('dashboard/dashboard_model');
    $user = $this->db->dbprefix('user');
    $user_skill = $this->db->dbprefix('new_user_skill');
    $this->db->select("DISTINCT $user.*", FALSE)
      ->from('user')
      ->join('new_user_skill', "$user.user_id=$user_skill.user_id", "LEFT")
      ->where("$user.status", 'Y');

    if (!empty($srch_param['skill_id'])) {
      $this->db->where("$user_skill.skill_id", $srch_param['skill_id']);
    }

    if (!empty($srch_param['sub_skill_id'])) {
      $this->db->where("$user_skill.sub_skill_id", $srch_param['sub_skill_id']);
    }

    if (!empty($srch_param['memplan']) and $srch_param['memplan'] != 'All') {
      $this->db->where("$user.membership_plan", $srch_param['memplan']);
    }

    if (!empty($srch_param['ccode']) and $srch_param['ccode'] != 'All') {
      $this->db->where("$user.country", $srch_param['ccode']);
    }

    if (!empty($srch_param['ccode']) and $srch_param['ccode'] != 'All') {
      $this->db->where("$user.country", $srch_param['ccode']);
    }

    if (!empty($srch_param['city']) and $srch_param['city'] != 'All') {
      $this->db->where("$user.city", $srch_param['city']);
    }

    if (!empty($srch_param['q']) and $srch_param['q'] != '') {
      $srch_param['q'] = trim($srch_param['q']);
      $this->db->where("(CONCAT_WS(' ',$user.fname,$user.lname) LIKE '%{$srch_param['q']}%')");
    }
    $this->db->where("$user.account_type", "F");
    if ($for_list) {
      $result = $this->db->limit($offset, $limit)->order_by("$user.user_id", 'ASC')->get()->result_array();
      //echo $this->db->last_query();
      if (count($result > 0)) {
        foreach ($result as $k => $v) {
          $result[$k]['rating'] = $this->dashboard_model->getrating_new($v['user_id']);
          $result[$k]['com_project'] = get_freelancer_project($v['user_id'], 'C');
          $result[$k]['total_project'] = $this->countTotalProject_professional($v['user_id']);
          $result[$k]['skills'] = $this->getUserSkills($v['user_id']);
        }
      }
    } else {
      $result = $this->db->get()->num_rows();
    }

    return $result;
  }

  public function getUserSkills($user_id = '')
  {
    if ($user_id == '') {
      return FALSE;
    }

    $this->db->select('ps.skill_name as parent_skill_name,s.skill_name as skill,s.skill_name,s.arabic_skill_name,s.spanish_skill_name,s.swedish_skill_name , ps.id as parent_skill_id , s.id as skill_id')
      ->from('new_user_skill us')
      ->join('skills ps', 'ps.id=us.skill_id', 'INNER')
      ->join('skills s', 's.id=us.sub_skill_id', 'INNER');
    $this->db->where('us.user_id', $user_id);
    $result = $this->db->get()->result_array();
    return $result;
  }


  public function gettalents($limit = '5', $start = '0', $userid = '')
  {

    $this->db->select("user_id,fname,lname,reg_date,ldate,logo,hourly_rate,country,city,membership_plan,verify");
    $this->db->order_by("user_id");
    $this->db->limit($limit, $start);

    $res = $this->db->get_where("user", array("status" => "Y"));

    $data = array();
    foreach ($res->result() as $row) {
      $data[] = array(
        "user_id"         => $row->user_id,
        "fname"           => $row->fname,
        "lname"           => $row->lname,
        "reg_date"        => $row->reg_date,
        "ldate"           => $row->ldate,
        "logo"            => $row->logo,
        "country"         => $row->country,
        "city"            => $row->city,
        "hourly_rate"     => $row->hourly_rate,
        "membership_plan" => $row->membership_plan,
        "rating"          => $this->dashboard_model->getrating($row->user_id),
        "com_project"     => $this->countComplete_professional($row->user_id),
        "total_project"   => $this->countTotalProject_professional($row->user_id),
        "verify"          => $row->verify
      );
    }

    return $data;
  }

  public function countmytalents($user_id)
  {

    $bidder_id = $this->mybidder($user_id);

    $this->db->select("user_id,fname,lname,reg_date,ldate,logo,hourly_rate,country,city,membership_plan,verify");
    $this->db->order_by("user_id");
    $this->db->where_in('user_id', $bidder_id);
    $res = $this->db->get_where("user", array("status" => "Y"));

    return $res->num_rows();
  }

  public function getmytalents($user_id, $limit = '5', $start = '0')
  {

    $bidder_id = $this->mybidder($user_id);

    $this->db->select("user_id,fname,lname,reg_date,ldate,logo,hourly_rate,country,city,membership_plan,verify");
    $this->db->order_by("user_id");
    $this->db->limit($limit, $start);
    $this->db->where_in('user_id', $bidder_id);
    $res = $this->db->get_where("user", array("status" => "Y"));

    $data = array();
    foreach ($res->result() as $row) {
      $data[] = array(
        "user_id"         => $row->user_id,
        "fname"           => $row->fname,
        "lname"           => $row->lname,
        "reg_date"        => $row->reg_date,
        "ldate"           => $row->ldate,
        "logo"            => $row->logo,
        "country"         => $row->country,
        "city"            => $row->city,
        "hourly_rate"     => $row->hourly_rate,
        "membership_plan" => $row->membership_plan,
        "rating"          => $this->dashboard_model->getrating($row->user_id),
        "com_project"     => $this->countComplete_professional($row->user_id),
        "total_project"   => $this->countTotalProject_professional($row->user_id),
        "verify"          => $row->verify
      );
    }

    return $data;
  }

  public function mybidder($user_id)
  {
    $this->db->select("bidder_id");
    $this->db->where('bidder_id !=', '0');
    $this->db->where("user_id", $user_id);
    $res = $this->db->get("projects");
    $bidder_id = array();
    foreach ($res->result() as $row) {
      $bidder_id[] = $row->bidder_id;
    }
    return $bidder_id;
  }

  public function gettalents_search($talent, $skill, $country, $city, $plans)
  {

    $this->db->select("user_id,fname,lname,reg_date,ldate,logo,hourly_rate,country,city,membership_plan,verify");
    $this->db->order_by("user_id");


    $this->db->where("(CONCAT_WS(' ',`fname`,`lname`) LIKE '%$talent%')");

    if ($country != "All") {
      $this->db->where("country", $country);
    }
    if ($city != "All") {
      $this->db->where("city", $city);
    }
    if ($plans != "All") {
      $this->db->where("membership_plan", $plans);
    }
    if ($skill != "All") {
      $user = $this->getskill_userlist($skill);
      $this->db->where_in("user_id", $user);
    }

    $res = $this->db->get_where("user", array("status" => "Y"));

    //echo $this->db->last_query(); die();

    $data = array();
    foreach ($res->result() as $row) {
      $data[] = array(
        "user_id"         => $row->user_id,
        "fname"           => $row->fname,
        "lname"           => $row->lname,
        "reg_date"        => $row->reg_date,
        "ldate"           => $row->ldate,
        "logo"            => $row->logo,
        "country"         => $row->country,
        "city"            => $row->city,
        "hourly_rate"     => $row->hourly_rate,
        "membership_plan" => $row->membership_plan,
        "rating"          => $this->dashboard_model->getrating($row->user_id),
        "com_project"     => $this->countComplete_professional($row->user_id),
        "total_project"   => $this->countTotalProject_professional($row->user_id),
        "verify"          => $row->verify
      );
    }

    return $data;
  }

  public function getFilertalent($skill, $country, $city, $plans)
  {
    $skill_id_list = "";
    $user = "";
    $this->db->select("user_id,fname,lname,reg_date,ldate,logo,hourly_rate,country,city,membership_plan,verify");
    if ($skill != "All") {
      $skill_id_list = $this->getskill_userlist($skill);
      $this->db->where_in("user_id", $skill_id_list);
    }

    if ($country != 'All') {
      $this->db->where('country', $country);
    }
    if ($city != "All") {
      $this->db->where("city", $city);
    }
    if ($plans != "All") {
      $this->db->where("membership_plan", $plans);
    }
    $data = array();
    //if($country!='All' || $skill!='All' && count($skill_id_list)>0){
    $this->db->order_by("user_id");
    $res = $this->db->get_where('user', array('status' => 'Y'));

    $data = array();
    foreach ($res->result() as $row) {
      $data[] = array(
        "user_id"         => $row->user_id,
        "fname"           => $row->fname,
        "lname"           => $row->lname,
        "reg_date"        => $row->reg_date,
        "ldate"           => $row->ldate,
        "logo"            => $row->logo,
        "country"         => $row->country,
        "city"            => $row->city,
        "hourly_rate"     => $row->hourly_rate,
        "membership_plan" => $row->membership_plan,
        "rating"          => $this->dashboard_model->getrating($row->user_id),
        "com_project"     => $this->countComplete_professional($row->user_id),
        "total_project"   => $this->countTotalProject_professional($row->user_id),
        "verify"          => $row->verify
      );
    }


    //}


    return $data;
  }


  public function getFilertalentCount($skill, $country, $city, $plans)
  {
    $skill_id_list = "";
    $this->db->select("user_id,fname,lname,reg_date,ldate,logo,hourly_rate,country,city,membership_plan,verify");

    if ($skill != "All") {
      $skill_id_list = $this->getskill_userlist($skill);
      $this->db->where_in("user_id", $skill_id_list);
    }

    if ($country != 'All') {
      $this->db->where('country', $country);
    }
    if ($city != "All") {
      $this->db->where("city", $city);
    }
    if ($plans != "All") {
      $this->db->where("membership_plan", $plans);
    }

    $this->db->order_by("user_id");
    $res = $this->db->get_where('user', array('status' => 'Y'));

    return $res->num_rows();
  }


  public function getFilertalentSearchCount($talent, $skill, $country, $city, $plans)
  {
    $skill_id_list = "";
    $this->db->select("user_id,fname,lname,reg_date,ldate,logo,hourly_rate,country,city,membership_plan,verify");

    $this->db->where("(CONCAT_WS(' ',`fname`,`lname`) LIKE '%$talent%')");

    if ($skill != "All") {
      $skill_id_list = $this->getskill_userlist($skill);
      $this->db->where_in("user_id", $skill_id_list);
    }

    if ($city != "All") {
      $this->db->where("city", $city);
    }
    if ($plans != "All") {
      $this->db->where("membership_plan", $plans);
    }
    if ($country != 'All') {
      $this->db->where('country', $country);
    }

    $this->db->order_by("user_id");
    $res = $this->db->get_where('user', array('status' => 'Y'));

    return $res->num_rows();
  }


  public function getskill_userlist($skill_id)
  {
    $data = array();
    if ($skill_id != "All") {
      $user = $this->db->query("SELECT user_id FROM serv_user_skills WHERE FIND_IN_SET(" . $skill_id . ",skills_id)");


      foreach ($user->result() as $u) {
        $data[] = $u->user_id;
      }
      if (count($data) == 0) {
        $data[0] = 0;
      }

    } else {
      $data[0] = 0;
    }


    return $data;
  }

  public function countComplete_professional($user_id)
  {
    $this->db->select('project_id');
    $this->db->where('bidder_id', $user_id);
    $this->db->where('status', 'C');
    $this->db->from('projects');
    return $this->db->count_all_results();
  }

  public function countTotalProject_professional($user_id)
  {
    $this->db->select('project_id');
    $this->db->where("FIND_IN_SET('$user_id',bidder_id) > 0");
    $this->db->where("status IN('P','C')");
    $this->db->from('projects');
    return $this->db->count_all_results();

  }

  public function getplans()
  {
    $this->db->select('id,name');
    $this->db->where('status', 'Y');
    $res = $this->db->get('membership_plan');
    $data = array();
    foreach ($res->result() as $row) {
      $data[] = array(
        'id'   => $row->id,
        'name' => $row->name
      );
    }
    return $data;
  }

  public function getprojects($user_id)
  {
    $this->db->select('id,title,project_type,project_id');
    $this->db->order_by('id', 'desc');
    $this->db->limit('10', '0');
    return $this->db
      ->where_in('status', ['P', 'O'])
      ->get_where('projects', ['user_id' => $user_id])
      ->result_array();
    //echo $this->db->last_query();
  }

  public function getpreviousfreelancer($user_id)
  {
    $this->db->select('bidder_id');
    $r = array();
    $rb = $this->db->distinct('bidder_id')->where_in('status', array('C', 'P', 'PS'))->get_where('projects', array('user_id' => $user_id, 'bidder_id !=' => '0'));

    foreach ($rb->result() as $val) {
      $r[] = $val->bidder_id;
    }
    return $r;


  }

  public function givebonustouser($bonus_freelancer_id, $user_id, $bonus_amount, $bonus_reason)
  {
    $this->load->model('myfinance/myfinance_model');
    $this->load->model('myfinance/transaction_model');
    $this->load->model('dashboard/dashboard_model');

    $user_wallet_id = get_user_wallet($user_id);
    $freelancer_wallet_id = get_user_wallet($bonus_freelancer_id);

    $err = 0;
    if ($bonus_freelancer_id < 1 || $bonus_freelancer_id == '') {
      $err = 1;
      $msg['msg'] = __('findtalents_invalid_freelancer', 'Invalid Freelancer');
    } elseif ($bonus_amount == '' || !preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $bonus_amount) || $bonus_amount == 0) {
      $err = 1;
      $msg['msg'] = __('findtalents_invalid_amount', 'Invalid Amount');
    } else {
      $bidder_id = $this->auto_model->getFeild('user_id', 'user', 'user_id', $bonus_freelancer_id);
      if ($bidder_id != $bonus_freelancer_id) {
        $err = 1;
        $msg['msg'] = __('findtalents_invalid_freelancer', 'Invalid Freelancer');
      }
      $acc_balance = $this->auto_model->getFeild("acc_balance", "user", "user_id", $user_id);
      $acc_balance = get_wallet_balance($user_wallet_id);

      if ($bonus_amount > $acc_balance) {
        $err = 1;
        $msg['msg'] = __('findtalents_insufficient_fund', 'Insufficient fund');
      }

    }
    if ($err == 0) {
      $data = array(
        'freelance_id' => $bonus_freelancer_id,
        'user_id'      => $user_id,
        'reason_desc'  => $bonus_reason,
        'sent_date'    => date('Y-m-d H:i:s'),
        'amount'       => $bonus_amount,
        'status'       => 'N'
      );


      $this->db->insert('bonus', $data);
      $insert = $this->db->insert_id();
      if ($insert) {
        /**
         *
         * @Employer section ***********
         *
         */
        $bonus_charge = $this->auto_model->getFeild('bonus_amount', 'setting', 'id', 1);
        $bider_to_pay = sprintf('%1.2f', ($bonus_amount - ($bonus_amount * $bonus_charge) / 100));
        $profit = sprintf('%1.2f', ($bonus_amount - $bider_to_pay));
        $data_transaction = array(
          "user_id"         => $user_id,
          "amount"          => $bonus_amount,
          "profit"          => $profit,
          "transction_type" => "DR",
          "transaction_for" => "Bonus Send",
          "transction_date" => date("Y-m-d H:i:s"),
          "status"          => "Y"
        );


        $balance = sprintf("%01.2f", sprintf("%01.2f", $acc_balance) - sprintf("%01.2f", $bonus_amount));
        /**
         *
         * @Freelancer section ***********
         *
         */

        $data_transaction_f = array(
          "user_id"         => $bonus_freelancer_id,
          "amount"          => $bider_to_pay,
          "profit"          => 0,
          "transction_type" => "CR",
          "transaction_for" => "Bonus Send",
          "transction_date" => date("Y-m-d H:i:s"),
          "status"          => "Y"
        );

        $acc_balance_f = $this->auto_model->getFeild("acc_balance", "user", "user_id", $bonus_freelancer_id);
        $balance_f = sprintf("%01.2f", sprintf("%01.2f", $acc_balance_f) + sprintf("%01.2f", $bider_to_pay));

        // transaction insert
        $new_txn_id = $this->transaction_model->add_transaction(BONUS_TO_FREELANCER, $user_id);

        $ref1 = json_encode(array('user_id' => $bonus_freelancer_id));
        $ref2 = json_encode(array('user_id' => $user_id));

        $this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $bonus_amount, 'ref' => $ref1, 'info' => '{Bonus_given}'));

        $this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $freelancer_wallet_id, 'credit' => $bonus_amount, 'ref' => $ref2, 'info' => '{Bonus_received}'));

        wallet_less_fund($user_wallet_id, $bonus_amount);

        wallet_add_fund($freelancer_wallet_id, $bonus_amount);

        check_wallet($user_wallet_id, $new_txn_id);

        check_wallet($freelancer_wallet_id, $new_txn_id);


        if ($this->dashboard_model->insertTransaction($data_transaction)) {
          if ($this->dashboard_model->update_User($balance, $user_id)) {
            if ($this->dashboard_model->insertTransaction($data_transaction_f)) {
              if ($this->dashboard_model->update_User($balance_f, $bonus_freelancer_id)) {
                $this->db->where('id', $insert);
                $this->db->update('bonus', array('status' => 'Y', 'user_id' => $user_id, 'freelance_id' => $bonus_freelancer_id));
                $msg['msg'] = __('findtalents_bonus_sent_to_freelancer_account', 'Bonus sent to freelancer account');
              } else {
                $msg['msg'] = __('findtalents_amount_not_update_in_freelancer_account', 'Amount not update in Freelancer account');
              }
            } else {
              $msg['msg'] = __('findtalents_amount_debited_but_not_added_to_freelancer_account', 'Amount debited but not added to freelancer account');
            }


          } else {
            $msg['msg'] = __('findtalents_error_in_update_amount', 'Error in update amount');
          }
        } else {
          $msg['msg'] = __('findtalents_error_in_debit_amount', 'Error in debit amount');
        }

        $msg['status'] = 'OK';

      } else {
        $msg['msg'] = __('findtalents_bonus_not_send_try_again_later', 'Bonus not sent. Try again later!');
        $msg['status'] = 'ERROR';
      }


    } else {

      $msg['status'] = 'ERROR';
    }


    return json_encode($msg);
  }

}
