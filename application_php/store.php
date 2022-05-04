<?php
ini_set('display_errors', 0);
session_start();


if ($_SESSION['User'][0] == "P" and $_SESSION['User'][1] == "A") {

  //vérifie que les données sont présente pour évité que le script créer un fichier vide
  if ($_POST['activite'] == NULL) {
    header("Location: eleve.php");
  } else {
    $compteurActivity = 1;
    $i = 1;

    $date = strtotime(date('Y-m-d'));
    $week = date('W', $date);

    $file = fopen("data.csv", "r");
    flock($file, LOCK_SH);
    $lines = array();
    while (!feof($file)) {
      $lines[] = fgetcsv($file);
    }
    flock($file, LOCK_UN);
    fclose($file);



    $file = fopen("activite.txt", "r");
    flock($file, LOCK_SH);
    $linesA = array();
    while (!feof($file)) {
      $linesA[] = fgetcsv($file);
    }
    flock($file, LOCK_UN);
    fclose($file);

    //variable pour récupérer le nombre de tentative
    $file = fopen("data.csv", "w");
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
      if ($line[0] == $_SESSION['User']) {
        $tmp = true;
        break;
      } else {
        $tmp = false;
      }
    }

    //si non, création d'une ligne
    if ($tmp == false) {

      $data = array($_SESSION['User']);
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

      if ($line[0] == $_SESSION['User'] && $line != null) {

        $numb = $line[$compteurActivity][0];
        $numb++;

        if ($numb <= 9) {
          $data = array($_SESSION['User']);
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
          if ($line[0] != $_SESSION['User'] && $line != null) {
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
          if ($line[0] != $_SESSION['User'] && $line != null) {
            $modif = str_replace(",", ";", $line);
            fputcsv($file, $modif);
          }
        }
      } else {
        foreach ($lines as $line) {
          if ($line[0] != $_SESSION['User'] && $line != null) {
            fputcsv($file, $modif);
          }
        }
      }
      flock($file, LOCK_UN);
      fclose($file);
    } else {
    }
  }

  //fichier log
  $txt = "l'utilisateur " . "$_SESSION[User]" . " a modifier l'activé " . "$_POST[activite]" . " le " . date("Y-m-d H:i:s") . "\n";
  $file = fopen("logs.txt", "a");
  flock($file, LOCK_EX);
  fputs($file, $txt);
  flock($file, LOCK_UN);
  fclose($file);


  if ($numb >= 9) {
    $message =  'limite de tentative pour ce module';
  } else {
    $message =  'données envoyées';
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
              <div class='col-6 mx-auto'>
                  <div class='card bg-dark mt-5 '>
                      <div class='card-title bg-dark text-white mt-5'>
      
                              <h3 class='text-center py-3'>$message</h3>
                          </div>
                          <div class='card-body'>
                          <a href='eleve.php' class='btn btn-primary btn-block'>Retour</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      
      </body>
      </html>";
} elseif ($_SESSION['User'][0] == "P" and $_SESSION['User'][1] == "E") {
  header("Location: download.php");
} else {
  header("Location: index.php");
}
