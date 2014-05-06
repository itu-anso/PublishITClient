<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Forside</title>
		<link rel="stylesheet" type="text/css" href="/assets/publishit/style.css">
		<?= $this->headerqueue->flush_header_queue(); ?>
	</head>
	<body>
		<header class="mainpageheader">
			<div class="logo">
				<img src="/assets/publishit/images/logo.png" alt="Publish IT logo">
			</div>			
			<nav class="mainmenu">
				<a href="">Opret bruger</a>
			</nav>
		</header>
		<div id="left_content"><?= !empty($left_content) ? $left_content : ''; ?> </div>
		<?= $main_content; ?>
	</body>
</html>