<div class="toggle_hide_new_user hide">
	<h1>Opret ny bruger</h1>
	<form method="post">
		<input id="form_id" name="form_id" type="hidden" value="new_user_form" />
		<input name="new_user_form_name" type="text" placeholder="Navn"/><br />
		<input name="new_user_form_surname" type="text" placeholder="Efternavn" /><br />
		<input name="new_user_form_email" type="text" placeholder="email" /><br />
		<select name="new_user_form_role"><option value="admin">Administrator</option><option value="user">Bruger</option></select>
		<input type="submit" value="Opret bruger" />
	</form>
</div>

<br />

<div class="toggle_hide_new_password hide">
	<h1>Opret nyt password</h1>
	<form method="post">
		<input id="form_id" name="form_id" type="hidden" value="new_password_form" />
		<input name="new_password_form_password" type="password" placeholder="Nyt password"/>
		<input name="new_password_form_repeat_password" type="password" placeholder="Gentag password" />
		<input type="submit" value="Gem nyt password" />
	</form>
</div>