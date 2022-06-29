<?php

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
      ),
      'postTaxonomyPreFilter' => array(
        'type' => 'array'
      )
    ),
    'render_callback' => 'WPgutenberg_postsfilter_blockRender'
  )
);

function WPgutenberg_postsfilter_ContentRow($value, $id){
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
          return get_post_meta($id, $value, true);
        endif;
      endif;
  }
}

// post results
function WPgutenberg_postsfilter_PostBuilder(array $attr, $id){
  $output = '';
  $get_url = get_post_meta($id, 'BlockUrl', true) ? get_post_meta($id, 'BlockUrl', true) : get_the_permalink($id);
  $linkOpen = $get_url && $get_url !== '' ? '<a href="' . $get_url . '">' : '';
  $linkClose = $get_url && $get_url !== '' ? '</a>' : '';
  $output .= '<div data-id="' . $id . '">';
    if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_box', $attr['postTaxonomyFilterOptions'])):
      $output .= $linkOpen;
    endif;
      // add post thumbnail
      if(array_key_exists('postThumb', $attr) && $attr['postThumb'] !== false && $attr['postThumb'] !== ''):
        if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_img', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
          $output .= $linkOpen;
        endif;
        $output .= get_the_post_thumbnail($id) ? '<figure>' . get_the_post_thumbnail($id, 'full', array("data-id" => $id)) . '</figure>' : '';
        if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_img', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
          $output .= $linkClose;
        endif;
      endif;
      // add content
      $output .= '<div class="post-content">';
        if(array_key_exists('postTextOne', $attr) && $attr['postTextOne'] !== ''):
          $output .= $attr['postTextOne'] == 'title' ? '<h4>' : '<div>';
            if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('link_row1', $attr['postTaxonomyFilterOptions']) && !in_array('link_box', $attr['postTaxonomyFilterOptions'])):
              $output .= $linkOpen;
            endif;
              $output .= WPgutenberg_postsfilter_ContentRow($attr['postTextOne'], $id);
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
              $output .= WPgutenberg_postsfilter_ContentRow($attr['postTextTwo'], $id);
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

  return $output;
}

// post results
function WPgutenberg_postsfilter_getResultsAndSort(array $attr, string $source = 'first_load'){
  // print_r($attr);
  // sort direction
  $postSortBy = in_array($attr['postSortBy'], array('title', 'date', 'menu_order')) ? $attr['postSortBy'] : 'meta_value';
  $output = '';
  // update filter options
  if(array_key_exists('postTaxonomyFilterOptions', $attr) && !is_array($attr['postTaxonomyFilterOptions'])):
    $attr['postTaxonomyFilterOptions'] = explode("__", $attr['postTaxonomyFilterOptions']);
  endif;
  // add filter
  $filter = [];
  // categories
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
  // pre selection
  if(array_key_exists('postTaxonomyPreFilter', $attr)):
    if($source == 'first_load'):
      foreach ($attr['postTaxonomyPreFilter'] as $key => $value) {
        $stringToArray = explode("-", $value);
        // if(array_key_exists($stringToArray[0], $filter)):
        //   $filter[$stringToArray[0]] = [];
        // endif;
        $term = get_term( $stringToArray[1], $stringToArray[0] );
        $filter[$stringToArray[0]][] = $term->slug;
      }
    endif;
  endif;
  // print_r($filter);
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
    'orderby' => $postSortBy,
    'order' => $attr['postSortDirection'],
    'tax_query' => $term_array
  );

  if(strpos($attr['postSortBy'], 'tax__') !== false):
    // sort by taxonomy
    $cleanTax = str_replace('tax__', '', $attr['postSortBy']);
    $terms = get_terms($cleanTax);
  elseif(!in_array($attr['postSortBy'], array('title', 'date', 'menu_order'))):
    $queryArgs['meta_key'] = $attr['postSortBy'];
  endif;
  if($tagsToQuery):
    $queryArgs['tag_id'] = $tagsToQuery;
  endif;
  // text search
  if($source == 'first_load' && $_GET['textsearch']):
    $queryArgs['s'] = $_GET['textsearch'];
  elseif($source == 'ajax' && array_key_exists('textsearch', $attr) && $attr['textsearch'] !== ""):
    $queryArgs['s'] = $attr['textsearch'];
  endif;
  // language
  if($source == 'ajax' && array_key_exists('language', $attr) && $attr['language'] !== ""):
    $queryArgs['lang'] = $attr['language'];
  endif;
  // apply query filter
  $queryArgs = apply_filters( 'WPgutenberg_filter_postsfilter_query', $queryArgs );
  // call posts
  $filter_query = new WP_Query( $queryArgs );
  // return
  if ( $filter_query->have_posts() ) :
    while ( $filter_query->have_posts() ) : $filter_query->the_post();
      $key = get_the_ID();
      $allPosts[$key] = get_the_ID();
    endwhile;
    wp_reset_postdata();

    // apply filter to resulted ids
    $allPosts = apply_filters( 'WPgutenberg_filter_postsfilter_results', $allPosts, $attr );

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
      $groupedIds = apply_filters( 'WPgutenberg_filter_postsfilter_taxSorting', $groupedIds, $attr );
      // return by taxonomy
      foreach ($groupedIds as $termkey => $termgroup) {
        if(is_array($termgroup) && !empty($termgroup)):
          foreach ($termgroup as $idkey => $id) {
            // taxonomy is not empty
            $output .= WPgutenberg_postsfilter_PostBuilder($attr, $id);
          }
        endif;
      }
    else:
      foreach ($allPosts as $key => $postID) {
        $output .= WPgutenberg_postsfilter_PostBuilder($attr, $postID);
      }
    endif;
  else:
    $output .= '<p class="no-results wide">' . __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'devTheme' ) . '</p>';
  endif;

  // grid fixer
  // if(array_key_exists('postColumns', $attr) && $attr['postColumns'] > 1):
  //   for ($x = 1; $x < $attr['postColumns']; $x++) {
  //     $output .= '<div class="grid-fixer"></div>';
  //   }
  // endif;


  return $output;
}

