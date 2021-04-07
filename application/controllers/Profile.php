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
     *
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
     *
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
     *
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


     /**
     *
	 * This function education is used 
	 * to update the educational details of the user. 
	 * 
	 */
    public function education()
    {
    	//print_r($_SESSION);die;
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
        
	      
				        if($this->input->post('submit') == 'education')
				        {                   	
					        // validate form input 
					        $this->form_validation->set_rules('qualification', 'Qualification', 'trim|required|max_length[50]');   
					        $this->form_validation->set_rules('college', 'College', 'trim|required|max_length[50]');
					        $this->form_validation->set_rules('year', 'Year', 'required');
					        $this->form_validation->set_rules('specialization', 'Specialization', 'trim|required'); 
					        if ($this->form_validation->run() === TRUE)
					        {
				         	    $form_data =[
				         	                'user_id' => $this->session->userdata('user_id'),			             
							                'qualification' => strtolower($this->input->post('qualification')),
							                'college' => strtolower($this->input->post('college')),
							                'year' => strtolower($this->input->post('year')),
							                'specialization' => strtolower($this->input->post('specialization')),                
							                'created_at' => date('Y-m-d H:i:s'),                
								            ];
								            $form_data = $this->security->xss_clean($form_data);
								            $education_data = $this->profile_model->get_educationData($this->session->userdata('user_id'))->row();
								            if($education_data){
								            $this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">You have already submitted form.</span>');
								            redirect('profile/education');
								            }
				                            $res = $this->profile_model->education($form_data);
									if($res)
									{
										$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has been submitted.</span>');
									}else{
										$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</span>');

									}
							           redirect('profile/education');            
					        }
					    }
					$this->load->view('education');    
	    	
    }


     /**
     *
	 * This function list_education is used to
	 * list the education and experience 
	 * details of the user. 
	 * 
	 */

    public function list_education()
    {
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		$data['educations'] = $this->profile_model->get_educationData($this->session->userdata('user_id'))->row();
			
        $this->load->view('list_education',$data);
    }

     /**
     *
	 * This function edit_education is used to
	 * show the services and experience 
	 * details of the user for edit purpose. 
	 * 
	 */

    public function edit_education()
    {
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		$data['education_data'] = $this->profile_model->get_educationData($this->session->userdata('user_id'))->row();	
        $this->load->view('edit_education',$data);
    }

     /**
     *
	 * This function updated_education is used to
	 * edit the education  
	 * details of the user. 
	 * 
	 */

    public function updated_education()
    {
        if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}			    
	    	    if($this->input->post('submit') == 'edit')
				    {                   	
					        // validate form input 
					        $this->form_validation->set_rules('qualification', 'Qualification', 'trim|required|max_length[50]');   
					        $this->form_validation->set_rules('college', 'College', 'trim|required|max_length[50]');
					        $this->form_validation->set_rules('year', 'Year', 'required');
					        $this->form_validation->set_rules('specialization', 'Specialization', 'trim|required'); 
					        if ($this->form_validation->run() === TRUE)
					        {
				         	    $form_data =[					             
							                'qualification' => strtolower($this->input->post('qualification')),
							                'college' => strtolower($this->input->post('college')),
							                'year' => strtolower($this->input->post('year')),
							                'specialization' => strtolower($this->input->post('specialization')),                
							                'updated_at' => date('Y-m-d H:i:s'),                
								            ];
								            $form_data = $this->security->xss_clean($form_data);
								            $education_data = $this->profile_model->get_educationData($this->session->userdata('user_id'))->row();
				                            $res = $this->profile_model->educationUpdate($form_data,$this->session->userdata('user_id'));
									if($res)
									{
									if($education_data->qualification !== $this->input->post('qualification')){ 
                                     $arr['qualification'] = $this->input->post('qualification');
                                    }
                                    if($education_data->college !== $this->input->post('college')){
                                     $arr['college'] = $this->input->post('college');
                                    }
                                    if($education_data->year !== $this->input->post('year')){
                                     $arr['year'] =  $this->input->post('year');
                                    }
                                    if($education_data->specialization !== $this->input->post('specialization')){
                                      $arr['specialization'] =  $this->input->post('specialization');
                                    }                                                                        
                                    log_message('all', json_encode($arr));
										$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has been submitted.</span>');
									}else{
										$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</span>');

									}
							           redirect('profile/education');            
					        }
			        }
	        
    }

    

     /**
     *
	 * This function services is used to
	 * insert the services and experience 
	 * details of the user into the database. 
	 * 
	 */
    public function services()
    {
    	//print_r($_SESSION);die;
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}        
	        
				        if($this->input->post('submit') == 'services')
				        {                   	
					        // validate form input 
					        $this->form_validation->set_rules('services', 'Services', 'trim|required');   
					        $this->form_validation->set_rules('role', 'Role', 'trim|required|max_length[50]');
					        $this->form_validation->set_rules('establishment', 'Establishment', 'required');
					        $this->form_validation->set_rules('city', 'City', 'trim|required'); 
					        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required'); 
					        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
					        if ($this->form_validation->run() === TRUE)
					        {
				         	    $form_data = [
				         	                'user_id' => $this->session->userdata('user_id'),			             
							                'services' => strtolower($this->input->post('services')),
							                'role' => strtolower($this->input->post('role')),
							                'establishment' => strtolower($this->input->post('establishment')),
							                'city' => strtolower($this->input->post('city')),
							                'start_date' => strtolower($this->input->post('start_date')),
							                'end_date' => strtolower($this->input->post('end_date')),                
							                'created_at' => date('Y-m-d H:i:s'),                
								            ];
								            $form_data = $this->security->xss_clean($form_data);
				                            $res = $this->profile_model->services($form_data);
									if($res)
									{
										$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has been submitted.</span>');
									}else{
										$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</span>');

									}
							           redirect('profile/services');            
					        }
					    }
	    	$this->load->view('services');
    }


    /**
     *
	 * This function list_services is used to
	 * list the services and experience 
	 * details of the user. 
	 * 
	 */

    public function list_services()
    {
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		$data['services'] = $this->profile_model->get_services($this->session->userdata('user_id'))->result();	
        $this->load->view('list_services',$data);
    } 


     /**
     *
	 * This function edit_services is used to
	 * show the services and experience 
	 * details of the user for edit purpose. 
	 * 
	 */

    public function edit_services()
    {
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		$data['services'] = $this->profile_model->get_services($this->session->userdata('user_id'))->row();	
        $this->load->view('edit_services',$data);
    } 
   
   /**
     *
	 * This function update_services is used to
	 * edit the services and experience 
	 * details of the user. 
	 * 
	 */

    public function update_services()
    {
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		  if($this->input->post('submit') == 'edit_services')
		        {                   	
			        // validate form input 
			        $this->form_validation->set_rules('services', 'Services', 'trim|required');   
			        $this->form_validation->set_rules('role', 'Role', 'trim|required|max_length[100]');
			        $this->form_validation->set_rules('establishment', 'Establishment', 'required');
			        $this->form_validation->set_rules('city', 'City', 'trim|required'); 
			        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required'); 
			        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
			        if ($this->form_validation->run() === TRUE)
			        {
		         	    $form_data = [				         	                			             
					                'services' => strtolower($this->input->post('services')),
					                'role' => strtolower($this->input->post('role')),
					                'establishment' => strtolower($this->input->post('establishment')),
					                'city' => strtolower($this->input->post('city')),
					                'start_date' => strtolower($this->input->post('start_date')),
					                'end_date' => strtolower($this->input->post('end_date')),                
					                'updated_at' => date('Y-m-d H:i:s'),                
						            ];
						            $form_data = $this->security->xss_clean($form_data);
						            $service_data = $this->profile_model->get_services($this->input->post('id'))->row();      
		                      $res = $this->profile_model->servicesUpdate($form_data,$this->input->post('id'));
							if($res)
							{  								
                                    if($service_data->services !== $this->input->post('services')){ 
                                     $arr['services'] = $this->input->post('services');
                                    }
                                    if($service_data->role !== $this->input->post('role')){
                                     $arr['role'] = $this->input->post('role');
                                    }
                                    if($service_data->establishment !== $this->input->post('establishment')){
                                     $arr['establishment'] =  $this->input->post('establishment');
                                    }
                                    if($service_data->city !== $this->input->post('city')){
                                      $arr['city'] =  $this->input->post('city');
                                    }
                                    if($service_data->start_date !== $this->input->post('start_date')){
                                     $arr['start_date'] =  $this->input->post('start_date');
                                    }
                                    if($service_data->end_date !== $this->input->post('end_date')){
                                     $arr['end_date'] =  $this->input->post('end_date');
                                    }                                     
                                    log_message('all', json_encode($arr)); 
								$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your services & experience has been updated.</span>');
							}else{
								$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your services & experience has been updated.</span>');

							}
					           redirect('profile/edit_services/'.$this->input->post('id'));            
			        }else{
			        	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your services & experience has not been updated. Please fill are the fields.</span>');
			        	 redirect('profile/edit_services/'.$this->input->post('id'));			        	
			        }
			    }else{
			    	redirect('profile/list_services');
			    }	
       
    }


    /**
     *
	 * This function rewards is used to
	 * insert the rewards 
	 * details of the user. 
	 * 
	 */

    public function rewards()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        if($this->input->post('submit') == 'rewards')
			        {  
				        // validate form input 
				        $this->form_validation->set_rules('reward[]', 'Reward', 'trim|required');   
                		$this->form_validation->set_rules('year[]', 'Year', 'trim|required');
                		$this->form_validation->set_rules('membership[]', 'Membership', 'trim|required');
				        if ($this->form_validation->run() === TRUE)
				        {
			         	    $form_data = [
			         	                'user_id' => $this->session->userdata('user_id'),
						                'reward' => strtolower(implode("|",$this->input->post('reward'))),
						                'year' => strtolower(implode("|",$this->input->post('year'))),
									    'membership' => strtolower(implode("|",$this->input->post('membership'))),        
						                'created_at' => date('Y-m-d H:i:s'),                
							            ];
							            //print_r($form_data);die;
							            $form_data = $this->security->xss_clean($form_data);
							            $check = $this->profile_model->check_rewards($this->session->userdata('user_id'));
							            if($check >0){
                                           $this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">You already have submitted your form.</span>');
                                           redirect('profile/rewards');
							            }else
							            {
                                             $res = $this->profile_model->rewards($form_data);
											if($res)
											{
												$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has been submitted.</span>');
											}else{
												$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your form has not been submitted.</span>');

											}
							            }
			                  
						           redirect('profile/rewards');            
				        }
				    }
	    	
        	$this->load->view('rewards');
    } 

    /**
     *
	 * This function list_services is used to
	 * list the services and experience 
	 * details of the user. 
	 * 
	 */

    public function list_rewards()
    {
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		$data['rewards'] = $this->profile_model->get_rewards($this->session->userdata('user_id'))->result();
        $this->load->view('list_rewards',$data);
    } 


     /**
     *
	 * This function edit_rewards is used to
	 * show the awards and membership 
	 * details of the user for edit purpose. 
	 * 
	 */

    public function edit_rewards()
    {
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		$data['rewards'] = $this->profile_model->get_rewards($this->session->userdata('user_id'))->row();			
        $this->load->view('edit_rewards',$data);
    } 

     /**
     *
	 * This function update_rewards is used to
	 * edit the rewards and memberships 
	 * details of the user. 
	 * 
	 */

    public function update_rewards()
    {
    	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		  if($this->input->post('submit') == 'edit_rewards')
		        {                   	
			        // validate form input 
				        $this->form_validation->set_rules('reward', 'Reward', 'trim|required');   
                		$this->form_validation->set_rules('year', 'Year', 'trim|required');
                		$this->form_validation->set_rules('membership', 'Membership', 'trim|required'); 
			        if ($this->form_validation->run() === TRUE)
			        {
		         	    $form_data = [				         	                			             
					                'user_id' => $this->session->userdata('user_id'),
						            'reward' => strtolower($this->input->post('reward')),
						            'year' => strtolower($this->input->post('year')),
									'membership' => strtolower($this->input->post('membership')),                
					                'updated_at' => date('Y-m-d H:i:s'),                
						            ];
						            $form_data = $this->security->xss_clean($form_data);
						            $rewards_data = $this->profile_model->get_rewards($this->session->userdata('user_id'))->row();      
		                      $res = $this->profile_model->rewardsUpdate($form_data,$this->session->userdata('user_id'));		                     
							if($res)
							{  								
                                    if($rewards_data->reward !== $this->input->post('reward')){ 
                                     $arr['reward'] = $this->input->post('reward');
                                    }
                                    if($rewards_data->year !== $this->input->post('year')){
                                     $arr['year'] = $this->input->post('year');
                                    }
                                    if($rewards_data->membership !== $this->input->post('membership')){
                                     $arr['membership'] =  $this->input->post('membership');
                                    }                                                                        
                                    log_message('all', json_encode($arr)); 
								$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your rewards and membership has been updated.</span>');
							}else{
								$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your rewards and membership has been updated.</span>');

							}
					           redirect('profile/edit_rewards/'.$this->session->userdata('user_id'));            
			        }else{
			        	$this->session->set_flashdata('msg', '<span style="font-size:14px;color:red;">Your services & experience has not been updated. Please fill are the fields.</span>');
			        	 redirect('profile/edit_rewards/'.$this->session->userdata('user_id'));			        	
			        }
			    }else{
			    	redirect('profile/list_rewards');
			    }	
       
    }


}