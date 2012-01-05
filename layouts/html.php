<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
				echo TITLE;
				if(isset($title)) {
					echo TITLE_SEPARATOR . $title;
				}
			?>
		</title>

		<script type='text/javascript' src='/js/jquery-1.7.1.min.js'></script>

		<?php if(isset($json)): ?>
			<script type='text/javascript'>
				var json = <?php echo json_encode($json); ?>;
			</script>
		<?php endif; ?>

		<?php if(isset($js) && is_array($js)): foreach($js as $src): ?>
			<script type='text/javascript' src='/js/<?php echo $src; ?>.js'>
			</script>
		<?php endforeach; endif; ?>

		<?php if(isset($css) && is_array($css)): foreach($css as $href): ?>
			<link
				rel='stylesheet'
				type='text/css'
				href='/css/<?php echo $href; ?>.css'
			>
		<?php endforeach; endif; ?>
	</head>
	<body>
		<h1><?php echo TITLE; ?></h1>
		<div id='Main'>
			<?php if(isset($title)): ?>
				<h2><?php echo $title; ?></h2>
			<?php endif; ?>
			<hr>
			<?php echo $content; ?>
			<div class='clear'></div>
		</div>
	</body>
</html>
