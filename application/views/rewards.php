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
            <h1>Awards & Membership Form</h1>
			      <p>Please Fill this form.</p>
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
              <form action="<?php echo base_url(); ?>profile/rewards" enctype="multipart/form-data" method="post">
                <input name="<?php echo $this->security->get_csrf_token_name(); ?>" type="hidden" value="<?php echo $this->security->get_csrf_hash(); ?>" /> 
                <div class="card-body">
                    <div class="card-footer">
                      <button type="button" name="addMore" id="addMore" class="btn btn-primary">Add More</button>
                    </div>                
                      <div id="envelope_div">
                        <div class="form-group">                  
                            <label for="exampleInputEmail1">Rewards</label></br>
                            <input type="text" class="form-control" name="reward[]" id="reward_1" value="" placeholder="Enter Name">
                            <label for="exampleInputEmail1">Year of Completion</label>
                            <input type="text" class="form-control" name="year[]" id="year_1" value="" placeholder="Enter Name">
                        </div>
                      </div> 
                        <div class="card-footer">
                        <button type="button" name="addMembership" id="addMembership" class="btn btn-primary">Add Membership</button>
                        </div>                 
                      <div id="envelope_div_membership">
                        <div class="form-group">                  
                            <label for="exampleInputEmail1">Membership</label></br>
                            <input type="text" class="form-control" name="membership[]" id="membership_1" value="" placeholder="Enter Name">                            
                        </div>
                      </div>                   
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary" value="rewards">Submit</button>
                      </div>
                </div>      
              </form>              
            </div>
            <!-- /.card -->
            <!-- general form elements -->			
	   </div>     
    </section>
 </div>
  </div>    
<?php $this->load->view('auth/footer.php'); ?>
<script>
var i=2;
$("#addMore").click(function(){
    $("#envelope_div").append("<div class='form-group' id='cover_" + i + "'>" +                  
    "<label for='exampleInputEmail1'>Reward</label></br>" +
    "<input type='text' class='form-control' name='reward[]' id='reward_" + i + "' value='' placeholder='Enter Reward'>" +
    "<label for='exampleInputEmail1'>Year of Completion</label>" +
    "<input type='text' class='form-control' name='year[]' id='year_" + i + "' value='' placeholder='Enter Year'>" +
    "<button type='button' name='subMore' id='subMore' onclick=foo('"+ i +"') class='btn btn-primary'>Del</button>" +
    "</div>");
    i++;
});
</script>
<script>
  function foo(id){    
    $("#cover_"+id).remove();
}
</script>
<script>
var i=2;
$("#addMembership").click(function(){
    $("#envelope_div_membership").append("<div class='form-group' id='member_" + i + "'>" +                  
    "<label for='exampleInputEmail1'>Membership</label></br>" +
    "<input type='text' class='form-control' name='membership[]' id='membership_" + i + "' value='' placeholder='Enter Membership'>" +    
    "<button type='button' name='subMembership' id='subMembership' onclick=fooMem('"+ i +"') class='btn btn-primary'>Del</button>" +
    "</div>");
    i++;
});
</script>
<script>
  function fooMem(id){
    $("#member_"+id).remove();
}
</script>