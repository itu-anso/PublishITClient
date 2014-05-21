<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Forside</title>
		<link rel="stylesheet" type="text/css" href="/assets/publishit/style.css">
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/redmond/jquery-ui.css" />
		
		<?= $this->headerqueue->flush_header_queue(); ?>
	</head>
	<body>
		<header class="mainpageheader">
			<div class="logo">
				<a href="/"><img src="/assets/publishit/images/alt_logo_color.png" alt="PublishIT logo"></a>
			</div>			
			<nav class="mainmenu">

				<? if(!$this->user->is_logged_in): ?>
					<a id="create_account_button" href="" onclick="return false;" >Create Account</a>
				<? endif; ?>
				
				<? if($this->user->is_logged_in): ?>
					Velkommen <a><?= $this->user->name; ?>!</a>
					<a id="upload_button" href="" onclick="return false;" >Upload</a>
					<a id="logout_button" href="/login?logout=true" >Logout</a>

				<? endif; ?>
			</nav>
		</header>
		<? if( $this->message->has_error()): ?>
			<?= $error_messages; ?>
		<? endif; ?>


		<div class="searchcontent">
			<? if(!$this->user->is_logged_in): ?>
				<div id="create_account_form">
					<form name="create_account" method="post">
						<input type="hidden" name="form_id" value="create_account" />
						Name: <input type="text" name="create_account_name" required />
						Email: <input type="email" name="create_account_email" required />
						Birthdate: <input type="date" name="create_account_birthday" required />
						Username: <input type="text" name="create_account_username" required />
						Password: <input type="password" name="create_account_password" required />
						<input type="submit" name="submit" value="submit" />
					</form>
				</div>
			<? endif; ?>

			<? if ($this->user->is_logged_in): ?>
				<div id="dialog" title="Upload publication">
					<form name="upload_file_form" method="post" enctype="multipart/form-data">
						<input type="hidden" id="form_id" name="form_id" value="upload_file_form" />
						<input type="text" name="upload_file_form_title" placeholder="Enter title here" />
						<input type="text" name="upload_file_form_description" placeholder="Enter description">
						<input name="upload_file_form_status" type="checkbox" checked /><label for="upload_file_form_status">Yes i want my work to be for all eyes to see!</label>
						<input id="upload_file" name="upload_file_form_upload_file" type="file" name="file" />
						<input type="submit" id="upload" value="Upload" />
					</form>
				</div>
			<? endif; ?>
			<?= !empty($left_content) ? '<div id="leftSection">' . $left_content . '</div>' : ''; ?>
			<?= $main_content; ?>
		</div>
		<footer>
			<pre><em>PublishIT - 2014</em></pre>
		</footer>
	</body>
</html>