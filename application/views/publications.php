<section class="leftSection">
	<div id="accordion">
		<? foreach ($medias as $media): ?>
			<h3> <?= $media['title']; ?> </h3>
			<div class="accContainer">
				<p>Description: <?= $media['description']; ?> </p>
				<p>Average Rating: <?= $media['average rating']; ?> </p>
				<p>Uploaded: <?= $media['date']; ?> </p>
				<p>Downloads: <?= $media['number of downloads']; ?> </p>
				<ul>
					<li>
						<form method="get" action="">   <!-- File navn herinde--> 
							<button type="submit"> 
								<a href="path_to_file" download="proposed_file_name">Download</a>
							</button> 
						</form>
					</li>
					<li><a href="">Læs</a></li> <!--Link til at læse filen indsættes her-->
				</ul>
			</div>
		<? endforeach; ?>
	</div>
</section>