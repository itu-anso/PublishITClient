<section class="leftSection">
	<div id="accordion">

		<? if (!empty($medias)): ?>
			<? foreach ($medias as $media): ?>
				<h3> <?= $media['title']; ?> </h3>
				<div>
					<p>Description: <?= $media['description']; ?> </p>
					<p>Average Rating: <?= $media['average_rating']; ?> </p>
					<p>Uploaded: <?= $media['date']; ?> </p>
					<p>Downloads: <?= $media['number_of_downloads']; ?> </p>
					<ul>
						<li>
							<form method="get" action="">   <!-- File navn herinde--> 
								<button type="submit"> 
									<a href="path_to_file" download="proposed_file_name">Download</a>
								</button> 
							</form>
						</li>
						<li>
							<a href="?form_id=read&read_media_id=<?= $media['media_id']; ?>&read_title=<?= $media['title']; ?> " >Læs</a>
						</li> 
					</ul>
				</div>
			<? endforeach; ?>
		<? endif; ?>
	</div>
</section>