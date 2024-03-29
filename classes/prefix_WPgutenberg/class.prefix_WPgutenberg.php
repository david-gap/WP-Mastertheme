<?php
/**
 *
 *
 * WORDPRESS GUTENBERG SUPPORT
 * https://github.com/david-gap/classes
 *
 * @author      David Voglgsang
 * @version     2.29.17
 */

/*=======================================================
Table of Contents:
---------------------------------------------------------
1.0 INIT & VARS
  1.1 CONFIGURATION
  1.2 ON LOAD RUN
  1.3 BACKEND ARRAY
2.0 FUNCTIONS
  2.1 GET SETTINGS FROM CONFIGURATION FILE
  2.2 DISABLE GUTENBERG
  2.3 DISABLE GUTENBERG STYLING
  2.4 MANAGE BLOCKS
  2.5 ADD STYLES OPTIONS
  2.6 CUSTOM THEME SUPPORT
  2.7 ENQUEUE CUSTOM BLOCKS ASSETS
  2.8 REGISTER CUSTOM BLOCKS
  2.9 API REST FIX - ORDER BY MENU
3.0 OUTPUT
  3.1 RETURN CUSTOM CSS
  3.2 CHANGE INLINE FONT SIZE
  3.3 FILTER BLOCKS BEFORE DOM
  3.4 EXTENTION FILES
=======================================================*/

class prefix_WPgutenberg {

  /*==================================================================================
    1.0 INIT & VARS
  ==================================================================================*/

    /* 1.1 CONFIGURATION
    /------------------------*/
    /**
      * default vars
      * @param private int $WPgutenberg_active: disable gutenberg
      * @param private int $WPgutenberg_css: disable gutenberg styling
      * @param private int $WPgutenberg_Stylesfile: Add the file with the additional gutenberg css classes
      * @param private int $WPgutenberg_DefaultPatterns: Remove default patterns
      * @param private int $WPgutenberg_fontsizeScaler: Activate fontsize scaler
      * @param private array $WPgutenberg_AllowedBlocks: List core allowed gutenberg blocks
      * @param private array $WPgutenberg_CustomAllowedBlocks: List custom allowed gutenberg blocks
      * @param private array $WPgutenberg_ColorPalette: Custom theme color palette
      * @param private array $WPgutenberg_FontSizes: Custom theme font sizes
      * @param private int $WPgutenberg_ColorPalette_CP: Disable custom color picker
    */
    private $WPgutenberg_active                 = 0;
    private $WPgutenberg_css                    = 0;
    private $WPgutenberg_Stylesfile             = 0;
    private $WPgutenberg_DefaultPatterns        = 0;
    private $WPgutenberg_fontsizeScaler         = 0;
    private $WPgutenberg_AllowedBlocks          = array();
    private $WPgutenberg_CustomAllowedBlocks    = array();
    private static $WPgutenberg_ColorPalette    = array();
    private static $WPgutenberg_FontSizes       = array();
    private static $WPgutenberg_ColorPalette_CP = 0;


