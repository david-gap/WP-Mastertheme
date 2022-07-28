<?php

// register block
register_block_type(
  'templates/posts',
  array(
    'editor_script' => 'gutenberg-blockposts',
    'attributes' => array(
      'anchor' => array(
        'type' => 'string'
      ),
      'postTaxonomyFilter' => array(
        'type' => 'array'
      ),
      'postTaxonomyFilterRelation' => array(
        'type' => 'string'
      ),
      'className' => array(
        'type' => 'string'
      ),
      'postType' => array(
        'type' => 'string',
        'default' => 'post'
      ),
      'postSum' => array(
        'type' => 'number',
        'default' => 10
      ),
      'postRepeater' => array(
        'type' => 'boolean',
        'default' => true,
      ),
      'postSortBy' => array(
        'type' => 'string',
        'default' => 'menu_order'
      ),
      'postSortDirection' => array(
        'type' => 'string',
        'default' => 'asc'
      ),
      'postTextOne' => array(
        'type' => 'string',
        'default' => 'title'
      ),
      'postTextTwo' => array(
        'type' => 'string',
        'default' => 'date'
      ),
      'postColumns' => array(
        'type' => 'number',
        'default' => 1
      ),
      'postColumnsSpace' => array(
        'type' => 'number',
        'default' => 20
      ),
      'postThumb' => array(
        'type' => 'boolean',
        'default' => true
      ),
      'postSwiper' => array(
        'type' => 'boolean',
        'default' => false
      ),
      'postPopUp' => array(
        'type' => 'boolean',
        'default' => false
      ),
      'postPopUpNav' => array(
        'type' => 'boolean',
        'default' => false
      ),
      'postSortNav' => array(
        'type' => 'boolean',
        'default' => false
      ),
      'postsInsideLoad' => array(
        'type' => 'boolean',
        'default' => false
      ),
      'postsInsideLoadFirst' => array(
        'type' => 'boolean',
        'default' => false
      ),
    ),
    'render_callback' => 'WPgutenberg_posts_blockRender'
  )
);

function WPgutenberg_posts_ContentRow($value, $id){
  switch ($value) {
    case "title":
      return get_the_title($id);
      break;
    case "date":
      return get_the_date('d.m.Y', $id);
      break;
    case "template":
      ob_start();
      if(get_post_type($id) == "post" || post_type_supports(get_post_type($id), 'post-formats')):
        $blog_type = get_post_format($id) ? get_post_format($id) : "default";
        global $post;
        $post = get_post($id);
        setup_postdata($post);
        // blog output
        if(locate_template('template_parts/' . get_post_type($id) . '_' . $blog_type . '.php')):
          get_template_part('template_parts/' . get_post_type($id) . '_' . $blog_type, '', array('id' => $id));
        else:
          get_template_part('template_parts/post_' . $blog_type, '', array('id' => $id));
        endif;
      else:
        // default output
        get_template_part('template_parts/post_default', '', array('id' => $id));
      endif;
      return ob_get_clean();
      break;
    case "templateMedia":
      ob_start();
      if(get_post_type($id) == "post" || post_type_supports(get_post_type($id), 'post-formats')):
        $blog_type = get_post_format($id) ? get_post_format($id) : "default";
        global $post;
        $post = get_post($id);
        setup_postdata($post);
        // blog output
        if(locate_template('template_parts/' . get_post_type($id) . '_' . $blog_type . '.php')):
          get_template_part('template_parts/' . get_post_type($id) . '_' . $blog_type, '', array('id' => $id, 'mediaOnly' => 1));
        else:
          get_template_part('template_parts/post_' . $blog_type, '', array('id' => $id, 'mediaOnly' => 1));
        endif;
      else:
        // default output
        get_template_part('template_parts/post_default', '', array('id' => $id, 'mediaOnly' => 1));
      endif;
      return ob_get_clean();
      break;
    case "excerpt":
      return get_the_excerpt($id);
      break;

    default:
      if(substr($value, 0, 5) === "tax__"):
        $cleanTax = str_replace('tax__', '', $value);
        return prefix_core_BaseFunctions::ListTaxonomies($cleanTax, $id, false, ', ');
      else:
        if(strpos($value, 'Image') !== false):
          $get_meta = get_post_meta($id, $value, true);
          $img_url = wp_get_attachment_image($get_meta, 'full' );
          if($img_url):
            return '<figure>' . $img_url . '</figure>';
          endif;
        else:
          $metaValue = get_post_meta($id, $value, true);
          if(is_array($metaValue)):
            foreach ($metaValue as $key => $value) {
              return '<span>' . get_the_title($value) . '</span>';
            }
          else:
            return $metaValue;
          endif;
        endif;
      endif;
  }
}

