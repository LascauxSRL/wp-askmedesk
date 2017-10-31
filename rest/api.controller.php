<?php

class AskmeDeskRestController extends WP_REST_Controller {

	private $endpoint = null;
	private $args = null; 

    function __construct() {
        $askmeEndpoint = get_option('askmedesk_apiendpoint');
        $username = get_option('askmedesk_username');
		$password = get_option('askmedesk_password');
		$this->session_id = null;
		$this->csrf_token = null;
		$this->endpoint = $askmeEndpoint;
		$this->args = array(
			'headers' => array(
			  'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password )
			)
		);
    }


	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$version = '1';
		$namespace = 'askmedesk/v' . $version;
        register_rest_route( $namespace, '/tipi-richiesta', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_tipi_richiesta'],
            'permission_callback' => [$this, 'askmedesk_permission_check']
		));
		register_rest_route($namespace, '/creazione-richiesta', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => [$this, 'crea_richiesta'],
			'permission_callback' => [$this, 'askmedesk_permission_check'],
			'args' => $this->get_endpoint_args_for_item_schema( false )
		));
	}

	/**
	 * Autenticazione
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function set_csrf_token() {
		if($this->csrf_token == null){
			$url = $this->endpoint . "/authentication/token";
			$response = $this->httpGet($url);
			if($response != null){
				$this->csrf_token = $response['token'];
				$this->session_id = $response['sessionId'];
				$username = get_option('askmedesk_username');
				$password = get_option('askmedesk_password');
				$this->args = array(
					'headers' => array(
					  'X-CSRF-TOKEN' => $this->csrf_token
					)
				);
				setcookie("JSESSIONID",$this->session_id, time() + 1800);
				return true;
			} else {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Recupera i tipi richiesta
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_tipi_richiesta($request) {
		$serviceCode = get_option('askmedesk_servicecode');
		$assetCode = get_option('askmedesk_asscode');
		$url = $this->endpoint . "/domains/tipiRichiesta?idServizio=".$serviceCode."&idAssetPadre=".$assetCode;
		$response = $this->httpGet($url);
		if($response != null){
			return new WP_REST_Response($response, 200);
		}
		return new WP_REST_Response(400);
	}
	
	/**
	 * Crea richiesta
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function crea_richiesta(WP_REST_Request $request) {
		$this->set_csrf_token();
		$priority = 'G3';
		$channel = 'WEB';
		$idUtente = 222;
		$serviceCode = get_option('askmedesk_servicecode');
		$assetCode = get_option('askmedesk_asscode');
		 $args = array(
			'idServizio' => $serviceCode,
			'idAssetRoot' => $assetCode,
			'idAssetFiglio' => $assetCode,
			'idTipoRichiesta' => $request->get_param( 'idTipoRichiesta' ),
			'oggetto' => $request->get_param( 'oggetto' ),
			'descrizione' => $request->get_param( 'descrizione' ),
			'codUrgenza' => $priority,
			'codPriorita' => $priority,
			'codiceCanale' => $channel,
			'idUtente' => $idUtente,
			'idUtenteRichiedente' => 578
		);
		$url = $this->endpoint . "/richieste/creazione-richiesta-ct";		
		$response = $this->httpPost($url, $args);
		if($response != null){
			return new WP_REST_Response($response, 200);
		}
		return new WP_REST_Response(400);
    }
	
	
	/**
	 * 
	 */
	private function httpGet($url){
		$response = wp_remote_get($url, $this->args);
		if ( is_array( $response ) ) {
			$body = json_decode(wp_remote_retrieve_body( $response ), true);
			return $body;
		}
		return null;
	}

	/**
	 * 
	 */
	private function httpPost($url, $data){
		$args = $this->args;
		$args['body'] = $data;
		$response = wp_remote_post($url, $args);
		if ( is_array( $response ) ) {
			$body = json_decode(wp_remote_retrieve_body( $response ), true);
			return $body;
		}
		return null;
	}

    /**
	 * Check if a given request has access
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function askmedesk_permission_check( $request ) {
		return true;
	}

}