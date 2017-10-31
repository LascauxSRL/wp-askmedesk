<h1>Askme Desk</h1>
<p>Configura il modulo per la creazione richieste di assistenza.</p>

<img class="askmedesk-main-logo" src="<?php echo plugins_url('../images/askmedesk-flat.png', __FILE__ );?>" alt="<?php echo ASKMECHAT_ADMIN_TITLE;?>">

<?php
$askmedesk_options = array();
$askmedesk_options['askmedesk_apiendpoint'] = get_option('askmedesk_apiendpoint');
$askmedesk_options['askmedesk_username'] = get_option('askmedesk_username');
$askmedesk_options['askmedesk_password'] = get_option('askmedesk_password');
//Terna di riferimento
$askmedesk_options['askmedesk_servicecode'] = get_option('askmedesk_servicecode');
$askmedesk_options['askmedesk_asscode'] = get_option('askmedesk_asscode');

if(isset($_REQUEST['submit'])){
	foreach ($askmedesk_options as $key => $value){		
		if(isset($_REQUEST[$key])){
			if(get_option($key)){
				update_option($key, $_REQUEST[$key]);
			} else {
				add_option($key, $_REQUEST[$key]);
			}
			$askmedesk_options[$key] = get_option($key);
		}		
	}
}
?>
<form method="post" action="" novalidate="novalidate">
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="endpoint-api">Endpoint API</label></th>
				<td><input name="askmedesk_apiendpoint" type="url" id="endpoint-api" value="<?php echo $askmedesk_options['askmedesk_apiendpoint']; ?>" class="regular-text">
					<p class="description" id="tagline-description">L'endpoint per le API di Askme Desk</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="username-api">Username</label></th>
				<td><input name="askmedesk_username" type="text" id="username-api" value="<?php echo $askmedesk_options['askmedesk_username']; ?>" class="regular-text">
					<p class="description" id="tagline-description">Lo username per l'utilizzo delle API Askme Desk</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="password-api">Password</label></th>
				<td><input name="askmedesk_password" type="password" id="password-api" value="<?php echo $askmedesk_options['askmedesk_password']; ?>" class="regular-text">
					<p class="description" id="tagline-description">La password per l'utilizzo delle API Askme Desk</p>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="servicecode-api">ID Servizio</label></th>
				<td><input style="width: 120px;" maxlength="10" name="askmedesk_servicecode" type="number" id="servicecode-api" value="<?php echo $askmedesk_options['askmedesk_servicecode']; ?>" class="regular-text">
					<p class="description" id="tagline-description">L'ID del Servizio Askme Desk</p>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="assetcode-api">ID Asset</label></th>
				<td><input style="width: 120px;" maxlength="10" name="askmedesk_asscode" type="number" id="assetcode-api" value="<?php echo $askmedesk_options['askmedesk_asscode']; ?>" class="regular-text">
					<p class="description" id="tagline-description">L'ID dell'Asset Askme Desk</p>
				</td>
			</tr>
	</tbody>
	</table>

	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Salva le modifiche">
	</p>
</form>