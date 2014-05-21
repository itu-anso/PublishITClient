<section class="rightSection">
	<ul>
		<li>
			<select class="criteria">
				<option value="titel">Titel</option>
				<option value="author">Forfatter</option>
				<option value="rating">Rating</option>
			</select>
		</li>
		<li>
			<form class="criteria" method="get" action="">
				<input type="hidden" name="form_id" value="search_form">
				<input type="text" name="search_form_search_string" id="search_string" placeholder="Find document">
				<input type="submit" id="searchSubmit" value="Søg">
			</form>
		</li><br><br><br><br>
		<div class="searchResults">
			<div class="search_items">
				<? if (!empty($medias)): ?>
					<div id="search_accordion">
						<? foreach ($medias as $id => $media): ?>
							<h3 >[<?= $media['author']; ?>] <?= $media['title']; ?></h3>
							<div class="accContainer">
								<span class="description"><?= $media['description']; ?></span>
								<form method="post" action="/">
									<input type="hidden" name="form_id" value="download_form" />
									<input type="hidden" name="download_form_media_id" value="<?= $id; ?>"/>
									<input type="hidden" name="download_form_media_title" value="<?=  $media['title']; ?>"/>
									<input type="submit" name="download_form_download" value="Download"/>
								</form>

								<div class="rating" data-score="<?= $rating->GetRatingResult; ?>">
									<input type="hidden" name="media_id" value="<?= $id; ?>" /> 
								</div>

							</div>
						<? endforeach; ?>
					</div>
				<? endif; ?>
			</div>
		</div>
	</ul>
</section>
