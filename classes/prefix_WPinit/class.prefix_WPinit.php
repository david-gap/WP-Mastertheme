<?php
/**
 *
 *
 * Wordpress - init configuration
 * https://github.com/david-gap/classes
 *
 * @author      David Voglgsang
 * @version     2.18.15
 *
*/

/*=======================================================
Table of Contents:
---------------------------------------------------------
1.0 INIT & VARS
  1.1 CONFIGURATION
  1.2 ON LOAD RUN
  1.3 BACKEND ARRAY
2.0 FUNCTIONS
  2.1 GET CONFIGURATION FORM CONFIG FILE
  2.2 HEADER CLEANUP
  2.3 RESET INLINE IMAGE DIMENSIONS (FOR CSS-SCALING OF IMAGES)
  2.4 ENQUEUE SCRIPTS/STYLES
  2.5 EMBED GOOGLE FONTS
  2.6 EMBED TYPEKIT FONTS
  2.7 HIDE CORE-UPDATES FOR NON-ADMINS
  2.8 THEME SUPPORT
  2.9 BACKEND CONTROL
  2.10 REGISTER MENUS
  2.11 CLEAN THE CONTENT
  2.12 ADD FILE TYPES TO UPLOADER
  2.13 UPDATE LOCALS
  2.14 EDITORS BACKEND
  2.15 ACF TO REST API
  2.16 LOAD THEME TRANSLATION FILES
  2.17 ADD META SORT TO REST API
3.0 OUTPUT
  3.1 MENU
  3.2 RETURN CUSTOM CSS
=======================================================*/

class prefix_WPinit {

  /*==================================================================================
    1.0 INIT & VARS
  ==================================================================================*/

    /* 1.1 CONFIGURATION
    /------------------------*/
    /**
      * default vars
      * @param private array $WPinit_support: select theme support
      * @param private int $WPinit_css: activate theme styling
      * @param private int $WPinit_cachebust: activate cachebust styling file
      * @param private int $WPinit_cachebust_file: theme cachebust styling path
      * @param private int $WPinit_css_version: theme styling version
      * @param private string $WPinit_css_path: theme styling path (theme is root)
      * @param private string $WPinit_admin_css_path: backend theme styling path (theme is root)
      * @param private int $WPinit_js: activate theme js
      * @param private int $WPinit_js_version: theme js version
      * @param private string $WPinit_js_path: theme js path (theme is root)
      * @param private string $WPinit_admin_js_path: backend theme js path (theme is root)
      * @param private int $WPinit_jquery: activate jquery
      * @param private int $WPinit_upload_svg: enable svg upload
      * @param private array $WPinit_admin_menu: disable backend menus from not admins
      * @param private array $WPinit_EditorMenu: make menu visible for editors
      * @param private array $WPinit_EditorWidget: make widgets visible for editors
      * @param private array $WPinit_EditorCustomizer: make customizer visible for editors
      * @param private array $WPinit_menus: list of all wanted WP menus
      * @param private string $WPinit_typekit_id: typekit fonts
      * @param private array $WPinit_google_fonts: google fonts
      * @param private array $WPinit_HeaderCss: Load cutom theme css in header
      * @param private int $WPinit_imgScaling: Disable default image scaling
    */
    private $WPinit_support            = array("title-tag", "menus", "html5", "post-thumbnails", "custom-line-height");
    private $WPinit_css                = 0;
    private $WPinit_cachebust          = 1;
    private $WPinit_cachebust_file     = '/dist/rev-manifest.json';
    private $WPinit_css_version        = 1.0;
    private $WPinit_css_path           = "/dist/style.min.css";
    private $WPinit_admin_css_path     = "/dist/style_backend.min.css";
    private $WPinit_theme_js_version   = 1.9;
    private $WPinit_theme_css_version  = 1.8;
    private $WPinit_js                 = 0;
    private $WPinit_js_version         = 1.0;
    private $WPinit_js_path            = "/dist/script.min.js";
    private $WPinit_admin_js_path      = "/dist/script_backend.min.js";
    private $WPinit_jquery             = 1;
    private $WPinit_upload_svg         = 1;
    private $WPinit_admin_menu         = array();
    private $WPinit_EditorMenu         = 0;
    private $WPinit_EditorWidget       = 0;
    private $WPinit_EditorCustomizer   = 0;
    private $WPinit_menus              = array(
      array(
        'key' => 'mainmenu',
        'value' => 'Main Menu'
      ),
      array(
        'key' => 'footermenu',
        'value' => 'Footer Menu'
      )
    );
    private $WPinit_upload_types     = array();
    private $WPinit_typekit_id       = '';
    private $WPinit_google_fonts     = array();
    private $WPinit_HeaderCss        = 0;
    private $WPinit_imgScaling       = 0;


