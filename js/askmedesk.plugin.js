/**
 * Plugin Askme Desk per le chiamate alle API
 */

(function (win, $) {
    if($){
        function askmeDeskAPI() {

            var _api = {};

            /**
             * Set the global API endpoint
             */
            _api.init = function(endpoint){
                this._endpoint = endpoint;
                this._namespace = 'askmedesk/v1';
            }

            /**
             * Recupera tutti i tipi richiesta disponibili
             */
            _api.getTipiRichiesta = function(idServizio, idAsset){
                var url = this._endpoint + this._namespace + '/tipi-richiesta';
                return $.get(url);
            }

             /**
             * Creazione richiesta
             */
            _api.creaRichiesta = function(options){
                var data = {idRichiesta: 1};
                var url = this._endpoint + this._namespace + '/creazione-richiesta';
                return $.post(url, data);
            }


            _api.createUrlParameters = function(params = []){
                var encoded = '';
                var counter = 0;
                for(var i = 0; i < params.length; i++){
                    var param = params[i];
                    if(param['name'] && param['value']){
                        if(counter == 0){
                            encoded += "?"
                        } else {
                            encoded += "&";
                        }
                        encoded += param['name'] + '=' + encodeURIComponent(param['value']);
                        counter++;
                    }
                }
                return encoded;
            }


            return _api;
        }

        if (typeof(win.askmeDeskAPI) === 'undefined') {
            win.askmeDeskAPI = askmeDeskAPI();
        }
    }
})(window, jQuery);