// post builder
function WPgutenberg_posts_PostBuilder(array $attr, $id, $currentId){

  $addClass = $currentId === $id ? ' class="current-item"' : '';
  $pageOptions = prefix_template::PageOptions($id);

  $output = '';
  $output .= '<li data-id="' . $id . '"' . $addClass . '>';
    $defaultUrl = !in_array('disableDetailpage', $pageOptions) ? get_the_permalink($id) : '';
    $get_url = get_post_meta($id, 'BlockUrl', true) ? get_post_meta($id, 'BlockUrl', true) : $defaultUrl;
    if(array_key_exists('postsInsideLoad', $attr) && $attr['postsInsideLoad'] !== false && $attr['postsInsideLoad'] !== 0):
      $linkOpen = '<span data-load="content">';
      $linkClose = '</span>';
    else:
      $linkOpen = $get_url && $get_url !== '' ? '<a href="' . $get_url . '">' : '';
      $linkClose = $get_url && $get_url !== '' ? '</a>' : '';
    endif;
    if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_box', $attr['postTaxonomyFilterOptions'])):
      $output .= $linkOpen;
    endif;
      // add post thumbnail
      if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_img', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
        $output .= $linkOpen;
      endif;
        if(array_key_exists('postThumb', $attr) && $attr['postThumb'] !== false):
        if($attr['postType'] == 'attachment'):
          $mineType = get_post_mime_type($id);
          $audioType = ['audio/mpeg3', 'audio/x-mpeg-3', 'video/mpeg', 'video/x-mpeg', 'audio/m4a', 'audio/ogg', 'audio/wav', 'audio/x-wav', 'audio/mpeg'];
          $videoType = ['video/mp4', 'video/x-m4v', 'video/quicktime', 'video/x-ms-asf', 'video/x-ms-wmv', 'application/x-troff-msvideo', 'video/avi', 'video/msvideo', 'video/x-msvideo', 'video/ogg', 'video/3gpp', 'audio/3gpp', 'video/3gpp2', 'audio/3gpp2', 'video/mpeg'];
          if(in_array($mineType, $audioType)):
            $file = '<audio controls src="' . wp_get_attachment_url($id) . '" data-id="' . $id . '" />';
          elseif (in_array($mineType, $videoType)):
            $file = '<video controls src="' . wp_get_attachment_url($id) . '" data-id="' . $id . '" />';
          else:
            $file = wp_get_attachment_image($id, 'full', true, array("data-id" => $id));
          endif;
          $output .= '<figure>' . $file . '</figure>';
        else:
          $output .= get_the_post_thumbnail($id) ? '<figure>' . get_the_post_thumbnail($id, 'full', array("data-id" => $id)) . '</figure>' : '';
        endif;
        endif;
      if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_img', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
        $output .= $linkClose;
      endif;
      // add content
      $output .= '<div class="post-content">';
        if(array_key_exists('postTextOne', $attr) && $attr['postTextOne'] !== ''):
          $output .= $attr['postTextOne'] == 'title' ? '<h4>' : '<div class="' . $attr['postTextOne'] . '">';
            if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_row1', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
              $output .= $linkOpen;
            endif;
              $output .= WPgutenberg_posts_ContentRow($attr['postTextOne'], $id);
            if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_row1', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
              $output .= $linkClose;
            endif;
          $output .= $attr['postTextOne'] == 'title' ? '</h4>' : '</div>';
        endif;
        if(array_key_exists('postTextTwo', $attr) && $attr['postTextTwo'] !== ''):
          $output .= $attr['postTextTwo'] == 'title' ? '<h4>' : '<div class="' . $attr['postTextTwo'] . '">';
            if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_row2', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
              $output .= $linkOpen;
            endif;
              $output .= WPgutenberg_posts_ContentRow($attr['postTextTwo'], $id);
            if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_row2', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
              $output .= $linkClose;
            endif;
          $output .= $attr['postTextTwo'] == 'title' ? '</h4>' : '</div>';
        endif;
      $output .= '</div>';
      if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_box', $attr['postTaxonomyFilterOptions'])):
        $output .= $linkClose;
      endif;
  $output .= '</li>';
  return $output;
}

