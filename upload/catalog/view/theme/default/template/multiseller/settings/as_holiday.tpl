<?php echo $header; ?>
<div class="container">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
	<?php if (isset($error_warning) && $error_warning) { ?>
		<div class="alert alert-danger warning main"><?php echo $error_warning; ?></div>
	<?php } ?>

	<?php if (isset($success) && ($success)) { ?>
		<div class="alert alert-success"><?php echo $success; ?></div>
	<?php } ?>

	<?php if (isset($statustext) && ($statustext)) { ?>
		<div class="alert alert-<?php echo $statusclass; ?>"><?php echo $statustext; ?></div>
	<?php } ?>

	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="ms-product <?php echo $class; ?> ms-account-profile"><?php echo $content_top; ?>
			<h1><?php echo $ms_account_sellerinfo_heading; ?></h1>
			<div class="row">
				<div class="col-sm-3">
					<ul>
					<?php if(isset($group_menu) && $group_menu){ ?>
						<?php foreach($group_menu as $link){ ?>
						<li><a href="<?php echo $link['link'];?>" title="<?php echo $link['name'];?>"><?php echo $link['name'];?></a></li>
						<?php }?>
					<?php }?>
					<ul>
				</div>
				<div class="col-sm-9">
					
					<form id="ms-sellerinfo" class="ms-form form-horizontal" method="POST">
						<div class="form-group required">
								<label class="col-sm-2 control-label"><?php echo $ms_account_sellerinfo_nickname; ?></label>
								<div class="col-sm-10">
									<input type="text" class="form-control"  name="nickname" value="<?php echo $seller['ms.nickname']; ?>" />
									<p class="ms-note"><?php echo $ms_account_sellerinfo_nickname_note; ?></p>
								</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $ms_account_sellerinfo_description; ?></label>
							<div class="col-sm-10">
								<!-- todo strip tags if rte disabled -->
								<textarea name="description" id="seller_textarea" class="form-control <?php echo $this->config->get('msconf_enable_rte') ? 'ckeditor' : ''; ?>"><?php echo $this->config->get('msconf_enable_rte') ? htmlspecialchars_decode($seller['ms.description']) : strip_tags(htmlspecialchars_decode($seller['ms.description'])); ?></textarea>
								<p class="ms-note"><?php echo $ms_account_sellerinfo_description_note; ?></p>
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
<?php echo $footer; ?>