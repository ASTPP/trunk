<? extend('master.php') ?>
<? startblock('extra_head') ?>
<?php
session_start();
include "view_freeswitch_request.php";
include "config.php";
$url_array=explode("/",$_SERVER['REQUEST_URI']);
$url='';
$folder_name=$url_array[1];
for($i=1;$i<count($url_array)-1;$i++){
	$url.="/".$url_array[$i];
}
?>
<script type="text/javascript">

$(document).ready(function(){ 
  var ip = location.host;
  $.ajax({
    type:'POST',
    url: "<?php echo base_url();?>fsmonitor/sip_devices_file_exits/",
    cache    : false,                 
    async: false, 
    success: function(data) {
	if(!data){
	      window.location.href = "<?php echo base_url();?>fsmonitor/sip_devices/";
	}
    }
   });
});
</script>
<?php 
	$filename = $licence_file;
	if(file_exists($filename))
	{ 
	 $localkey = file_get_contents($filename);
	}
	else{
	 $localkey = '';
	}
?>
<?php
	if(common_model::$global_config['system_config']['opensips'] == 0){
		redirect(base_url()."fsmonitor/opensips_devices/");
	}
 	    $this->db->select("value"); 
        $this->db->where("name",'refresh_second'); 
        $system      = $this->db->get("system");
        $system_res  = $system->result_array();
	
        if(isset($system_res[0]) && !empty($system_res[0])) {
    		$result = $system_res[0];    	
        }
?>


<?php 

	if(isset($result['value']) && !empty($result['value'])) {
?>


<meta http-equiv="refresh" content="<?php echo $result['value']; ?>" > 

<?php
	}

?>


<?php

if(empty($_POST)){
$_POST['host_id']=0;
} 

if(isset($_POST['second_reload']) && $_POST['second_reload'] != '') {
		$update_array = array("value"=>$_POST['second_reload']);
		$this->db->where("name","refresh_second");
		$this->db->update("system",$update_array);
	}
?>
<script type="text/javascript">
$(document).ready(function(){
 var id="<?php echo $_POST['host_id']?>";
  $("#fs_extension").flexigrid({
    url: "<?php echo base_url();?>fsmonitor/sip_devices_json/"+id,
    method: 'GET',
    dataType: 'json',
	colModel : [
		{display: '<?=gettext('User')?>', name: 'User', width: 200, sortable: false, align: 'center'},
		{display: '<?=gettext('Contact')?>', name: 'Contact', width: 200, sortable: false, align: 'center'},
		{display: '<?=gettext('Client-IP')?>', name: 'network-ip', width: 190, sortable: false, align: 'center'},
		{display: '<?=gettext('Client Port')?>', name: 'network-port', width: 220, sortable: false, align: 'center'},
                {display: '<?=gettext('Status')?>', name: 'status', width: 400, sortable: false, align: 'center'},
		{display: '<?=gettext('User Agent')?>', name: 'agent', width: 195, sortable: false, align: 'center'},
		],
	nowrap: false,
	showToggleBtn: false,
	sortname: "call-id",
	sortorder: "asc",
	usepager: true,
	resizable: true,
	useRp: true,
	rp: 50,
	showTableToggleBtn: false,
	width: "auto",
	height: "auto",
	pagetext: '<?=gettext('Page')?>',
	outof: '<?=gettext('of')?>',
	page:'1',
	nomsg: '<?=gettext('No items')?>',
	procmsg: '<?=gettext('Processing, please wait ...')?>',
	pagestat: '<?=gettext('Displaying')?> {from} <?=gettext('to')?> {to} <?=gettext('of')?> {total} <?=gettext('items')?>',
	onSuccess: function(data){
	  $('a[rel*=facebox]').facebox({
		    loadingImage : '<?php echo base_url();?>/images/loading.gif',
		    closeImage   : '<?php echo base_url();?>/images/closelabel.png'
	    });
	},
	onError: function(){
	    alert('<?=gettext('Sorry, we are unable to connect to freeswitch!!!')?>');
	}
});
  $("#host_id").change(function(){
	var id = document.getElementById("host_id").value;

  });
});
</script>
<script>
function myFunction() {
		document.getElementById("extension").submit();
    
}
</script>
<? endblock() ?>
<? startblock('page-title') ?>
<?=$page_title?>
<? endblock() ?>
<? startblock('content') ?>

