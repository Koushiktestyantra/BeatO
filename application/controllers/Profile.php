<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
	{
		parent::__construct();		
		$this->load->helper(['url', 'language']);		
		$this->load->library('session');
		$this->load->helper('form');		
		$this->load->library('form_validation');		
		$this->load->library('upload');
		$this->load->helper('file');		
		$this->load->database();
		$this->load->model('profile_model');
		
		date_default_timezone_set("Asia/Kolkata");
		$this->form_validation->set_error_delimiters('<span style="font-size:12px;color:red;margin-left:0px;">', '</span>');
	}

	public function create_profile()
	{
		
        if(isset($_POST) != null){ 
        // validate form input
        $this->form_validation->set_rules('name', 'Name', 'trim|required');   
        $this->form_validation->set_rules('gender', 'Gender', 'required');      
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[profile.email]');               
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|max_length[10]');
        $this->form_validation->set_rules('experience', 'Experience', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[20]');
        
       
        if ($this->form_validation->run() === TRUE)
        {
            $email = strtolower($this->input->post('email'));

            $data = [
                'name' => $this->input->post('name'),
                'gender' => $this->input->post('gender'),
                'email' => $email,
                'city' => $this->input->post('city'),
                'phone' => $this->input->post('phone'),
                'experience' => $this->input->post('experience'),
                'description' => $this->input->post('description'),                
            ];
            $res = $this->profile_model->profile($data); 
           
            if($res){
            	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has been submitted.</span>');
                  $msg = ''; 
            }else{
            	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</span>');
                 
            }
            redirect('profile/create_profile');
        }
        }         
          $this->load->view('auth/create_profile');
		}
}
