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
		$this->load->helper('security');		
		$this->load->database();
		$this->load->model('profile_model');
		
		date_default_timezone_set("Asia/Kolkata");
		$this->form_validation->set_error_delimiters('<span style="font-size:12px;color:red;margin-left:0px;">', '</span>');
	}

	public function list_profile()
	{
		$data['profiles'] = $this->profile_model->get_profiles()->result();
	
       $this->load->view('list_profiles',$data);
    }


	public function create_profile()
	{		
        if($this->input->post('submit') == 'profile')
        {        	
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
	            if(!empty($_FILES['profileImage']['name']))
	        	{
		        	$files = $_FILES;
		       		$_FILES['userfile']['name']= $files['profileImage']['name']; 
		            $_FILES['userfile']['type']= $files['profileImage']['type'];
		            $_FILES['userfile']['tmp_name']= $files['profileImage']['tmp_name'];
		            $_FILES['userfile']['error']= $files['profileImage']['error'];
		            $_FILES['userfile']['size']= $files['profileImage']['size'];				
					$config['upload_path'] = "./uploads/";			
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '2048';				
					$this->upload->initialize($config);
					$this->upload->do_upload();				
						if($this->upload->do_upload())
			            {			            	
			            	$data = array('upload_data' => $this->upload->data()); 
	                        $email = strtolower($this->input->post('email'));
				            $form_data = 
					            [
					                'name' => $this->input->post('name'),
					                'gender' => $this->input->post('gender'),
					                'email' => $email,
					                'city' => $this->input->post('city'),
					                'phone' => $this->input->post('phone'),
					                'experience' => $this->input->post('experience'),
					                'image' => $_FILES['profileImage']['name'],
					                'description' => $this->input->post('description'),                
					            ];	
					            $form_data = $this->security->xss_clean($form_data);				           
				                $res = $this->profile_model->profile($form_data); 
			           
					            if($res){
					            	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has been submitted.</span>');
					            }else{
					            	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</span>');
					                 
					            }
			            		redirect('profile/create_profile');

			            }else{
			            	$error = array('error' => $this->upload->display_errors());	           
			            	 $this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">You can upload a image of max 2MB size only.</span>');
			             redirect('profile/create_profile');
			            }
	         	}else{
	                  $this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Please choose an image.</span>');
			             redirect('profile/create_profile'); 
	         	}   	
	        }
        }         
          $this->load->view('create_profile');
	}

    
    public function edit_profile()
	{
		$data['profile'] = $this->profile_model->get_profile($this->uri->segment('3'))->row();	
        $this->load->view('edit_profile',$data);
    }

     public function update_profile()
	{	   	 
		if($this->input->post('submit') == 'profileUpdate')
        { 
           $seg = $this->input->post('profileId');        	
	        // validate form input 
	        $this->form_validation->set_rules('name', 'Name', 'trim|required');   
	        $this->form_validation->set_rules('gender', 'Gender', 'required'); 
	        $profile_email_count = $this->profile_model->emailCount($this->input->post('email'));
				if($profile_email_count >1)
				{   
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[profile.email]');
				}else{
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');	
				}               
	        $this->form_validation->set_rules('city', 'City', 'trim|required');
	        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|max_length[10]');
	        $this->form_validation->set_rules('experience', 'Experience', 'trim|required');
	        $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[20]');  
	        if ($this->form_validation->run() === TRUE)
	        {	        	
	            if(!empty($_FILES['profileImage']['name']))
	        	{
		        	$files = $_FILES;
		       		$_FILES['userfile']['name']= $files['profileImage']['name']; 
		            $_FILES['userfile']['type']= $files['profileImage']['type'];
		            $_FILES['userfile']['tmp_name']= $files['profileImage']['tmp_name'];
		            $_FILES['userfile']['error']= $files['profileImage']['error'];
		            $_FILES['userfile']['size']= $files['profileImage']['size'];				
					$config['upload_path'] = "./uploads/";			
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '2048';				
					$this->upload->initialize($config);
					$this->upload->do_upload();				
						if($this->upload->do_upload())
			            {			            	
			            	$data = array('upload_data' => $this->upload->data()); 
	                        $email = strtolower($this->input->post('email'));
				            $form_data = 
					            [					             
					                'name' => $this->input->post('name'),
					                'gender' => $this->input->post('gender'),
					                'email' => $email,
					                'city' => $this->input->post('city'),
					                'phone' => $this->input->post('phone'),
					                'experience' => $this->input->post('experience'),
					                'image' => $_FILES['profileImage']['name'],
					                'description' => $this->input->post('description'),
					                'updated_at' => date('Y-m-d H:i:s'),                
					            ];
					            $form_data = $this->security->xss_clean($form_data);
					            $profile_data = $this->profile_model->get_profile($this->input->post('profileId'))->row();                                                             
				                $res = $this->profile_model->profileUpdate($form_data,$this->input->post('profileId')); 
			                   
					            if($res){
					            	if( $profile_data->name !== $this->input->post('name')){ 
                                    log_message('all', 'name logged');
                                    }
                                    if($profile_data->gender !== $this->input->post('gender')){
                                     log_message('all', 'gender logged');
                                    }
                                    if($profile_data->email !== $email){
                                     log_message('all', 'email logged');
                                    }
                                    if($profile_data->city !== $this->input->post('city')){
                                      log_message('all', 'city logged');
                                    }
                                    if($profile_data->phone !== $this->input->post('phone')){
                                     log_message('all', 'phone logged');
                                    }
                                    if($profile_data->experience !== $this->input->post('experience')){
                                        log_message('all', 'experience logged');
                                    }
                                    if($profile_data->image !== $this->input->post('imageName')){
                                       log_message('all', 'image logged');
                                    }
                                    if($profile_data->description !== $this->input->post('description')){
                                        log_message('all', 'description logged');
                                    }     					            	
					            	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has been submitted succesfully.</span>');				            	  
			            		        redirect('profile/edit_profile/'.$seg); 
					            }else{
					            	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</span>');					                
			            		     redirect('profile/edit_profile/'.$seg);    
					            }					            
			            }else{
			            	$error = array('error' => $this->upload->display_errors());	           
			            	 $this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">You can upload a image of max 2MB size only.</span>');			            	
			                redirect('profile/edit_profile/'.$seg);
			            }
	         	}else{
	         		        $email = strtolower($this->input->post('email'));
				            $form_data = 
					            [
		 			                'name' => $this->input->post('name'),
					                'gender' => $this->input->post('gender'),
					                'email' => $email,
					                'city' => $this->input->post('city'),
					                'phone' => $this->input->post('phone'),
					                'experience' => $this->input->post('experience'),
					                'image' => $this->input->post('imageName'),
					                'description' => $this->input->post('description'),
					                'updated_at' => date('Y-m-d H:i:s'),                
					            ];
					            $form_data = $this->security->xss_clean($form_data);
					            $profile_data = $this->profile_model->get_profile($this->input->post('profileId'))->row();          
				                $res = $this->profile_model->profileUpdate($form_data,$this->input->post('profileId'));
					            if($res)
					            {
					            	if( $profile_data->name !== $this->input->post('name')){ 
                                    log_message('all', 'name logged');
                                    }
                                    if($profile_data->gender !== $this->input->post('gender')){
                                     log_message('all', 'gender logged');
                                    }
                                    if($profile_data->email !== $email){
                                     log_message('all', 'email logged');
                                    }
                                    if($profile_data->city !== $this->input->post('city')){
                                      log_message('all', 'city logged');
                                    }
                                    if($profile_data->phone !== $this->input->post('phone')){
                                     log_message('all', 'phone logged');
                                    }
                                    if($profile_data->experience !== $this->input->post('experience')){
                                        log_message('all', 'experience logged');
                                    }
                                    if($profile_data->image !== $this->input->post('imageName')){
                                       log_message('all', 'image logged');
                                    }
                                    if($profile_data->description !== $this->input->post('description')){
                                        log_message('all', 'description logged');
                                    }     					            	
					            	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has been submitted.</span>');					            	
					            	redirect('profile/edit_profile/'.$seg);
					            }else{
					            	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</span>');					            	
					                 redirect('profile/edit_profile/'.$seg);
					            }				            		
        			$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Please choose an image.</span>');	                			
            		redirect('profile/edit_profile/'.$seg); 
	         	}   	
	        }else{
	            $this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted. Please fill all the fields.</span>');	           
	          redirect('profile/edit_profile/'.$seg);
	        }
        }else{                  	
        	redirect('profile/list_profile');
        }
    }


}
