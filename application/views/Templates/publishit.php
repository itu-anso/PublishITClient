<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Forside</title>
		<link rel="stylesheet" type="text/css" href="/assets/publishit/style.css">
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
		
		<?= $this->headerqueue->flush_header_queue(); ?>
	</head>
	<body>
		<header class="mainpageheader">
			<div class="logo">
				<img src="/assets/publishit/images/logo.png" alt="Publish IT logo">
			</div>			
			<nav class="mainmenu">
				<a href="">Opret bruger</a>
				<a id="upload_button" href="" onclick="return false;" >Upload</a>
			</nav>
		</header>
		<? if ($this->user->is_logged_in): ?>
			<div id="dialog">
				<form name="upload_file_form" method="post" enctype="multipart/form-data">
					<input type="hidden" id="form_id" name="form_id" value="upload_file_form" />
					<input type="text" name="upload_file_form_title" placeholder="Enter title here" />
					<input id="upload_file" name="upload_file_form_upload_file" type="file" name="file" />
					<input type="submit" id="upload" value="Upload" />
				</form>
			</div>
		<? endif; ?>
		<div id="left_content"><?= !empty($left_content) ? $left_content : ''; ?> </div>
		<?= $main_content; ?>
	</body>
</html>