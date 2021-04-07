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
       <h1>Profile Listing</h1>   
       		<div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Rewads</th>
                      <th>Year</th>
                      <th>Membership</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                    <tr> 
                      <td> <?php echo $educations->id;?> </td>                     
                      <td> <?php echo htmlspecialchars( $educations->college,ENT_QUOTES,'UTF-8');?> </td>
                      <td><?php echo htmlspecialchars( $educations->year ,ENT_QUOTES,'UTF-8');?></td>
                      <td><?php echo htmlspecialchars( $educations->specialization,ENT_QUOTES,'UTF-8');?></td>
                      <td><a href="<?php echo base_url();?>profile/edit_education/<?php echo $educations->id;?>">EDIT</a></td>
                    </tr> 
                                       
                  </tbody>
                </table>
            </div>     
	    </div>
    </section>
 </div>
  </div>    
<?php $this->load->view('auth/footer.php'); ?>