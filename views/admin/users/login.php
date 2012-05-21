<?php /* login($error): */ ?>
<div id='Login' class='center'>
	<?php if($error): ?>
		<p class='error center'>Invalid username or password.</p>
	<?php endif; ?>
	<form action='/admin/users/login' method='POST'>
		<label>
			Username:
			<input type='text' name='username'>
		</label>
		<label>
			Password:
			<input type='password' name='password'>
		</label>
		<p class='center'>
			<button type='submit'>Login</button>
		</p>
	</form>
</div>