    /* 1.2 ON LOAD RUN
    /------------------------*/
    public function __construct() {
      // update default vars with configuration file
      SELF::updateVars();
      // clean wp head
      add_action('wp_head', array( $this, 'WPinit_headcleanup' ), 1);
      // clean WP head
      add_action( 'admin_head', array( $this, 'wp_onlyadmin_update' ), 1 );
      // template translation files
      add_action('after_setup_theme', array( $this, 'themeTranslations' ));
      // disable admin menu
      add_action( 'admin_menu', array( $this, 'Backend_remove_menus' ), 1 );
      // thumbnail dimensions
      add_filter( 'post_thumbnail_html', array( $this, 'wp_remove_thumbnail_dimensions' ), 10, 3);
      // frontend css/js files
      add_action('wp_enqueue_scripts', array( $this, 'WPinit_enqueue' ));
      // add theme support
      SELF::theme_support();
      // add google fonts
      add_action( 'wp_footer', array( $this, 'GoogleFonts' ) );
      // add typekit fonts
      add_action( 'wp_head', array( $this, 'TypekitFonts' ) );
      // add menu
      add_action( 'init', array( $this, 'WPinit_theme_menus' ) );
      // update local language
      add_action( 'init', array( $this, 'WPinit_locals' ) );
      // clean the content
      add_filter( 'the_content', array( $this, 'WPinit_CleanContent' ) );
      // shortcodes
      add_shortcode( 'menu', array( $this, 'WPinit_GetMenu' ) );
      // enable upload types
      add_filter( 'upload_mimes', array( $this, 'AddUploadTypes' ) );
      // backend css/js files
      add_action('admin_enqueue_scripts', array( $this, 'WPinit_enqueue' ));
      add_action( 'admin_head', array( $this, 'GoogleFonts' ) );
      add_action( 'admin_head', array( $this, 'TypekitFonts' ) );
      // acf fields
      add_filter('rest_prepare_post', array( $this, 'ACFtoRestApi' ), 10, 3);
      add_filter('rest_prepare_page', array( $this, 'ACFtoRestApi' ), 10, 3);
      // meta fields sort in rest
      add_filter('rest_post_query', array( $this, 'restMetaQuery' ), 10, 2);
      add_filter('rest_post_collection_params', array( $this, 'restCollectionparms' ), 10, 2);
      add_filter('rest_page_query', array( $this, 'restMetaQuery' ), 10, 2);
      add_filter('rest_page_collection_params', array( $this, 'restCollectionparms' ), 10, 2);
      // return css inside head
      if($this->WPinit_HeaderCss == 1):
        add_action( 'wp_head', array( $this, 'BuildCustomCSS' ), 10, 1 );
      endif;
      // disable image scaling
      if($this->WPinit_imgScaling == 0):
        add_filter( 'big_image_size_threshold', '__return_false' );
      endif;
      // show backend menu for editors
      if (current_user_can('editor')):
        $role_object = get_role( 'editor' );
        if($this->WPinit_EditorMenu == 1 || $this->WPinit_EditorWidget == 1 || $this->WPinit_EditorCustomizer == 1):
          $role_object->add_cap( 'edit_theme_options' );
        else:
          $role_object->remove_cap( 'edit_theme_options' );
        endif;
        add_action('admin_head', array( $this, 'EditorAppearance' ));
      endif;
      // register strings
      $backendStrings = array(
        __('Wordpress settings', 'devTheme'),
        __('Wordpress Support', 'devTheme'),
        __('Embed CSS file', 'devTheme'),
        __('Activate Cache Busting', 'devTheme'),
        __('Embed Jquery file', 'devTheme'),
        __('Embed custom JS file', 'devTheme'),
        __('Load custom css inside header', 'devTheme'),
        __('Enable SVG upload', 'devTheme'),
        __('CSS Version', 'devTheme'),
        __('JS Version', 'devTheme'),
        __('CSS file path', 'devTheme'),
        __('Cache Busting file path', 'devTheme'),
        __('JS file path', 'devTheme'),
        __('Hide backend menu to not admins', 'devTheme'),
        __('Show menu to editors', 'devTheme'),
        __('Show widgets to editors', 'devTheme'),
        __('Show customizer to editors', 'devTheme'),
        __('Registered menu', 'devTheme'),
        __('Slug', 'devTheme'),
        __('Name', 'devTheme'),
        __('Add file types to uploader', 'devTheme'),
        __('Slug', 'devTheme'),
        __('Name', 'devTheme'),
        __('Typekit ID', 'devTheme'),
        __('Embed Google Fonts', 'devTheme')
      );
    }


