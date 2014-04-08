<div id="site_map">
	<ul class="list">
		<form method="POST">
			<input type="hidden" name="form_id" value="new_page" />
			<input type="submit" value="Opret ny side" />
		</form>
		<? $temp = '';?>
		<? foreach ($sitemap as $page ): ?>
			<? if ($temp != $page['parent_page_title']): ?>
				<li><a id="page_id_<?= $page['page_id']; ?>" data-page-id="<?= $page['page_id']; ?>" href="<?= $page['parent_page_title']; ?>"><?= $page['parent_page_title']; ?> (<?= $page['page_id']; ?>)</a></li>
				<? $temp = $page['parent_page_title']; ?>
			<? endif; ?>
			<? if ($temp == $page['parent_page_title'] && !empty($page['child_page_title'])): ?>
				<li class="child"><a id="page_id_<?= $page['child_page_id']; ?>" data-page-id="<?= $page['child_page_id']; ?>" href="<?= $page['child_page_title']; ?>"> <?= $page['child_page_title']; ?> (<?= $page['child_page_id']; ?>)</a></li>
			<? endif; ?>
		<? endforeach; ?>
	</ul>
</div>