// post results
function WPgutenberg_posts_getResultsAndSort(array $attr, string $source = 'first_load'){
  // sort direction
  $postSortBy = in_array($attr['postSortBy'], array('title', 'date', 'menu_order')) ? $attr['postSortBy'] : 'meta_value';
  // add filter
  $filter = [];
  if(array_key_exists('postTaxonomyFilter', $attr)):
    if($source == 'first_load'):
      foreach ($attr['postTaxonomyFilter'] as $key => $value) {
        $stringToArray = explode("-", $value);
        // if(array_key_exists($stringToArray[0], $filter)):
        //   $filter[$stringToArray[0]] = [];
        // endif;
        $filter[$stringToArray[0]][] = $stringToArray[1];
      }
    elseif($source == 'ajax'):
      if($attr['postTaxonomyFilter'] !== ''):
        $thefilter = explode("__", $attr['postTaxonomyFilter']);
        foreach ($thefilter as $key => $value) {
          $stringToArray = explode("-", $value);
          $filter[$stringToArray[0]][] = $stringToArray[1];
        }
      endif;
      if($attr['postTaxonomyFilterOptions'] !== ''):
        $attr['postTaxonomyFilterOptions'] = explode("__", $attr['postTaxonomyFilterOptions']);
      endif;
    endif;
  endif;
  if(!empty($filter)):
    $term_array = array('relation' => $attr['postTaxonomyFilterRelation']);
    foreach ($filter as $key => $value) {
      if($key == 'categories'):
        $catName = 'category';
        $isTax = true;
      elseif($key == 'tags'):
        $tagsToQuery = implode(',', $value);
        $isTax = false;
      else:
        $catName = $key;
        $isTax = true;
      endif;
      if($isTax):
          $meta_check = array(
            'taxonomy'  => $catName,
            'field'     => 'id',
            'terms'     => $value,
            'operator' => 'IN'
          );
          $term_array[] = $meta_check;
      endif;
    }
  endif;
  // add query
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
  $queryArgs = array(
    'post_type'=> $attr['postType'],
    'post_status'=>'publish',
    'posts_per_page'=> $attr['postSum'],
    'paged' => $paged,
    'orderby' => $postSortBy,
    'order' => $attr['postSortDirection']
  );
  if(strpos($attr['postSortBy'], 'tax__') !== false):
    // sort by taxonomy
    $cleanTax = str_replace('tax__', '', $attr['postSortBy']);
    $terms = get_terms($cleanTax);
  elseif(!in_array($attr['postSortBy'], array('title', 'date', 'menu_order'))):
    $queryArgs['meta_key'] = $attr['postSortBy'];
  endif;
  if($attr['postType'] == 'attachment'):
    $queryArgs['post_status'] = 'inherit';
  endif;
  if(array_key_exists('postIdFilter', $attr)):
   $queryArgs['post__in'] = $attr['postIdFilter'];
  else:
    $queryArgs['tax_query'] = $term_array;
    if($tagsToQuery):
      $queryArgs['tag_id'] = $tagsToQuery;
    endif;
  endif;
  // language
  if($source == 'ajax' && array_key_exists('language', $attr) && $attr['language'] !== ""):
    $queryArgs['lang'] = $attr['language'];
  endif;
  // apply query filter
  $queryArgs = apply_filters( 'WPgutenberg_filter_posts_query', $queryArgs );
  // call posts
  $filter_query = new WP_Query( $queryArgs );
  // output
  $allPosts = array();
  $output = '';
  if ( $filter_query->have_posts() ) :
    while ( $filter_query->have_posts() ) : $filter_query->the_post();
      $key = get_the_ID();
      $allPosts[$key] = get_the_ID();
    endwhile;
    wp_reset_postdata();
    // apply filter to resulted ids
    $allPosts = apply_filters( 'WPgutenberg_filter_posts_results', $allPosts, $attr );

    // current page
    $obj = get_queried_object();
    $currentId = $obj && property_exists($obj, 'ID') ? $obj->ID : 0;
    if($terms):
      // sort query by taxonomy
      $termsGroup = array();
      foreach ($terms as $key => $term) {
        $termsGroup[$key] = array($term->term_id, $term->name);
      }
      $termsSorted = prefix_core_BaseFunctions::MultidArraySort($termsGroup, 1, $attr['postSortDirection'], false);
      // regroup
      $groupedIds = array();
      foreach ($termsSorted as $key => $term) {
        $groupedIds[$term["0"]] = array();
        foreach ($allPosts as $key => $postID) {
          $post_terms = wp_get_object_terms( $postID, $cleanTax, array( 'fields' => 'ids' ) );
          if(in_array($term["0"], $post_terms)):
            // check primary taxonomy
            $primary_term = intval(get_post_meta( $postID, '_primary_term_' . $cleanTax, true ));
            if($primary_term == 0 || $primary_term > 0 && $primary_term == $term["0"]):
              $groupedIds[$term["0"]][$postID] = $postID;
              unset($allPosts[$key]);
            endif;
          endif;
        }
      }
      // insert all posts without term to a special array
      $groupedIds["no-term"] = $allPosts;
      // set taxonomy filter
      $groupedIds = apply_filters( 'WPgutenberg_filter_posts_taxSorting', $groupedIds, $attr );
      // return by taxonomy
      $sum = 0;

      foreach ($groupedIds as $termkey => $termgroup) {
        if(is_array($termgroup) && !empty($termgroup)):
          foreach ($termgroup as $idkey => $id) {
            // taxonomy is not empty
            $sum++;
            $output .= WPgutenberg_posts_PostBuilder($attr, $id, $currentId);
          }
        endif;
      }
      // repeat posts
      if($attr['postRepeater'] && $sum < $attr['postSum']):
        while($sum < $attr['postSum']){
          if(is_array($termgroup) && !empty($termgroup)):
            foreach ($termgroup as $idkey => $id) {
              // taxonomy is not empty
              if($sum < $attr['postSum']):
                $sum++;
                $output .= WPgutenberg_posts_PostBuilder($attr, $id, $currentId);
              else:
                break;
              endif;
            }
          endif;
        }
      endif;
    else:
      foreach ($allPosts as $key => $postID) {
        $sum++;
        $output .= WPgutenberg_posts_PostBuilder($attr, $postID, $currentId);
      }
      // repeat posts
      if($attr['postRepeater'] && $sum < $attr['postSum']):
        while($sum < $attr['postSum']){
          foreach ($allPosts as $key => $postID) {
            if($sum < $attr['postSum']):
              $sum++;
              $output .= WPgutenberg_posts_PostBuilder($attr, $postID, $currentId);
            else:
            //  break;
            endif;
          }
        }
      endif;
    endif;
    // grid fixer
    // if(array_key_exists('postSwiper', $attr) && $attr['postSwiper'] !== true && array_key_exists('postColumns', $attr) && $attr['postColumns'] > 1):
    //   for ($x = 1; $x < $attr['postColumns']; $x++) {
    //     $output .= '<span class="grid-fixer"></span>';
    //   }
    // endif;
  else:
    $output .= '<li class="wide"><p class="no-results">' . __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'devTheme' ) . '</p></li>';
  endif;

  return $output;
}


