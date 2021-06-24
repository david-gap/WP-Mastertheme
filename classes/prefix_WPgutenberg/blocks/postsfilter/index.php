<?

// register block
register_block_type(
  'templates/postsfilter',
  array(
    'editor_script' => 'gutenberg-blockposts',
    'attributes' => array(
      'anchor' => array(
        'type' => 'string'
      ),
      'postType' => array(
        'type' => 'string',
        'default' => 'post'
      ),
      'postSortBy' => array(
        'type' => 'string',
        'default' => 'date'
      ),
      'postSortDirection' => array(
        'type' => 'string',
        'default' => 'desc'
      ),
      'postTaxonomyFilterRelation' => array(
        'type' => 'string',
        'default' => 'AND'
      ),
      'postTextOne' => array(
        'type' => 'string',
        'default' => 'title'
      ),
      'postTextTwo' => array(
        'type' => 'string',
        'default' => 'date'
      ),
      'postFilterPosition' => array(
        'type' => 'string',
        'default' => 'left'
      ),
      'postListTemplate' => array(
        'type' => 'string',
        'default' => 'grid'
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
        'default' => true,
      ),
      'postTextSearch' => array(
        'type' => 'boolean',
        'default' => false,
      ),
      'postTaxonomyFilter' => array(
        'type' => 'array'
      )
    ),
    'render_callback' => 'WPgutenberg_blockRender_postsfilter'
  )
);

function WPgutenberg_block_postsfilterValue($value, $id){
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
          return get_post_meta($id, $value, true);
        endif;
      endif;
  }
}

// post results
function WPgutenberg_postresults_postsfilter(array $attr, string $source = 'first_load'){
  $output = '';
  // update filter options
  if(array_key_exists('postTaxonomyFilterOptions', $attr) && !is_array($attr['postTaxonomyFilterOptions'])):
    $attr['postTaxonomyFilterOptions'] = explode("__", $attr['postTaxonomyFilterOptions']);
  endif;
  // add filter
  $filter = [];
  if(array_key_exists('postTaxonomyFilter', $attr)):
    $attr['postTaxonomyFilter'] = is_array($attr['postTaxonomyFilter']) ? $attr['postTaxonomyFilter'] : explode("__", $attr['postTaxonomyFilter']);
    foreach ($attr['postTaxonomyFilter'] as $key => $value) {
      if($source == 'first_load'):
        if($_GET[$value]):
          $stringToArray = explode("__", $_GET[$value]);
          $filter[$value] = $stringToArray;
        endif;
      elseif($source == 'ajax'):
        if(array_key_exists($value, $attr) && $attr[$value] !== ""):
          $stringToArray = explode("__", $attr[$value]);
          $filter[$value] = $stringToArray;
        endif;
      endif;
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
            'field'     => 'slug',
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
    'posts_per_page'=> -1,
    'paged' => $paged,
    'orderby' => $attr['postSortBy'],
    'order' => $attr['postSortDirection'],
    'tax_query' => $term_array
  );
  if($tagsToQuery):
    $queryArgs['tag_id'] = $tagsToQuery;
  endif;
  // text search
  if($source == 'first_load' && $_GET['textsearch']):
    $queryArgs['s'] = $_GET['textsearch'];
  elseif($source == 'ajax' && array_key_exists('textsearch', $attr) && $attr['textsearch'] !== ""):
    $queryArgs['s'] = $attr['textsearch'];
  endif;
  // call posts
  $filter_query = new WP_Query( $queryArgs );
  // return
  if ( $filter_query->have_posts() ) :
    while ( $filter_query->have_posts() ) : $filter_query->the_post();
      $get_url = get_post_meta(get_the_ID(), 'BlockUrl', true) ? get_post_meta(get_the_ID(), 'BlockUrl', true) : get_the_permalink();
      $linkOpen = $get_url && $get_url !== '' ? '<a href="' . $get_url . '">' : '';
      $linkClose = $get_url && $get_url !== '' ? '</a>' : '';
      $output .= '<div>';
        if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_box', $attr['postTaxonomyFilterOptions'])):
          $output .= $linkOpen;
        endif;
          // add post thumbnail
          if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_img', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
            $output .= $linkOpen;
          endif;
            if(array_key_exists('postThumb', $attr) && $attr['postThumb'] !== false && $attr['postThumb'] !== ''):
              $output .= get_the_post_thumbnail() ? '<figure>' . get_the_post_thumbnail(get_the_id(), 'full', array("data-id" => get_the_id())) . '</figure>' : '';
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
        $output .= '</div>';
    endwhile;
    wp_reset_postdata();
  else:
    $output .= '<p class="no-results wide">' . __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'WPgutenberg' ) . '</p>';
  endif;

  // grid fixer
  if(array_key_exists('postColumns', $attr) && $attr['postColumns'] > 1):
    for ($x = 1; $x < $attr['postColumns']; $x++) {
      $output .= '<div class="grid-fixer"></div>';
    }
  endif;


  return $output;
}

