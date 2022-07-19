<?php

// register block
register_block_type(
  'templates/image-pins-item',
  array(
    'editor_script' => 'gutenberg-blockposts',
    'attributes' => array(
      'anchor' => array(
        'type' => 'string'
      ),
      'pinPostion' => array(
        'type' => 'object',
        'default' => array(
          'x' => '0.5',
          'y' => '0.5'
        )
      ),
      'pinImgId' => array(
        'type' => 'number',
        'default' => 0
      ),
      'pinImageURL' => array(
        'type' => 'string',
        'default' => ''
      ),
      'pinPostType' => array(
        'type' => 'string',
        'default' => 'post'
      ),
      'pinPostId' => array(
        'type' => 'array'
      ),
      'pinTarget' => array(
        'type' => 'string',
        'default' => 'heritage'
      ),
      'pinInfo' => array(
        'type' => 'string',
        'default' => 'heritage'
      ),
      'pinInfoRowOne' => array(
        'type' => 'string',
        'default' => 'heritage'
      ),
      'pinInfoRowTwo' => array(
        'type' => 'string',
        'default' => 'heritage'
      ),
      'pinInfoTrigger' => array(
        'type' => 'array'
      ),
      'parentAttributes' => array(
        'type' => 'object'
      )
    ),
    'render_callback' => 'WPgutenberg_pin_blockRender'
  )
);

