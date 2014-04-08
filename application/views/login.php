<form method="POST">
	<input type="hidden" name="form_id" value="login_form" />
	
	<table>
		<tr>
			<td>
				<label for="email">Email</label>
			</td>
			<td>
				<input type="email" name="login_form_email" value="" placeholder="Skriv din email"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="password">Kodeord</label>
			</td>
			<td>
				<input type="password" name="login_form_password" value="" placeholder="Skriv dit kodeord" />
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="Log ind" /></td>
		</tr>
	</table>
</form>