    /* 1.3 BACKEND ARRAY
    /------------------------*/
    static $classtitle = 'Wordpress settings';
    static $classkey = 'wp';
    static $backend = array(
      "support" => array(
        "label" => "Wordpress Support",
        "type" => "array_addable"
      ),
      "imgSacaling" => array(
        "label" => "IMG scaling",
        "type" => "switchbutton"
      ),
      "menus" => array(
        "label" => "Registered menu",
        "type" => "array_addable",
        "value" => array(
          "key" => array(
            "label" => "Slug",
            "type" => "text"
          ),
          "value" => array(
            "label" => "Name",
            "type" => "text"
          )
        )
      ),
      "upload_types" => array(
        "label" => "Add file types to uploader",
        "type" => "array_addable",
        "value" => array(
          "key" => array(
            "label" => "Slug",
            "type" => "text"
          ),
          "value" => array(
            "label" => "Name",
            "type" => "text"
          )
        )
      ),
      "title_assets" => array(
        "label" => "Assets",
        "type" => "title"
      ),
      "css" => array(
        "label" => "Embed custom CSS file",
        "type" => "switchbutton"
      ),
      "cachebust" => array(
        "label" => "Activate Cache Busting",
        "type" => "switchbutton"
      ),
      "jquery" => array(
        "label" => "Embed Jquery file",
        "type" => "switchbutton"
      ),
      "js" => array(
        "label" => "Embed custom JS file",
        "type" => "switchbutton"
      ),
      "HeaderCss" => array(
        "label" => "Load custom css inside header",
        "type" => "switchbutton"
      ),
      "css_version" => array(
        "label" => "CSS Version",
        "type" => "text"
      ),
      "js_version" => array(
        "label" => "JS Version",
        "type" => "text"
      ),
      // "upload_svg" => array(
      //   "label" => "Enable SVG upload",
      //   "type" => "switchbutton"
      // ),
      // "css_path" => array(
      //   "label" => "CSS file path",
      //   "type" => "text"
      // ),
      // "cachebust_file" => array(
      //   "label" => "Cache Busting file path",
      //   "type" => "text"
      // ),
      // "js_path" => array(
      //   "label" => "JS file path",
      //   "type" => "text"
      // ),
      "title_access" => array(
        "label" => "Backend access",
        "type" => "title"
      ),
      "admin_menu" => array(
        "label" => "Hide backend menu to not admins",
        "type" => "array_addable"
      ),
      "EditorMenu" => array(
        "label" => "Show menu to editors",
        "type" => "switchbutton"
      ),
      "EditorWidget" => array(
        "label" => "Show widgets to editors",
        "type" => "switchbutton"
      ),
      "EditorCustomizer" => array(
        "label" => "Show customizer to editors",
        "type" => "switchbutton"
      ),
      "title_fonts" => array(
        "label" => "Fonts embed",
        "type" => "title"
      ),
      "typekit_id" => array(
        "label" => "Typekit ID",
        "type" => "text"
      ),
      "google_fonts" => array(
        "label" => "Embed Google Fonts",
        "type" => "array_addable"
      )
    );



  /*==================================================================================
    2.0 FUNCTIONS
  ==================================================================================*/

