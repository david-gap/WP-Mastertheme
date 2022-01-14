<?php
/**
 *
 *
 * Posts filter ajax
 *
 * @author      David Voglgsang
 * @version     1.0
 *
*/

// Get variables from ajax request
$access = isset($_POST['access']) ? $_POST['access'] : $_GET['access'];
$run_action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

if($access == 'granted'):

  /* CONNECT TO DATABASE
  /===================================================== */
  $allow_connection = array('loadPosts');
  if(in_array($run_action, $allow_connection)):
      $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
      $url = $_SERVER['REQUEST_URI'];
      $my_url = explode('wp-content' , $url);
      $path = $_SERVER['DOCUMENT_ROOT']."/".$my_url[0];
      include_once $path . '/wp-config.php';
      include_once $path . '/wp-includes/wp-db.php';
      include_once $path . '/wp-includes/pluggable.php';
      include_once $path . '/wp-admin/includes/user.php';
      include_once $path . '/wp-content/themes/mastertheme/classes/prefix_WPgutenberg/blocks/postsfilter/index.php';
  endif;



  /* LOAD POSTS
  /------------------------*/
  function filterPosts(){
    $output = '';
    $output .= WPgutenberg_postsfilter_getResultsAndSort($_POST, 'ajax');
    $return = array(
      'action' => 'insertFilteredPosts',
      'id' => $_POST['id'],
      'content' => $output
    );
    echo json_encode($return);
  }



  /* RUN FUNCTIONS
  /===================================================== */
  switch ($run_action) {
    case "loadPosts":
      filterPosts();
      break;

    default:
      echo "Keine Aktion definiert";
  }

else:
  $return = array(
    'log' => 'access denied'  // return in the console
  );
  echo json_encode($return);
endif;
