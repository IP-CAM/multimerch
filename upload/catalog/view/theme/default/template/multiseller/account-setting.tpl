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

				</div>

			</div>
		<?php echo $content_bottom; ?></div>
	<?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>