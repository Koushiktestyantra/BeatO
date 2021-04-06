<?php $this->load->view('auth/header');?>
<!-- Tags Plugin Files -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
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
			<p>Please Fill Your Educational Qualifications in this form</p>
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
                <div class="card-body">
                <input type="hidden" class="form-control" name="user_id" id="college" value="<?php if($education_data->college != ''){ echo $education_data->college;} ?>" placeholder="Enter Name">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Qualification</label>
                    <input type="text" class="form-control" name="qualification" id="qualification" value="<?php if($education_data->qualification != ''){ echo $education_data->qualification;} ?>" placeholder="Enter Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">College</label></br>
                    <input type="text" class="form-control" name="college" id="college" value="<?php if($education_data->college != ''){ echo $education_data->college;} ?>" placeholder="Enter Name">
                  </div>           
                  <div class="form-group">
                    <label for="exampleInputEmail1">Year of Completion</label>
                    <select type="text" class="form-control" name="year" id="year">                    	
                      <?php for($i=2010;$i<2016;$i++){?>
                    	<option value="<?php if($education_data->year == $i){ echo 'selected="select"'; }?>"><?php echo $i;?></option>
                      <?php } ?>                    	
                    </select>
                  </div>
                   <!-- Select multiple-->
                  <div class="form-group">
                    <label>Specialization</label>
                     <input type="text" data-role="tagsinput" class="form-control" name="sepecialization" id="sepecialization">    
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

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
  <!-- Tags Plugin Files -->
<script type="text/javascript">
  $('#sepecialization').tagsinput({
   confirmKeys: [13, 44],
   maxTags: 20
});
</script>