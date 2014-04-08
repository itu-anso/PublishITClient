<div id="settings_container" title="Indstillinger">
	<div id="tabs">
		<ul>
			<li><a href="#section_1">Page settings</a></li>
			<li><a href="#section_2">Module settings</a></li>
		</ul>

		<div id="section_1">
			<form>
				<input type="hidden" name="form_id" value="update_settings" />
				<input type="hidden" name="action" value="update_settings" />
				<input type="hidden" name="update_settings_page_id" value="<?= $setting['page_id']; ?>">
				<table>
					<? foreach ($setting as $key => $value): ?>
					<tr>
						<td>
							<label><?= $key ?></label>
						</td>
						<td>
							<input name="update_settings_<?= $key ?>" value="<?= $value ?>" />
						</td>
					</tr>
					<? endforeach; ?>
				</table>
				<button data-page-id="<?= $setting['page_id']; ?>" class="save_settings">Gem</button>
			</form>
		</div>

		<div id="section_2">
			<? if ($module_settings): ?>
				<? foreach ($module_settings as $key => $module): ?>
					<span><?= $module['class_name'] . '(' . $key . ')'; ?></span><br />
					<? foreach ($module as $setting_key => $value): ?>
						<? if ($setting_key == 'content_area'): ?>
							<label for="content_area"><?= $setting_key; ?></label>
							<input type="text" name="content_area" value="<?= $value; ?>" />
						<? endif; ?>
					<? endforeach; ?>
				<? endforeach; ?>
			<? endif; ?>
		</div>
	</div>
</div>
