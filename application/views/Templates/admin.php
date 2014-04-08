<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/assets/Admin/Admin.css" type="text/css">
		<?php echo $this->headerqueue->flush_header_queue(); ?>
		<title>Am Bar | Admin</title>
	</head>
	<body>
		<form id="logout" method="POST" action="/log-ind">
			<input type="hidden" name="form_id" value="logout"/>
			<a onclick="document.getElementById('logout').submit();" href="#">Log af</a>
		</form>
		
		<div id="menu_wrapper"><?echo (isset($menu) ? $menu: ''); ?></div>
		<?php echo $main_content; ?>
	</body>
</html>