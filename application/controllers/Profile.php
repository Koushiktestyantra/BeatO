<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	/**
	 *
	 * This is the profile controller which is used to handle the
	 * profile related logic.
	 *
	 */

    public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->load->helper(['url', 'language', 'form', 'file', 'security']);	
		$this->load->library(['ion_auth', 'session', 'upload', 'form_validation']);
		$this->load->model('profile_model');
		$this->lang->load('auth');		
		date_default_timezone_set("Asia/Kolkata");
		$this->form_validation->set_error_delimiters('<span style="font-size:12px;color:red;margin-left:0px;">', '</span>');
	}
    
    /**
     *
	 * This  function list_profile is used 
	 * to list the profile of all the users. 
	 * 
	 */
	public function my_profile()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}		
       $this->load->view('my_profile');
    }

    /**
     *
	 * This  function list_profile is used 
	 * to list the profile of all the users. 
	 * 
	 */
	public function list_profile()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		$data['profiles'] = $this->profile_model->get_profiles()->result();
	
       $this->load->view('list_profiles',$data);
    }
   
     /**
	 * This  function create_profile is used 
	 * to show  the profile form to the users. 
	 * 
	 */
	public function create_profile()
	{		
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
        if($this->input->post('submit') == 'profile')
        {        	
	        // validate form input
	        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');   
	        $this->form_validation->set_rules('gender', 'Gender', 'required');      
	        $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email|is_unique[profile.email]');               
	        $this->form_validation->set_rules('city', 'City', 'trim|required');
	        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|max_length[10]');
	        $this->form_validation->set_rules('experience', 'Experience', 'trim|required|max_length[10]');
	        $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[200]');
	        
	 
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
				            $form_data = 
					            [
					                'name' => strtolower($this->input->post('name')),
					                'gender' => $this->input->post('gender'),
					                'email' => strtolower($this->input->post('email')),
					                'city' => $this->input->post('city'),
					                'phone' => $this->input->post('phone'),
					                'experience' => $this->input->post('experience'),
					                'image' => $_FILES['profileImage']['name'],
					                'description' => $this->input->post('description'),
					                'created_at' => date('Y-m-d H:i:s'),                
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

     /**
	 * This  function edit_profile is used 
	 * to show  the edit profile form to the users. 
	 * 
	 */
    public function edit_profile()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		if($this->uri->segment(3))
		{
			$data['profile'] = $this->profile_model->get_profile($this->uri->segment('3'))->row();	
        	$this->load->view('edit_profile',$data);
        }else{
           redirect('profile/list_profile', 'refresh');
        }
    }
    
    /**
	 * This  function update_profile is used 
	 * to update the profile of the user. 
	 * 
	 */
     public function update_profile()
	{	 
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}  	 
		if($this->input->post('submit') == 'profileUpdate')
        { 
           $seg = $this->input->post('profileId');        	
	        // validate form input 
	        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');   
	        $this->form_validation->set_rules('gender', 'Gender', 'required'); 
	            $email_data = $this->profile_model->get_profile($this->input->post('profileId'))->row();  
	            if($email_data->email == $this->input->post('email')){
	            	$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email');	
				}else{
                	$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email|is_unique[profile.email]');    
				}              
	        $this->form_validation->set_rules('city', 'City', 'trim|required');
	        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|max_length[10]');
	        $this->form_validation->set_rules('experience', 'Experience', 'trim|required|max_length[10]');
	        $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[200]');  
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
				            $form_data = 
					            [					             
					                'name' => strtolower($this->input->post('name')),
					                'gender' => $this->input->post('gender'),
					                'email' => strtolower($this->input->post('email')),
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
			                   
					            $arr = array();
                                    if($res){
                                    if( $profile_data->name !== $this->input->post('name')){ 
                                     $arr['name'] = $this->input->post('name');
                                    }
                                    if($profile_data->gender !== $this->input->post('gender')){
                                     $arr['gender'] = $this->input->post('gender');
                                    }
                                    if($profile_data->email !== $this->input->post('email')){
                                     $arr['email'] =  $this->input->post('email');
                                    }
                                    if($profile_data->city !== $this->input->post('city')){
                                      $arr['city'] =  $this->input->post('city');
                                    }
                                    if($profile_data->phone !== $this->input->post('phone')){
                                     $arr['phone'] =  $this->input->post('phone');
                                    }
                                    if($profile_data->experience !== $this->input->post('experience')){
                                     $arr['experience'] =  $this->input->post('experience');
                                    }
                                    if($profile_data->image !== $_FILES['profileImage']['name']){
                                       $arr['image'] =  $_FILES['profileImage']['name'];
                                    }
                                    if($profile_data->description !== $this->input->post('description')){
                                        $arr['description'] =  $this->input->post('description');
                                    } 
                                    log_message('all', json_encode($arr));   					            	
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
		 			                'name' => strtolower($this->input->post('name')),
					                'gender' => $this->input->post('gender'),
					                'email' => strtolower($this->input->post('email')),
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
					            if($res){
                                    if($profile_data->name !== $this->input->post('name')){ 
                                     $arr['name'] = $this->input->post('name');
                                    }
                                    if($profile_data->gender !== $this->input->post('gender')){
                                     $arr['gender'] = $this->input->post('gender');
                                    }
                                    if($profile_data->email !== $this->input->post('email')){
                                     $arr['email'] =  $this->input->post('email');
                                    }
                                    if($profile_data->city !== $this->input->post('city')){
                                      $arr['city'] =  $this->input->post('city');
                                    }
                                    if($profile_data->phone !== $this->input->post('phone')){
                                     $arr['phone'] =  $this->input->post('phone');
                                    }
                                    if($profile_data->experience !== $this->input->post('experience')){
                                     $arr['experience'] =  $this->input->post('experience');
                                    }
                                    if($profile_data->image !== $this->input->post('imageName')){
                                       $arr['image'] =  $this->input->post('imageName');
                                    }
                                    if($profile_data->description !== $this->input->post('description')){
                                        $arr['description'] =  $this->input->post('description');
                                    } 
                                    log_message('all', json_encode($arr));                      		            	
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
	            $this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</br> Please fill all the fields.</br> Email must be unique. </span>');	           
	          redirect('profile/edit_profile/'.$seg);
	        }
        }else{                  	
        	redirect('profile/list_profile');
        }
    }


}