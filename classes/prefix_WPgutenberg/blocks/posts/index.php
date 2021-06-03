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
        'default' => 'date'
      ),
      'postSortDirection' => array(
        'type' => 'string',
        'default' => 'desc'
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
      )
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
        return get_post_meta($id, $value, true);
      endif;
  }
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
  $spacing = array_key_exists('postColumns', $attr) && $attr['postColumns'] > 1 ? $attr['postColumnsSpace'] : 0;
  // inline stylings
  $columns = array_key_exists('postColumns', $attr) ? $attr['postColumns'] : 1;
  $inlinecss .= '--postColumns: ' . $columns . ';';
  $inlinecss .= ' --postColumnsSpace: ' . $spacing . 'px;';
  // add filter
  $filter = [];
  if(array_key_exists('postTaxonomyFilter', $attr)):
    foreach ($attr['postTaxonomyFilter'] as $key => $value) {
      $stringToArray = explode("-", $value);
      if(array_key_exists($stringToArray[0], $filter)):
        $filter[$stringToArray[0]] = [];
      endif;
      $filter[$stringToArray[0]][] = $stringToArray[1];
    }
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
    'orderby' => $attr['postSortBy'],
    'order' => $attr['postSortDirection'],
    'tax_query' => $term_array
  );
  if($tagsToQuery):
    $queryArgs['tag_id'] = $tagsToQuery;
  endif;

  $filter_query = new WP_Query( $queryArgs );
  // build content
  if ( $filter_query->have_posts() ) :
    $output .= '<div' . $id . ' class="block-posts' . $css . '" data-columnspace="' . $spacing . '" data-columns="' . $columns . '" style="' . $inlinecss . '">';
      $output .= '<ul>';
        while ( $filter_query->have_posts() ) : $filter_query->the_post();
          $output .= '<li>';
            // add post thumbnail
            if(array_key_exists('postThumb', $attr) && $attr['postThumb'] !== false):
              $output .= get_the_post_thumbnail() ? '<figure>' . get_the_post_thumbnail(get_the_id(), 'full', array("data-id" => get_the_id())) . '</figure>' : '';
            endif;
            // add content
            if(array_key_exists('postTextOne', $attr) && $attr['postTextOne'] !== ''):
              $output .= '<h4>' . WPgutenberg_block_postsValue($attr['postTextOne'], get_the_ID()) . '</h4>';
            endif;
            if(array_key_exists('postTextTwo', $attr) && $attr['postTextTwo'] !== ''):
              $output .= '<span>' . WPgutenberg_block_postsValue($attr['postTextTwo'], get_the_ID()) . '</span>';
            endif;
          $output .= '</li>';
        endwhile;
        wp_reset_postdata();
      $output .= '</ul>';
    $output .= '</div>';
  endif;

  return $output;
}

?>
