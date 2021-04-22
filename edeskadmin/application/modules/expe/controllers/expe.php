<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expe extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('expe_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
        redirect(base_url() . 'expe/page');
    }

    /////////////// Menu Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        if ($this->input->post()) 
		{
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('arb_name', 'Arabic Name', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('arb_description', 'Arabic Description', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } 
			else
			{
				$post_data['name'] = $this->input->post('name');
				$post_data['arb_name'] = $this->input->post('arb_name');
				$post_data['description'] = $this->input->post('description');
				$post_data['arb_description'] = $this->input->post('arb_description');
				$post_data['status'] = $this->input->post('status');

				$insert = $this->expe_model->add_expe($post_data);
				if ($insert) 
				{
					$this->session->set_flashdata('succ_msg', 'Experience level Inserted Successfully');
				} else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
				}
				redirect(base_url() . 'expe/page');
			}
        }
        else 
		{
            $this->layout->view('add', $lay, $data);
        }
    }
    
    /* public function get_banner_type_position($type)
    {
        $data['positions'] = $this->banner_model->get_banner_position($type); 
        $this->layout->view("banner_type_position", "", $data, FALSE);
    } */

    public function edit() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }
		$data['id'] = $id;
		$data['status'] = $this->auto_model->getFeild('status', 'experience_level', 'id', $id);
		$data['name'] = $this->auto_model->getFeild('name', 'experience_level', 'id', $id);
		$data['arb_name'] = $this->auto_model->getFeild('arb_name', 'experience_level', 'id', $id);
		$data['description'] = $this->auto_model->getFeild('description', 'experience_level', 'id', $id);
		$data['arb_description'] = $this->auto_model->getFeild('arb_description', 'experience_level', 'id', $id);
        if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('arb_name', 'Arabic Name', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('arb_description', 'Arabic Description', 'required');
            $this->form_validation->set_rules('status', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {
				$post_data['name'] = $this->input->post('name');
				$post_data['arb_name'] = $this->input->post('arb_name');
				$post_data['description'] = $this->input->post('description');
				$post_data['arb_description'] = $this->input->post('arb_description');
				$post_data['status'] = $this->input->post('status');
                $update = $this->expe_model->update_expe($post_data,$id);

                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Experience level Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'expe/page');
            }
        } else {
            $data['id'] = $id;
            $data['status'] = $this->auto_model->getFeild('status', 'experience_level', 'id', $id);
			$data['name'] = $this->auto_model->getFeild('name', 'experience_level', 'id', $id);
			$data['arb_name'] = $this->auto_model->getFeild('arb_name', 'experience_level', 'id', $id);
			$data['description'] = $this->auto_model->getFeild('description', 'experience_level', 'id', $id);
			$data['arb_description'] = $this->auto_model->getFeild('arb_description', 'experience_level', 'id', $id);
            $this->layout->view('edit', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->expe_model->delete_expe($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Experience level Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'expe/page');
    }

    public function page($limit_from = '') {
        $lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "expe/page";
        $config["total_rows"] = $this->expe_model->record_count_expe();
        $config["per_page"] = 30;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0) {
            for ($i = 1; $i < $page; $i++) {
                $start = $start + $per_page;
            }
        }

        $data['data'] = $this->auto_model->leftPannel();
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["total_rows"];
        $data['all_data'] = $this->expe_model->getexpeList($config['per_page'], $start);
        $this->layout->view('list', $lay, $data);
    }

    public function change_expe_status() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'inact')
            $data['status'] = 'N';
        if ($this->uri->segment(4) == 'act')
            $data['status'] = 'Y';

        $update = $this->expe_model->update_expe($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'inact')
                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
            if ($this->uri->segment(4) == 'act')
                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        $status = $this->uri->segment(5);
        redirect(base_url() . 'expe/page/');
    }

    /* public function search_banner() {
        $type = $this->uri->segment(3);
        $data['data'] = $this->auto_model->leftPannel();
        //$data['list'] = $this->banner_model->getbannerList($type);
        $lay['lft'] = "inc/section_left";
        if ($this->input->post('submit')) {
            $usr_select = $this->input->post('usr_select');
            $search_element = $this->input->post('search_element');
            $data['usr_select'] = $usr_select;
            $data['search_element'] = $search_element;
            if ($usr_select == '' || $search_element == '' || $usr_select == 'all') {
                if ($usr_select == 'all') {
                    $data['all_data'] = $this->banner_model->getbannerList($type);
                    //echo "<pre>";
                    //print_r($data);die;
                    $this->layout->view('list', $lay, $data);
                }
                redirect(base_url() . 'banner/page/' . $type);
            } else {


                if ($usr_select == 'type') {
                    $get_type = $this->auto_model->getFeild('id', 'banner', 'type', $search_element);
                    $data['all_data'] = $this->banner_model->getAllSearchData('id', $get_type, $type);
                    $this->layout->view('list', $lay, $data);
                } else {
                    $data['all_data'] = $this->banner_model->getAllSearchData($usr_select, $search_element, $type);


                    $this->layout->view('list', $lay, $data);
                }
            }
        }
    } */

}