    /* 2.1 GET CONFIGURATION FORM CONFIG FILE
    /------------------------*/
    private function updateVars(){
      // get configuration
      global $configuration;
      // if configuration file exists && class-settings
      if($configuration && array_key_exists('wp', $configuration)):
        // class configuration
        $myConfig = $configuration['wp'];
        // update vars
        $this->WPinit_support = array_key_exists('support', $myConfig) ? $myConfig['support'] : $this->WPinit_support;
        $this->WPinit_google_fonts = array_key_exists('google_fonts', $myConfig) ? $myConfig['google_fonts'] : $this->WPinit_google_fonts;
        $this->WPinit_typekit_id = array_key_exists('typekit_id', $myConfig) ? $myConfig['typekit_id'] : $this->WPinit_typekit_id;
        $this->WPinit_css = array_key_exists('css', $myConfig) ? $myConfig['css'] : $this->WPinit_css;
        $this->WPinit_cachebust = array_key_exists('cachebust', $myConfig) ? $myConfig['cachebust'] : $this->WPinit_cachebust;
        $this->WPinit_cachebust_file = array_key_exists('cachebust_file', $myConfig) ? $myConfig['cachebust_file'] : $this->WPinit_cachebust_file;
        $this->WPinit_css_path = array_key_exists('css_path', $myConfig) ? $myConfig['css_path'] : $this->WPinit_css_path;
        $this->WPinit_admin_css_path = array_key_exists('admin_css_path', $myConfig) ? $myConfig['admin_css_path'] : $this->WPinit_admin_css_path;
        $this->WPinit_css_version = array_key_exists('css_version', $myConfig) ? $myConfig['css_version'] : $this->WPinit_css_path;
        $this->WPinit_js = array_key_exists('js', $myConfig) ? $myConfig['js'] : $this->WPinit_js;
        $this->WPinit_js_version = array_key_exists('js_version', $myConfig) ? $myConfig['js_version'] : $this->WPinit_js_version;
        $this->WPinit_js_path = array_key_exists('js_path', $myConfig) ? $myConfig['js_path'] : $this->WPinit_js_path;
        $this->WPinit_admin_js_path = array_key_exists('admin_js_path', $myConfig) ? $myConfig['admin_js_path'] : $this->WPinit_admin_js_path;
        $this->WPinit_jquery = array_key_exists('jquery', $myConfig) ? $myConfig['jquery'] : $this->WPinit_jquery;
        $this->WPinit_admin_menu = array_key_exists('admin_menu', $myConfig) ? $myConfig['admin_menu'] : $this->WPinit_admin_menu;
        $this->WPinit_EditorMenu = array_key_exists('EditorMenu', $myConfig) ? $myConfig['EditorMenu'] : $this->WPinit_EditorMenu;
        $this->WPinit_EditorWidget = array_key_exists('EditorWidget', $myConfig) ? $myConfig['EditorWidget'] : $this->WPinit_EditorWidget;
        $this->WPinit_EditorCustomizer = array_key_exists('EditorCustomizer', $myConfig) ? $myConfig['EditorCustomizer'] : $this->WPinit_EditorCustomizer;
        $this->WPinit_menus = array_key_exists('menus', $myConfig) ? array_merge($this->WPinit_menus, $myConfig['menus']) : $this->WPinit_menus;
        $this->WPinit_upload_svg = array_key_exists('upload_svg', $myConfig) ? $myConfig['upload_svg'] : $this->WPinit_upload_svg;
        $this->WPinit_upload_types = array_key_exists('upload_types', $myConfig) ? $myConfig['upload_types'] : $this->WPinit_upload_types;
        $this->WPinit_HeaderCss = array_key_exists('HeaderCss', $myConfig) ? $myConfig['HeaderCss'] : $this->WPinit_HeaderCss;
        $this->WPinit_imgScaling = array_key_exists('imgSacaling', $myConfig) ? $myConfig['imgSacaling'] : $this->WPinit_imgScaling;
      endif;
    }

