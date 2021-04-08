<?php $this->load->view('auth/header');?>
<?php $this->load->view('auth/sidebar');?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">          
        </div>
      </div><!-- /.container-fluid -->
    </section>
     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">     
            <h1>Create Profile</h1>
			<p>This is the profile form</p>
             <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quick Example</h3>                 
              </div>
              <div>               
                 <h3 class="card-title"><?php echo $this->session->flashdata('msg');?></h3>
              </div>
              <?php echo validation_errors(); ?>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="<?php echo base_url(); ?>profile/create_profile" enctype="multipart/form-data" method="post">
              <input name="<?php echo $this->security->get_csrf_token_name(); ?>" type="hidden" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="" placeholder="Enter Name">
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">Gender</label></br>
                    Male:<input type="radio" class="form-control" name="gender" value="1">
                    Female:<input type="radio" class="form-control" name="gender" value="2">
                  </div>                 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <select type="text" class="form-control" name="city" id="city">
                    	<option value="">Select City</option>
                    	<option value="1">Mumbai</option>
                    	<option value="2">Kolkata</option>
                    	<option value="3">Delhi</option>
                    	<option value="4">Chennai</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="Phone">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Years of Experience</label>
                    <input type="text" class="form-control" name="experience" id="experience" value="" placeholder="Experience">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="profileImage" class="custom-file-input" id="profileImage" value="">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputEmail1">About Me</label>
                    <textarea type="text" class="form-control" name="description" id="description" value="" placeholder="Description"></textarea>
                  </div>              
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary" value="profile">Submit</button>
                </div>
              </form>
            </div><!-- /.card -->
            <!-- general form elements -->			
	  </div>
</section>
 </div>
  </div>    
<?php $this->load->view('auth/footer.php'); ?>