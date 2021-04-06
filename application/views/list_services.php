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
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($services as $service){?>
                    <tr> 
                       <td> <?php echo $service->id;?> </td>                     
                      <td> <?php echo htmlspecialchars( $service->services,ENT_QUOTES,'UTF-8');?> </td>
                      <td><?php echo htmlspecialchars( $service->role,ENT_QUOTES,'UTF-8');?></td>
                      <td><?php echo htmlspecialchars($service->establishment);?></td>
                      <td><a href="<?php echo base_url();?>profile/edit_services/<?php echo $service->id;?>">EDIT</a></td>
                    </tr> 
                    <?php }?>                   
                  </tbody>
                </table>
            </div>     
	</div>
</section>
 </div>
  </div>    
<?php $this->load->view('auth/footer.php'); ?>