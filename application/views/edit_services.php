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
            <h1>Services & Experience Edit Form</h1>
			<p>Please Fill Your Services & Experience in this form.</p>
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
               <form action="<?php echo base_url(); ?>profile/update_services" enctype="multipart/form-data" method="post">
                <div class="card-body">
                <input type="hidden" class="form-control" name="id" value="<?php echo htmlspecialchars( $services->id); ?>">
                  <div class="form-group">
                     <!-- Select multiple-->
                  <div class="form-group">
                    <label>Services</label>
                     <input type="text" data-role="tagsinput" class="form-control" name="services" id="services" value="<?php echo htmlspecialchars( $services->services,ENT_QUOTES,'UTF-8'); ?>">    
                  </div>
                  <!-- Select multiple--> 
                  <div class="form-group"> 
                    <label for="exampleInputEmail1">Role</label>
                    <input type="text" class="form-control" name="role" id="role" value="<?php echo htmlspecialchars( $services->role,ENT_QUOTES,'UTF-8'); ?>" placeholder="Enter Role">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Establishment</label></br>
                    <input type="text" class="form-control" name="establishment" id="establishment" value="<?php echo htmlspecialchars( $services->establishment,ENT_QUOTES,'UTF-8'); ?>" placeholder="Enter Establishment Name">
                  </div> 
                   <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <select type="text" class="form-control" name="city" id="city">
                      <option value="">Select City</option>
                      <option value="1" <?php if($services->city == '1'){ echo 'selected="checked"';}?>>Mumbai</option>
                      <option value="2" <?php if($services->city == '2'){ echo 'selected="checked"';}?>>Kolkata</option>
                      <option value="3" <?php if($services->city == '3'){ echo 'selected="checked"';}?>>Delhi</option>
                      <option value="4" <?php if($services->city == '4'){ echo 'selected="checked"';}?>>Chennai</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Start Date</label></br>
                    <input type="text" class="form-control" name="start_date" id="start_date" value="<?php echo htmlspecialchars( $services->start_date,ENT_QUOTES,'UTF-8'); ?>" placeholder="Enter Start Date">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">End Date</label></br>
                    <input type="text" class="form-control" name="end_date" id="end_date" value="<?php echo htmlspecialchars( $services->end_date,ENT_QUOTES,'UTF-8'); ?>" placeholder="Enter End Date">
                  </div>                                    
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary" value="edit_services">EDIT</button>
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