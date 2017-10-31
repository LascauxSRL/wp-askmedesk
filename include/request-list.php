
<?php
function askmedesk_request_list(){
?>
<h1>Le tue richieste di assistenza</h1>
<table style="width:100%">
  <tr>
    <th>ID</th>
    <th>Tipo richiesta</th>
    <th>Data apertura</th>
    <th>Stato</th>
    <th>Azioni</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Generazione report</td>
    <td>10 ott 2017 10:51</td>
    <td>Aperta</td>
    <td>
        <button class="askmedesk-btn">Dettaglio</button>
    </td>
  </tr>
</table>
<?php
}
add_shortcode('askmedesk_request_list', 'askmedesk_request_list');
?>