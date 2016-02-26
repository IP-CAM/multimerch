<?php echo $header; ?>
<div class="container">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>

	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="ms-product <?php echo $class; ?> ms-account-profile"><?php echo $content_top; ?>
			<div class="row">
				<div class="col-sm-3">
					<h1><?php echo $ms_account_sellersetting_breadcrumbs; ?></h1>
				</div>
				<div class="col-sm-9">
					<form id="ms-sellersettings" class="ms-form form-horizontal" method="POST">
						<fieldset>
							<input type="hidden" name="seller_id" value="<?php echo $seller_id ;?>">
							<!--<input type="hidden" name="seller_group" value="<?php echo $seller_group_id['seller_group'] ;?>"> -->
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_full_name; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_full_name]" value="<?php echo (isset($settings['slr_full_name'])) ? $settings['slr_full_name'] : '' ; ?>" placeholder="<?php echo $ms_seller_full_name; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_address1; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_address_line1]" value="<?php echo (isset($settings['slr_address_line1'])) ? $settings['slr_address_line1'] : '' ; ?>" placeholder="<?php echo $ms_seller_address1_placeholder ;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_address2; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_address_line2]" value="<?php echo (isset($settings['slr_address_line2'])) ? $settings['slr_address_line2'] : '' ; ?>" placeholder="<?php echo $ms_seller_address2_placeholder ;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_city; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_city]" value="<?php echo (isset($settings['slr_city'])) ? $settings['slr_city'] : '' ; ?>" placeholder="<?php echo $ms_seller_city; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_state; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_state]" value="<?php echo (isset($settings['slr_state'])) ? $settings['slr_state'] : '' ; ?>" placeholder="<?php echo $ms_seller_state ;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_zip; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_zip]" value="<?php echo (isset($settings['slr_zip'])) ? $settings['slr_zip'] : '' ; ?>" placeholder="<?php echo $ms_seller_zip ;?>">
								</div>
							</div>
	
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_country; ?></label>
								<div class="col-sm-10">
									<select class="form-control" name="settings[slr_country]">
										<?php foreach($countries as $country) :?>
										<?php if($settings['slr_country'] == $country['country_id']) :?>
										<option value="<?php echo $country['country_id'] ;?>" selected><?php echo $country['name'] ;?></option>
										<?php else :?>
										<option value="<?php echo $country['country_id'] ;?>"><?php echo $country['name'] ;?></option>
										<?php endif ;?>
										<?php endforeach ;?>
									</select>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Information</legend>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_website; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_website]" value="<?php echo (isset($settings['slr_website'])) ? $settings['slr_website'] : '' ; ?>" placeholder="<?php echo $ms_seller_website ;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_company; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_company]" value="<?php echo (isset($settings['slr_company'])) ? $settings['slr_company'] : '' ; ?>" placeholder="<?php echo $ms_seller_company ;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_seller_phone; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="settings[slr_phone]" value="<?php echo (isset($settings['slr_phone'])) ? $settings['slr_phone'] : '' ; ?>" placeholder="<?php echo $ms_seller_phone ;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $ms_account_sellerinfo_avatar; ?></label>
								<div class="col-sm-10">
									<div class="buttons">
										<a name="ms-file-selleravatar" id="ms-file-selleravatar" class="btn btn-primary"><span><?php echo $ms_button_select_image; ?></span></a>
									</div>

									<p class="ms-note"><?php echo $ms_account_sellerinfo_avatar_note; ?></p>
									<p class="error" id="error_sellerinfo_avatar"></p>

									<div id="sellerinfo_avatar_files">
										<?php if (!empty($settings['slr_logo'])) { ?>
										<div class="ms-image">
											<img src="<?php echo $settings['slr_thumb']; ?>" />
											<span class="ms-remove"></span>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</fieldset>
						<div class="buttons">
							<div class="pull-right"><button type="submit" class="btn btn-primary" id="ms-submit-button"><?php echo $ms_button_save; ?></button></div>
						</div>
					</form>
				</div>
			</div>
		<?php echo $content_bottom; ?></div>
	<?php echo $column_right; ?></div>
</div>
<script>
	$("#ms-submit-button").click(function(e) {
		var data = $('#ms-sellersettings').serialize();
		$.ajax({
			url: 'index.php?route=seller/account-setting/jxsavesellerinfo',
			data: data,
			dataType: 'json',
			type: 'post',
			success: function(response) {
				console.log(response);
			},
			error: function(error) {
				console.log(error);
			}
		});
	});
</script>
<?php $timestamp = time(); ?>
<script>
	var msGlobals = {
		timestamp: '<?php echo $timestamp; ?>',
		token : '<?php echo md5($salt . $timestamp); ?>',
		session_id: '<?php echo session_id(); ?>',
		zone_id: '<?php echo $seller["ms.zone_id"] ?>',
			uploadError: '<?php echo htmlspecialchars($ms_error_file_upload_error, ENT_QUOTES, "UTF-8"); ?>',
			formError: '<?php echo htmlspecialchars($ms_error_form_submit_error, ENT_QUOTES, "UTF-8"); ?>',
	};
</script>
<?php echo $footer; ?>