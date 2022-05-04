<?php

/*
plugin name: AILearn
plugin URI: http://www.wordpress.com/
Description: AILearn.
Version: 1.0
Author: Romain Carlier
*/

use AILearn\ai_learn\AILearnPlugin;
use AILearn\ai_learn\Controller\formController;
use AILearn\ai_learn\Controller\storeController;
use AILearn\ai_learn\Controller\loginController;
if (!defined('ABSPATH')) {
    exit;
}

define('AILEARN_PLUGIN_DIR', plugin_dir_path(__FILE__));
require plugin_dir_path(__FILE__) . 'vendor/autoload.php';

$plugin = new AILearnPlugin(__FILE__);

add_action('init', 'session_manager'); 
function session_manager() {
	if (!session_id()) {
		session_start();
	}
}



add_action( 'wp_logout', 'redirect_after_logout');
function redirect_after_logout(){
  session_destroy();
  wp_redirect(home_url('/80-2'));
  exit();
}

add_shortcode('AILearn_show', formController::class . '::form_menu');
add_shortcode('AILearn_store', storeController::class . '::storeData');
add_shortcode('AILearn_login', loginController::class . '::store_login');