    /* 2.2 HEADER CLEANUP
    /------------------------*/
    // remove unused stuff from wp_head()
    function WPinit_headcleanup () {
      // remove the generator meta tag
      remove_action('wp_head', 'wp_generator', 10);
      // remove wlwmanifest link
      remove_action('wp_head', 'wlwmanifest_link');
      // remove RSD API connection
      remove_action('wp_head', 'rsd_link');
      // remove wp shortlink support
      remove_action('wp_head', 'wp_shortlink_wp_head');
      // remove next/previous links (this is not affecting blog-posts)
      remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
      // remove generator name from RSS
      add_filter('the_generator', '__return_false');
      // disable emoji support
      remove_action('wp_head', 'print_emoji_detection_script', 7);
      remove_action('wp_print_styles', 'print_emoji_styles');
      // disable automatic feeds
      remove_action('wp_head', 'feed_links_extra', 3);
      remove_action('wp_head', 'feed_links', 2);
      // remove rest API link
      remove_action( 'wp_head', 'rest_output_link_wp_head', 10);
      // remove oEmbed link
      remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10);
      remove_action('wp_head', 'wp_oembed_add_host_js');
    }


    /* 2.3 RESET INLINE IMAGE DIMENSIONS (FOR CSS-SCALING OF IMAGES)
    /------------------------*/
    function wp_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
      $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html);
      return $html;
    }


    /* 2.4 ENQUEUE SCRIPTS/STYLES
    /------------------------*/
    // enqueues scripts and styles (optional typekit embed)
    // >> https://developer.wordpress.org/reference/functions/wp_enqueue_script/
    function WPinit_enqueue() {
      // template javascript
        wp_register_script('theme/scripts', get_template_directory_uri() . $this->WPinit_js_path, ['jquery'], $this->WPinit_theme_js_version, true);
        wp_enqueue_script('theme/scripts');
        # get theme directory for javascript files
        wp_localize_script( 'theme/scripts', 'theme_directory', get_stylesheet_directory_uri());
        # get configuration settings from config file for javascript files
        $configuration_file = get_stylesheet_directory_uri() . '/configuration.json';
        // check if file exists or empty
        if(file_exists($configuration_file) && filesize($configuration_file) > 0):
          $configuration_content = file_get_contents($configuration_file);
          $configuration = json_decode($configuration_content,true);
        else:
          $configuration = get_option('WPadmin_configuration') ? get_option('WPadmin_configuration') : false;
        endif;
        wp_localize_script( 'theme/scripts', 'configurations', $configuration);
        // add block ajax path to main js file
        $postsBlock = '../mastertheme/classes/prefix_WPgutenberg/blocks/posts/ajax.php';
        $postsFilterBlock = '../mastertheme/classes/prefix_WPgutenberg/blocks/postsfilter/ajax.php';
        wp_localize_script( 'theme/scripts', 'postsBlock', $postsBlock);
        wp_localize_script( 'theme/scripts', 'postsFilterBlock', $postsFilterBlock);
        // add core ajax path
        $mainAjax = '../mastertheme/main-ajax.php';
        wp_localize_script( 'theme/scripts', 'mainPath', $mainAjax);
      // template css
        wp_enqueue_style('theme/styles', get_template_directory_uri() . '' . $this->WPinit_css_path, false, $this->WPinit_theme_css_version);
      // jQuery (from wp core)
      if ($this->WPinit_jquery == 1 && !is_admin()):
        wp_deregister_script( 'jquery' );
        wp_register_script('jquery', get_template_directory_uri() . '/assets/jquery-3.5.1.min.js', false, '3.5.1');
        wp_enqueue_script( 'jquery' );
      endif;
      // scripts
      if ($this->WPinit_js == 1 && !is_admin()):
        wp_register_script('custom/scripts', get_stylesheet_directory_uri() . $this->WPinit_js_path, ['jquery'], $this->WPinit_js_version, true);
        wp_enqueue_script('custom/scripts');
        # get custom directory for javascript files
        wp_localize_script( 'custom/scripts', 'theme_directory', get_stylesheet_directory_uri());
      endif;
      if (is_admin()):
        wp_register_script('theme/backend-scripts', get_stylesheet_directory_uri() . $this->WPinit_admin_js_path, $this->WPinit_js_version, true);
        wp_enqueue_script('theme/backend-scripts');
        wp_enqueue_style('theme/backend-styles', get_stylesheet_directory_uri() . '' . $this->WPinit_admin_css_path, false, $this->WPinit_theme_css_version);
        # get theme directory for javascript files
        wp_localize_script( 'theme/backend-scripts', 'theme_directory', get_stylesheet_directory_uri());
      endif;
      // styles
      if ($this->WPinit_css == 1):
        if($this->WPinit_cachebust == 1):
          $bust_file = get_stylesheet_directory_uri() . $this->WPinit_cachebust_file;
          $css_manifest_content = json_decode(file_get_contents($bust_file), true);
          $file = '/dist/'.$css_manifest_content['style.min.css'];
        else:
          $file = $this->WPinit_css_path;
        endif;
        wp_enqueue_style('custom/styles', get_stylesheet_directory_uri() . $file, false, $this->WPinit_css_version);
      endif;
    }


    /* 2.5 EMBED GOOGLE FONTS
    /------------------------*/
    function GoogleFonts(){
      if($this->WPinit_google_fonts):
        // embed start
        $output = '<link href="https://fonts.googleapis.com/css?family=';
        if(is_array($this->WPinit_google_fonts)):
          // array output
          $row = count($this->WPinit_google_fonts);
          foreach ($this->WPinit_google_fonts as $value) {
            $output .= $value;
            $output .= $row > 1 ? '|' : '';
            $row--;
          }
        else:
          // fallback for a string
          $output .= $this->WPinit_google_fonts;
        endif;
        // embed end
        $output .= '&display=swap" rel="stylesheet">';
        // return result
        echo $output;
      endif;
    }


    /* 2.6 EMBED TYPEKIT FONTS
    /------------------------*/
    function TypekitFonts(){
      if($this->WPinit_typekit_id !== ''):
        // embed typekit
        $output = '<link rel="stylesheet" href="https://use.typekit.net/' . $this->WPinit_typekit_id . '.css">';
        echo $output;
      endif;
    }


    /* 2.7 HIDE CORE-UPDATES FOR NON-ADMINS
    /------------------------*/
    function wp_onlyadmin_update() {
      if (!current_user_can('update_core')) { remove_action( 'admin_notices', 'update_nag', 3 ); }
    }


    /* 2.8 THEME SUPPORT
    /------------------------*/
    function theme_support()  {
      if($this->WPinit_support):
        foreach ($this->WPinit_support as $key => $value) {
          add_theme_support($value);
        }
      endif;
    }


    /* 2.9 BACKEND CONTROL
    /------------------------*/
    /**
    * Removes some menus by page.
    */
    function Backend_remove_menus(){
      // get current login user's role
      $roles = wp_get_current_user()->roles;
      // test role
      if( in_array('administrator',$roles)){
      return;
      }
      if(!empty($this->WPinit_admin_menu)):
        foreach ($this->WPinit_admin_menu as $key => $value) {
          remove_menu_page( $value );
        }
      endif;
      // index.php                  // Dashboard
      // edit.php                   // Posts
      // upload.php                 // Media
      // edit.php?post_type=page    // Pages
      // edit-comments.php          // Comments
      // themes.php                 // Appearance
      // plugins.php                // Plugins
      // users.php                  // Users
      // tools.php                  // Tools
      // options-general.php        // Settings
    }


    /* 2.10 REGISTER MENUS
    /------------------------*/
    // => https://codex.wordpress.org/Function_Reference/register_nav_menus
    function WPinit_theme_menus() {
      if(is_array($this->WPinit_menus)):
        $menus = array();
        foreach ($this->WPinit_menus as $key => $menu) {
          $menus[$menu["key"]] = $menu["value"];
        }
        register_nav_menus($menus);
      endif;
    }


    /* 2.11 CLEAN THE CONTENT
    /------------------------*/
    function WPinit_CleanContent( $content ) {
      return preg_replace( '/[\r\n]+/', "\n", $content );
    }


    /* 2.12 ADD FILE TYPES TO UPLOADER
    /------------------------*/
    function AddUploadTypes($mime_types){
      // if svg is enabled
      if ($this->WPinit_upload_svg == 1):
        $mime_types['svg'] = 'image/svg+xml';
        $mime_types['svgz'] = 'image/svg+xml';
      endif;
      // additional file types
      if(is_array($this->WPinit_upload_types)):
        foreach ($this->WPinit_upload_types as $key => $type) {
          $mime_types[$type["key"]] = $type["value"];
        }
      endif;
      // return
      return $mime_types;
    }


    /* 2.13 UPDATE LOCALS
    /------------------------*/
    function WPinit_locals(){
      // local language for frontend
      if (!is_admin()) {
        $language = prefix_core_BaseFunctions::getCurrentLang() . '_' . strtoupper(prefix_core_BaseFunctions::getCurrentLang());
        setlocale(LC_TIME, $language);
      }
    }


    /* 2.14 EDITORS BACKEND
    /------------------------*/
    function EditorAppearance(){
      // menu
      if($this->WPinit_EditorMenu == 0):
        remove_submenu_page( 'themes.php', 'nav-menus.php' );
      endif;
      // widgets
      if($this->WPinit_EditorWidget == 0):
        remove_submenu_page( 'themes.php', 'widgets.php' );
      endif;
      // customizer
      if($this->WPinit_EditorCustomizer == 0):
        remove_submenu_page( 'themes.php', 'customize.php?return=%2Fwp-admin%2F' );
      endif;
      // remove themes selection from editors
      remove_submenu_page( 'themes.php', 'themes.php' );
    }


    /* 2.15 ACF TO REST API
    /------------------------*/
    function ACFtoRestApi($response, $post, $request) {
        if (!function_exists('get_fields')) return $response;
        if (isset($post)) {
            $acf = get_fields($post->id);
            if($acf):
              foreach ($acf as $key => $value) {
                // code...
                $response->data['meta'][$key] = $value;
              }
            endif;
        }
        return $response;
    }


    /* 2.16 LOAD THEME TRANSLATION FILES
    /------------------------*/
    function themeTranslations(){
      load_theme_textdomain('devTheme', get_template_directory() . '/languages');
    }


    /* 2.17 ADD META SORT TO REST API
    /------------------------*/
    public function restMetaQuery($args, $request) {
      if ( isset( $request['meta_key']) && !empty($request['meta_key'] ) ) {
        $args['meta_key'] = $request['meta_key'];
      }
      return $args;
    }
    public function restCollectionparms($query_params, $post_type){
      array_push($query_params['orderby']['enum'],'meta_value' );
      return $query_params;
    }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

  /* 3.1 MENU
  /------------------------*/
  public static function WPinit_GetMenu($atts){
    $config = shortcode_atts( array(
      'slug' => 'mainmenu',
      'css' => '',
      'container' => '0',
      'nav' => '1',
      'direction' => 'vertical',
      'seperator' => '0'
    ), $atts );
    $output = '';
    if ( has_nav_menu( $config['slug'] ) ) :
      // container
      if($config['container'] == 1):
        $container = true;
      else:
        $container = false;
      endif;
      // css
      $css = 'wp-menu';
      if($config['css'] !== ''):
        $css .= ' ' . $config['css'];
      endif;
      if($config['direction'] == 'h' || $config['direction'] == 'horizontal'):
        $css .= ' horizontal';
      endif;
      if($config['seperator'] == 1):
        $css .= ' menu-seperated';
      endif;
      // output
      if($config['nav']):
        $output .= '<nav>';
      endif;
        $output .= wp_nav_menu([
          'menu_class'=> $css,
          'menu_id' => 'menu_' . $config['slug'],
          'container'=> $container,
          'theme_location' => $config['slug'],
          'echo' => false
        ]);
      if($config['nav']):
        $output .= '</nav>';
      endif;

    endif;
    return $output;
  }

  /* 3.2 RETURN CUSTOM CSS
  /------------------------*/
  function BuildCustomCSS($container = true){
    // vars
    $output = '';
    $classesoutput = '';
    // build styling
    $registered_classes = get_declared_classes();
    foreach ($registered_classes as $class_key => $classname) {
      if(strpos($classname, 'prefix_') === 0 && strpos($classname, '_core_') == false && method_exists($classname, 'returnCustomCSS')):
        $classesoutput .= $classname::returnCustomCSS();
      endif;
    }
    // return styling
    if($classesoutput !== ''):
      $output .= $container !== false ? '<style id="WPgutenberg_styles" type="text/css">' : '';
        $output .= $classesoutput;
      $output .= $container !== false ? '</style>' : '';
    endif;

    // return
    if($container !== false):
      echo $output;
    else:
      return $output;
    endif;
  }



}
