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
                  <?php foreach($rewards as $reward){?>
                    <tr> 
                      <td> <?php echo $reward->id;?> </td>                     
                      <td> <?php echo htmlspecialchars( str_replace('|', ',', $reward->reward),ENT_QUOTES,'UTF-8');?> </td>
                      <td><?php echo htmlspecialchars( str_replace('|', ',', $reward->year),ENT_QUOTES,'UTF-8');?></td>
                      <td><?php echo htmlspecialchars( str_replace('|', ',', $reward->membership));?></td>
                      <td><a href="<?php echo base_url();?>profile/edit_rewards/<?php echo $reward->id;?>">EDIT</a></td>
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