<?
/**
 *
 *
 * Ajax actions
 * Author:      David Voglgsnag
 */

// Get variables from ajax request
$run_action = $_POST['action'] ? $_POST['action'] : $_GET['action'];

if($run_action) {

  /* CONNECT TO DATABASE
  /===================================================== */
  $allow_connection = array('SaveFormInput', 'GeneratConfigFile');
  if(in_array($run_action, $allow_connection)):
      $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
      $url = $_SERVER['REQUEST_URI'];
      $my_url = explode('wp-content' , $url);
      $path = $_SERVER['DOCUMENT_ROOT']."/".$my_url[0];
      include_once $path . '/wp-config.php';
      include_once $path . '/wp-includes/wp-db.php';
      include_once $path . '/wp-includes/pluggable.php';
  endif;



  /* FUNCTIONS
  /===================================================== */

  /* SAVE BACKEND CONFIGURATION
  /------------------------*/
  function SaveFormInput(){
    // get
    $fields  = unserialize($_POST['formdata']);
    $fields  = serialize($fields);
    $fields = array();
    parse_str($_POST['formdata'], $fields);
    // clean array
    $fields = prefix_core_BaseFunctions::CleanArray($fields, 3);
    // check if option exists
    $db_option = get_option('WPadmin_configuration') ? true : false;
    // save values
    if($db_option !== false):
      $return = array(
        'message' => __('Configuration updated','WPadmin'),
        'type' => 'success'
      );
      update_option('WPadmin_configuration', $fields, false);
    else:
      $return = array(
        'message' => __('Configuration saved','WPadmin'),
        'type' => 'success'
      );
      add_option('WPadmin_configuration', $fields, '', false);
    endif;
    echo json_encode($return);
  }


  /* SAVE CONFIGURATIN FILE
  /------------------------*/
  function GeneratConfigFile(){
    $db_option = get_option('WPadmin_configuration') ? get_option('WPadmin_configuration') : false;
    // check if configurations been saved
    if($db_option !== false):
      $configuration_file = get_stylesheet_directory() . '/configuration.json';
      $return = array(
        'message' => __('Configuration file created','WPadmin'),
        'type' => 'success'
      );
      $fp = fopen($configuration_file, 'w');
      fwrite($fp, json_encode($db_option));
      fclose($fp);
    else:
      $return = array(
        'message' => __('Configuration Missing','WPadmin'),
        'type' => 'error'
      );
    endif;
    echo json_encode($return);
  }


  /* DEMO
  /------------------------*/
  function Demo(){
    $return = array(
      'message' => 'message',
      'type' => 'success or error',
      'log' => 'Log'
    );
    echo json_encode($return);
  }



  /* RUN FUNCTIONS
  /===================================================== */
  switch ($run_action) {
    case "SaveFormInput":
      SaveFormInput();
      break;
    case "GeneratConfigFile":
      GeneratConfigFile();
      break;
    default:
      echo "no access granted";
  }

}
