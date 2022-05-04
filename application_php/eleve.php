<?php
session_start();


function read($fileName)
{
  $file = fopen($fileName, "r");
  $lines = array();
  while (!feof($file)) {
    $lines[] = fgetcsv($file);
  }
  fclose($file);
  return $lines;
}


function generateForm($lines)
{
  $html = "<form action='eleve.php' method='post'>";
  $html .= "<select name='activite'>";
  foreach ($lines as $line) {
    $html .= "<option value='" . $line[0] . "'>" . $line[0] . "</option>";
  }
  $html .= "</select>";
  $html .= "<input type='submit' value='Valider'>";
  $html .= "</form>";
  return $html;
}




function getUserData()
{
  $lines = read("data.csv");

  $userData = array();
  foreach ($lines as $line) {
    if ($line[0] == $_SESSION['User']) {
      $userData = $line;
      break;
    }
  }
  if (count($userData) == 0) {
    exit;
  }
  else{
    return $userData;
  }

}



function getCouleur($activ, $result)
{

  if ($activ == "ae1") {
    if ($result == 1) {
      return "orange";
    } elseif ($result == 2) {
      return "yellow";
    } elseif ($result == 3 || $result == 4) {
      return "green";
    }
  } elseif ($activ == "ae2") {
    if ($result == 1 || $result == 2) {
      return "orange";
    } elseif ($result == 3) {
      return "yellow";
    } elseif ($result == 4) {
      return "green";
    }
  } elseif ($activ == "ae3") {
    if ($result == 1 || $result == 2) {
      return "magenta";
    } elseif ($result == 3 || $result == 4) {
      return "green";
    }
  } elseif ($activ == "tp") {
    if ($result == 1 || $result == 2) {
      return "yellow";
    } elseif ($result == 3 || $result == 4) {
      return "green";
    }
  } elseif ($activ == "test") {
    if ($result == 1 || $result == 2) {
      return "magenta";
    } elseif ($result == 3 || $result == 4) {
      return "green";
    }
  } else {
    return "white";
  }
}



function generateTable($userData)
{
  $linesA = read("activite.txt");

  $html = "<table border=1>";
  $html .= "<tr>";
  $html .= "<th>Activité</th>";
  $html .= "<th>Nombre de tentative</th>";
  $html .= "<th>Contexte</th>";
  $html .= "<th>Resultat</th>";
  $html .= "<th>Semaine</th>";
  $html .= "</tr>";
  for ($i = 1; $i < count($userData); $i++) {
    $html .= "<tr style='background-color:" . getCouleur($linesA[$i-1][0], $userData[$i][2]) . "'>";
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






if (isset($_SESSION['User'])) {
  if ($_SESSION['User'][0] == "P" and $_SESSION['User'][1] == "A") {



    echo '<a href="logout.php?logout">Logout</a>';

    $lines = read("activite.txt");


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


    <form action="store.php" method="post">
    <h2>Contexte</h2>
    ';


    $html .= "<select name='activite'>";
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



    echo generateTable(getUserData());
  } else {
    header("Location: index.php");
  }
} else {
  header("Location: index.php");
}