// callback function
function WPgutenberg_posts_blockRender($attr){
  $output = '';
  $css = '';
  $inlinecss = '';
  // add edvanced options (ID/CSS)
  $id = array_key_exists('anchor', $attr) ? ' id="' . $attr['anchor'] . '"' : '';
  $css .= array_key_exists('className', $attr) ? ' ' . $attr['className'] : '';
  $css .= array_key_exists('align', $attr) ? ' align' . $attr['align'] : '';
  // add swiper
  $css .= array_key_exists('postSwiper', $attr) && $attr['postSwiper'] !== false ? ' gallery-swiper' : ' gallery-grid';
  // add popup
  $css .= array_key_exists('postPopUp', $attr) && $attr['postPopUp'] !== false ? ' add-popup' : '';
  $css .= array_key_exists('postPopUpNav', $attr) && $attr['postPopUpNav'] !== false ? ' popup-preview' : '';
  // reset spacing if only one column
  $spacing = $attr['postColumnsSpace'];
  // inline stylings
  $columns = array_key_exists('postColumns', $attr) ? $attr['postColumns'] : 1;
  $inlinecss .= '--postColumns: ' . $columns . ';';
  $inlinecss .= ' --postColumnsSpace: ' . $spacing . 'px;';
  // build content
  $output .= '<div' . $id . ' class="block-posts' . $css . '" data-columnspace="' . $spacing . '" data-columns="' . $columns . '" style="' . $inlinecss . '">';
    // sort options
    if(array_key_exists('postSortNav', $attr) && $attr['postSortNav'] !== false):
      $output .= '<div class="sort-options">';
        if(array_key_exists('postSortNavOptions', $attr)):
          foreach ($attr['postSortNavOptions'] as $key => $value) {
            if (function_exists('acf_get_field')):
              $term = acf_get_field($value);
              if($term):
                $name = __( $term['label'], 'WPgutenberg-' . $attr['postType'] );
              else:
                $name = __( $value, 'WPgutenberg-' . $attr['postType'] );
              endif;
            else:
              $name = __( $value, 'WPgutenberg-' . $attr['postType'] );
            endif;
            $sortd = $value == $attr['postSortBy'] ? $attr['postSortDirection'] : 'asc';
            $sort_css = '';
            $sort_css .= $value == $attr['postSortBy'] ? 'active' : "";
            $sort_css .= $sortd == 'desc' ? ' z-a' : "";
            $output .= '<label data-sort="' . $value . '" data-sortd="' . $sortd . '" tabindex="0" class="' . $sort_css . '">';
              $output .= '<span class="sort-name">' . $name . '</span>';
              $output .= '<span class="sort-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="16.679" height="12.609" viewBox="0 0 16.679 12.609"><g transform="translate(-330.757 -433.378)"><g><line y1="1.05" x2="9" transform="matrix(-0.574, -0.819, 0.819, -0.574, 338.236, 443.67)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="3"/><line x2="9" y2="1.05" transform="matrix(0.574, -0.819, 0.819, 0.574, 339.096, 443.068)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="3"/></g></g></svg></span>';
            $output .= '</label>';
          }
          // fields to resort
          $output .= '<form class="thefilter">';
            $output .= '<input type="hidden" name="language" value="' . prefix_core_BaseFunctions::getCurrentLang() . '">';
            if(array_key_exists('postTaxonomyFilter', $attr)):
              $output .= '<input type="hidden" name="postTaxonomyFilter" value="' . implode('__', $attr['postTaxonomyFilter']) . '">';
            endif;
            $output .= '<input type="hidden" name="postSum" value="' . $attr['postSum'] . '">';
            $output .= '<input type="hidden" name="postRepeater" value="' . $attr['postRepeater'] . '">';
            $output .= '<input type="hidden" name="postTaxonomyFilterRelation" value="' . $attr['postTaxonomyFilterRelation'] . '">';
            $output .= '<input type="hidden" name="postType" value="' . $attr['postType'] . '">';
            $output .= '<input type="hidden" name="postSortBy" value="' . $attr['postSortBy'] . '">';
            $output .= '<input type="hidden" name="postSortDirection" value="' . $attr['postSortDirection'] . '">';
            if(array_key_exists('postTaxonomyFilterOptions', $attr)):
              $output .= '<input type="hidden" name="postTaxonomyFilterOptions" value="' . implode('__', $attr['postTaxonomyFilterOptions']) . '">';
            endif;
            $output .= '<input type="hidden" name="postTextOne" value="' . $attr['postTextOne'] . '">';
            $output .= '<input type="hidden" name="postTextTwo" value="' . $attr['postTextTwo'] . '">';
            $output .= '<input type="hidden" name="postThumb" value="' . $attr['postThumb'] . '">';
            $output .= '<input type="hidden" name="postColumns" value="' . $columns . '">';
            $output .= '<input type="hidden" name="postsInsideLoad" value="' . $attr['postsInsideLoad'] . '">';
            $output .= '<input type="hidden" name="postsInsideLoadFirst" value="' . $attr['postsInsideLoadFirst'] . '">';
          $output .= '</form>';
        endif;
      $output .= '</div>';
    endif;
    // posts
    $output .= '<ul>';
      $output .= WPgutenberg_posts_getResultsAndSort($attr);
    $output .= '</ul>';
    // container to load posts content into it
    if(array_key_exists('postsInsideLoad', $attr) && $attr['postsInsideLoad'] === true):
      $postsTargetAttr = '';
      $postsTargetAttr .= array_key_exists('postsInsideLoadFirst', $attr) && $attr['postsInsideLoadFirst'] === true ? 'data-load="true"' : 'data-load="false"';
      $postsTargetCss = array_key_exists('postsInsideLoadFirst', $attr) && $attr['postsInsideLoadFirst'] === true ? ' loading' : ' dn';
      $output .= '<div class="wp-block-group posts-target"><div class="wp-block-group__inner-container' . $postsTargetCss . '"' . $postsTargetAttr . '>';
      $output .= '</div></div>';
    endif;
  $output .= '</div>';

  return $output;
}

?>
