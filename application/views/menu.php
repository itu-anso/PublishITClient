<ul>
	<? foreach($menu as $menu_item): ?>
	<li><a href="<?= $menu_item['page_path']; ?>"><?= strtoupper($menu_item['page_title']); ?></a></li>

	<? endforeach;?>
</ul>