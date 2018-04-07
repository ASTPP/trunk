
<?php extend('master.php') ?>
<?php startblock('extra_head') ?>
<?php endblock() ?>
<?php startblock('page-title') ?>
<?=$page_title?><br/>
<?php endblock() ?>
<?php startblock('content') ?>
<?php 	$command_show = str_replace("api ", "", $command); ?>
<script>
$(document).ready(function(){
  $("#freeswitch_command").change(function(){
    $('#error_field_command').text('');
    return false;
  });
});
</script>
<script type="text/javascript">
function validateForm(){
      if(document.getElementById('freeswitch_command').value == "")
      {
	  $('#error_field_command').text( "Please Enter Switch command" );
	  document.getElementById('freeswitch_command').focus();
	  return false;
      }
      $('#form').submit();
}
</script>
<section class="slice color-three padding-b-20">
   <div class="w-section inverse no-padding">
     <div class="container">
       <div class="row">
         <div class="col-md-12">      
           <form method="POST" id="form" name="form" action="<?php echo base_url(); ?>freeswitch/freeswitch_fs_cli_command/" enctype="multipart/form-data">  
       <div class="row">
		<div class="col-md-2" style="text-align:right;">
                  <h4>Switch Host:</h4>
		</div>
		<div class="col-md-2">
		  <select class="form-control" name="host_id" id="host_id">
  		      <?php
				foreach($fs_data as $name) { ?>
     			 <option value="<?= $name['id'] ?>"<?php if(isset($host_id) && ($name['id'] == $host_id))echo 'selected';?>><?= $name['freeswitch_host'] ?></option>
  			  <?php
				  } ?>
		   </select>
                </div>	
		<div class="col-md-2 " style="text-align:left;">
                  <h4>Switch Command:</h4>
		</div>
		       <div class="row">
		<div class="col-md-3">
		  <input type="text" class="form-control" value="<?php echo $command_show; ?>" id="freeswitch_command" name="freeswitch_command" placeholder="freeswitch command" style="height:40px;" >
		</div>   
                  <button type="button" onclick="validateForm();" class="btn btn-line-parrot pull">Execute</button>   
                </div>
		</div>
		<span style="color:red;margin-left:655px;float:left;" id="error_field_command"></span>
		</div>
	     <?php if ($command != '') { ?>
             <div style="margin-left:00px;"><h2>Command : <font color="blue"><?php echo $command_show; ?></font></h2></div>
	
	     <div class="col-md-12"> 

		<div class="" style="">
                  <h6><?php echo "<pre>".$response."\n"; ?></h6>
		</div>
		<?php } ?>
		</div>
              </form>
            </div>  
           </div>
        </div>
    </div>
</section>

<?php

endblock();
end_extend();