    /* 1.2 ON LOAD RUN
    /------------------------*/
    public function __construct() {
      // update default vars with configuration file
      SELF::updateVars();
      // filter gutenberg blocks
      if(!empty($this->WPgutenberg_AllowedBlocks)):
        add_filter( 'allowed_block_types', array($this, 'AllowGutenbergBlocks') );
      endif;
      // add gutenberg style options
      if(!empty($this->WPgutenberg_Stylesfile)):
        add_action( 'enqueue_block_editor_assets', array($this, 'AddBackendStyleOptions'), 100 );
      endif;
      // disable gutenberg
      if($this->WPgutenberg_active == 0):
        SELF::DisableGutenberg();
      endif;
      // disable Gutenberg block styles
      if($this->WPgutenberg_css == 0):
        add_action( 'wp_enqueue_scripts', array($this, 'DisableGutenbergCSS'), 100 );
      endif;
      // add theme support
      SELF::CustomThemeSupport();
      // Change inline font size to var
      if($this->WPgutenberg_fontsizeScaler == 1):
        add_filter('the_content',  array($this, 'InlineFontSize') );
      endif;
      // add custom blocks scripts
      add_action( 'enqueue_block_editor_assets', array($this, 'WPgutenbergEnqueueCustomBlocksAssets'), 1 );
      // register custom blocks
      add_action( 'init', array($this, 'WPgutenbergRegisterCustomBlocks') );
      // Fix rest api sort
      add_action( 'init', array($this, 'WPgutenbergFixApiSort'), 99 );
      // filter blocks before dom
      add_filter('render_block_data',  array($this, 'FilterBlocksData'), 10, 3 );
      add_filter('render_block',  array($this, 'FilterBlocks'), 10, 2 );
      // extension files
      add_action( 'enqueue_block_assets', array($this, 'embedExtentionFiles') );
      // remove inline styles
      // remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
      // remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );
      // remove_filter( 'render_block', 'wp_render_elements_support', 10, 2 );
      // remove_filter( 'render_block', 'gutenberg_render_elements_support', 10, 2 );
      // extend thumbnail metabox
      register_meta( 'post', 'template_page_videothumb_videoId', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true
      ) );
      register_meta( 'post', 'template_page_videothumb_videoUrl', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true
      ) );
      register_meta( 'post', 'template_page_videothumb_options', array(
        'type' => 'array',
        'single' => true,
        'show_in_rest' => array(
          'schema' => array(
            'type'  => 'array',
            'items' => array(
              'type' => 'string'
            )
          )
        ),
      ) );
      // register strings
      $backendStrings = array(
        __('Gutenberg', 'devTheme'),
        __('Active', 'devTheme'),
        __('Gutenberg styles embed', 'devTheme'),
        __('Backend style options', 'devTheme'),
        __('Default Patterns', 'devTheme'),
        __('Fontsize scaler', 'devTheme'),
        __('Allowed core blocks', 'devTheme'),
        __('Allowed costum blocks', 'devTheme'),
        __('Custom color picker', 'devTheme'),
        __('Custom color palette', 'devTheme'),
        __('Name', 'devTheme'),
        __('Color', 'devTheme'),
        __('Custom font sizes', 'devTheme'),
        __('Name', 'devTheme'),
        __('Size (without px)', 'devTheme')
      );
    }

    /* 1.3 BACKEND ARRAY
    /------------------------*/
    static $classtitle = 'Gutenberg';
    static $classkey = 'gutenberg';
    static $backend = array(
      "active" => array(
        "label" => "Active",
        "type" => "switchbutton"
      ),
      "css" => array(
        "label" => "Gutenberg styles embed",
        "type" => "switchbutton"
      ),
      "Stylesfile" => array(
        "label" => "Backend style options",
        "type" => "switchbutton"
      ),
      "Patterns" => array(
        "label" => "Default Patterns",
        "type" => "switchbutton"
      ),
      "fontsizeScaler" => array(
        "label" => "Fontsize scaler",
        "type" => "switchbutton"
      ),
      "AllowedBlocks" => array(
        "label" => "Allowed core blocks",
        "css" => "multiple selectAll",
        "type" => "checkboxes",
        "value" => array(
          "core/paragraph",
          "core/image",
          "core/heading",
          "core/gallery",
          "core/list",
          "core/quote",
          "core/group",
          "core/audio",
          "core/file",
          "core/video",
          "core/table",
          "core/verse",
          "core/code",
          "core/cover",
          "core/freeform",
          "core/html",
          "core/preformatted",
          "core/pullquote",
          "core/button",
          "core/buttons",
          "core/columns",
          "core/media-text",
          "core/more",
          "core/nextpage",
          "core/separator",
          "core/spacer",
          "core/shortcode",
          "core/archives",
          "core/categories",
          "core/latest-comments",
          "core/latest-posts",
          "core/calendar",
          "core/rss",
          "core/search",
          "core/tag-cloud",
          "core/query",
          "core/navigation",
          "core/site-logo",
          "core/site-title",
          "core/site-tagline",
          "core/query",
          "core/posts-list",
          "core/avatar",
          "core/post-title",
          "core/post-excerpt",
          "core/post-featured-image",
          "core/post-content",
          "core/post-author",
          "core/post-date",
          "core/post-terms",
          "core/post-navigation-link",
          "core/read-more",
          "core/comments-query-loop",
          "core/post-comments-form",
          "core/loginout",
          "core/term-description",
          "core/query-title",
          "core/post-author-biography",
          "core/social-links",
          "core/comment-author-name",
          "core/comment-content",
          "core/comment-date",
          "core/comment-edit-link",
          "core/comment-reply-link",
          "core/comment-template",
          "core/comments-pagination-next",
          "core/comments-pagination-numbers",
          "core/comments-pagination-previous",
          "core/comments-pagination",
          "core/comments-title",
          "core/home-link",
          "core/legacy-widget",
          "core/navigation-link",
          "core/navigation-submenu",
          "core/page-list",
          "core/pattern",
          "core/post-comments",
          "core/post-template",
          "core/query-no-results",
          "core/query-pagination-next",
          "core/query-pagination-numbers",
          "core/query-pagination-previous",
          "core/query-pagination",
          "core/social-link",
          "core/template-part",
          "core/widget-group",
          "core/column",
          "core/missing",
          "core/text-columns",
          "core/embed",
          "core-embed/twitter",
          "core-embed/youtube",
          "core-embed/facebook",
          "core-embed/instagram",
          "core-embed/wordpress",
          "core-embed/soundcloud",
          "core-embed/spotify",
          "core-embed/flickr",
          "core-embed/vimeo",
          "core-embed/animoto",
          "core-embed/cloudup",
          "core-embed/collegehumor",
          "core-embed/dailymotion",
          "core-embed/funnyordie",
          "core-embed/hulu",
          "core-embed/imgur",
          "core-embed/issuu",
          "core-embed/kickstarter",
          "core-embed/meetup-com",
          "core-embed/mixcloud",
          "core-embed/photobucket",
          "core-embed/polldaddy",
          "core-embed/reddit",
          "core-embed/reverbnation",
          "core-embed/screencast",
          "core-embed/scribd",
          "core-embed/slideshare",
          "core-embed/smugmug",
          "core-embed/speaker",
          "core-embed/tiktok",
          "core-embed/ted",
          "core-embed/tumblr",
          "core-embed/videopress",
          "core-embed/wordpress-tv",
          "templates/vimeo",
          "templates/posts",
          "templates/postsfilter",
          // "templates/maps",
          "templates/accordion",
          "templates/accordion-item",
          "templates/gallery",
          "templates/gallery-item",
          "templates/image-pins",
          "templates/image-pins-item"
        )
      ),
      "CustomAllowedBlocks" => array(
        "label" => "Allowed custom blocks registered in React",
        "type" => "array_addable"
      ),
      "ColorPalette_CP" => array(
        "label" => "Custom color picker",
        "type" => "switchbutton"
      ),
      "ColorPalette" => array(
        "label" => "Custom color palette",
        "type" => "array_addable",
        "value" => array(
          "key" => array(
            "label" => "Name",
            "type" => "text"
          ),
          "value" => array(
            "label" => "Color",
            "type" => "text",
            "css" => "colorpicker"
          )
        )
      ),
      "FontSizes" => array(
        "label" => "Custom font sizes",
        "type" => "array_addable",
        "value" => array(
          "key" => array(
            "label" => "Name",
            "type" => "text"
          ),
          "value" => array(
            "label" => "Size",
            "type" => "text"
          ),
          "valueMobile" => array(
            "label" => "Mobile size",
            "type" => "text"
          )
        )
      )
    );



  /*==================================================================================
    2.0 FUNCTIONS
  ==================================================================================*/


  /* 2.1 GET SETTINGS FROM CONFIGURATION FILE
  /------------------------*/
  private function updateVars(){
    // get configuration
    global $configuration;
    // if configuration file exists && class-settings
    if($configuration && array_key_exists('gutenberg', $configuration)):
      // class configuration
      $myConfig = $configuration['gutenberg'];
      // update vars
      $this->WPgutenberg_active = array_key_exists('active', $myConfig) ? $myConfig['active'] : $this->WPgutenberg_active;
      $this->WPgutenberg_css = array_key_exists('css', $myConfig) ? $myConfig['css'] : $this->WPgutenberg_css;
      $this->WPgutenberg_Stylesfile = array_key_exists('Stylesfile', $myConfig) ? $myConfig['Stylesfile'] : $this->WPgutenberg_Stylesfile;
      $this->WPgutenberg_DefaultPatterns = array_key_exists('Patterns', $myConfig) ? $myConfig['Patterns'] : $this->WPgutenberg_DefaultPatterns;
      $this->WPgutenberg_fontsizeScaler = array_key_exists('fontsizeScaler', $myConfig) ? $myConfig['fontsizeScaler'] : $this->WPgutenberg_fontsizeScaler;
      $this->WPgutenberg_AllowedBlocks = array_key_exists('AllowedBlocks', $myConfig) ? $myConfig['AllowedBlocks'] : $this->WPgutenberg_AllowedBlocks;
      $this->WPgutenberg_CustomAllowedBlocks = array_key_exists('CustomAllowedBlocks', $myConfig) ? $myConfig['CustomAllowedBlocks'] : $this->WPgutenberg_CustomAllowedBlocks;
      SELF::$WPgutenberg_ColorPalette = array_key_exists('ColorPalette', $myConfig) ? $myConfig['ColorPalette'] : SELF::$WPgutenberg_ColorPalette;
      SELF::$WPgutenberg_FontSizes = array_key_exists('FontSizes', $myConfig) ? $myConfig['FontSizes'] : SELF::$WPgutenberg_FontSizes;
      SELF::$WPgutenberg_ColorPalette_CP = array_key_exists('ColorPalette_CP', $myConfig) ? $myConfig['ColorPalette_CP'] : SELF::$WPgutenberg_ColorPalette_CP;
    endif;
  }


  /* 2.2 DISABLE GUTENBERG
  /------------------------*/
  private function DisableGutenberg(){
    // disable for posts
    add_filter('use_block_editor_for_post', '__return_false', 10);
    // disable for post types
    add_filter('use_block_editor_for_post_type', '__return_false', 10);
  }


  /* 2.3 DISABLE GUTENBERG STYLING
  /------------------------*/
  function DisableGutenbergCSS(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' );
  }


  /* 2.4 MANAGE BLOCKS
  /------------------------*/
  function AllowGutenbergBlocks($allowed_blocks){
    $customSelection = array_merge($this->WPgutenberg_AllowedBlocks, $this->WPgutenberg_CustomAllowedBlocks);
    $customSelection = array_merge($customSelection, array("core/block"));
    return $customSelection;
  }


  /* 2.5 ADD STYLES OPTIONS
  /------------------------*/
  function AddBackendStyleOptions(){
    $templatePath = get_template_directory_uri() . '/classes/prefix_WPgutenberg/gutenberg-editor.js';
    if(prefix_core_BaseFunctions::CheckFileExistence($templatePath)):
      wp_enqueue_script(
        'backend-gutenberg-template-css-classes',
        $templatePath,
        ['wp-i18n', 'wp-element', 'wp-blocks']
      );
    endif;
    $childPath = get_stylesheet_directory_uri() . '/gutenberg-editor.js';
    if(prefix_core_BaseFunctions::CheckFileExistence($childPath)):
      wp_enqueue_script(
        'backend-gutenberg-css-classes',
        $childPath,
        ['wp-i18n', 'wp-element', 'wp-blocks']
      );
    endif;
  }


  /* 2.6 CUSTOM THEME SUPPORT
  /------------------------*/
  function CustomThemeSupport(){
    // coloring
    if(!empty(SELF::$WPgutenberg_ColorPalette)):
      $newColors = array();
      foreach (SELF::$WPgutenberg_ColorPalette as $colorkey => $color) {
        $newColors[] = array(
          'name'  => __( $color["key"], 'devTheme' ),
          'slug'  => prefix_core_BaseFunctions::Slugify($color["key"]),
          'color'	=> $color["value"],
        );
      }
      add_theme_support( 'editor-color-palette', $newColors );
    endif;
    // font sizes
    if(!empty(SELF::$WPgutenberg_FontSizes)):
      $newColors = array();
      foreach (SELF::$WPgutenberg_FontSizes as $sizekey => $size) {
        $newColors[] = array(
          'name'  => __( $size["key"], 'devTheme' ),
          'slug'  => prefix_core_BaseFunctions::Slugify($size["key"]),
          'size'	=> $size["value"],
        );
      }
      add_theme_support( 'editor-font-sizes', $newColors );
      // disable custom color picker
      if(SELF::$WPgutenberg_ColorPalette_CP == 0):
        add_theme_support( 'disable-custom-colors');
      endif;
    endif;
    // disable default patterns
    if($this->WPgutenberg_DefaultPatterns == 0):
      remove_theme_support( 'core-block-patterns' );
    endif;

  }


  /* 2.7 ENQUEUE CUSTOM BLOCKS ASSETS
  /------------------------*/
  function WPgutenbergEnqueueCustomBlocksAssets(){
    // Only load if Gutenberg is available.
    if ( ! function_exists( 'register_block_type' ) ) {
      return;
    }
    $class_path = get_template_directory_uri() . '/classes/prefix_WPgutenberg/';
    // register script
    wp_enqueue_script(
      'gutenberg-block',
      $class_path . 'assets/js/gutenberg-blocks.js',
      ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
      '1.1'
    );
  }


  /* 2.8 REGISTER CUSTOM BLOCKS
  /------------------------*/
  function WPgutenbergRegisterCustomBlocks(){
    // Only load if Gutenberg is available.
    if ( ! function_exists( 'register_block_type' ) ) {
      return;
    }
    include 'blocks/posts/index.php';
    include 'blocks/postsfilter/index.php';
    // include 'blocks/map-marker/index.php';
    include 'blocks/image-pins-item/index.php';
  }


  /* 2.9 API REST FIX - ORDER BY MENU
  /------------------------*/
  function WPgutenbergFixApiSort() {
    // get core post types
    $core_args = array(
      'public' => true,
      '_builtin' => true
    );
    $core_pt = get_post_types( $core_args );
    // get custom post types
    $custom_args = array(
      'publicly_queryable' => true
    );
    $custom_pt = get_post_types($custom_args);
    // merge & clean post types
    $post_types = array_merge($core_pt, $custom_pt);
    // unset($post_types['attachment']);
    unset($post_types['nav_menu_item']);
    // register meta box for all selected post types
    foreach( $post_types as $post_type ){
        $filter_name = 'rest_' . $post_type . '_collection_params';
        add_filter( $filter_name, array($this, 'addRestOrderbyParams'), 10, 1 );
    }
  }
  function addRestOrderbyParams( $params ) {
    $params['orderby']['enum'][] = 'menu_order';
    return $params;
  }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

  /* 3.1 RETURN CUSTOM CSS
  /------------------------*/
  function returnCustomCSS(){
    // vars
    $output = '';
    // build styling
    if(!empty(SELF::$WPgutenberg_ColorPalette) || !empty(SELF::$WPgutenberg_FontSizes)):
      // coloring
      if(!empty(SELF::$WPgutenberg_ColorPalette)):
        foreach (SELF::$WPgutenberg_ColorPalette as $colorkey => $color) {
          $output .= ' .has-' . prefix_core_BaseFunctions::Slugify($color["key"]) . '-color {color: ' . $color["value"] . ';}';
          $output .= ' .has-' . prefix_core_BaseFunctions::Slugify($color["key"]) . '-background-color {background-color: ' . $color["value"] . ';}';
        };
      endif;
      // font sizes
      if(!empty(SELF::$WPgutenberg_FontSizes)):
        foreach (SELF::$WPgutenberg_FontSizes as $sizekey => $size) {
          $output .= ' .has-' . prefix_core_BaseFunctions::Slugify($size["key"]) . '-font-size {font-size: ' . $size["value"] . 'px;}';
        };
      endif;
    endif;
    // return
    return $output;
  }


  /* 3.2 CHANGE INLINE FONT SIZE
  /------------------------*/
  function InlineFontSize($content) {
    if(!is_admin()):
      return str_replace(array("font-size:","line-height:"),array("--font-size:","--line-height:"),$content);
    endif;
  }


  /* 3.3 FILTER BLOCKS BEFORE DOM
  /------------------------*/
  function FilterBlocksData($parsed_block, $source_block, $parent_block){
    // img block
    if("core/image" == $parsed_block['blockName'] && $parent_block && "core/gallery" == $parent_block->parsed_block['blockName']):
      // heritage download button
      if(array_key_exists('attrs', $parent_block->parsed_block) && $parent_block->parsed_block['attrs']):
        if($parent_block->parsed_block['attrs'] && array_key_exists('addDownloadButton', $parent_block->parsed_block['attrs']) && $parent_block->parsed_block['attrs']['addDownloadButton'] == 1):
          $parsed_block['attrs']['addDownloadButton'] = 1;
        endif;
      endif;
    endif;
    // block controls
    if(array_key_exists('attrs', $parsed_block) && $parsed_block['attrs']):
      if(array_key_exists('hideOnDesktop', $parsed_block['attrs']) && $parsed_block['attrs']['hideOnDesktop'] == 1):
        // mobile
        if(array_key_exists('className', $parsed_block['attrs']) && strpos($parsed_block['attrs']['className'], 'mobile') === false):
          $parsed_block['attrs']['className'] = $parsed_block['attrs']['className'] . ' mobile';
        else:
          $parsed_block['attrs']['className'] = 'mobile';
        endif;
      endif;
      if(array_key_exists('hideOnMobile', $parsed_block['attrs']) && $parsed_block['attrs']['hideOnMobile'] == 1):
        // desktop
        if(array_key_exists('className', $parsed_block['attrs']) && strpos($parsed_block['attrs']['className'], 'desktop') === false):
          $parsed_block['attrs']['className'] = $parsed_block['attrs']['className'] . ' desktop';
        else:
          $parsed_block['attrs']['className'] = 'desktop';
        endif;
      endif;
      if(array_key_exists('removeSpacing', $parsed_block['attrs']) && $parsed_block['attrs']['removeSpacing'] == 1):
        // no-spacing
        if(array_key_exists('className', $parsed_block['attrs']) && strpos($parsed_block['attrs']['className'], 'no-spacing') === false):
          $parsed_block['attrs']['className'] = $parsed_block['attrs']['className'] . ' no-spacing';
        else:
          $parsed_block['attrs']['className'] = 'no-spacing';
        endif;
      endif;
      if(array_key_exists('additionalSpacingOne', $parsed_block['attrs']) && $parsed_block['attrs']['additionalSpacingOne'] == 1):
        // spacing-one
        if(array_key_exists('className', $parsed_block['attrs']) && strpos($parsed_block['attrs']['className'], 'spacing-one') === false):
          $parsed_block['attrs']['className'] = $parsed_block['attrs']['className'] . ' spacing-one';
        else:
          $parsed_block['attrs']['className'] = 'spacing-one';
        endif;
      endif;
      if(array_key_exists('additionalSpacingTwo', $parsed_block['attrs']) && $parsed_block['attrs']['additionalSpacingTwo'] == 1):
        // spacing-two
        if(array_key_exists('className', $parsed_block['attrs']) && strpos($parsed_block['attrs']['className'], 'spacing-two') === false):
          $parsed_block['attrs']['className'] = $parsed_block['attrs']['className'] . ' spacing-two';
        else:
          $parsed_block['attrs']['className'] = 'spacing-two';
        endif;
      endif;
      if(array_key_exists('sideSpacing', $parsed_block['attrs']) && $parsed_block['attrs']['sideSpacing'] == 1):
        // side-spacing
        if(array_key_exists('className', $parsed_block['attrs']) && strpos($parsed_block['attrs']['className'], 'side-spacing') === false):
          $parsed_block['attrs']['className'] = $parsed_block['attrs']['className'] . ' side-spacing';
        else:
          $parsed_block['attrs']['className'] = 'side-spacing';
        endif;
      endif;
    endif;
    return $parsed_block;
  }
  function FilterBlocks($blockContent, $block){
    $currentUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    // make sure to run this only on frontend
    // if(!is_admin()):
    if(strpos($currentUrl, 'wp-admin') !== false):
    else:
      // disabled block - by costum attribute
      if($block['attrs'] && array_key_exists('disabledValue', $block['attrs'])):
        if($block['attrs']['disabledValue'] == 1):
          $blockContent = '';
        endif;
      endif;
      // scaduled blocks - by costum attribute
      if(array_key_exists('attrs', $block) && $block['attrs']):
        // check date statements
        if(array_key_exists('scaduleStart', $block['attrs']) && $block['attrs']['scaduleStart'] !== null && $block['attrs']['scaduleStart'] !== '' && array_key_exists('scaduleEnd', $block['attrs']) && $block['attrs']['scaduleEnd'] !== null && $block['attrs']['scaduleEnd'] !== ''):
          // if current date is between start and end date
          $timeStatement = prefix_core_BaseFunctions::DateCheck($block['attrs']['scaduleStart'], $block['attrs']['scaduleEnd'], "between");
          $blockContent = $timeStatement === false ? '' : $blockContent;
        elseif(array_key_exists('scaduleStart', $block['attrs']) && $block['attrs']['scaduleStart'] !== null && $block['attrs']['scaduleStart'] !== ''):
          // if given startdate is in the future
          $timeStatement = prefix_core_BaseFunctions::DateCheck($block['attrs']['scaduleStart'], "", "future");
          $blockContent = $timeStatement === true ? '' : $blockContent;
        elseif(array_key_exists('scaduleEnd', $block['attrs']) && $block['attrs']['scaduleEnd'] !== null && $block['attrs']['scaduleEnd'] !== ''):
          // if given enddate is in the paste
          $timeStatement = prefix_core_BaseFunctions::DateCheck("", $block['attrs']['scaduleEnd'], "past");
          $blockContent = $timeStatement === true ? '' : $blockContent;
        endif;
      endif;
      // overrides
      if($blockContent !== ''):
        // img
        if("core/image" == $block['blockName']):
          if($block['attrs'] && array_key_exists('addDownloadButton', $block['attrs'])):
            if($block['attrs']['addDownloadButton'] == 1):
              $downloadLink = '<a class="download-button" href="' . wp_get_attachment_image_url($block['attrs']['id'], 'full', false) . '" download>';
                $downloadLinkText = __( 'Download', 'devTheme' );
                $downloadLink .= apply_filters( 'WPgutenberg_image_downloadButton', $downloadLinkText, $block['attrs'] );
              $downloadLink .= '</a>';
              $blockContent = str_replace(array('<a href="', '</figure>'), array('<a download href="', $downloadLink . '</figure>'), $blockContent);
            endif;
          endif;
          $blockContent = array_key_exists('id', $block['attrs']) ? str_replace('<img', '<img data-id="' . $block['attrs']['id'] . '"', $blockContent) : $blockContent;
        endif;
        // gallery
        if("core/gallery" == $block['blockName']):
          if(array_key_exists('attrs', $block) && $block['attrs']):
            if($block['attrs'] && array_key_exists('addDownloadAllButton', $block['attrs']) && $block['attrs']['addDownloadAllButton'] == 1):
              $allItems = array();
              if(array_key_exists('innerBlocks', $block) && $block['innerBlocks']):
                foreach ($block['innerBlocks'] as $innerBlocksKey => $innerBlocks) {
                  if(array_key_exists('attrs', $innerBlocks) && $innerBlocks['attrs'] && array_key_exists('id', $innerBlocks['attrs'])):
                    $allItems[] = basename (get_attached_file($innerBlocks['attrs']['id'])) . "__" . wp_get_attachment_url($innerBlocks['attrs']['id']);
                  endif;
                }
                if(!empty($allItems)):
                  $base64 = implode($allItems, '|');
                  $downloadLink = '<div class="download-container">';
                    $downloadLink .= '<a class="download-all-button">';
                      $downloadLink .= '<span class="download-base">' . $base64 . '</span>';
                      $downloadLinkText = __( 'Download all', 'devTheme' );
                      $downloadLink .= apply_filters( 'WPgutenberg_gallery_downloadAllButton', $downloadLinkText, $block['attrs'] );
                    $downloadLink .= '</a>';
                    $downloadLink .= '<div class="progress-bar">';
                      $downloadLink .= '<div class="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>';
                    $downloadLink .= '</div>';
                  $downloadLink .= '</div>';
                  $blockContent .= $downloadLink;
                endif;
              endif;
            endif;
          endif;
        endif;
        // zoom
        if($block['attrs'] && array_key_exists('zoomActive', $block['attrs']) && $block['attrs']['zoomActive'] == true):
          // drag container
          $callPins = prefix_core_BaseFunctions::getBetween($blockContent, '<div class="pins">', '</div>');
          $drag = '<div class="drag-container">';
              if("core/image" == $block['blockName'] && array_key_exists('id', $block['attrs'])):
                $drag .= wp_get_attachment_image($block['attrs']['id'], 'full', false);
              elseif("templates/image-pins" == $block['blockName'] && array_key_exists('imageId', $block['attrs'])):
                $drag .= wp_get_attachment_image($block['attrs']['imageId'], 'full', false);
              else:
                $drag .= strip_tags($blockContent, '<img>');
              endif;
            $drag .= $callPins ? '<div class="pins">' . $callPins . '</div>' : '';
          $drag .= '</div>';
          // zoom configuration
          $zoomPosition = array_key_exists('zoomPosition', $block['attrs']) ? $block['attrs']['zoomPosition'] : 'bottom-right';
          $zoomMax = array_key_exists('zoomMax', $block['attrs']) ? $block['attrs']['zoomMax'] : '2';
          $zoomSteps = array_key_exists('zoomSteps', $block['attrs']) ? $block['attrs']['zoomSteps'] : '0.5';
          // zoom navigation
          $zoom = '<div class="zoom-navigation position-' . $zoomPosition . '" data-zoomcurrent="1" data-zoommax="' . $zoomMax . '" data-zoomstep="' . $zoomSteps . '">';
          $zoom .= '<span class="zoom-in">' . apply_filters( 'WPgutenberg_zoom_in', '+', $block['attrs'] ) . '</span>';
          $zoom .= '<span class="zoom-out disabled">' . apply_filters( 'WPgutenberg_zoom_out', '-', $block['attrs'] ) . '</span>';
          $zoom .= '</div>';
          // insert additional html
          if("core/image" == $block['blockName']):
            $blockContent = str_replace(array('<figure', '</figure>'), array('<figure data-zoom="1"', $zoom . $drag . '</figure>'), $blockContent);
          endif;
          if("templates/image-pins" == $block['blockName']):
            $blockContent = preg_replace('#<div class="pins">(.*?)</div></figure>#', '</figure>', $blockContent);
            $blockContent = str_replace(array('<figure', '</figure>'), array('<figure data-zoom="1"', $zoom . $drag . '</figure>'), $blockContent);
          endif;
        endif;
      endif;
    endif;

    return $blockContent;
  }


  /* 3.4 EXTENTION FILES
  /------------------------*/
  function embedExtentionFiles() {
    if(is_singular()):
      $id = get_the_ID();
      if(has_block('core/video', $id)):
        wp_enqueue_script(
          'video-js',
          'https://vjs.zencdn.net/7.19.2/video.min.js',
          [],
          '7.19.2'
        );
      endif;
      if(has_block('core/gallery', $id)):
        wp_enqueue_script(
          'zip-js',
          get_template_directory_uri() . '/assets/jszip.min.js',
          [],
          '3.10.1'
        );
      endif;
      if(has_block('templates/vimeo', $id)):
        wp_enqueue_script(
          'vimeo-player',
          'https://player.vimeo.com/api/player.js',
          [],
          '2.17.1'
        );
      endif;
    endif;
  }


}
