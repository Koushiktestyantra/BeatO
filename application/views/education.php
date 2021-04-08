<?php $this->load->view('auth/header');?>
 <!-- Tags Plugin Files -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/tags/custom_folder/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>public/tags/custom_folder/bootstrap-tagsinput.css" />
  <script src="<?php echo base_url();?>public/tags/custom_folder/bootstrap.min.js"></script>
  <script src="<?php echo base_url();?>public/tags/custom_folder/bootstrap-tagsinput.js"></script>
  <!-- Tags Plugin Files -->
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
            <h1>Education Form</h1>
			      <p>Please Fill Your this form</p>
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
              <form action="<?php echo base_url(); ?>profile/education" enctype="multipart/form-data" method="post">
                 <input name="<?php echo $this->security->get_csrf_token_name(); ?>" type="hidden" value="<?php echo $this->security->get_csrf_hash(); ?>" /> 
                <div class="card-body">
                <input type="hidden" class="form-control" name="user_id" id="college" value="" placeholder="Enter Name">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Qualification</label>
                    <input type="text" class="form-control" name="qualification" id="qualification" value="" placeholder="Enter Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">College</label></br>
                    <input type="text" class="form-control" name="college" id="college" value="" placeholder="Enter Name">
                  </div>           
                  <div class="form-group">
                    <label for="exampleInputEmail1">Year of Completion</label>
                    <select type="text" class="form-control" name="year" id="year">                    	
                      <?php for($i=2010;$i<2016;$i++){?>
                    	<option value="<?php echo $i;?>"><?php echo $i;?></option>
                      <?php } ?>                    	
                    </select>
                  </div>
                   <!-- Select multiple-->
                  <div class="form-group">
                    <label>Specialization</label>
                     <input type="text" data-role="tagsinput" class="form-control" name="specialization" id="specialization" value="">    
                  </div>
                  <!-- Select multiple-->                  
                             
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary" value="education">Submit</button>
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
  $('#specialization').tagsinput({
   confirmKeys: [13, 44],
   maxTags: 20
});
</script>