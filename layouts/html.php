<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
				echo $title;
				if(isset($pageTitle)) {
					echo $titleSeparator . $pageTitle;
				}
			?>
		</title>

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
		<h1><?php echo $title; ?></h1>
		<div id='Main'>
			<?php if(isset($pageTitle)): ?>
				<h2><?php echo $pageTitle; ?></h2>
			<?php endif; ?>
			<hr>
			<?php echo $content; ?>
			<div class='clear'></div>
		</div>
	</body>
</html>
