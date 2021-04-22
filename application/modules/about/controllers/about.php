<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class About extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('about_model');
		$this->load->library("mailtemplete");
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        parent::__construct();
		$idiom = $this->session->userdata('lang');
		$this->lang->load('about',$idiom);
    }

    public function index() {
		$breadcrumb=array(
            array(
                'title'=>__('about_us','About'),'path'=>''
            )
        );
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('about_us','About'));
		$data = '';
		$data['address']=$this->autoload_model->getFeild('corporate_address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('office_no','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('admin_mail','setting','id',1);
		
		$head['current_page']='about';
		$head['ad_page']='success_tips';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","About");
		$lay['client_testimonial']="inc/footerclient_logo";
		$data['contact']=$this->about_model->getcontact_info();
		$this->layout->view('view_about',$lay,$data, 'normal');
    }

}
