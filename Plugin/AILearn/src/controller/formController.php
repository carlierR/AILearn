<?php

namespace AILearn\ai_learn\Controller;

use AILearn\ai_learn\AILearnPlugin;
use mk_file_folder_manager;

class formController
{



  public function __construct()
  {
    $this->init_hooks();
  }

  public function init_hooks()
  {
    add_action('from_menu', [$this, 'form_menu']);
  }

  public static function GetActivity($filename)
  {

    if (!file_exists($filename)) {
      return false;
    } else {
      $file = fopen($filename, "r");
      $lines = array();
      while (!feof($file)) {
        $lines[] = fgetcsv($file);
      }
      fclose($file);
      return $lines;
    }
  }


  public static function read($fileName)
  {
    $file = fopen($fileName, "r");
    $lines = array();
    while (!feof($file)) {
      $lines[] = fgetcsv($file);
    }
    fclose($file);
    return $lines;
  }

  public static function getUserData()
  {
    $lines =  formController::read('wp-content\plugins\AILearn\file\data.csv', "r");

    $userData = array();

    if ($lines[0] == false) {
      return false;
    }else{
    foreach ($lines as $line) {
      if ($line[0] == wp_get_current_user()->user_login) {
        $userData = $line;
        break;
      }
    }
    if (count($userData) == 0) {
      exit;
    } else {
      return $userData;
    }
  }


  }



  public static function getCouleur($result)
  {

      if ($result == 1) {
        return "orange";
      } elseif ($result == 2) {
        return "yellow";
      } elseif ($result == 3 || $result == 4) {
        return "green";
  }
}



  public static function generateTable($userData)
  {
    $linesA =  formController::read('wp-content\plugins\AILearn\file\activity.txt');

    $html = "<table border=1>";
    $html .= "<tr>";
    $html .= "<th>Activité</th>";
    $html .= "<th>Nombre de tentative</th>";
    $html .= "<th>Contexte</th>";
    $html .= "<th>Resultat</th>";
    $html .= "<th>Semaine</th>";
    $html .= "</tr>";
    if(is_countable( $userData ) && count( $userData )){
      for ($i = 1; $i < count($userData); $i++) {
        $html .= "<tr style='background-color:" .  formController::getCouleur($userData[$i][2]) . "'>";
        $html .= "<td>" . $linesA[$i - 1][0] . "</td>";
        $html .= "<td>" . $userData[$i][0] . "</td>";
        $html .= "<td>" . $userData[$i][1] . "</td>";
        $html .= "<td>" . $userData[$i][2] . "</td>";
        $html .= "<td>" . $userData[$i][3] . $userData[$i][4] . "</td>";
        $html .= "</tr>";
      }
      $html .= "</table>";
      return $html;
    }
    return $html;
  }

  public static function form_menu()
  {

    if (is_user_logged_in()) {


      $html = '<html
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    
            <title> Form</title>
        </head>
        <body >';



      $html .=
        '
  
        <form action="        '. home_url().'/store" method="post">
        <h2>Contexte</h2>';


      $html .= "<select name='activite'>";
      $lines = formController::GetActivity('wp-content\plugins\AILearn\file\activity.txt');
      foreach ($lines as $line) {
        $html .= "<option value='" . $line[0] . "'>" . $line[0] . "</option>";
      }
      $html .= "</select></br>";









      $html .= '
        <input type="radio" name="contexte" value="1" checked> 1 Présence<br/>
        <input type="radio" name="contexte" value="2" >2 Autonomie<br/>
        <input type="radio" name="contexte" value="3">3 Les deux, la première tentative était en présence<br/>
        <input type="radio" name="contexte" value="4">4 Les deux, la première tentative était en autonomie<br/>
        <h2>Résultat</h2>
        <input type="radio" name="result" value="1" checked>1 Pas du tout maitrisé<br/>
        <input type="radio" name="result" value="2">2 Partiellement maitrisé<br/>
        <input type="radio" name="result" value="3">3 Maitrisé mais révision à prévoir<br/>
        <input type="radio" name="result" value="4">4 Définitivement maitrisé<br/>
    
    
        <input type="submit" name="submit" value="Submit">
        </form>
    
        </body>
        </html>';

      echo $html;
      echo  formController::generateTable(formController::getUserData());
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
