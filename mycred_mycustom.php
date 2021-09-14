<?php 

/*
Plugin Name: MyCredMyCustom
Version: 1.0
Description: Description
Author: F.myriam
*/

// Creation of a new hook

add_filter( 'mycred_setup_hooks', 'register_my_custom_hook' );
function register_my_custom_hook( $installed ) {
    $installed['hook_id'] = array(
        'title'       => __( 'Hook Title', 'textdomain' ),
        'description' => __( 'Hook description', 'textdomain' ),
        'callback'    => array( 'Hook_Class' )
    );
    return $installed;
}

// Database Connexion

function connexion() {
    $host = "localhost";
    $dbname = "local";
    $login = "root";
    $mdp = "root";
    try{
        $db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=UTF8',$login,$mdp);
        return $db;
    } 
    catch(Exception $error) {
        die ("Error : ". $error->getMessage());
    }
}

// Notice function

function notice() {
    if(!function_exists('mycred_add_new_notice')) {
        echo 'mycred not installed!';
    }
    else {
        wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . '/assets/css/style.css');        
        wp_enqueue_script( 'script', plugin_dir_url( __FILE__ ) . '/assets/js/script.js', array(), '1.0.0', true );
        $message = "<br/> <br/> <br/> Tu as " . do_shortcode('[mycred_total_points]') . " points";
        mycred_add_new_notice(array('user_id' => wp_get_current_user(), 'message' => $message));
    }
}

// Add notice function in loop_end hook

add_action('loop_end', 'notice', 1);

?>
