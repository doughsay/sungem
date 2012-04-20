<?php
	$html = function($pageTitle, $content, $json = null, $js = null, $css = null) {
		$title = getConfigVar('core', 'title');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo $title; ?>
			- <?php echo $pageTitle; ?>
		</title>

		<?php if($json !== null): ?>
			<script type='text/javascript'>
				var json = <?php echo json_encode($json); ?>;
			</script>
		<?php endif; ?>

		<?php if($js !== null && is_array($js)): foreach($js as $src): ?>
			<script type='text/javascript' src='/js/<?php echo $src; ?>.js'>
			</script>
		<?php endforeach; endif; ?>

		<?php if($css !== null && is_array($css)): foreach($css as $href): ?>
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
			<div class='clear'></div>
		</div>
	</body>
</html>
<?php }; ?>