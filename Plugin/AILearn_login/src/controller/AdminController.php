<?php

namespace AILearn\ai_learn\Controller;

use AILearn\ai_learn\AILearnPlugin;
ob_start();
class AdminController{

    const REDIRECT_TO_LIST = 0;
	const REDIRECT_TO_EDIT = 1;

    public function __construct(){
        $this->init_hooks();
        }

    public function init_hooks(){
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_init', [$this, 'admin_init']);
    }

    public function admin_menu(){

        //bouton dans l'onglet réglages
        add_options_page(
            'AILearn',
            'AILearn',
            'manage_options',
            'ailearn_config',
            [$this, 'config_page']
        );

    }

    public function config_page(){
        AILearnPlugin::render('config');
    }

    public function admin_init(){
        register_setting('ailearn_general', 'ailearn_config_general');
        add_settings_section('ailearn_config_section', 'Téléchargement', '', 'ailearn_config');
        add_settings_field('redirect_to', '', [$this, 'render_button'], 'ailearn_config', 'ailearn_config_section');
    }

	public function render_button(): void
	{
        echo '<a href="?page=ailearn_config&download=true" class="button button-primary">Télécharger</a>';
                if (isset($_GET['download'])) {
                    $this->downloadCsv();
                }

	}


    	public function downloadCsv(): void
	{
        $file = plugin_dir_path(__FILE__) . '../../file/donnee.csv';

        $path = plugin_dir_path(__FILE__) . '../../file/data.csv';

        $content = file_get_contents($path);    
        
        $content = str_replace(',', ';', $content);
        file_put_contents($file, $content);
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            while (ob_get_level()) {
                ob_end_clean();
                @readfile($file);
            }
            exit;
        } else {
            echo "le fichier n'existe pas";
        }


	}




    

}
