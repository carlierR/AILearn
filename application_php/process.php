<?php
session_start();
if (isset($_POST['Login'])) {
    if (empty($_POST['username']) || empty($_POST['Password'])) {
        header("location:index.php");
    } else {
        $myFile = "login.txt";
        $contents = file_get_contents($myFile);
        $contents = explode("\n", $contents);
        $islog = false;
        foreach ($contents as $values) {
            $loginInfo = explode(",", $values);

            if ($loginInfo[0] == $_POST['username'] &&  $loginInfo[1] == $_POST['Password']) {
                $_SESSION['User'] = $_POST['username'];
                header("location:eleve.php");
            }
        }
    } {
        header("location:index.php");
    }
}
