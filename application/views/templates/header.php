<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="<?=$description ?>"/>
	<meta name="keywords" content="<?=$keywords ?>">
	<meta name="author" content="<?=$author ?>">
	<title><?=$title ?></title>
<?php foreach ($style as $style_link): ?>
	<?= link_tag(base_url().$style_link)."\n"; ?>
<?php endforeach ?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<style>

.swiper-container {
  max-height: 495px !important;
}
	</style>
</head>
<?= $body."\n" ?>