<section class="slice color-three">
	<div class="w-section inverse p-0">
		<div id="floating-label" class="card col-md-12 px-0 pb-4">
			<h3 class="bg-secondary text-light p-2 rounded-top"><?=gettext('SIP Devices')?></h3>
			<form method="POST" action="" enctype="multipart/form-data" id="ListForm1" name="extension">
				<div class="col-md-6 form-group">
				<label class="col-md-12 p-0 control-label"><?=gettext('Switch Host')?> : </label>
					<select class="col-md-12 form-control form-control-lg selectpicker"  name="host_id" id="host_id" onchange="this.form.submit()">
						<option value="0"><?=gettext('--All--')?></option>
						<?php
						foreach($fs_data as $name) { ?>
						<option value="<?= $name['id'] ?>"<?php if(isset($_POST['host_id']) && ($name['id'] == $_POST['host_id']))echo 'selected';?>><?= $name['freeswitch_host'] ?></option>
						<?php
						} ?>
					</select>
				</div>
			<div class="col-md-5 float-right text-right">
				<label class="search_label col-md-5 text-right"><?=gettext('Refresh Time')?>:</label>
				<select class="col-md-6 form-control form-control-lg selectpicker"  name="second_reload" id="second_reload" onchange="this.form.submit()" >
					<?php
    		//for($i=5;$i<=300;$i+=5) {
					if($_POST['second_reload'] == ''){
						?>
						<option value="15" <?php if(isset($result['value']) && (15 == $result['value']))echo 'selected';?>>15 <?=gettext('Sec.')?></option>
						<option value="30" <?php if(isset($result['value']) && (30 == $result['value']))echo 'selected';?>>30 <?=gettext('Sec.')?></option>
						<option value="60" <?php if(isset($result['value']) && (60 == $result['value']))echo 'selected';?>>1 <?=gettext('Min.')?></option>
						<option value="120" <?php if(isset($result['value']) && (120 == $result['value']))echo 'selected';?>>2 <?=gettext('Min.')?></option>
						<option value="180" <?php if(isset($result['value']) && (180 == $result['value']))echo 'selected';?>>3 <?=gettext('Min.')?></option>
						<!-- <option value="<?php echo $i; ?>"<?php if(isset($result['value']) && ($i == $result['value']))echo 'selected';?>><?php echo $i; ?> Second</option> -->
						<?php
					}
					else{
						?>
						<option value="15" <?php if(isset($_POST['second_reload']) && (15 == $_POST['second_reload']))echo 'selected';?>>15 Second</option>
						<option value="30" <?php if(isset($_POST['second_reload']) && (30 == $_POST['second_reload']))echo 'selected';?>>30 Second</option>
						<option value="60" <?php if(isset($_POST['second_reload']) && (60 == $_POST['second_reload']))echo 'selected';?>>1 Minute</option>
						<option value="120" <?php if(isset($_POST['second_reload']) && (120 == $_POST['second_reload']))echo 'selected';?>>2 Minute</option>
						<option value="180" <?php if(isset($_POST['second_reload']) && (180 == $_POST['second_reload']))echo 'selected';?>>3 Minute</option>

						<?php
					}
    	      // } ?>
    	  </select>
    	</div>
    </form>
    <br/>

</div>
<br/>
</div>
</section>

<section class="slice color-three pb-4">
	<div class="w-section inverse p-0">
		<div class="card col-md-12 py-4">     
			<form method="POST" action="del/0/" enctype="multipart/form-data" id="ListForm">    
				<table id="fs_extension" align="left" style="display:none;"></table>
			</form>
		</div>  
	</div>
</section>


 <? endblock() ?>
	        
<? end_extend() ?>  