function WPgutenberg_pin_ContentRow($value, $id){
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


// callback function
function WPgutenberg_pin_blockRender($attr){
  $output = '';
  $css = '';
  $inlinecss = '';
  // set default settings
  $attr["pinTarget"] = array_key_exists('pinTarget', $attr) && $attr['pinTarget'] !== 'heritage' ? $attr["pinTarget"] : $attr["parentAttributes"]["pinsTarget"];
  $attr["pinInfo"] = array_key_exists('pinInfo', $attr) && $attr['pinInfo'] !== 'heritage' ? $attr["pinInfo"] : $attr["parentAttributes"]["pinsInfo"];
  $attr["pinInfoRowOne"] = array_key_exists('pinInfoRowOne', $attr) && $attr['pinInfoRowOne'] !== 'heritage' ? $attr["pinInfoRowOne"] : $attr["parentAttributes"]["pinsInfoRowOne"];
  $attr["pinInfoRowTwo"] = array_key_exists('pinInfoRowTwo', $attr) && $attr['pinInfoRowTwo'] !== 'heritage' ? $attr["pinInfoRowTwo"] : $attr["parentAttributes"]["pinsInfoRowTwo"];
  $attr["pinInfoTrigger"] =  array_key_exists('pinInfoTrigger', $attr) ? $attr["pinInfoTrigger"] : $attr["parentAttributes"]["pinsInfoTrigger"];
  // add edvanced options (ID/CSS)
  $id = array_key_exists('anchor', $attr) ? ' id="' . $attr['anchor'] . '"' : '';
  $css .= array_key_exists('className', $attr) ? ' ' . $attr['className'] : '';
  $posT = $attr['pinPostion'] ['y'] * 100;
  $posL = $attr['pinPostion']['x'] * 100;
  $inlinecss .= 'top: ' . $posT . '%;';
  $inlinecss .= ' left: ' . $posL . '%;';
  // link
  $pageOptions = prefix_template::PageOptions($attr['pinPostId']);
  $defaultUrl = !in_array('disableDetailpage', $pageOptions) ? get_the_permalink($attr['pinPostId']) : '';
  $get_url = get_post_meta($id, 'BlockUrl', true) ? get_post_meta($id, 'BlockUrl', true) : $defaultUrl;
  // define pin
  $pin = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><g transform="translate(111 -41)"><circle cx="5" cy="5" r="5" transform="translate(-107 45)" class="pin-fill" /><g transform="translate(-111 41)" fill="none" class="pin-stroke" stroke-width="2"><circle cx="9" cy="9" r="9" stroke="none"/><circle cx="9" cy="9" r="8" fill="none"/></g></g></svg>';
  $pinImg = array_key_exists('pinImgId', $attr) ? wp_get_attachment_image_src($attr['pinImgId'], 'full') : '';
  if($pinImg !== '' && is_array($pinImg)):
    $pinMaxWidth = $pinImg[1] / 2;
    $pin = '<img src="' . $pinImg[0] . '" width="' . $pinMaxWidth . '">';
  endif;
  $pin = apply_filters( 'WPgutenberg_imagepins_pin', $pin, $attr );
  // define close icon
  $closePin = '<svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74" style="transform: rotate(45deg);"><path d="M37,74A37.01,37.01,0,0,1,22.6,2.908,37.009,37.009,0,0,1,51.4,71.092,36.768,36.768,0,0,1,37,74ZM16.891,33.107a3.892,3.892,0,0,0,0,7.784H33.107V57.108a3.892,3.892,0,1,0,7.784,0V40.892H57.109a3.892,3.892,0,0,0,0-7.784H40.892V16.891a3.892,3.892,0,0,0-7.784,0V33.107Z" class="svg-fill"></path></svg>';
  $closePin = apply_filters( 'WPgutenberg_imagepins_pinclose', $closePin, $attr );
  //
  switch ($attr['pinTarget']) {
    case 'link':
        $pinOpen = '<a href="' . $get_url . '">';
        $pinClose = '</a>';
      break;
    case 'window':
        $pinOpen = '<a href="' . $get_url . '" target="_blank">';
        $pinClose = '</a>';
      break;
    default:
      $pinOpen = '<span data-load="content">';
      $pinClose = '</span>';
      break;
  }


  // build content
  if(is_array($attr['pinPostId'])):
    $output .= '<div' . $id . ' class="block-image-pin' . $css . '" style="' . $inlinecss . '" data-id="' . $attr['pinPostId'][0] . '" data-info="' . $attr['pinInfo'] . '">';
      $output .= array_key_exists('pinInfoTrigger', $attr) && in_array('link_pin', $attr['pinInfoTrigger']) ? $pinOpen : '<span>';
        $output .= $pin;
      $output .= array_key_exists('pinInfoTrigger', $attr) && in_array('link_pin', $attr['pinInfoTrigger']) ? $pinClose : '</span>';
      if(array_key_exists('pinInfo', $attr) && $attr['pinInfo'] !== ''):
        $output .= '<div class="pin-info">';
          if(array_key_exists('pinInfo', $attr) && $attr['pinInfo'] == 'click'):
            $output .= '<span class="close">';
              $output .= $closePin;
            $output .= '</span>';
          endif;
          if(array_key_exists('pinInfoTrigger', $attr) && in_array('link_box', $attr['pinInfoTrigger'])):
            $output .= $pinOpen;
          endif;
              // row 1
              if(array_key_exists('pinInfoRowOne', $attr) && $attr['pinInfoRowOne'] !== ''):
                $output .= $attr['pinInfoRowOne'] == 'title' ? '<h4>' : '<div>';
                  if(array_key_exists('pinInfoTrigger', $attr) && in_array('link_row1', $attr['pinInfoTrigger']) && !in_array('link_box', $attr['pinInfoTrigger'])):
                    $output .= $pinOpen;
                  endif;
                    $output .= WPgutenberg_posts_ContentRow($attr['pinInfoRowOne'], $attr['pinPostId'][0]);
                  if(array_key_exists('pinInfoTrigger', $attr) && in_array('link_row1', $attr['pinInfoTrigger']) && !in_array('link_box', $attr['pinInfoTrigger'])):
                    $output .= $pinClose;
                  endif;
                $output .= $attr['pinInfoRowOne'] == 'title' ? '</h4>' : '</div>';
              endif;
              // row 2
              if(array_key_exists('pinInfoRowTwo', $attr) && $attr['pinInfoRowTwo'] !== ''):
                $output .= $attr['pinInfoRowTwo'] == 'title' ? '<h4>' : '<div>';
                  if(array_key_exists('pinInfoTrigger', $attr) && in_array('link_row2', $attr['pinInfoTrigger']) && !in_array('link_box', $attr['pinInfoTrigger'])):
                    $output .= $pinOpen;
                  endif;
                    $output .= WPgutenberg_posts_ContentRow($attr['pinInfoRowTwo'], $attr['pinPostId'][0]);
                  if(array_key_exists('pinInfoTrigger', $attr) && in_array('link_row2', $attr['pinInfoTrigger']) && !in_array('link_box', $attr['pinInfoTrigger'])):
                    $output .= $pinClose;
                  endif;
                $output .= $attr['pinInfoRowTwo'] == 'title' ? '</h4>' : '</div>';
              endif;
          if(array_key_exists('pinInfoTrigger', $attr) && in_array('link_box', $attr['pinInfoTrigger'])):
            $output .= $pinClose;
          endif;
        $output .= '</div>';
      endif;
    $output .= '</div>';
  endif;

  return $output;
}

?>
