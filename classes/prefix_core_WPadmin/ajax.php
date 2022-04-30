<?php
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
  $allow_connection = array('SaveFormInput', 'GenerateConfigFile', 'GenerateCssFile');
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
    // $fields  = unserialize($_POST['formdata']);
    // $fields  = serialize($fields);
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
  function GenerateConfigFile(){
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
    // check for classes actions on publish
    // $registered_classes = get_declared_classes();
    // foreach ($registered_classes as $class_key => $classname) {
    //   if(strpos($classname, 'prefix_') === 0 && strpos($classname, '_core_') == false && method_exists($classname, 'returnCustomPublishAction')):
    //     $return['message'] .= $classname::returnCustomPublishAction();
    //   endif;
    // }
    echo json_encode($return);
  }


  /* GENERATE CSS FILE
  /------------------------*/
  function GenerateCssFile(){
    $css = prefix_WPinit::BuildCustomCSS(false);
    if($css !== ''):
      ob_start();
        header("Content-Disposition: attachment; filename=\"custom.css\"");
        header('Content-type: text/css');
        header("Content-Type: application/force-download");
        header("Connection: close");
        echo $css;
        $file_content = ob_get_contents();
      ob_end_clean();
      // custom css exists
      $return = array(
        'message' => __('New css file been created','WPadmin'),
        'type' => 'success',
        'file' => 'data:text/css;base64,' . base64_encode($file_content),
        'name' => 'custom.css'
      );
    else:
      // no custom css been defined
      $return = array(
        'message' => __('No css defined','WPadmin'),
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
      'log' => 'Log',
      'file' => 'file_content_to_download',
      'name' => 'file.name'
    );
    echo json_encode($return);
  }



  /* RUN FUNCTIONS
  /===================================================== */
  switch ($run_action) {
    case "SaveFormInput":
      SaveFormInput();
      break;
    case "GenerateConfigFile":
      GenerateConfigFile();
      break;
    case "GenerateCssFile":
      GenerateCssFile();
      break;
    default:
      echo "no access granted";
  }

}
