<?php $this->load->view('auth/header');?>
 <!-- Tags Plugin Files -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/tags/custom_folder/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>public/tags/custom_folder/bootstrap-tagsinput.css" />
  <script src="<?php echo base_url();?>public/tags/custom_folder/bootstrap.min.js"></script>
  <script src="<?php echo base_url();?>public/tags/custom_folder/bootstrap-tagsinput.js"></script>
  <!-- Tags Plugin Files -->
<?php $this->load->view('auth/sidebar');?>
<script>
  $( function() {
    $( "#start_date" ).datepicker();
    $( "#end_date" ).datepicker();
  } );
  </script>
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
            <h1>Services & Experience Form</h1>
			<p>Please Fill Your Services & Experience in this form</p>
             <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Educational</h3>                 
              </div>
              <div>               
                 <h3 class="card-title"><?php echo $this->session->flashdata('msg');?></h3>
              </div>
              <?php echo validation_errors(); ?>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="<?php echo base_url(); ?>profile/services" enctype="multipart/form-data" method="post">
                <div class="card-body">                
                  <div class="form-group">
                     <!-- Select multiple-->
                  <div class="form-group">
                    <label>Services</label>
                     <input type="text" data-role="tagsinput" class="form-control" name="services" id="services" value="">    
                  </div>
                  <!-- Select multiple--> 
                  <div class="form-group"> 
                    <label for="exampleInputEmail1">Role</label>
                    <input type="text" class="form-control" name="role" id="role" value="" placeholder="Enter Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Establishment</label></br>
                    <input type="text" class="form-control" name="establishment" id="establishment" value="" placeholder="Enter Name">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <select type="text" class="form-control" name="city" id="city">                    
                      <option value="">Select City</option>
                      <option value="1">Mumbai</option>
                      <option value="2">Delhi</option>
                      <option value="3">Kolkata</option>
                      <option value="4">Chennai</option>                                          
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Start Date</label></br>
                    <input type="text" class="form-control" name="start_date" id="start_date" value="" placeholder="Enter Name">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">End Date</label></br>
                    <input type="text" class="form-control" name="end_date" id="end_date" value="" placeholder="Enter Name">
                  </div>                                    
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary" value="services">Submit</button>
                </div>
              </form>              
            </div><!-- /.card -->
            <!-- general form elements -->			
	  </div>
</section>
 </div>
  </div>    
<?php $this->load->view('auth/footer.php'); ?>
<script type="text/javascript">
  $('#services').tagsinput({
   confirmKeys: [13, 44],
   maxTags: 20
});
</script>