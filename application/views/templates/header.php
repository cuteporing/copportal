<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="<?php echo $description;?>"/>
	<meta name="keywords" content="<?php echo $keywords;?>">
	<meta name="author" content="<?php echo $author;?>">
	<title><?php echo $title;?></title>
<?php foreach ($style as $style_link): ?>
	<?= link_tag(base_url().$style_link)."\n"; ?>
<?php endforeach ?>
</head>
<?= $body."\n" ?>