// callback function
function WPgutenberg_blockRender_postsfilter($attr){
  $output = '';
  $css = '';
  $inlinecss = '';
  // add edvanced options (ID/CSS)
  $id = array_key_exists('anchor', $attr) ? ' id="' . $attr['anchor'] . '"' : '';
  $css .= array_key_exists('className', $attr) ? ' ' . $attr['className'] : '';
  $css .= array_key_exists('align', $attr) ? ' align' . $attr['align'] : '';
  $css .= array_key_exists('postFilterPosition', $attr) ? ' filter-' . $attr['postFilterPosition']  : '';
  // reset spacing if only one column
  $spacing = array_key_exists('postColumns', $attr) && $attr['postColumns'] > 1 ? $attr['postColumnsSpace'] : 0;
  // inline stylings
  $columns = array_key_exists('postColumns', $attr) ? $attr['postColumns'] : 1;
  $inlinecss .= '--postColumns: ' . $columns . ';';
  $inlinecss .= ' --postColumnsSpace: ' . $spacing . 'px;';
  // build content
  $output .= '<div' . $id . ' class="block-postsfilter' . $css . '" data-id="' . prefix_core_BaseFunctions::ShortID() . '">';
    $output .= '<form class="thefilter">';
      if($attr['postTextSearch']):
        $output .= '<div class="textsearch">';
          if($_GET['textsearch']):
            $textsearch = $_GET['textsearch'];
          else:
            $textsearch = '';
          endif;
          $output .= '<label for="textsearch">' . __( 'Textsearch', 'WPgutenberg' ) . '</label>';
          $output .= '<input type="text" id="textsearch" name="textsearch" value="' . $textsearch . '" placeholder="' . __( 'Search for', 'WPgutenberg' ) . '">';
        $output .= '</div>';
      endif;
      if(array_key_exists('postTaxonomyFilter', $attr)):
        // default options
        $showlegend = false;
        $hierarchical = 0;
        $tax_arg = array(
            'hide_empty' => true
        );
        if(array_key_exists('postTaxonomyFilterOptions', $attr)):
          if(in_array('legend', $attr['postTaxonomyFilterOptions'])):
            $showlegend = true;
          endif;
          if(in_array('hierarchical', $attr['postTaxonomyFilterOptions'])):
            $hierarchical = 1;
          endif;
          if(in_array('emptytax', $attr['postTaxonomyFilterOptions'])):
            $tax_arg['hide_empty'] = false;
          endif;
        endif;
        foreach ($attr['postTaxonomyFilter'] as $key => $value) {
          $output .= prefix_core_BaseFunctions::GetFilterGroup($value, $tax_arg, 'group-' . $value, $hierarchical, $showlegend);
        }
      endif;
      $output .= '<input type="hidden" name="postTaxonomyFilter" value="' . implode('__', $attr['postTaxonomyFilter']) . '">';
      $output .= '<input type="hidden" name="postTaxonomyFilterRelation" value="' . $attr['postTaxonomyFilterRelation'] . '">';
      $output .= '<input type="hidden" name="postType" value="' . $attr['postType'] . '">';
      $output .= '<input type="hidden" name="postSortBy" value="' . $attr['postSortBy'] . '">';
      $output .= '<input type="hidden" name="postSortDirection" value="' . $attr['postSortDirection'] . '">';
      $output .= '<input type="hidden" name="postTaxonomyFilterOptions" value="' . implode('__', $attr['postTaxonomyFilterOptions']) . '">';
      $output .= '<input type="hidden" name="postTextOne" value="' . $attr['postTextOne'] . '">';
      $output .= '<input type="hidden" name="postTextTwo" value="' . $attr['postTextTwo'] . '">';
      $output .= '<input type="hidden" name="postThumb" value="' . $attr['postThumb'] . '">';
      $output .= '<input type="hidden" name="postColumns" value="' . $columns . '">';
    $output .= '</form>';
    $output .= '<div class="results ' . $attr['postListTemplate'] . '" data-columnspace="' . $spacing . '" data-columns="' . $columns . '" style="' . $inlinecss . '">';
      $output .= WPgutenberg_postresults_postsfilter($attr);
    $output .= '</div>';
  $output .= '</div>';

  return $output;
}

?>
