<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Auto_Model extends BaseModel
{

  public function __construct()
  {
    parent::__construct();
    $idiom = $this->session->userdata('lang');
    //$this->load->helper('eclanguage');
    $this->lang->load('global', $idiom);
  }

  public function getFeild($select, $table, $feild = "", $value = "", $where = null, $limit_from = 0, $limit_to = 0)
  {
    $this->db->select($select);
    if ($value != '' and $feild != '') {
      if ($limit_from > 0) {
        $rs = $this->db->get_where($table, array($feild => $value), $limit_to, $limit_from);
      } else {
        $rs = $this->db->get_where($table, array($feild => $value));
      }
    } else {
      if ($limit_from > 0) {
        $rs = $this->db->get_where($table, $where, $limit_to, $limit_from);
      } else {
        $rs = $this->db->get_where($table, $where);
      }
    }
    //echo $this->db->last_query();
    $data = '';
    foreach ($rs->result() as $row) {
      $data = $row->$select;
    }
    return $data;
  }

  public function date_format($dateformat)
  {
    $timestamp = strtotime($dateformat);
    $date = date("d M, Y", $timestamp);
    return $date;
  }

  public function send_email($from, $to, $template, $data_parse)
  {

    $mailcontent = $this->auto_model->getaldata('template,subject', 'mailtemplate', 'type', $template);
    //print_r($mailcontent); die();
    foreach ($mailcontent as $key => $val) {
      $contents = $val['body'];
      $subject = $val['subject'];
    }


    //$this->load->library('email');

    $config = array(
      'protocol'  => 'smtp',
      'smtp_host' => 'ssl://mail.vipleyo.com',
      'smtp_port' => 465,
      'smtp_user' => "admin@vipleyo.com",
      'smtp_pass' => "Gilmata4219x@",
      'mailtype'  => 'html',
      'charset'   => 'utf-8'
    );


    $this->load->library('email', $config);
    $this->email->initialize($config);

    //$this->load->library('encrypt');

    $this->email->set_newline("\r\n");


    //$this->email->_headers['From'] = 'admin@vipleyo.com';
    //$this->email->_headers['Reply-To'] = 'admin@vipleyo.com';


    $from = "admin@vipleyo.com";


    //$this->email->from($from, ADMIN_EMAIL);
    $this->email->from('admin@vipleyo.com');
    $this->email->to($to);
    $this->email->reply_to($from);
    $this->email->subject($subject);
    $this->email->set_mailtype("html");
    foreach ($data_parse as $key => $val) {

      $contents = str_replace('{' . trim($key) . '}', $val, $contents);
    }
    $contents = str_replace('src="/', 'src="' . VPATH, $contents);
    $contents = html_entity_decode($contents);
    $this->email->message($contents);

    return $this->email->send();
    //echo $this->email->print_debugger(); die;
  }


  public function send_emailone($from, $to, $template, $data_parse)
  {

    $mailcontent = $this->auto_model->getaldata('template,subject', 'mailtemplate', 'type', $template);
    /*print_r($mailcontent); die();*/
    foreach ($mailcontent as $key => $val) {
      $contents = $val['body'];
      $subject = $val['subject'];
    }
    $this->load->library('email');

    //echo ADMIN_EMAIL; die;
    $this->email->from($from, ADMIN_EMAIL);
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->set_mailtype("html");
    foreach ($data_parse as $key => $val) {

      $contents = str_replace('{' . trim($key) . '}', $val, $contents);
    }
    $contents = str_replace('src="/', 'src="' . VPATH, $contents);
    $contents = html_entity_decode($contents);
    $this->email->message($contents);

    return $this->email->send();
    //echo $this->email->print_debugger(); die;
  }

  public function getalldata($attr, $table, $by, $value, $limit = '')
  {
    $this->db->select($attr);
    if ($limit != '') {
      $this->db->limit($limit);
    }
    if ($by != '' && $value != '') {
      $this->db->where($by, $value);
    }
    $rs = $this->db->get($table);
    $data = array();

    foreach ($rs->result() as $key => $row) {
      $data["'" . $key . "'"] = $row;
    }
    return $data;

  }

  public function checkrequestajax()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    } else {
      die('error ');
    }
  }

  public function get_user_data($user_id)
  {
    $this->db->select();
    $query = $this->db->get_where("user", array("id" => $user_id));
    $result = array();
    foreach ($query->result() as $row) {
      $result['user_type'] = $row->user_type;
      $result['full_name'] = $row->full_name;
      $result['user_img'] = $row->user_img;
      $result['country'] = $row->country;
      $result['state'] = $row->state;
      $result['city'] = $row->city;
      $result['email'] = $row->email;
      $result['mobile'] = $row->mobile;
      $result['zip'] = $row->zip;
    }
    return $result;
  }

  public function get_fb_auth_id($user_id)
  {
    $fb_auth_id = $this->getFeild("fb_auth_no", "user", "id", $user_id);
    return $fb_auth_id;
  }

  public function user_log_check($get_result = 'N')
  {
    $user_id = 0;
    $user_id = $this->session->userdata('fab_user_id');
    if ($user_id == '' or $user_id == 0) {
      if ($get_result == 'Y') {
        return FALSE;
      } else {
        redirect(base_url() . 'user/login');
      }
    } else {
      return TRUE;
    }
  }

  //..............................................................................................//
  //                              Get Geo location from google                                    //
  //                                  pass complete address                                       //
  //                    returns country, state, city, latitude, longitude                         //
  //                              Developed by Somnath Mukherjee                                  //
  //..............................................................................................//

  public function reverse_geocode($address)
  {
    $address = str_replace(" ", "+", "$address");
    $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
    $result = file_get_contents("$url");
    $json = json_decode($result);
    $city = '';
    $state = '';
    $country = '';
    $latitude = '';
    $lngitude = '';

    foreach ($json->results as $result) {
      foreach ($result->address_components as $addressPart) {
        if ((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
          $city = $addressPart->long_name;
        else if ((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
          $state = $addressPart->long_name;
        else if ((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
          $country = $addressPart->long_name;
      }
      /* foreach ($result->geometry as $geo_loc) {
        if ($geo_loc->lat != '' && $geo_loc->lng != '') {
        $latitude = $geo_loc->lat;
        $lngitude = $geo_loc->lng;
        }
        } */
      if ($latitude == '' && $lngitude == '') {
        $latitude = $result->geometry->location->lat;
        $lngitude = $result->geometry->location->lng;
      }
    }

    if (($city != '') && ($state != '') && ($country != ''))
      $address = $city . ', ' . $state . ', ' . $country;
    else if (($city != '') && ($state != ''))
      $address = $city . ', ' . $state;
    else if (($state != '') && ($country != ''))
      $address = $state . ', ' . $country;
    else if ($country != '')
      $address = $country;

    // return $address;
    return "$country/$state/$city/$latitude/$lngitude";
  }

  //..............................................................................................//
  //                                    Get City locations                                        //
  //                        pass state id(optional), city id(optional)                            //
  //                              returns city details in array                                   //
  //                              Developed by Somnath Mukherjee                                  //
  //..............................................................................................//

  public function get_city_details($state_id = '', $city_id = '', $limit = 0)
  {
    $this->db->select();
    $this->db->order_by("city_name");
    //$this->db->from('city');
    $condition = array();
    $condition['status'] = 'Y';

    if ($state_id != '') {
      //$query = $this->db->where("state_id", $state_id);
      $condition["state_id"] = $state_id;
    }

    if ($city_id != '') {
      $condition['id'] = $city_id;
    }

    if ($limit > 0) {
      $query = $this->db->get_where("city", $condition, $limit);
    } else {
      $query = $this->db->get_where("city", $condition);
    }

    $result = array();
    foreach ($query->result() as $row) {
      $result[] = array(
        'id'        => $row->id,
        'state_id'  => $row->state_id,
        'city_name' => $row->city_name,
        'city_img'  => $row->city_img
      );
    }
    return $result;
  }

  //..............................................................................................//
  //                                    Get State locations                                       //
  //                        pass state id(optional), country id(optional)                         //
  //                                returns state list in array                                   //
  //                              Developed by Somnath Mukherjee                                  //
  //..............................................................................................//

  public function get_state_list($state_id = '', $country_id = '', $limit = 0)
  {
    $this->db->select();
    $this->db->order_by('order_id');

    $condition = array();
    $condition['status'] = 'Y';

    if ($state_id != '') {
      $condition["id"] = $state_id;
    }

    if ($country_id != '') {
      $condition['country_id'] = $country_id;
    }

    if ($limit > 0) {
      $query = $this->db->get_where("state", $condition, $limit);
    } else {
      $query = $this->db->get_where("state", $condition);
    }

    $result = array();
    foreach ($query->result() as $row) {
      $result[] = array(
        'id'         => $row->id,
        'state_name' => $row->state_name
      );
    }
    return $result;
  }

  //..............................................................................................//
  //                                Get locations from Zip code                                   //
  //                                       pass Zip code                                          //
  //                           returns latitude, longitude in array                               //
  //                              Developed by Somnath Mukherjee                                  //
  //..............................................................................................//

  public function get_lat_long_from_zip($zip)
  {
    if (strlen($zip) > 0) {
      $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($zip) . "&sensor=false";
      $result_string = file_get_contents($url);
      $result = json_decode($result_string, true);
      /* $result1[] = $result['results'][0];
        $result2[] = $result1[0]['geometry'];
        $result3[] = $result2[0]['location'];
        return $result3[0]; */


      return $result['results'][0]['geometry']['location'];
    } else {
      return false;
    }
  }

  public function getbanner($type = '', $limit_from = '', $limit_to = '')
  {
    $this->db->select('*');
    $this->db->limit($limit_to, $limit_from);
    $rs = $this->db->get_where('banner', array('status' => 'Y', 'type' => $type));
    $data = array();
    foreach ($rs->result() as $row) {
      $data[] = array(
        'id'    => $row->id,
        'type'  => $row->type,
        'image' => $row->image
      );
    }
    return $data;
  }

  public function get_setting()
  {
    $this->db->select('*');
    $rs = $this->db->get_where('setting');
    $data = array();
    foreach ($rs->result() as $row) {
      $data[] = array(
        'facebook'     => $row->facebook,
        'twitter'      => $row->twitter,
        'pinterest'    => $row->pinterest,
        'linkedin'     => $row->linkedin,
        'google_plus'  => $row->google_plus,
        'site_title'   => $row->site_title,
        'meta_desc'    => $row->meta_desc,
        'meta_keys'    => $row->meta_keys,
        'admin_mail'   => $row->admin_mail,
        'support_mail' => $row->support_mail,
        'paypal_mail'  => $row->paypal_mail,
        'contact_no'   => $row->contact_no,
        'office_no'    => $row->office_no,
        'telephone'    => $row->telephone
      );
    }
    return $data;
  }

  public function find_taskers()
  {
    $this->db->select('*');
    // $this->db->limit($limit_to, $limit_from);
    $rs = $this->db->get_where('find_taskers', array('status' => 'Y'));
    $data = array();
    foreach ($rs->result() as $row) {
      $data[] = array(
        'id'          => $row->id,
        'title'       => $row->title,
        'button_name' => $row->button_name
      );
    }
    return $data;
  }

  public function bid_count($task_id)
  {
    $this->db->select('count(id) as total');
    $rs = $this->db->get_where("buyer_bid", array('task_id' => $task_id));
    foreach ($rs->result() as $row) {
      $data = $row->total;
    }
    return $data;
  }

  public function getcleanurl($name)
  {
    $pattern = "/[^a-zA-Z0-9]+/";
    return trim(strtolower(preg_replace($pattern, '-', $name)), '-');

  }

  public function getcategory($pid)
  {
    $this->db->select("cat_id,cat_name,arabic_cat_name,spanish_cat_name,swedish_cat_name");
    $con = array(
      "parent_id" => $pid,
      "status"    => "Y"
    );
    $this->db->order_by("cat_name");
    $res = $this->db->get_where("categories", $con);
    $data = array();

    foreach ($res->result() as $row) {
      $data[] = array(
        "cat_id"           => $row->cat_id,
        "arabic_cat_name"  => $row->arabic_cat_name,
        "spanish_cat_name" => $row->spanish_cat_name,
        "swedish_cat_name" => $row->swedish_cat_name,
        "cat_name"         => $row->cat_name
      );
    }

    return $data;
  }

  public function getnumsubcat($pid)
  {
    $this->db->select("cat_id");
    $con = array(
      "parent_id" => $pid,
      "status"    => "Y"
    );
    $this->db->where($con);
    $this->db->from('categories');
    return $this->db->count_all_results();
  }

  public function getskill($pid)
  {
    $this->db->select("id,skill_name");
    $con = array(
      "parent_id" => $pid,
      "status"    => "Y"
    );
    $this->db->order_by("skill_name");
    $res = $this->db->get_where("skills", $con);
    $data = array();

    foreach ($res->result() as $row) {
      $data[] = array(
        "id"         => $row->id,
        "skill_name" => $row->skill_name
      );
    }

    return $data;
  }

  public function getskillbyname($term = '')
  {
    $this->db->select("id,skill_name,parent_id");
    $con = array(
      "parent_id <>" => '0',
      "status"       => "Y"
    );
    $this->db->where($con);
    $this->db->like('skill_name', $term);
    $this->db->order_by("skill_name");

    $res = $this->db->get("skills")->result_array();
    $data = array();

    if (count($res) > 0) {
      foreach ($res as $row) {
        $data[] = array(
          "id"         => $row['id'],
          "skill_name" => $row['skill_name'],
          "parent"     => $row['parent_id']
        );
      }
    }


    return $data;
  }


  public function getaldata($attr, $table, $by, $value)
  {
    $this->db->select($attr);
    $rs = $this->db->get_where($table, array($by => $value));
    $data = array();

    foreach ($rs->result() as $row) {
      $data[] = array(
        'body'    => $row->template,
        'subject' => $row->subject
      );
    }
    return $data;

  }

  public function count_results($attr, $table, $by = '', $values = '', $query = array())
  {
    $this->db->select($attr);
    if ($by != '' && $values != '') {
      $this->db->where($by, $values);
    }
    if (is_array($query) && count($query) > 0) {
      $this->db->where($query);
    }
    $this->db->from($table);
    return $this->db->count_all_results();

  }

  public function getCompleteness($user_id)
  {
    $basic_info = $this->getFeild('basic_info', 'setting', 'id', '1');
    $social_info = $this->getFeild('social_info', 'setting', 'id', '1');
    $portfolio_info = $this->getFeild('portfolio_info', 'setting', 'id', '1');
    $skill_info = $this->getFeild('skill_info', 'setting', 'id', '1');
    $finance_info = $this->getFeild('finance_info', 'setting', 'id', '1');
    $portfolio_count = $this->getFeild('portfolio', 'membership_plan', 'id', '4');
    $skill_count = $this->getFeild('skills', 'membership_plan', 'id', '4');

    $this->db->select();
    $this->db->where('user_id', $user_id);
    $res = $this->db->get('user');
    $row = $res->result();

    $bcount = 0;
    if ($row[0]->username != '') {
      $bcount += 1;
    }
    if ($row[0]->fname != '') {
      $bcount += 1;
    }
    if ($row[0]->lname != '') {
      $bcount += 1;
    }
    if ($row[0]->email != '') {
      $bcount += 1;
    }
    if ($row[0]->city != '') {
      $bcount += 1;
    }
    if ($row[0]->logo != '') {
      $bcount += 1;
    }
    if ($row[0]->v_stat == 'Y') {
      $bcount += 1;
    }
    if ($row[0]->acc_balance != '' || $row[0]->acc_balance != '0.00') {
      $bcount += 1;
    }
    if ($row[0]->slogan != '') {
      $bcount += 1;
    }
    if ($row[0]->overview != '') {
      $bcount += 1;
    }
    if ($row[0]->work_experience != '') {
      $bcount += 1;
    }
    if ($row[0]->hourly_rate != '') {
      $bcount += 1;
    }
    if ($row[0]->qualification != '') {
      $bcount += 1;
    }
    if ($row[0]->certification != '') {
      $bcount += 1;
    }
    if ($row[0]->education != '') {
      $bcount += 1;
    }
    if ($row[0]->asclient_aboutus != '') {
      $bcount += 1;
    }
    if ($row[0]->membership_plan != '' || $row[0]->membership_plan != '1') {
      $bcount += 1;
    }
    if ($row[0]->membership_upgrade != 'N') {
      $bcount += 1;
    }
    $basic = ($bcount / 18) * $basic_info;

    $scount = 0;
    if ($row[0]->facebook_link != '') {
      $scount += 1;
    }
    if ($row[0]->gplus_link != '') {
      $scount += 1;
    }
    if ($row[0]->twitter_link != '') {
      $scount += 1;
    }
    if ($row[0]->linkedin_link != '') {
      $scount += 1;
    }
    $social = ($scount / 4) * $social_info;

    $pcount = 0;
    $this->db->select('id');
    $this->db->where('user_id', $user_id);
    $this->db->from('user_portfolio');
    $pcount += $this->db->count_all_results();
    $portfolio = ($pcount / $portfolio_count) * $portfolio_info;

    $skcount = 0;
    $skills = $this->getFeild('skills_id', 'user_skills', 'user_id', $user_id);
    $skcount = count(explode(',', $skills));
    $skill = ($skcount / $skill_count) * $skill_info;

    $fcount = 0;
    $this->db->select('account_for');
    $this->db->where('user_id', $user_id);
    $this->db->from('user_bank_account');
    $fcount += $this->db->count_all_results();
    $finance = ($fcount / 2) * $finance_info;

    $rvcount = 0;
    $this->db->select('id');
    $this->db->where('user_id', $user_id);
    $this->db->where('rating_status', 'Y');
    $this->db->where('admin_review', 'Y');
    $this->db->from('references');
    $rvcount += $this->db->count_all_results();
    $review = ($rvcount / 3) * 30;

    return $basic + $social + $portfolio + $skill + $finance + $review;


  }

  public function updateproject()
  {
    $data = array(
      'status' => "E",
    );

    $this->db->where('status', "O");
    $this->db->where('expiry_date <', date("Y-m-d"));
    $this->db->update('projects', $data);
  }

  public function insert_data($table_name = '', $data = array())
  {

    if ($table_name != '' && is_array($data)) {
      return $this->db->insert($table_name, $data);
    } else {
      return false;
    }
  }

  public function getSimilarJobs($type, $key, $id)
  {
    if ($type == 'C') {
      $this->db->select("title,project_id,category,skills,buget_min,buget_max");
      $res = $this->db->get_where('projects', array('category' => $key, "project_status" => 'Y', "project_id !=" => $id), 3);
      $data = array();
      foreach ($res->result() as $row) {
        $data[] = array(
          "title"      => $row->title,
          "project_id" => $row->project_id,
          "category"   => $row->category,
          "skills"     => $row->skills,
          "buget_min"  => $row->buget_min,
          "buget_max"  => $row->buget_max
        );
      }

    } elseif ($type == 'S') {
      $this->db->select("title,project_id,category,skills,buget_min,buget_max");
      $this->db->like('skills', $key);
      $res = $this->db->get_where('projects', array("project_status" => 'Y', "project_id !=" => $id), 2);
      $data = array();
      foreach ($res->result() as $row) {
        $data[] = array(
          "title"      => $row->title,
          "project_id" => $row->project_id,
          "category"   => $row->category,
          "skills"     => $row->skills,
          "buget_min"  => $row->buget_min,
          "buget_max"  => $row->buget_max
        );
      }

    }
    return $data;
  }

  public function get_results($table_name, $query = array(), $cols = "*", $offset = '', $limit = '0', $order_by = array())
  {
    $this->db->select($cols)->from($table_name);
    if ($query and is_array($query)) {
      $this->db->where($query);
    }
    if (count($order_by) > 0 && is_array($order_by)) {
      foreach ($order_by as $key => $value) {
        $this->db->order_by($key, $value);
      }
    }
    if (is_numeric($offset) && is_numeric($limit)) {
      $this->db->limit($offset, $limit);
    }

    $rs = $this->db->get();
    //echo $this->db->last_query();
    $rs = $rs->result_array();

    return $rs;
  }

  public function update_data($table_name = '', $updated_data = array(), $cond_array = array())
  {

    if (count($cond_array) > 0 && is_array($cond_array)) {
      $this->db->where($cond_array);
    }

    return $this->db->update($table_name, $updated_data);
  }

  public function parseNotifcation($str = '')
  {
    //get_print($str);
    $noti_parse_array = array(
      'has_been_updated_his_bid_on'                                      => __('has_been_updated_his_bid_on', 'has been updated his bid on'),
      'you_are_invited_for_the_project'                                  => __('you_are_invited_for_the_project', 'You are invited for the project'),
      'has_been_placed_a_bid_on'                                         => __('has_been_placed_a_bid_on', 'has been placed a bid on'),
      'has_posted_an_entry_on_contest'                                   => __('has_posted_an_entry_on_contest', 'has posted an entry on contest'),
      'congratulation_you_have_been_awarded_for_the_contest'             => __('congratulation_you_have_been_awarded_for_the_contest', 'Congratulation, you have been awarded for the contest'),
      'congratulation_you_have_been_hired_for_the_project'               => __('congratulation_you_have_been_hired_for_the_project', 'Congratulation, you have been hired for the project'),
      'will_work_on_an_entry_and_submit_before_end_for_the_contest'      => __('will_work_on_an_entry_and_submit_before_end_for_the_contest', 'will work on an entry and submit before end for the contest'),
      'your_project'                                                     => __('your_project', 'Your Project'),
      'has_successfully_been_extended'                                   => __('has_successfully_been_extended', 'has successfully been extended'),
      'congratulations_your_project_offer_for'                           => __('congratulations_your_project_offer_for', 'Congratulations! Your project offer for'),
      'has_been_accepted_by'                                             => __('has_been_accepted_by', 'has been accepted by'),
      'your_project_offer_for_project'                                   => __('your_project_offer_for_project', 'Your project offer for project'),
      'has_been_declined_by'                                             => __('has_been_declined_by', 'has been declined by'),
      'escrow_is_enabled_for'                                            => __('escrow_is_enabled_for', 'Escrow is enabled for'),
      'milestone_was_set_successfully_for'                               => __('milestone_was_set_successfully_for', 'Milestone was set successfully for'),
      'milestone_was_successfully_set_for_your_project'                  => __('milestone_was_successfully_set_for_your_project', 'Milestone was successfully set for your project'),
      'milestone_is_modified_for_project'                                => __('milestone_is_modified_for_project', 'Milestone is modified for project'),
      'milestone_is_modified_for_your_project'                           => __('milestone_is_modified_for_your_project', 'Milestone is modified for your project'),
      'fund_request_was_sent_successfully_for'                           => __('fund_request_was_sent_successfully_for', 'Fund request was sent successfully for'),
      'bidder_requested_the_Fund_for_milestone'                          => __('bidder_requested_the_Fund_for_milestone', 'Bidder requested the Fund for milestone'),
      'release_payment_request_was_sent_successfully_for'                => __('release_payment_request_was_sent_successfully_for', 'Release payment request was sent successfully for'),
      'bidder_requested_for_the_payment_of'                              => __('bidder_requested_for_the_payment_of', 'Bidder requested for the payment of'),
      'you_have_successfully_closed_the_project'                         => __('you_have_successfully_closed_the_project', 'You have successfully closed the project'),
      'employer_has_successfully_closed_the_project'                     => __('employer_has_successfully_closed_the_project', 'Employer has successfully closed the project'),
      'you_have_successfully_give_bonus'                                 => __('you_have_successfully_give_bonus', 'You have successfully give bonus'),
      'to'                                                               => __('to', 'to'),
      'send_you_a_bonus'                                                 => __('send_you_a_bonus', 'send you a bonus'),
      'you_are_invited_for_the_project'                                  => __('you_are_invited_for_the_project', 'You are invited for the project'),
      'you_have_successfully_release_milestone'                          => __('you_have_successfully_release_milestone', 'You have successfully release milestone'),
      'payment_received_for_milestone'                                   => __('payment_received_for_milestone', 'Payment received for milestone'),
      'one_of_your_project'                                              => __('one_of_your_project', 'One of your project'),
      'has_been_disputed_please_check_your_disputes_list'                => __('has_been_disputed_please_check_your_disputes_list', 'has been disputed. Please check your disputes list'),
      'you_have_successfully_dispute_the_milestone'                      => __('you_have_successfully_dispute_the_milestone', 'You have successfully dispute the milestone'),
      'milestone'                                                        => __('milestone', 'Milestone'),
      'have_been_disputed_for_the_project'                               => __('have_been_disputed_for_the_project', 'have been disputed for the project'),
      'you_have_approved_the_Milestone_Chart_for_project'                => __('you_have_approved_the_Milestone_Chart_for_project', 'You have approved the Milestone Chart for project'),
      'milestone_Chart_have_been_approved_for_the_project'               => __('milestone_Chart_have_been_approved_for_the_project', 'Milestone Chart have been approved for the project'),
      'you_have_declined_the_milestone_for_project'                      => __('you_have_declined_the_milestone_for_project', 'You have declined the milestone for project'),
      'milestone_have_been_declined_for_the_project'                     => __('milestone_have_been_declined_for_the_project', 'Milestone have been declined for the project'),
      'you_have_declined_the_Fund_request_for_milestone'                 => __('you_have_declined_the_Fund_request_for_milestone', 'You have declined the Fund request for milestone'),
      'for_project'                                                      => __('for_project', 'for project'),
      'for_the_project'                                                  => __('for_the_project', 'for the project'),
      'your_Fund_request_declined_for_milestone'                         => __('your_Fund_request_declined_for_milestone', 'Your Fund request declined for milestone'),
      'you_have_declined_the_payment_for_milestone'                      => __('you_have_declined_the_payment_for_milestone', 'You have declined the payment for milestone'),
      'payment_have_been_canceled_for_milestone'                         => __('payment_have_been_canceled_for_milestone', 'Payment have been canceled for milestone'),
      'fund_added_in_Escrow_Successfully_for_hourly_job_for_the_project' => __('fund_added_in_Escrow_Successfully_for_hourly_job_for_the_project', 'Fund added in Escrow Successfully for hourly job for the project'),
      'fund_added_in_Escrow_for_hourly_job_for_the_project'              => __('fund_added_in_Escrow_for_hourly_job_for_the_project', 'Fund added in Escrow for hourly job for the project'),
      'you_have_successfully_release_hourly_job_payment_for'             => __('you_have_successfully_release_hourly_job_payment_for', 'You have successfully release hourly job payment for'),
      'payment_received_for_hourly_job_payment_for_the_project'          => __('payment_received_for_hourly_job_payment_for_the_project', 'Payment received for hourly job payment for the project'),
      'you_have_successfully_dispute_the_hourly_job_payment_for'         => __('you_have_successfully_dispute_the_hourly_job_payment_for', 'You have successfully dispute the hourly job payment for'),
      'hourly_job_payment_have_been_disputed_for_the_project'            => __('hourly_job_payment_have_been_disputed_for_the_project', 'Hourly Job payment have been disputed for the project'),
      'you_have_successfully_dispute_the_payment_for'                    => __('you_have_successfully_dispute_the_payment_for', 'You have successfully dispute the payment for'),
      'payment_have_been_disputed_for_the_project'                       => __('payment_have_been_disputed_for_the_project', 'Payment have been disputed for the project'),
      'you_have_successfully_give_feedback_to'                           => __('you_have_successfully_give_feedback_to', 'You have successfully give feedback to'),
      'send_you_a_feedback'                                              => __('send_you_a_feedback', 'send you a feedback'),
      'an_activity_has_been_assigned_to_you_on_project'                  => __('an_activity_has_been_assigned_to_you_on_project', 'An activity has been assigned to you on project'),
      'an_activity_has_been_approved_by'                                 => __('an_activity_has_been_approved_by', 'An activity has been approved by'),
      'an_activity_has_been_denied_by'                                   => __('an_activity_has_been_denied_by', 'An activity has been denied by'),
      'a_new_dispute_message_by'                                         => __('a_new_dispute_message_by', 'A new dispute message by'),
      'send_you_a_dispute_settlement_request'                            => __('send_you_a_dispute_settlement_request', 'send you a dispute settlement request'),
      'your_dispute_settlement_request_has_been_approved'                => __('your_dispute_settlement_request_has_been_approved', 'Your dispute settlement request has been approved'),
      'your_dispute_settlement_request_has_been_rejected'                => __('your_dispute_settlement_request_has_been_rejected', 'Your dispute settlement request has been rejected'),
      'disputed_milestone_has_been_settled'                              => __('disputed_milestone_has_been_settled', 'Disputed milestone has been settled'),
      'updated_project_start_date_for'                                   => __('updated_project_start_date_for', 'updated project start date for'),
      'request_a_project_start_date_for'                                 => __('request_a_project_start_date_for', 'request a project start date for'),
      'you_request_for_project'                                          => __('you_request_for_project', 'You request for project'),
      'has_been_accepted'                                                => __('has_been_accepted', 'has been accepted'),
      'has_been_rejected'                                                => __('has_been_rejected', 'has been rejected'),
      'fund_successfully_added_for_project'                              => __('fund_successfully_added_for_project', 'Fund successfully added for project'),
      'manual_hour_requested_by'                                         => __('manual_hour_requested_by', 'Manual hour requested by'),
      'edit_request_for'                                                 => __('edit_request_for', 'edit request for'),
      'edited_hour_for'                                                  => __('edited_hour_for', 'edited hour for'),
      'payment_received_for'                                             => __('payment_received_for', 'Payment received for'),
      'contract_endded_with'                                             => __('contract_endded_with', 'Contract ended with'),
      'review_updated'                                                   => __('review_updated', 'Review updated'),
      'new_review_given_to_you'                                          => __('new_review_given_to_you', 'New review given to you'),
      'milestone_request_received_for'                                   => __('milestone_request_received_for', 'Milestone request received for'),
      'milestone_request_approved'                                       => __('milestone_request_approved', 'Milestone request approved'),
      'milestone_request_rejected'                                       => __('milestone_request_rejected', 'Milestone request rejected'),
      'send_you_a_invoice_for'                                           => __('send_you_a_invoice_for', 'send you a invoice for'),
      'invoice_number'                                                   => __('invoice_number', 'Invoice number'),
      'has_been_paid'                                                    => __('has_been_paid', 'has been paid'),
      'your_Fund_request_declined_for_milestone'                         => __('your_Fund_request_declined_for_milestone', 'Your Fund request declined for milestone'),
      'you_have_successfully_pause_the_project'                          => __('you_have_successfully_pause_the_project', 'You have successfully pause the project'),
      'employer_has_successfully_pause_the_project'                      => __('employer_has_successfully_pause_the_project', 'Employer has successfully pause the project'),
      'your_manual_hour_requested_for_project'                           => __('your_manual_hour_requested_for_project', 'Your manual hour requested for project'),
      'has_been_deleted_by'                                              => __('has_been_deleted_by', 'has been deleted by'),
      'request_for_payment'                                              => __('request_for_payment', 'request for payment'),
      'contract_ended_with'                                              => __('contract_ended_with', 'contract ended with'),
      'project_is_now_running'                                           => __('project_is_now_running', 'project is now running'),
      'project_is_marked_as_completed'                                   => __('project_is_marked_as_completed', 'project is marked as completed'),
      'project_is_paused_by_the_employer'                                => __('project_is_paused_by_the_employer', 'project is paused by the employer'),
      'Confirm_the_cancel_request_of_project'                            => __('Confirm_the_cancel_request_of_project', 'Confirm the cancel request of project'),
      'Confirm_the_complete_request_of_project'                          => __('Confirm_the_complete_request_of_project', 'Confirm the complete request of project'),
      'tööandja_has_successfully_pause_the_project'                      => __('tööandja_has_successfully_pause_the_project', 'tööandja has successfully pause the project'),
      'project_is_paused'                                                => __('project_is_paused', 'project is paused'),
      'project_is_start_by_the_employer'                                 => __('project_is_start_by_the_employer', 'project is start by the employer'),
      'project'                                                          => __('project', 'project'),
      'confirm_the_cancel_request_of'                                    => __('confirm_the_cancel_request_of', 'confirm the cancel request of'),
      'requested_for_payment'                                            => __('requested_for_payment', 'requested for payment'),
    );
    foreach ($noti_parse_array as $k => $v) {
      $str = str_replace('{' . $k . '}', $v, $str);
    }
    return $str;
  }

  public function parseTransaction($str = '')
  {
    //get_print($str);
    $noti_parse_array = array(
      'Fund_added_by_admin'                      => __('Fund_added_by_admin', 'Fund added by admin'),
      'Featured_Contest'                         => __('Featured_Contest', 'Featured Contest'),
      'Sealed_Contest'                           => __('Sealed_Contest', 'Sealed Contest'),
      'Contest_Awarded_To_Entry'                 => __('Contest_Awarded_To_Entry', 'Contest Awarded To Entry'),
      'Contest_Awarded'                          => __('Contest_Awarded', 'Contest Awarded'),
      'Project_payment_to_escrow'                => __('Project_payment_to_escrow', 'Project payment to escrow'),
      'Project_payment'                          => __('project_payment', 'project payment'),
      'Project_fund_refunded'                    => __('Project_fund_refunded', 'Project fund refunded'),
      'Project_fund_refund_received'             => __('Project_fund_refund_received', 'Project fund refund received'),
      'Bid_Purchase'                             => __('Bid_Purchase', 'Bid Purchase'),
      'Bonus_given'                              => __('Bonus_given', 'Bonus given'),
      'Bonus_received'                           => __('Bonus_received', 'Bonus received'),
      'Membership_upgrade'                       => __('Membership_upgrade', 'Membership upgrade'),
      'Fund_added_through_paypal'                => __('Fund_added_through_paypal', 'Fund added through paypal'),
      'Fund_withdraw'                            => __('Fund_withdraw', 'Fund withdraw'),
      'Freelancer_payment_through_escrow_wallet' => __('Freelancer_payment_through_escrow_wallet', 'Freelancer payment through escrow wallet'),
      'Commission_deducted'                      => __('Commission_deducted', 'Commission deducted'),
      'Commission_received'                      => __('Commission_received', 'Commission received'),
      'Project_payment_to_freelancer'            => __('Project_payment_to_freelancer', 'Project payment to freelancer'),
      'Project_payment_received'                 => __('Project_payment_received', 'Project payment received'),
      'Hourly_project_fund_added_to_escrow'      => __('Hourly_project_fund_added_to_escrow', 'Hourly project fund added to escrow'),
      'Hourly_project_payment_through_escrow'    => __('Hourly_project_payment_through_escrow', 'Hourly project payment through escrow'),
      'Project_featured_fee'                     => __('Project_featured_fee', 'Project featured fee'),
      'Project_featured_fee_received'            => __('Project_featured_fee_received', 'Project featured fee received'),
      'Disputed_Project_payment_received'        => __('Disputed_Project_payment_received', 'Disputed Project payment received'),
      'Disputed_Project_payment'                 => __('Disputed_Project_payment', 'Disputed Project payment'),
      'commission_paid'                          => __('commission_paid', 'commission paid'),
      'Project_fund_deposited'                   => __('Project_fund_deposited', 'Project fund deposited'),
    );
    foreach ($noti_parse_array as $k => $v) {
      $str = str_replace('{' . $k . '}', $v, $str);
    }
    return $str;
  }
}
