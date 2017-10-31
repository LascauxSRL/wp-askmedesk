(function($){
    $(document).ready(function(){
        if(askmeDeskAPI){
            askmeDeskAPI.getTipiRichiesta().done(function(data){
                var select =  $('.askmedesk-select-tipirichiesta');
                select.empty();
                $.each(data, function(index, tipoRichiesta){
                    var opt = $('<option></option>')
                        .val(tipoRichiesta.id)
                        .text(tipoRichiesta.nome);
                    select.append(opt);
                })
                
            });
        
            /**
             * Form di creazione richiesta
             */
            $('form.askmedesk-create-request-form').submit(function(e){
                e.preventDefault();
                debugger;
                var idTipoRichiesta = $('.askmedesk-select-tipirichiesta').val();
                var oggetto = $('.askmedesk-input-oggetto').val();
                var descrizione = $('.askmedesk-input-descrizione').val();
                var data = {
                    'idTipoRichiesta': idTipoRichiesta,
                    'oggetto': oggetto,
                    'descrizione': descrizione
                }
                askmeDeskAPI.creaRichiesta(data).done(function(response){
                    console.log(response);
                }).fail(function(error){
                    console.log(error);
                });
            })
        }
    });
})(jQuery);