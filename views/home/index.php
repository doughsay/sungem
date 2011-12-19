<p>This is some static content.</p>

<p><?php echo $foo; ?></p>

<p><?php echo $bar; ?></p>

<p><?php echo snippet('baz', array('baz' => 'And this is baz!')); ?>

<p>
	Strings from the database:
	<ul>
		<?php foreach($strings as $string): ?>
			<li>
				<?php echo $string; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</p>