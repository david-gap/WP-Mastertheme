<?

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
    ),
    // 'render_callback' => function($atts) {
    //   return SELF::WPgutenberg_blockRender_posts($atts);
    // }
    'render_callback' => 'WPgutenberg_blockRender_posts'
  )
);

function WPgutenberg_block_postsValue($value, $id){
  switch ($value) {
    case "title":
      return get_the_title($id);
      break;
    case "date":
      return get_the_date('d.m.Y', $id);
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

// post results
function WPgutenberg_postresults_postssorting(array $attr, string $source = 'first_load'){
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
      $thefilter = explode("__", $attr['postTaxonomyFilter']);
      foreach ($thefilter as $key => $value) {
        $stringToArray = explode("-", $value);
        $filter[$stringToArray[0]][] = $stringToArray[1];
      }
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
  if(!in_array($attr['postSortBy'], array('title', 'date', 'menu_order'))):
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
  $filter_query = new WP_Query( $queryArgs );
  // output
  $output = '';
  if ( $filter_query->have_posts() ) :
    while ( $filter_query->have_posts() ) : $filter_query->the_post();
      $output .= '<li data-id="' . get_the_ID() . '">';
        $get_url = get_post_meta(get_the_ID(), 'BlockUrl', true) ? get_post_meta(get_the_ID(), 'BlockUrl', true) : get_the_permalink();
        $linkOpen = $get_url && $get_url !== '' ? '<a href="' . $get_url . '">' : '';
        $linkClose = $get_url && $get_url !== '' ? '</a>' : '';
        if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_box', $attr['postTaxonomyFilterOptions'])):
          $output .= $linkOpen;
        endif;
          // add post thumbnail
          if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_img', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
            $output .= $linkOpen;
          endif;
            if(array_key_exists('postThumb', $attr) && $attr['postThumb'] !== false):
            if($attr['postType'] == 'attachment'):
              $mineType = get_post_mime_type();
              $audioType = ['audio/mpeg3', 'audio/x-mpeg-3', 'video/mpeg', 'video/x-mpeg', 'audio/m4a', 'audio/ogg', 'audio/wav', 'audio/x-wav', 'audio/mpeg'];
              $videoType = ['video/mp4', 'video/x-m4v', 'video/quicktime', 'video/x-ms-asf', 'video/x-ms-wmv', 'application/x-troff-msvideo', 'video/avi', 'video/msvideo', 'video/x-msvideo', 'video/ogg', 'video/3gpp', 'audio/3gpp', 'video/3gpp2', 'audio/3gpp2', 'video/mpeg'];
              if(in_array($mineType, $audioType)):
                $file = '<audio controls src="' . wp_get_attachment_url(get_the_id()) . '" data-id="' . get_the_id() . '" />';
              elseif (in_array($mineType, $videoType)):
                $file = '<video controls src="' . wp_get_attachment_url(get_the_id()) . '" data-id="' . get_the_id() . '" />';
              else:
                $file = wp_get_attachment_image(get_the_id(), 'full', true, array("data-id" => get_the_id()));
              endif;
              $output .= '<figure>' . $file . '</figure>';
            else:
              $output .= get_the_post_thumbnail() ? '<figure>' . get_the_post_thumbnail(get_the_id(), 'full', array("data-id" => get_the_id())) . '</figure>' : '';
            endif;
            endif;
          if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_img', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
            $output .= $linkClose;
          endif;
          // add content
          $output .= '<div class="post-content">';
            if(array_key_exists('postTextOne', $attr) && $attr['postTextOne'] !== ''):
              $output .= $attr['postTextOne'] == 'title' ? '<h4>' : '<div>';
                if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_row1', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
                  $output .= $linkOpen;
                endif;
                  $output .= WPgutenberg_block_postsValue($attr['postTextOne'], get_the_ID());
                if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_row1', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
                  $output .= $linkClose;
                endif;
              $output .= $attr['postTextOne'] == 'title' ? '</h4>' : '</div>';
            endif;
            if(array_key_exists('postTextTwo', $attr) && $attr['postTextTwo'] !== ''):
              $output .= $attr['postTextTwo'] == 'title' ? '<h4>' : '<div>';
                if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_row2', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
                  $output .= $linkOpen;
                endif;
                  $output .= WPgutenberg_block_postsValue($attr['postTextTwo'], get_the_ID());
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
    endwhile;
    wp_reset_postdata();
    // grid fixer
    // if(array_key_exists('postSwiper', $attr) && $attr['postSwiper'] !== true && array_key_exists('postColumns', $attr) && $attr['postColumns'] > 1):
    //   for ($x = 1; $x < $attr['postColumns']; $x++) {
    //     $output .= '<span class="grid-fixer"></span>';
    //   }
    // endif;
  else:
    $output .= '<li class="wide"><p class="no-results">' . __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'WPgutenberg' ) . '</p></li>';
  endif;
  return $output;
}

// callback function
function WPgutenberg_blockRender_posts($attr){
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
                $name = $term['label'];
              else:
                $name = __( $value, 'WPgutenberg' );
              endif;
            else:
              $name = __( $value, 'WPgutenberg' );
            endif;
            $sortd = $value == $attr['postSortBy'] ? $attr['postSortDirection'] : 'asc';
            $sort_css = '';
            $sort_css .= $value == $attr['postSortBy'] ? 'active' : "";
            $sort_css .= $sortd == 'desc' ? ' z-a' : "";
            $output .= '<label data-sort="' . $value . '" data-sortd="' . $sortd . '" tabindex="0" class="' . $sort_css . '">';
              $output .= '<span class="sort-name">' . $name . '</span>';
              $output .= '<span class="sort-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="9.155" height="4.926" viewBox="0 0 9.155 4.926"><path d="M4.66 4.922a.88.88 0 0 0 .487-.208l3.676-3.158A.876.876 0 1 0 7.684.225l-3.11 2.667L1.464.225A.876.876 0 1 0 .328 1.556l3.68 3.154a.879.879 0 0 0 .652.208z" fill="#000"/></svg></span>';
            $output .= '</label>';
          }
          // fields to resort
          $output .= '<form class="thefilter">';
            if(array_key_exists('postTaxonomyFilter', $attr)):
              $output .= '<input type="hidden" name="postTaxonomyFilter" value="' . implode('__', $attr['postTaxonomyFilter']) . '">';
            endif;
            $output .= '<input type="hidden" name="postTaxonomyFilterRelation" value="' . $attr['postTaxonomyFilterRelation'] . '">';
            $output .= '<input type="hidden" name="postType" value="' . $attr['postType'] . '">';
            $output .= '<input type="hidden" name="postSortBy" value="' . $postSortBy . '">';
            $output .= '<input type="hidden" name="postSortDirection" value="' . $attr['postSortDirection'] . '">';
            if(array_key_exists('postTaxonomyFilterOptions', $attr)):
              $output .= '<input type="hidden" name="postTaxonomyFilterOptions" value="' . implode('__', $attr['postTaxonomyFilterOptions']) . '">';
            endif;
            $output .= '<input type="hidden" name="postTextOne" value="' . $attr['postTextOne'] . '">';
            $output .= '<input type="hidden" name="postTextTwo" value="' . $attr['postTextTwo'] . '">';
            $output .= '<input type="hidden" name="postThumb" value="' . $attr['postThumb'] . '">';
            $output .= '<input type="hidden" name="postColumns" value="' . $columns . '">';
          $output .= '</form>';
        endif;
      $output .= '</div>';
    endif;
    // posts
    $output .= '<ul>';
      $output .= WPgutenberg_postresults_postssorting($attr);
    $output .= '</ul>';
  $output .= '</div>';

  return $output;
}

?>
