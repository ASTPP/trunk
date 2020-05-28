<? extend('master.php') ?>
<? startblock('extra_head') ?>
<? endblock() ?>
<? startblock('page-title') ?>
<?= $page_title ?>
<? endblock() ?>
<? startblock('content') ?>        
<style>
.bootstrap-select.show-tick .dropdown-menu .selected span.check-mark {
    position: relative;
    float: right;
}
</style>

<section class="slice color-three">
  <div class="w-section inverse p-0">
      <div class="container">
        <div class="row">
        <span id="error_msg" class=" success"></span>
              <div class="portlet-content"  id="update_bar" style="cursor:pointer; display:none">
                      <?php echo $form_batch_update; ?>
              </div>
            </div>
        </div>
    </div>
</section>
<section class="slice color-three padding-b-20">
  <div id="floating-label" class="w-section inverse p-0">
	<form method="post" name="product_add_form" id="product_edit_form" action="<?= base_url()."products/products_save/";?>">
	 <div class="col-md-4 float-left pl-0">      
	  <div class="card float-left p-4">      
          <div class="card pb-4 px-0 col-12">
              <h3 class="bg-secondary text-light p-3 rounded-top"><?php echo gettext('Basic Information'); ?></h3>
		<div class="row px-4">
		<input class="col-md-12 form-control form-control-lg m-0" name="id" value="<?php echo $product_info['id']?>" size="16" type="hidden"/>
		 <div class='col-md-12 form-group'>
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Product Category'); ?></label>
                      <div class="col-md-12 form-control selectpicker form-control-lg p-0" >
                                <input class="col-md-12 form-control form-control-lg m-0" name= "product_category" value="<?php echo gettext($this->common->get_field_name("name","category",array("id"=>$product_info['product_category'])));?>" size="16" type="text" readonly/>
			</div>	
                  </div>

                  <div class='col-md-12 form-group'> 
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Name'); ?> *</label>
                      <input class="col-md-12 form-control form-control-lg m-0" value="<?php echo (isset($product_info['name']))?$product_info['name']:'' ?>" name="product_name" size="16" type="text"/>
			<div class="tooltips error_div pull-left no-padding" id="product_name_error_div" style="display: none;"><i style="color:#D95C5C; padding-right: 6px; padding-top: 10px;" class="fa fa-exclamation-triangle"></i><span class="popup_error error  no-padding" id="product_name_error">  
 </span></div>	
                  </div>
                  <div class='col-md-12 form-group'> 
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Description'); ?></label>
                       <input class="col-md-12 form-control form-control-lg m-0" value= "<?php echo (isset($product_info['description']))?$product_info['description']:'' ?>" name="product_description" size="16" type="textarea"/>
                  </div>

                  <div class='col-md-12 form-group'>
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Status'); ?></label>
                      <select  name="status" class="col-md-12 form-control selectpicker form-control-lg" data-live-search='true' datadata-live-search-style='begins'>
                          <option value="0" <?php if($product_info['status'] == '0'){ ?> selected="selected" <?php } ?>><?php echo gettext('Active'); ?></option>
			<option value="1" <?php if($product_info['status'] == '1'){ ?> selected="selected" <?php } ?>><?php echo gettext('Inactive'); ?></option>
                      </select>
                  </div>

                  <div class='col-md-12 form-group'> 
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Buy Cost'); ?> (<?php echo ($currency)?>)</label>
                      <input class="col-md-12 form-control form-control-lg m-0" value= "<?php echo (isset($product_info['buy_cost']))?$this->common->convert_to_currency ( '', '', $product_info['buy_cost'] ):'' ?>" name="product_buy_cost" size="16" type="text"/>
                  </div>

                  <div class='col-md-12 form-group'>
                    <label class="col-md-12 p-0 control-label"><?php echo gettext('Reports'); ?></label>
                    <select name="resources[]" multiple='multiple' class='select field multiselectable col-md-12 form-control form-control-lg selectpicker'>
                        <?php foreach($product_info['resources'] as $item){
                            $checked = isset($product_info['attr']) && in_array($item['id'], $product_info['attr']) ? 'selected':'';
                        ?>
                        <option value="<?=$item['id']?>" <?=$checked?> ><?php echo gettext($item['description']); ?></option>
                    <?php }  ?>
                    </select>
                    <div class="tooltips error_div pull-left no-padding display_none" id="resources_error_div" >
                        <i style="color:#D95C5C; padding-left: 3px; padding-top: 10px;" class="fa fa-exclamation-triangle"></i>
                        <span class="popup_error error  no-padding" id="resources_error"></span>
                    </div>
                  </div>

                  <div class='col-md-12 form-group'>
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Can be purchased?'); ?></label>
                      <select  name="can_purchase" class="col-md-12 form-control selectpicker form-control-lg" data-live-search='true' datadata-live-search-style='begins'>
                          <option value="0" <?php if($product_info['can_purchase'] == '0'){ ?> selected="selected" <?php } ?>><?php echo gettext('Yes'); ?></option>
			<option value="1" <?php if($product_info['can_purchase'] == '1'){ ?> selected="selected" <?php } ?>><?php echo gettext('No'); ?></option>
                      </select>
                  </div>
            
              </div>
             </div>
           </div>
          </div>

		<div id="package_view" class="card float-right col-md-8 py-4 mb-4">      
		  <div class="card pb-4 px-0">
		     <h3 class="bg-secondary text-light p-3 rounded-top"><?php echo gettext('Product Details'); ?></h3>
		<div  class="row px-4">
		
                  <div class='col-md-6 form-group'>
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Reseller can resell'); ?></label>
                      <select  name="can_resell" class="col-md-12 form-control selectpicker  form-control-lg" data-live-search='true' datadata-live-search-style='begins'>
                        <option value="1" <?php if($product_info['can_resell'] == '1'){ ?> selected="selected" <?php } ?>><?php echo gettext('No'); ?></option>
			<option value="0" <?php if($product_info['can_resell'] == '0'){ ?> selected="selected" <?php } ?>><?php echo gettext('Yes'); ?></option>
                      </select>
                  </div>
		
                  <div class='col-md-6 form-group'> 
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Commission'); ?> (%)</label>
                     <input class="col-md-12 form-control form-control-lg m-0" name="commission" value="<?php echo (isset($product_info['commission']))?round(floatval($product_info['commission']),2):'' ?>" size="16" type="text"/>
			<div class="tooltips error_div pull-left no-padding" id="commission_error_div" style="display: none;"><i style="color:#D95C5C; padding-right: 6px; padding-top: 10px;" class="fa fa-exclamation-triangle"></i><span class="popup_error error  no-padding" id="commission_error">   </span></div>	
                  </div>
			<div class='col-md-6 form-group'> 
                      	  <label class="col-md-12 p-0 control-label"><?php echo gettext('Setup Fee').' ('.$currency.')'; ?></label>
                          <input class="col-md-12 form-control form-control-lg m-0" name="setup_fee" value = "<?php echo  $this->common->convert_to_currency ( '', '', $product_info['setup_fee'] )?>" size="16" type="text"/>
			<div class="tooltips error_div pull-left no-padding" id="setup_fee_error_div" style="display: none;"><i style="color:#D95C5C; padding-right: 6px; padding-top: 10px;" class="fa fa-exclamation-triangle"></i><span class="popup_error error  no-padding" id="setup_fee_error">   </span></div>	
				
                  </div>
		   <div class='col-md-6 form-group'> 
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Price'); ?> (<?php echo ($currency)?>) *</label>
                     <input class="col-md-12 form-control form-control-lg m-0" name="price" value= "<?php echo ($product_info['price'] !='')?$this->common->convert_to_currency ( '', '', $product_info['price'] ):'' ?>" size="16" type="text"/>
			<div class="tooltips error_div pull-left no-padding" id="price_error_div" style="display: none;"><i style="color:#D95C5C; padding-right: 6px; padding-top: 10px;" class="fa fa-exclamation-triangle"></i><span class="popup_error error  no-padding" id="price_error">   </span></div>	
		
                  </div>
		 <div class='col-md-6 form-group'>
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Billing Type'); ?></label>
                      <select  name="billing_type" class="col-md-12 form-control selectpicker form-control-lg" data-live-search='true' datadata-live-search-style='begins'>
                       <option value="0" <?php if($product_info['billing_type'] == '0'){ ?> selected="selected" <?php } ?>><?php echo gettext('One Time'); ?></option>
			<option value="1" <?php if($product_info['billing_type'] == '1'){ ?> selected="selected" <?php } ?>><?php echo gettext('Recurring'); ?></option>
                      </select>
                  </div>
                  <div class='col-md-6 form-group'> 
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Billing Days'); ?> *</label>
                        <input class="col-md-12 form-control form-control-lg m-0" name="billing_days" value= "<?php echo (isset($product_info['billing_days']))?$product_info['billing_days']:'' ?>" size="16" type="text"/>
			<div class="tooltips error_div pull-left no-padding" id="billing_days_error_div" style="display: none;"><i style="color:#D95C5C; padding-right: 6px; padding-top: 10px;" class="fa fa-exclamation-triangle"></i><span class="popup_error error  no-padding" id="billing_days_error"></span></div>
                  </div>
                 <div class='col-md-6 form-group'>
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Apply on existing accounts'); ?> </label>
                      <select  name="apply_on_existing_account" class="col-md-12 form-control selectpicker form-control-lg" data-live-search='true' datadata-live-search-style='begins' disabled>
                        <option value="1" <?php if($product_info['apply_on_existing_account'] == '1'){ ?> selected="selected" <?php } ?>><?php echo gettext('No');?></option>
			<option value="0" <?php if($product_info['apply_on_existing_account'] == '0'){ ?> selected="selected" <?php } ?>><?php echo gettext('Yes');?></option>
                      </select>
                  </div>
		    <div class='col-md-6 form-group'>
                      <label class="col-md-12 p-0 control-label"><?php echo gettext('Release if no balance'); ?></label>
                      <select  name="release_no_balance" class="col-md-12 form-control selectpicker form-control-lg" data-live-search='true' datadata-live-search-style='begins'>
                        	<option value="1" <?php if($product_info['release_no_balance'] == '1'){ ?> selected="selected" <?php } ?>><?php echo gettext('No'); ?></option>
					<option value="0" <?php if($product_info['release_no_balance'] == '0'){ ?> selected="selected" <?php } ?>><?php echo gettext('Yes'); ?></option>
                      </select>
                  </div>
		<div class="col-md-12 my-4">
                    <div class="col-md-2 float-right">
                       <button class="btn btn-success btn-block" name="action" value="Save" type="submit"><?php echo gettext('Save'); ?> </button>
                    </div>
                    <div class="col-md-2 float-right">
                      <button class="btn btn-secondary btn-block" name="cancel" onclick="return redirect_page('/products/products_list/')" value="Cancel" type="button">  <?php echo gettext('Cancel'); ?> </button>
                    </div>                        
                  </div>
		</div>
	 </form>
      </div>
    </div>
  </div>
<?php
    if (isset($validation_errors) && $validation_errors != '') {
?>

<script>
    var ERR_STR = '<?php echo $validation_errors; ?>';
	print_error(ERR_STR);
</script>
    <? } ?>
  </div>
</div>
</section>
<? endblock() ?>  
<? end_extend() ?> 
