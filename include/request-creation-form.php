
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
        <select class="askmedesk-select-tipirichiesta">
            <option>Generica</option>
        </select>
    </p>
    <p>
        <label>Messaggio</label>
        <textarea name="message" placeholder="Inserisci qui il tuo messaggio..."></textarea>
    </p>
    <button type="submit">Invia</button>
</form>
<script src="<?php echo plugins_url('../js/askmedesk.createrequest.js', __FILE__);?>"></script>
<?php
}
add_shortcode('askmedesk_request_form', 'askmedesk_request_form_creation');
?>