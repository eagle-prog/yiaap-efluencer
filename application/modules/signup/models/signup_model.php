<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class signup_model extends BaseModel
{

  public function __construct()
  {

    return parent::__construct();

  }

  public function register()
  {

    $this->load->helper('date');
    $this->load->library('MY_Validation');
    //$this->load->library('form_validation');
    //z$this->load->helper('recaptcha');
    $i = 0;
    $fname = $this->input->post('fname');
    $lname = $this->input->post('lname');
    $username = $this->input->post('regusername');
    $email = $this->input->post('email');
    $cnfemail = $this->input->post('cnfemail');
    $password = $this->input->post('regpassword');
    $cpassword = $this->input->post('cpassword');
    $country = $this->input->post('country');
    $city = $this->input->post('city');
    $captcha = trim(strtolower($this->input->post('captcha')));
    if ($this->input->post('termsandcondition') != 'Y') {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'termsandcondition';
      $msg['errors'][$i]['message'] = __('signup_please_check_terms_and_condition', 'Please check terms and conditions');
      $i++;
    }

    /* fname checking */
    if ($fname == '') {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'fname';
      $msg['errors'][$i]['message'] = __('signup_please_enter_first_name', 'Please enter first name');
      $i++;
    } else if (!preg_match("/^[a-zA-Z]+$/", $fname)) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'fname';
      $msg['errors'][$i]['message'] = __('signup_alphabetic', 'Please enter alphabetic character');
      $i++;
    } else if (strlen($fname) > 15) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'fname';
      $msg['errors'][$i]['message'] = __('signup_15char_first_name', 'First name cannot be longer than 15');
      $i++;
    }
    /* lname checking */
    if ($lname == '') {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'lname';
      $msg['errors'][$i]['message'] = __('signup_please_enter_last_name', 'Please enter last name');
      $i++;
    } else if (!preg_match("/^[a-zA-Z]+$/", $lname)) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'lname';
      $msg['errors'][$i]['message'] = __('signup_alphabetic', 'Please enter alphabetic character');
      $i++;
    } else if (strlen($lname) > 15) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'lname';
      $msg['errors'][$i]['message'] = __('signup_15char_last_name', 'Last name cannot be longer than 15');
      $i++;
    }

    if ($username == '' || strlen($username) < 4 || strlen($username) > 20 || !preg_match('/^[a-zA-Z0-9\._-]+$/', $username)) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'regusername';
      $msg['errors'][$i]['message'] = __('signup_username_must_be_4_to_20_characters', 'Username must be 4 to 20 characters, only letters and/or numbers');
      $i++;
    } else {
      $this->db->where("username", $username);
      $un = $this->db->count_all_results('user');
      if ($un > 0) {
        $msg['status'] = 'FAIL';
        $msg['errors'][$i]['id'] = 'username';
        $msg['errors'][$i]['message'] = __('signup_username_already_exists', 'The username you are trying to use already exists please try again');
        $i++;
      }
    }
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
    if ($email == '' || !preg_match($regex, $email)) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'email';
      $msg['errors'][$i]['message'] = __('signup_enter_valid_email', 'Please enter a valid e-mail');
      $i++;
    }
    if ($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'email';
      $msg['errors'][$i]['message'] = __('signup_type_email_address', 'Please type email address');
      $i++;
    } elseif ($cnfemail == '' || $email != $cnfemail) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'cnfemail';
      $msg['errors'][$i]['message'] = __('signup_conf_email_not_match', 'Confirm email not match');
      $i++;
    } else {
      $this->db->where("email", $email);
      $em = $this->db->count_all_results('user');
      if ($em > 0) {
        $msg['status'] = 'FAIL';
        $msg['errors'][$i]['id'] = 'email';
        $msg['errors'][$i]['message'] = __('signup_error_email_exist', 'This email is already in use. Please enter a different one');
        $i++;
      }
    }


