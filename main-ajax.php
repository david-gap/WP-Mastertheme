<?php
/**
 *
 *
 * Ajax actions
 *
 * @author      David Voglgsang
 * @version     1.1
 *
*/

// Get variables from ajax request
$access = isset($_POST['access']) ? $_POST['access'] : $_GET['access'];
$run_action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

if($access == 'granted'):

  /* CONNECT TO DATABASE
  /===================================================== */
  $allow_connection = array('loadPageContent', 'loadEntryInfo');
  if(in_array($run_action, $allow_connection)):
      $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
      $url = $_SERVER['REQUEST_URI'];
      $my_url = explode('wp-content' , $url);
      $path = $_SERVER['DOCUMENT_ROOT']."/".$my_url[0];
      include_once $path . '/wp-config.php';
      include_once $path . '/wp-includes/wp-db.php';
      include_once $path . '/wp-includes/pluggable.php';
      include_once $path . '/wp-admin/includes/user.php';
  endif;


  /* GET POST CONTENT
  /------------------------*/
  function loadPostContent(){
    if($_POST['id']):
      $blocks = parse_blocks( get_the_content( null, false, $_POST['id'] ) );
      $content = '';
      foreach ( $blocks as $block ) {
          $content .= render_block( $block );
      }
      $content = apply_filters( 'template_loadPostContent', $content, $_POST['id'] );
      // $content = get_the_content( null, false, $_POST['id'] );
      $return = array(
        'targetContent' => $_POST['targetContent'] ? str_replace('\\', '', $_POST['targetContent']) : '',
        'content' => $content
      );
    else:
      $return = array(
        'log' => 'ID is missing'
      );
    endif;
    echo json_encode($return);
  }


  /* GET POST CONTENT
  /------------------------*/
  function entryInfo(){
    if($_POST['id']):
      $content = '';
      $currentPostType = get_post_type($_POST['id']);
      if($currentPostType == 'attachment'):
        $post = get_post($_POST['id']);
        $content .= '<h3>' . $post->post_title . '</h3>';
        // $content .= '<p>' . $post->post_content . '</p>';
        $content .= '<div class="excerpt">' . $post->post_excerpt . '</div>';
      else:
        $content .= '<h3>' . get_the_title($_POST['id']) . '</h3>';
        $content .= '<div class="excerpt">' . get_the_excerpt($_POST['id']) . '</div>';
      endif;
      $postTax = get_object_taxonomies($currentPostType, 'objects');
      if($postTax):
        foreach ($postTax as $tax => $obj) {
          if($obj->name == "language"):
          else:
            $taxValues = wp_get_object_terms($_POST['id'], $obj->name,  array("fields" => "names"));
            if($taxValues):
              $content .= '<div class="tax-group">';
              $content .= '<h4>' . $obj->label . '</h4>';
              $content .= prefix_core_BaseFunctions::ListTaxonomies($obj->name, $_POST['id'], false, ',');
              $content .= '</div>';
            endif;
          endif;
        }
      endif;
      $content .= prefix_template::postMeta($currentPostType, array(), 1, $_POST['id']);
      $content = apply_filters( 'template_entryInfo', $content, $_POST['id'] );
      $return = array(
        'targetContent' => $_POST['targetContent'] ? str_replace('\\', '', $_POST['targetContent']) : '',
        'content' => $content

      );
    else:
      $return = array(
        'log' => 'ID is missing'
      );
    endif;
    echo json_encode($return);
  }



  /* RUN FUNCTIONS
  /===================================================== */
  switch ($run_action) {
    case "loadPageContent":
      loadPostContent();
      break;
    case "loadEntryInfo":
      entryInfo();
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
