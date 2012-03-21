<?php $pageTitle = "Home sweet home"; // You can override any variables used in the layout ?>

<p>This is some static content.</p>

<p><?php echo $foo; ?></p>

<p><?php echo $bar; ?></p>

<p><?php echo snippet('baz', array('baz' => 'And this is baz!')); ?>

<p>
	Strings from the database:
</p>

<ul>
	<?php foreach($strings as $string): ?>
		<li>
			<?php echo $string; ?>
		</li>
	<?php endforeach; ?>
</ul>

<ul>
	<li><a href='page1'>Static page1</li>
	<li><a href='/pages/show/page2'>Static page2</li>
	<li><a href='/home/some_json'>Some JSON data</li>
	<li><a href='/admin'>Admin login</li>
</ul>
