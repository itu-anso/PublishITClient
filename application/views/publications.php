<section class="leftSection">
	<div id="accordion">

		<? if (!empty($medias)): ?>
			<? foreach ($medias as $media): ?>
				<h3> <?= $media['title']; ?> - <?= $media['average_rating']; ?> </h3>
				<div>
					<p class="description"><?= ucfirst($media['description']); ?> </p>
					<p>Uploaded: <?= $media['date']; ?> </p>
					<p>Downloads: <?= $media['number_of_downloads']; ?> </p>
					<form method="post">
						<input type="hidden" name="form_id" value="download_form" />
						<input type="hidden" name="download_form_media_id" value='<?= $media['media_id']; ?>'/>
						<input type="hidden" name="download_form_media_title" value="<?=  $media['title']; ?>"/>
						<input type="submit" name="download_form_download" value="Download"/>
						<a href="?form_id=read&read_media_id=<?= $media['media_id']; ?>&read_title=<?= $media['title']; ?> " >Læs</a>
					</form>
					
						
				</div>
			<? endforeach; ?>
		<? endif; ?>
	</div>
</section>