//$hasAlphaNum = preg_match('b[a-z0-9]+bi', $password);
//$hasNonAlphaNum = preg_match('b[\!\@#$%\?&\*\(\)_\-\+=]+bi', $password);

    /*if($password=='' || strlen($password)<6 || strlen($password)>12 || !preg_match('/^[a-zA-Z0-9,_@+*^]+$/',$password)){



        $msg['status']='FAIL';



        $msg['errors'][$i]['id']='regpassword';



        $msg['errors'][$i]['message']="Your password must be at least 6 characters and no longer than 12. Password can only contain numbers or letters or both or ',_@+*^' all other symbols are invalid";



        $i++;



    }*/

    //if($password=='' || strlen($password)<6 || strlen($password)>12 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%^&+=_])(?=.{6,12}).*$/',$password) || !preg_match('/^[0-9A-Za-z@#$%^&+=_]+$/',$password)){

    /*if($password=='' || strlen($password)<6 || strlen($password)>12 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%^&+=_])(?=.{6,12}).*$/',$password)){
        $msg['status']='FAIL';
        $msg['errors'][$i]['id']='regpassword';
        $msg['errors'][$i]['message']="Your password  must be 6 to 12 characters with one Capital letters,one small letter and one numbers and one special characters (@#$%^&+=_) all other symbols are invalid";
        $i++;
    }*/

    if ($password == '' || strlen($password) < 6 || strlen($password) > 12) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'regpassword';
      $msg['errors'][$i]['message'] = __('signup_password_must_be_6_to_12_char_letters_numbers', 'Password must be 6 to 12 characters, only letters and/or numbers');
      $i++;
    } elseif ($cpassword == '' || $password != $cpassword) {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'cpassword';
      $msg['errors'][$i]['message'] = __('signup_conf_password_not_match', 'Confirm password not match');
      $i++;
    }
    if ($country == "") {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'country';
      $msg['errors'][$i]['message'] = __('signup_select_your_country', 'Select Your Country');
      $i++;
    }
    /* if($country==""){
        $msg['status']='FAIL';
        $msg['errors'][$i]['id']='country';
        $msg['errors'][$i]['message']="Select Your Country";
        $i++;
    }
    */
    if ($city == "") {
      $msg['status'] = 'FAIL';
      $msg['errors'][$i]['id'] = 'city';
      $msg['errors'][$i]['message'] = __('signup_select_your_city', 'Select Your city');
      $i++;
    }
    /*if (!$this->my_validation->recaptcha_matches()) {



        $msg['status']='FAIL';



        $msg['errors'][$i]['id']='captcha';



        $msg['errors'][$i]['message']="Captcha is invalid";



        $i++;



    }*/

    if ($i == 0) {
      if (EMAIL_VERI == 'N') {
        $v_stat = 'Y';
        $status = 'N';
      } else {
        $v_stat = 'N';
        $status = 'N';
      }
      $v_stat = 'Y';
      $data = array(
        'username'         => $this->input->post('regusername'),
        'fname'            => strip_tags(trim($this->input->post('fname'))),
        'lname'            => strip_tags(trim($this->input->post('lname'))),
        //added new field for account type
        'account_type'     => $this->input->post('account_type'),
        'password'         => md5($password),
        'email'            => $this->input->post('email'),
        'country'          => $this->input->post('country'),
        'city'             => $this->input->post('city'),
        'v_stat'           => $v_stat,
        'status'           => $status,
        'verify'           => 'N',
        'membership_plan'  => '1',
        'membership_start' => date("Y-m-d"),
        'ip'               => $_SERVER['REMOTE_ADDR']
      );

      $this->db->set('reg_date', 'NOW()', FALSE);
      $this->db->set('edit_date', 'NOW()', FALSE);
      $this->db->set('ldate', 'NOW()', FALSE);
      /*parent::insert("user", $data);*/
      if ($this->db->insert('user', $data)) {
        $user_id = $this->db->insert_id();
        /**
         *
         * @var ******************************
         *
         */
        $this->db->insert('wallet', array('user_id' => $user_id, 'title' => $data['fname'] . ' ' . $data['lname'], 'balance' => 0));
        if ($this->session->userdata('user_affiliate_set')) {

          $affiliate_data = array(
            'user_id'      => $user_id,
            'affiliate_id' => $this->session->userdata('user_affiliate_set'),
            'email'        => $this->input->post('email'),
            'reg_date'     => date('Y-m-d H:i:s'),
            'status'       => 'N',
            'ip'           => $this->input->ip_address()
          );
          $this->db->insert('user_affiliate_list', $affiliate_data);


        }
        /**
         *
         * @var ***********************
         *
         */

        $token = md5(time() . '-' . $user_id);
        $this->db->where('user_id', $user_id)->update('user', array('email_verification_link' => $token));
        $url = SITE_URL . "login/index/" . base64_encode($user_id);
        $url = SITE_URL . "login/index/" . $token;
        if (EMAIL_VERI == 'Y') {
          $link = $url;
        } else {
          $link = SITE_URL . "login/";
        }
        $link = $url;
        $from = ADMIN_EMAIL;
        $to = $email;
        $template = 'registration';
        $data_parse = array('username' => $username,
                            'password' => $password,
                            'email'    => $email,
                            'copy_url' => $link,
                            'url_link' => $link
        );
        $msg['status'] = 'OK';
        $msg['message'] = __('signup_registration_successfull', 'Registration Successfully');
        $msg['uid'] = $user_id;
        //$send_email = $this->auto_model->send_email($from,$to,$template,$data_parse);

        $send_email = send_layout_mail($template, $data_parse, $to);
        if ($send_email) {
          $msg['status'] = 'OK';
          if (EMAIL_VERI == 'Y') {
            $msg['message'] = __('signup_registration_successfull_check_your_mail_for_activation_link', 'Registration Success.Please check your mail for activation link');
          } else {
            $msg['message'] = __('signup_registration_successfull_check_your_mail', 'Registration Success.Please check your mail');
          }
        } else {
          $msg['status'] = 'OK';
          $msg['message'] = __('signup_registration_successfull_mail_send_failed', 'Registration Success. Mail sending fail');
        }
      } else {
        $msg['status'] = 'FAIL';
        $msg['errors'][$i]['id'] = 'agree_terms';
        $msg['errors'][$i]['message'] = 'dB error!';
      }
    }
    unset($_POST);
    echo json_encode($msg);
  }


  public function getCountry()
  {
    $this->db->select('*');
    $this->db->order_by('name');
    $res = $this->db->get('countries');
    $data = array();
    foreach ($res->result() as $row) {
      $data[] = array(
        'name'  => $row->name,
        'code3' => $row->iso3
      );
    }
    return $data;
  }


  public function getCity()


  {


    $this->db->select('city');


    $this->db->group_by('city');


    $this->db->order_by('city');


    $res = $this->db->get('cities');


    $data = array();


    foreach ($res->result() as $row) {


      $data[] = array(


        'city' => $row->city


      );


    }


    return $data;


  }


  public function socialSignup($user_profile)


  {


    /*echo "<pre>";



    print_r($user_profile);die();*/


    $v_stat = 'Y';


    $status = 'Y';


    //$country=end(explode(",",$user_profile['location']['name']));


    $data = array(


      'username' => strtolower($user_profile['first_name'] . $user_profile['last_name']),


      'fname' => $user_profile['first_name'],


      'lname' => $user_profile['last_name'],


      'password' => md5('123456'),


      'email' => $user_profile['email'],


      'v_stat' => $v_stat,


      'status' => $status,


      'membership_plan' => '1',


      'membership_start' => date("Y-m-d"),


      'ip' => $_SERVER['REMOTE_ADDR']


    );


    $this->db->set('reg_date', 'NOW()', FALSE);


    $this->db->set('edit_date', 'NOW()', FALSE);


    $this->db->set('ldate', 'NOW()', FALSE);


    parent::insert("user", $data);


    if ($this->db->insert('user', $data)) {


      $user_id = $this->db->insert_id();


      $url = SITE_URL . "login/";


      $link = $url;


      $from = ADMIN_EMAIL;


      $to = $user_profile['email'];


      $template = 'registration';


      $data_parse = array('username' => strtolower($user_profile['first_name'] . $user_profile['last_name']),


                          'password' => '123456',


                          'email' => $user_profile['email'],


                          'copy_url' => $link,


                          'url_link' => $link


      );


      $this->auto_model->send_email($from, $to, $template, $data_parse);


      return true;


    }


  }


  public function linkedinSignup($user_profile)


  {


    $v_stat = 'Y';


    $status = 'Y';


    $data = array(


      'username' => strtolower($user_profile['first_name'] . $user_profile['second_name']),


      'fname' => $user_profile['first_name'],


      'lname' => $user_profile['second_name'],


      'password' => md5('123456'),


      'email' => $user_profile['email-address'],


      'v_stat' => $v_stat,


      'status' => $status,


      'membership_plan' => '1',


      'membership_start' => date("Y-m-d"),


      'ip' => $_SERVER['REMOTE_ADDR']


    );


    $this->db->set('reg_date', 'NOW()', FALSE);


    $this->db->set('edit_date', 'NOW()', FALSE);


    $this->db->set('ldate', 'NOW()', FALSE);


    parent::insert("user", $data);


    if ($this->db->insert('user', $data)) {


      $user_id = $this->db->insert_id();


      $url = SITE_URL . "login/";


      $link = $url;


      $from = ADMIN_EMAIL;


      $to = $user_profile['email-address'];


      $template = 'registration';


      $data_parse = array('username' => strtolower($user_profile['first_name'] . $user_profile['second_name']),


                          'password' => '123456',


                          'email' => $user_profile['email-address'],


                          'copy_url' => $link,


                          'url_link' => $link


      );


      $this->auto_model->send_email($from, $to, $template, $data_parse);


      return true;


    }


  }

  public function usercheck()
  {
    $user = htmlentities(strip_tags(trim($this->input->post('user'))), ENT_QUOTES);
    $this->db->select('user_id');
    $this->db->where("(username = '" . $user . "')");
    $query = $this->db->get('user');
    $result = $query->result();
    if ($query->num_rows() == 1) {
      $msg = 0;
    } else {
      $msg = 1;
    }
    unset($_POST);
    echo $msg;
  }

  public function emailcheck()
  {
    $email = htmlentities(strip_tags(trim($this->input->post('email'))), ENT_QUOTES);
    $this->db->select('user_id');
    $this->db->where("(email = '" . $email . "')");
    $query = $this->db->get('user');
    $result = $query->result();
    if ($query->num_rows() == 1) {
      $msg = 0;
    } else {
      $msg = 1;
    }
    unset($_POST);
    echo $msg;
  }


}
