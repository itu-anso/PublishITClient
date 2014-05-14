<section class="rightSection">
	<form class="criteria" method="get" action="">
		<input type="hidden" name="form_id" value="search_form">
		<ul>
			<li>
				<select class="criteria">
					<option value="titel">Titel</option>
					<option value="author">Forfatter</option>
					<option value="rating">Rating</option>
				</select>
			</li>
			<li>
				<input type="text" name="search_form_search_string" id="search_string" placeholder="Find document">
				<input type="submit" id="searchSubmit" value="Søg">
				
			</li><br><br><br><br>
			<div class="searchResults">
				<div class="search_items">
					<? foreach ($medias as $media): ?>
						<h3 class="accordionHeader">[<?= $media['author']; ?>] <?= $media['title']; ?></h3>
						<div class="accContainer">
							<span class="description"><?= $media['description']; ?></span>
							<button>Download</button>
							
						</div>
					<? endforeach; ?>
				</div>
			</div>
		</ul>
	</form>
</section>
