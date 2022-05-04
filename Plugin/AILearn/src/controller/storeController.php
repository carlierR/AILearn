<?php

namespace AILearn\ai_learn\Controller;


class storeController
{


  public function __construct()
  {
    $this->init_hooks();
  }

  public function init_hooks()
  {
    add_action('from_menu', [$this, 'storeData']);
  }

  public static function storeData()
  {


    if (is_user_logged_in()) {

      ini_set('display_errors', 0);



      if ($_POST['activite'] == NULL) {
        $message =  'veuillez choisir une activité';
      } else {
        $compteurActivity = 1;
        $i = 1;

        $date = strtotime(date('Y-m-d'));
        $week = date('W', $date);

        $file = fopen('wp-content\plugins\AILearn\file\data.csv', "r");
        flock($file, LOCK_SH);
        $lines = array();
        while (!feof($file)) {
          $lines[] = fgetcsv($file);
        }
        flock($file, LOCK_UN);
        fclose($file);



        $file = fopen('wp-content\plugins\AILearn\file\activity.txt', "r");
        flock($file, LOCK_SH);
        $linesA = array();
        while (!feof($file)) {
          $linesA[] = fgetcsv($file);
        }
        flock($file, LOCK_UN);
        fclose($file);

        //variable pour récupérer le nombre de tentative
        $file = fopen('wp-content\plugins\AILearn\file\data.csv', "w");
        flock($file, LOCK_EX);
        $numb = 1;
        $tmp = true;


        //init les lignes de l'utilisateur
        $compteurActivity = array_search($_POST['activite'], $linesA);
        $array = array();
        foreach ($linesA as $lineA) {
          array_push($array, $lineA);
        }

        $key = array_search('ae1', $linesA);

        $list = array();
        foreach ($linesA as $lineA) {
          array_push($list, $lineA[$key]);
        }

        $compteurActivity = array_search($_POST['activite'], $list);
        $compteurActivity++;

        //vérification si l'utilisateur a une ligne dans le fichier
        foreach ($lines as $line) {
          if ($line[0] == wp_get_current_user()->user_login) {
            $tmp = true;
            break;
          } else {
            $tmp = false;
          }
        }

        //si non, création d'une ligne
        if ($tmp == false) {

          $data = array(wp_get_current_user()->user_login);
          //ligne qui va être ajouté dans le fichier
          for ($l = 1; $l <= count($linesA); $l++) {
            if ($compteurActivity == $l) {
              array_push($data, $numb . $_POST["contexte"] . $_POST["result"] . $week);
            } else {
              array_push($data, '00000');
            }
          }
        } else {
        }


        foreach ($lines as $line) {


          if ($line[0] == wp_get_current_user()->user_login && $line != null && $line != '') {

            $numb = $line[$compteurActivity][0];
            $numb++;

            if ($numb <= 9) {
              $data = array(wp_get_current_user()->user_login);
              //ligne qui va être ajouté dans le fichier
              for ($l = 1; $l <= count($linesA); $l++) {
                if ($compteurActivity == $l) {
                  array_push($data, $numb . $_POST["contexte"] . $_POST["result"] . $week);
                } else {
                  array_push($data, $line[$l]);
                }
              }
            }

            //ajout des lines déja existante qui ne sont pas de l'utilisateur connecté
            else {
              if ($line[0] != wp_get_current_user()->user_login && $line != null) {
                foreach ($lines as $line) {
                  fputcsv($file, $line);
                }
              } else {
                foreach ($lines as $line) {
                  fputcsv($file, $line);
                }
              }
            }
          } else {
          }
        }
        if ($data != null) {
          fputcsv($file, $data);
          if ($lines != null) {
            foreach ($lines as $line) {
              //on ajoute les anciennes données dans le fichier
              if ($line[0] != wp_get_current_user()->user_login && $line != null) {
                $modif = str_replace(",", ";", $line);
                fputcsv($file, $modif);
              }
            }
          } else {
          }
          flock($file, LOCK_UN);
          fclose($file);
        } else {
        }




      if ($numb >= 9) {
        $message =  'limite de tentative pour ce module';
      } else {
        $message =  'données envoyées';
        $txt = "l'utilisateur " . wp_get_current_user()->user_login . " a modifier l'activé " . "$_POST[activite]" . " le " . date("Y-m-d H:i:s") . "\n";
        $file = fopen('wp-content\plugins\AILearn\file\logs.txt', "a");
        flock($file, LOCK_EX);
        fputs($file, $txt);
        flock($file, LOCK_UN);
        fclose($file);
      }
    }
      echo
      "<html
              <!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              
              <!-- Bootstrap CSS -->
              <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css'>
              
                  <title>Login Form</title>
              </head>
              <body >
        
              <div class='container'>
                  <div class='row'>
                      <div class='col-12 mx-auto'>
                          <div class='card bg-dark mt-5 '>
                              <div class='card-title bg-dark text-white mt-5'>
              
                                      <h3 class='text-center py-3'>$message</h3>
                                  </div>
                                  <div class='card-body'>
                                  <a href='" . home_url() . "' class='btn btn-primary btn-block'>Retour</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              
              </body>
              </html>";
    } else {
      echo "<html
      <!DOCTYPE html>
      <html lang='en'>
      <head>
          <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      
      <!-- Bootstrap CSS -->
      <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css'>
      
          <title>Login Form</title>
      </head>
      <body >

      <div class='container'>
          <div class='row'>
              <div class='col-12 mx-auto'>
                  <div class='card bg-dark mt-5 '>
                      <div class='card-title bg-dark text-white mt-5'>
      
                              <h3 class='text-center py-3'>accès refusé, veuillez vous connecter</h3>
                          </div>
                          <div class='card-body'>
                          <a href='" . wp_login_url() . "' class='btn btn-primary btn-block'>Retour</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </body>
      </html>";
    }
  }
}
