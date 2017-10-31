
<?php
function askmedesk_request_form_creation(){
?>
<form method="POST" class="askmedesk-create-request-form">
    <p>
        <label>Utente</p>
        <span>Lorenzo Cioni</p>
    </p>
    <p>
        <label>Tipo richiesta</label>
        <select class="askmedesk-select-tipirichiesta"></select>
    </p>
    <p>
        <label>Oggetto</label>
        <input type="text" class="askmedesk-input-oggetto" name="oggetto" placeholder="Oggetto"></textarea>
    </p>
    <p>
        <label>Messaggio</label>
        <textarea class="askmedesk-input-descrizione" name="message" placeholder="Inserisci qui il tuo messaggio..."></textarea>
    </p>
    <button type="submit">Invia</button>
</form>
<script src="<?php echo plugins_url('../js/askmedesk.createrequest.js', __FILE__);?>"></script>
<?php
}
add_shortcode('askmedesk_request_form', 'askmedesk_request_form_creation');
?>