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
						<input type="hidden" name="seller_id" value="<?php echo $seller_id ;?>">
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
<?php echo $footer; ?>