// callback function
function WPgutenberg_postsfilter_blockRender($attr){
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
          $output .= '<label for="textsearch">' . __( 'Textsearch', 'devTheme' ) . '</label>';
          $output .= '<input type="text" id="textsearch" name="textsearch" value="' . $textsearch . '" placeholder="' . __( 'Search for', 'devTheme' ) . '">';
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
          if(in_array('hirarchical', $attr['postTaxonomyFilterOptions'])):
            $hierarchical = 1;
          endif;
          if(in_array('emptytax', $attr['postTaxonomyFilterOptions'])):
            $tax_arg['hide_empty'] = false;
          endif;
        endif;
        foreach ($attr['postTaxonomyFilter'] as $key => $value) {
          $given = array();
          if(array_key_exists('postTaxonomyPreFilter', $attr)):
            foreach ($attr['postTaxonomyPreFilter'] as $prefilter_key => $prefilter_value) {
              $stringToArray = explode("-", $prefilter_value);
              if($stringToArray[0] == $value):
                $term = get_term( $stringToArray[1], $stringToArray[0] );
                $given[] = $term->slug;
              endif;
            }
          endif;
          $output .= prefix_core_BaseFunctions::GetFilterGroup($value, $tax_arg, 'group-' . $value, $hierarchical, $showlegend, '', $given);
        }
      endif;
      // prefilter
      if(array_key_exists('postTaxonomyPreFilter', $attr)):
        $prefilterCats = array();
        foreach ($attr['postTaxonomyPreFilter'] as $prefilter_key => $prefilter_value) {
          $stringToArray = explode("-", $prefilter_value);
          if(!in_array($stringToArray[0] , $attr['postTaxonomyFilter'])):
            $prefilterCats[] = $stringToArray[0];
          endif;
        }
        $prefilterCats = array_unique($prefilterCats);
        foreach ($prefilterCats as $key => $value) {
          $attr['postTaxonomyFilter'][] = $value;
          $given = array();
          if(array_key_exists('postTaxonomyPreFilter', $attr)):
            foreach ($attr['postTaxonomyPreFilter'] as $prefilter_key => $prefilter_value) {
              $stringToArray = explode("-", $prefilter_value);
              if($stringToArray[0] == $value):
                $term = get_term( $stringToArray[1], $stringToArray[0] );
                $given[] = $term->slug;
              endif;
            }
          endif;
          $output .= prefix_core_BaseFunctions::GetFilterGroup($value, $tax_arg, 'dn group-' . $value, $hierarchical, $showlegend, '', $given);
        }
      endif;
      // filter settings
      $output .= '<input type="hidden" name="language" value="' . prefix_core_BaseFunctions::getCurrentLang() . '">';
      if(array_key_exists('postTaxonomyFilter', $attr)):
        $output .= '<input type="hidden" name="postTaxonomyFilter" value="' . implode('__', $attr['postTaxonomyFilter']) . '">';
      endif;
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
      if(array_key_exists('postTaxonomyFilterOptions', $attr) && in_array('restButton', $attr['postTaxonomyFilterOptions'])):
        $output .= '<div id="resetSelection" class="hidden"><input type="reset" name="resetSelection" value="Reset"></div>';
      endif;
    $output .= '</form>';
    $output .= '<div class="results ' . $attr['postListTemplate'] . '" data-columnspace="' . $spacing . '" data-columns="' . $columns . '" style="' . $inlinecss . '">';
      $output .= WPgutenberg_postsfilter_getResultsAndSort($attr);
    $output .= '</div>';
  $output .= '</div>';

  return $output;
}

?>
