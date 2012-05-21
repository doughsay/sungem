<?php
$title = getConfigVar('core', 'title');
/* html($pageTitle, $content, $js, $css): */
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo $title; ?>
			- <?php echo $pageTitle; ?>
		</title>

		<?php if(isset($css)): foreach($css as $href): ?>
			<link
				rel='stylesheet'
				type='text/css'
				href='/css/<?php echo $href; ?>.css'
			>
		<?php endforeach; endif; ?>
	</head>
	<body>
		<h1><?php echo $title; ?></h1>
		<h2><?php echo $pageTitle; ?></h2>
		<div id='Main'>
			<hr>
			<?php echo $content; ?>
		</div>
	</body>

	<?php if(isset($js)): foreach($js as $src): ?>
		<script type='text/javascript' src='/js/<?php echo $src; ?>.js'>
		</script>
	<?php endforeach; endif; ?>
</html>