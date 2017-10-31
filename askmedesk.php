<?php
/*

Plugin Name: Askme Desk plugin
Description: Modulo di creazione richiesta da Wordpress. Lista e dettaglio richieste aperte dal cliente.
Version: 1.0
Author: Lascaux s.r.l.
Author URI: http://www.lascaux.it
*/

define ( 'ASKMEDESK_JQUERY_VERSION', '2.2.4' );
define ( 'ASKMEDESK_STYLES_FILE', 'css/askmedesk.plugin.css' );
define ( 'ASKMECHAT_PLUGIN_NAME', 'askmedesk' );
define ( 'ASKMECHAT_ADMIN_TITLE', 'Askme Desk' );
define ( 'ASKMECHAT_ADMIN_CAPABILITY', 'manage_options' );
define ( 'ASKMECHAT_SETTINGS_PAGE', 'askme-desk-configuration');

add_action("wp_enqueue_scripts", "askmedesk_init_plugin");
add_action("admin_enqueue_scripts", "askmedesk_init_admin_styles");
add_action("admin_menu", "askmedesk_admin_page");

function askmedesk_init_plugin() {
    if (!is_admin()) {

        if(! wp_script_is( 'jquery', 'enqueued' )) {
            wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/" . ASKMECHAT_JQUERY_VERSION . "/jquery.min.js", false, null);
            wp_enqueue_script('jquery');
        }

        wp_enqueue_script( 'askmedesk_api', plugins_url('js/askmedesk.plugin.js', __FILE__ ), array( 'jquery' ));
    }

    include_once 'include/request-creation-form.php';
    include_once 'include/request-list.php';
}

add_action( 'rest_api_init', function () {
    include 'rest/api.controller.php';
    $controller = new AskmeDeskRestController();
    $controller->register_routes();
    
} );


add_action('wp_head', 'initializeApi');
function initializeApi(){
    if(get_option('askmedesk_apiendpoint')){
        $endpoint = rest_url();
        echo '<script>
            if(window.askmeDeskAPI){
                window.askmeDeskAPI.init("'.$endpoint.'");
            }
        </script>';
    }
}

/**
* Admin styles and scripts
*/
function askmedesk_init_admin_styles() {
    if (is_admin()) {
        wp_register_style('askmedesk_admin_style', plugins_url('css/askmedesk.admin.css', __FILE__ ));
	    wp_enqueue_style('askmedesk_admin_style');		
    }   
}


/*
* Widget admin page
*/
function askmedesk_admin_page(){
    $title = ASKMECHAT_ADMIN_TITLE;
    $capability = ASKMECHAT_ADMIN_CAPABILITY;
    $logo = plugins_url(). '/' . ASKMECHAT_PLUGIN_NAME . '/images/logo.png';

    $parent_slug = 'askmedesk-configuration';

	add_menu_page( $title, $title, $capability, $parent_slug, 'askmedesk_settings_admin_page', $logo, 30 );
	add_submenu_page( $parent_slug, 'Impostazioni', 'Impostazioni', $capability, $parent_slug, 'askmedesk_settings_admin_page' );    
    //add_submenu_page( $parent_slug, 'Editor', 'Editor', $capability, 'askmedesk-styles-editor', 'askmedesk_styles_editor_admin_page' );
}

function askmedesk_settings_admin_page(){
    include_once 'admin/askmedesk-config.php';
}
?>