<?php
namespace AILearn\ai_learn\Controller;
ob_start();
use AILearn\ai_learn\AILearnPlugin;
use mk_file_folder_manager;

class loginController
{


  public function __construct()
  {
    $this->init_hooks();
  }




  public function init_hooks()
  {
    add_action('from_menu', [$this, 'store_login']);
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

  public static function render(string $name, array $args = []): void
  {
      extract($args);

      $file = AILEARN_PLUGIN_DIR . "views/$name.php";

      ob_start();

      include_once($file);

      echo ob_get_clean();
  }


  public static function is_connected()
  {
    if (isset($_SESSION['username'])) {
      return true;
    } else {
      return false;
    }
  }

  public static function getUserUsername()
  {
    if (isset($_SESSION['username'])) {
      return $_SESSION['username'];
    } else {
      return false;
    }
  }


  public static function store_login(){
        if (isset($_POST['username'])&&isset($_POST['Password'])) {
          $username = $_POST['username'];
          $password = $_POST['Password'];
          $lines =  loginController::read('wp-content\plugins\AILearn\file\login.txt', "r");
          foreach ($lines as $line) {
            if ($line[0] == $username && $line[1] == $password) {
              $_SESSION['username'] = $username;
            }
          }
        }

        if(isset($_SESSION['username'])){
            echo "<a href='".wp_logout_url()."'>logout</a>";
            wp_redirect(home_url('/'));
            exit();

        }
        else{


          echo "<form action='' method='post'>
          <input type='text' name='username' placeholder='username'>
          <input type='password' name='Password' placeholder='Password'>
          <input type='submit' value='login'>
          </form>";

          
        }
}
}
?>