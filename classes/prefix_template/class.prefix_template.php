<?php
/**
 *
 *
 * Basic template parts
 * https://github.com/david-gap/classes
 *
 * @author      David Voglgsang
 * @version     2.33.17
 *
*/

/*=======================================================
Table of Contents:
---------------------------------------------------------
1.0 INIT & VARS
  1.1 CONFIGURATION
  1.2 ON LOAD RUN
  1.3 BACKEND ARRAY
  1.4 PAGE OPTIONS - CREATE META BOX
2.0 FUNCTIONS
  2.1 GET CONFIGURATION FORM CONFIG FILE
  2.2 ACTIVATE CONTAINER CSS CLASS FOR HEADER/FOOTER
  2.3 STICKY HEADER
  2.4 SAVE METABOXES
  2.5 REGISTER WIDGETS
  2.6 REBUILD SEARCH FORM
  2.7 ADD VALUES TO REST API
  2.8 REDIRECT DETAIL PAGE
  2.9 EXTEND THUMBNAIL
3.0 OUTPUT
  3.1 SORTABLE HEADER CONTENT
  3.2 SORTABLE FOOTER CONTENT
  3.3 BACKEND PAGE OPTIONS - METABOX
  3.4 PAGE OPTIONS
  3.5 PLACEHOLDER
  3.6 LOGO
  3.7 MAIN MENU
  3.8 ADDRESS BLOCK
  3.9 DIVIDE HEADER FROM CONTENT
  3.10 FOOTER MENU
  3.11 COPYRIGHT
  3.12 SOCIAL MEDIA
  3.13 CONTACT BLOCK
  3.14 ICON BLOCK
  3.15 CONTENT BLOCK
  3.16 BODY CSS
  3.17 BODY ATTRIBUTES
  3.18 POST META
  3.19 SCROLL TO TOP BUTTON
  3.20 MAIN MENU SEARCH FORM
  3.21 RETURN WIDGET
  3.22 LANGUAGE SWITCHER
  3.23 THUMBNAIL
  3.24 BREADCRUMBS
  3.25 ARRAY OF ALL TEMPLATE PARTS
=======================================================*/


class prefix_template {

  /*==================================================================================
    1.0 INIT & VARS
  ==================================================================================*/

  /* 1.1 CONFIGURATION
  /------------------------*/
  /**
    * default vars
    * @param static int $template_container_header: activate container for the header
    * @param static int $template_container_breadcrumbs: activate container for the breadcrumbs
    * @param static int $template_container: activate container for the content
    * @param static int $template_container_totop: activate container for the scroll to top button
    * @param static int $template_container_footer: activate container for the footer
    * @param static string $template_coloring: template coloring (dark/light)
    * @param static bool $template_ph_active: activate placeholder
    * @param static bool $template_ph_address: placeholder show address block
    * @param static string $template_ph_custom: placeholder custom content
    * @param static array $template_address: address block content
    * @param static array $template_socialmedia: social media
    * @param static int $template_header_wrap: Allow the header content to wrap
    * @param static int $template_header_divider: Activate header divider
    * @param static int $template_header_sticky: activate sticky header
    * @param static int $template_header_stickyload: activate sticky header on load
    * @param static int $template_header_dmenu: Activate header hamburger for desktop
    * @param static int $template_header_menusearchform: Activate searchform inside the main menu
    * @param static string $template_header_menu_style: Select menu direction (options: horizontal/vertical)
    * @param static string $template_header_hmenu_style: Select hamburger menu style (options: fullscreen, top, top_contained, left, left_contained, right, right_contained)
    * @param static int $template_header_hmenu_text: Show text on hamburger menu button
    * @param static int $template_header_hmenu_streched: Strech main menu verticaly
    * @param static int $template_header_hmenu_visible_head: Define if header is visible on active hamburger menu
    * @param static int $template_header_hmenu_scroll: Define if hamburger menu close by scrolling (Desktop only)
    * @param static string $template_header_hmenu_toggle: Hamburger Menü toggle able submenus
    * @param static string $template_header_custom:  Custom header html
    * @param static array $template_header_sort: Sort and activate blocks inside header builder
    * @param static string $template_header_logo_link: Logo link with wordpress fallback
    * @param static array $template_header_logo_d: desktop logo configuration
    * @param static array $template_header_logo_m: mobile logo configuration
    * @param static array $template_header_logo_scrolled: scrolled logo configuration
    * @param static array $template_header_logo_svg: Insert SVG code as logo
    * @param static string $template_header_after: html code after header
    * @param static int $template_page_active: activate page options
    * @param static array $template_page_additional: additional custom fields template elements
    * @param static array $template_page_metablock: activate metablock on detail page/posts
    * @param static array $template_page_metablockAdds: Add metabox to CPT by slugs
    * @param static array $template_page_options: show/hide template elements
    * @param static int $template_thumbvideo: Activate video as thumbnail
    * @param static int $template_page_bgColor: Activate custom background color
    * @param static int $template_page_bgImg: Activate custom background image
    * @param static int $template_scrolltotop_active: activate scroll to top
    * @param static int $template_footer_active: activate footer
    * @param static int $template_footer_wrap: Allow the footer content to wrap
    * @param static string $template_footer_cr: copyright text
    * @param static string $template_footer_custom: custom html
    * @param static string $template_footer_menu: footer menu settings
    * @param static array $template_footer_sort: Sort and activate blocks inside footer builder
    * @param static string $template_footer_before: html code before footer
    * @param static string $template_searchform_autocomplete: configure the autocomplete in the search form
    * @param static int $template_breadcrumbs_active: activate breadcrumbs
    * @param static int $template_breadcrumbs_inside: Place breadcrumbs inside page content and if first element is image than after image
    * @param static int $template_breadcrumbs_intro: Show introduction text
    * @param static int $template_breadcrumbs_home: Show home link
    * @param static string $template_breadcrumbs_separator: Separate crumbs by string
    * @param static int $template_languageSwitcher_separat: Separat languages
    * @param static string $template_languageSwitcher_direction: Select direction
    * @param static string $template_languageSwitcher_nameDisplay: Select what should be displayed in the language switcher
    * @param static int $template_thumbnail_div: return thumbnail in a div to repeat it
    * @param static string $template_thumbnail_align: align all thumbnails
    * @param static string $template_404_align: align 404 page thumbnail
    * @param static string $template_search_align: align search results page thumbnail
    * @param static int $template_404_searchForm: Display search form on 404 page
    * @param static int $template_404_backToHome: Display back to home page button on 404 page
  */
  static $template_container_header                = 1;
  static $template_container_breadcrumbs           = 1;
  static $template_container                       = 1;
  static $template_container_totop                 = 1;
  static $template_container_footer                = 1;
  static $template_container_header_wide           = 0;
  static $template_container_footer_wide           = 0;
  static $template_coloring                        = "light";
  static $template_ph_active                       = true;
  static $template_ph_address                      = true;
  static $template_ph_custom                       = "";
  static $template_address                         = array(
    'logo' => array(
      "img" => "",
      "width" => "",
      "height" => "",
      "alt" => ""
    ),
    'company' => '',
    'name' => '',
    'street' => '',
    'street2' => '',
    'postalCode' => '',
    'city' => '',
    'country' => '',
    'phone' => '',
    'fax' => '',
    'mobile' => '',
    'email' => '',
    'labels' => array(
      'company' => '',
      'name' => '',
      'street' => '',
      'street2' => '',
      'postalCode' => '',
      'city' => '',
      'country' => '',
      'phone' => '',
      'fax' => '',
      'mobile' => '',
      'email' => ''
    )
  );
  static $template_socialmedia                     = array(
    "facebook" => "",
    "instagram" => ""
  );
  static $template_contactblock                    = array(
    "phone" => "",
    "mail" => "",
    "whatsapp" => ""
  );
  static $template_header_divider                  = 1;
  static $template_header_wrap                     = 0;
  static $template_header_sticky                   = 1;
  static $template_header_stickyload               = 0;
  static $template_header_dmenu                    = 1;
  static $template_header_menusearchform           = 0;
  static $template_header_menu_style               = 'horizontal';
  static $template_header_hmenu_style              = 'fullscreen';
  static $template_header_hmenu_visible_head       = 0;
  static $template_header_hmenu_text               = '';
  static $template_header_hmenu_containerDirection = 'horizontal';
  static $template_header_hmenu_streched           = 0;
  static $template_header_hmenu_scroll             = 0;
  static $template_header_hmenu_toggle             = 0;
  static $template_header_custom                   = "";
  static $template_header_sort                     = array(
    "container_start" => 1,
    "logo" => 1,
    "menu" => 1,
    "hamburger" => 1,
    "socialmedia" => 0,
    "custom" => 0,
    "searchform" => 0,
    "languages" => 0,
    "widget_one" => 0,
    "widget_two" => 0,
    "widget_three" => 0,
    "thumbnail" => 0,
    "container_end" => 1
  );
  static $template_header_logo_link                = "";
  static $template_header_logo_d                   = array(
    "img" => "",
    "width" => "",
    "height" => "",
    "alt" => ""
  );
  static $template_header_logo_m                   = array(
    "img" => "",
    "width" => "",
    "height" => "",
    "alt" => ""
  );
  static $template_header_logo_scrolled            = array(
    "img" => "",
    "width" => "",
    "height" => "",
    "alt" => ""
  );
  static $template_header_logo_svg                 = "";
  static $template_header_after                    = "";
  static $template_page_active                     = 1;
  static $template_page_options                    = array(
    "disableDetailpage" => 0,
    "header" => 1,
    "header_fixed" => 1,
    "date" => 0,
    "time" => 0,
    "author" => 0,
    "title" => 1,
    "titleWide" => 0,
    "thumbnail" => 1,
    "thumbnailWide" => 0,
    "thumbnailFull" => 0,
    "comments" => 1,
    "sidebar" => 1,
    "scrolltotop" => 0,
    "footer" => 1,
    "darkmode" => 1,
    "beforeMain" => 1,
    "afterMain" => 1
  );
  static $template_thumbvideo                     = 0;
  static $template_page_bgColor                    = 0;
  static $template_page_bgImg                      = 0;
  static $template_page_metablock                  = array(
    "page" => 0,
    "post" => 0
  );
  static $template_page_metablockAdds              = array();
  static $template_blog_type                       = 1;
  static $template_blog_type_parts                 = array(
    "author" => 0,
    "date" => 0,
    "time" => 0,
    "categories" => 0
  );
  static $template_blog_dateformat                 = 'd.m.Y';
  static $template_page_additional                 = array();
  static $template_scrolltotop_active              = 0;
  static $template_footer_active                   = 1;
  static $template_footer_wrap                     = 0;
  static $template_footer_cr                       = "";
  static $template_footer_custom                   = "";
  static $template_footer_menu                     = array(
    'direction' => 'vertical',
    'seperator' => '0',
    'css' => ''
  );
  static $template_footer_sort                     = array(
    "container_start" => 1,
    "menu" => 1,
    "socialmedia" => 1,
    "copyright" => 1,
    "address" => 1,
    "custom" => 0,
    "languages" => 0,
    "searchform" => 0,
    "container_end" => 1,
    "widget_one" => 0,
    "widget_two" => 0,
    "widget_three" => 0
  );
  static $template_footer_before                   = "";
  static $template_footer_after                    = "";
  static $template_searchform_autocomplete         = 0;
  static $template_breadcrumbs_active              = 0;
  static $template_breadcrumbs_inside              = 0;
  static $template_breadcrumbs_intro               = 0;
  static $template_breadcrumbs_home                = 1;
  static $template_breadcrumbs_separator           = '&raquo;';
  static $template_languageSwitcher_separat        = 0;
  static $template_languageSwitcher_direction      = 'horizontal';
  static $template_languageSwitcher_nameDisplay    = 'slug';
  static $template_thumbnail_div                   = 0;
  static $template_thumbnail_404                   = 0;
  static $template_thumbnail_search                = 0;
  static $template_thumbnail_align                 = 'normal';
  static $template_404_align                       = 'normal';
  static $template_search_align                    = 'normal';
  static $template_404_searchForm                  = 0;
  static $template_404_backToHome                  = 1;


  /* 1.2 ON LOAD RUN
  /------------------------*/
  public function __construct() {
    // update default vars with configuration file
    SELF::updateVars();
    // add page options to backend
    if(SELF::$template_page_active == 1 || SELF::$template_page_bgColor == 1 || SELF::$template_page_bgImg == 1):
      // metabox for option selection
      add_action( 'add_meta_boxes', array( $this, 'WPtemplate_Metabox' ) );
      // update custom fields
      add_action('save_post', array( $this, 'WPtemplate_meta_Save' ),  10, 2 );
    endif;
    // extend thumbnail metabox
    add_filter( 'admin_post_thumbnail_html', array( $this, 'extendThumbnailMetabox' ), 10, 2 );
    add_filter( 'post_thumbnail_html', array( $this, 'extendThumbnailOutput' ), 10, 5 );
    // register widgets
    SELF::registerCustomWidgets();
    // shortcodes
    add_shortcode( 'socialmedia', array( $this, 'SocialMedia' ) );
    add_shortcode( 'copyright', array( $this, 'Copyright' ) );
    add_shortcode('languages', array( $this, 'languageSwitcher') );
    // add post formats
    if(SELF::$template_blog_type == 1):
      add_theme_support( 'post-formats', array( 'image', 'video', 'audio' ) );
    endif;
    // add post formats
    if(SELF::$template_header_hmenu_toggle == 1):
      add_filter( 'nav_menu_item_title', array( $this, 'addToggleElementToMenu' ), 10, 2 );
    endif;
    // add search form to main menu
    if(SELF::$template_header_menusearchform == 1):
      add_filter('wp_nav_menu_items', array( $this, 'addSearchFormToMainmenu' ), 10, 2);
    endif;
    // add breadcrumbs to content
    if(SELF::$template_breadcrumbs_inside == 1):
      add_filter( 'the_content', array( $this, 'breadcrumbNavigation' ), 50 );
    endif;
    // redirect detail pages
    add_action( 'template_redirect', array($this, 'redirectDetailPage') );
    // register strings
    $backendStrings = array(
      __('Template', 'devTheme'),
      __('Activate header container', 'devTheme'),
      __('Activate breadcrumbs container', 'devTheme'),
      __('Activate main container', 'devTheme'),
      __('Activate scroll to top container', 'devTheme'),
      __('Activate footer container', 'devTheme'),
      __('Body css (light/dark)', 'devTheme'),
      __('Addressblock information', 'devTheme'),
      __('Logo', 'devTheme'),
      __('SVG Logo', 'devTheme'),
      __('Logo on scrolled', 'devTheme'),
      __('URL', 'devTheme'),
      __('Width', 'devTheme'),
      __('Height', 'devTheme'),
      __('Alternative text', 'devTheme'),
      __('Company', 'devTheme'),
      __('Name', 'devTheme'),
      __('Street', 'devTheme'),
      __('Street add', 'devTheme'),
      __('Postcode', 'devTheme'),
      __('City', 'devTheme'),
      __('Country', 'devTheme'),
      __('Phone', 'devTheme'),
      __('Fax', 'devTheme'),
      __('Mobile', 'devTheme'),
      __('E-Mail', 'devTheme'),
      __('Labels', 'devTheme'),
      __('Company', 'devTheme'),
      __('Name', 'devTheme'),
      __('Street', 'devTheme'),
      __('Street add', 'devTheme'),
      __('Postcode', 'devTheme'),
      __('City', 'devTheme'),
      __('Country', 'devTheme'),
      __('Phone', 'devTheme'),
      __('Fax', 'devTheme'),
      __('Mobile', 'devTheme'),
      __('E-Mail', 'devTheme'),
      __('Social Media block (Icons)', 'devTheme'),
      __('Facebook', 'devTheme'),
      __('Instagram', 'devTheme'),
      __('Twitter', 'devTheme'),
      __('Linkedin', 'devTheme'),
      __('Contact block (Icons)', 'devTheme'),
      __('Phone', 'devTheme'),
      __('Mail', 'devTheme'),
      __('WhatsApp', 'devTheme'),
      __('Placeholder', 'devTheme'),
      __('Activate placeholder', 'devTheme'),
      __('Add Adressblock', 'devTheme'),
      __('Custom output', 'devTheme'),
      __('Header', 'devTheme'),
      __('Activate divider', 'devTheme'),
      __('Sticky header', 'devTheme'),
      __('Sticky header on load', 'devTheme'),
      __('Desktop menu', 'devTheme'),
      __('Activate menu search form', 'devTheme'),
      __('Menu direction', 'devTheme'),
      __('Hamburger menu position', 'devTheme'),
      __('Hamburger text', 'devTheme'),
      __('Visible header while menu is active', 'devTheme'),
      __('Close hamburger menu on scroll', 'devTheme'),
      __('Hamburger menu toggle able submenus', 'devTheme'),
      __('Custom Element', 'devTheme'),
      __('Custom Logo link', 'devTheme'),
      __('Logo desktop', 'devTheme'),
      __('URL', 'devTheme'),
      __('Width', 'devTheme'),
      __('Height', 'devTheme'),
      __('Alternative text', 'devTheme'),
      __('Logo mobile', 'devTheme'),
      __('URL', 'devTheme'),
      __('Width', 'devTheme'),
      __('Height', 'devTheme'),
      __('Alternative text', 'devTheme'),
      __('Sort and activate', 'devTheme'),
      __('Container start', 'devTheme'),
      __('Logo', 'devTheme'),
      __('Menu', 'devTheme'),
      __('Hamburger', 'devTheme'),
      __('social media', 'devTheme'),
      __('Search form', 'devTheme'),
      __('Custom', 'devTheme'),
      __('Widget 1', 'devTheme'),
      __('Widget 2', 'devTheme'),
      __('Widget 3', 'devTheme'),
      __('Container end', 'devTheme'),
      __('Custom content after header', 'devTheme'),
      __('Page', 'devTheme'),
      __('Activate page options', 'devTheme'),
      __('Activate metablock', 'devTheme'),
      __('Pages', 'devTheme'),
      __('Posts', 'devTheme'),
      __('Metablock for CPT', 'devTheme'),
      __('Page options', 'devTheme'),
      __('Hide header', 'devTheme'),
      __('Hide date', 'devTheme'),
      __('Hide thumbnail', 'devTheme'),
      __('Hide time', 'devTheme'),
      __('Hide author', 'devTheme'),
      __('Hide title', 'devTheme'),
      __('Hide comments', 'devTheme'),
      __('Hide sidebar', 'devTheme'),
      __('Hide scroll to top', 'devTheme'),
      __('Hide footer', 'devTheme'),
      __('Darkmode', 'devTheme'),
      __('Header fixed', 'devTheme'),
      __('Code before main block', 'devTheme'),
      __('Code after main block', 'devTheme'),
      __('Add page options', 'devTheme'),
      __('Option key', 'devTheme'),
      __('Option label', 'devTheme'),
      __('Blog', 'devTheme'),
      __('Activate blog template options', 'devTheme'),
      __('Show on overview pages', 'devTheme'),
      __('Activate author', 'devTheme'),
      __('Activate date', 'devTheme'),
      __('Activate time', 'devTheme'),
      __('Activate categories', 'devTheme'),
      __('Date format', 'devTheme'),
      __('Activate scroll to top', 'devTheme'),
      __('Footer', 'devTheme'),
      __('Activate footer', 'devTheme'),
      __('Copyright', 'devTheme'),
      __('Custom Element', 'devTheme'),
      __('Sort and activate', 'devTheme'),
      __('Container start', 'devTheme'),
      __('Menu', 'devTheme'),
      __('Social media', 'devTheme'),
      __('Copyright', 'devTheme'),
      __('Address block', 'devTheme'),
      __('Custom', 'devTheme'),
      __('Search form', 'devTheme'),
      __('Widget 1', 'devTheme'),
      __('Widget 2', 'devTheme'),
      __('Widget 3', 'devTheme'),
      __('Container end', 'devTheme'),
      __('Custom content before footer', 'devTheme'),
      __('Custom content after footer', 'devTheme'),
      __('Search form', 'devTheme'),
      __('Autocomplete', 'devTheme'),
      __('Activate breadcrumbs', 'devTheme'),
      __('Place breadcrumbs inside content and after img (if its the first element)', 'devTheme'),
      __('Show introduction text', 'devTheme'),
      __('Show home link', 'devTheme'),
      __('Separate by', 'devTheme'),
      __('Strech main menu verticaly', 'devTheme')
    );
    // REST API
    add_action( 'rest_api_init', array($this, 'addContentToRestApi') );
  }


  /* 1.3 BACKEND ARRAY
  /------------------------*/
  static $classtitle = 'Template';
  static $classkey = 'template';
  static $backend = array(
    "container_header" => array(
      "label" => "Activate header container",
      "type" => "switchbutton"
    ),
    "container_breadcrumbs" => array(
      "label" => "Activate breadcrumbs container",
      "type" => "switchbutton"
    ),
    "container" => array(
      "label" => "Activate main container",
      "type" => "switchbutton"
    ),
    "container_scrolltotop" => array(
      "label" => "Activate scroll to top container",
      "type" => "switchbutton"
    ),
    "container_footer" => array(
      "label" => "Activate footer container",
      "type" => "switchbutton"
    ),
    "container_header_wide" => array(
      "label" => "Activate header wide container",
      "type" => "switchbutton"
    ),
    "container_footer_wide" => array(
      "label" => "Activate footer wide container",
      "type" => "switchbutton"
    ),
    "coloring" => array(
      "label" => "Body css (light/dark)",
      "type" => "text"
    ),
    "address" => array(
      "label" => "Addressblock information",
      "type" => "multiple",
      "value" => array(
        "logo" => array(
          "label" => "Logo",
          "type" => "multiple",
          "value" => array(
            "img" => array(
              "label" => "URL",
              "type" => "img",
              "translation" => 'template_address_logo_img'
            ),
            "width" => array(
              "label" => "Width",
              "type" => "text"
            ),
            "height" => array(
              "label" => "Height",
              "type" => "text"
            ),
            "alt" => array(
              "label" => "Alternative text",
              "type" => "text",
              "translation" => 'template_address_logo_alt',
            )
          )
        ),
        "company" => array(
          "label" => "Company",
          "type" => "text",
          "translation" => 'template_address_company'
        ),
        "name" => array(
          "label" => "Name",
          "type" => "text",
          "translation" => 'template_address_name'
        ),
        "street" => array(
          "label" => "Street",
          "type" => "text",
          "translation" => 'template_address_street'
        ),
        "street2" => array(
          "label" => "Street add",
          "type" => "text",
          "translation" => 'template_address_street2'
        ),
        "postalCode" => array(
          "label" => "Postcode",
          "type" => "text",
          "translation" => 'template_address_postalCode'
        ),
        "city" => array(
          "label" => "City",
          "type" => "text",
          "translation" => 'template_address_city'
        ),
        "country" => array(
          "label" => "Country",
          "type" => "text",
          "translation" => 'template_address_country'
        ),
        "phone" => array(
          "label" => "Phone",
          "type" => "text",
          "translation" => 'template_address_phone'
        ),
        "fax" => array(
          "label" => "Fax",
          "type" => "text",
          "translation" => 'template_address_fax'
        ),
        "mobile" => array(
          "label" => "Mobile",
          "type" => "text",
          "translation" => 'template_address_mobile'
        ),
        "email" => array(
          "label" => "E-Mail",
          "type" => "text",
          "translation" => 'template_address_email'
        ),
        "labels" => array(
          "label" => "Labels",
          "type" => "multiple",
          "value" => array(
            "company" => array(
              "label" => "Company",
              "type" => "text",
              "translation" => 'template_address_label_company'
            ),
            "name" => array(
              "label" => "Name",
              "type" => "text",
              "translation" => 'template_address_label_name'
            ),
            "street" => array(
              "label" => "Street",
              "type" => "text",
              "translation" => 'template_address_label_street'
            ),
            "street2" => array(
              "label" => "Street add",
              "type" => "text",
              "translation" => 'template_address_label_street2'
            ),
            "postalCode" => array(
              "label" => "Postcode",
              "type" => "text",
              "translation" => 'template_address_label_postalCode'
            ),
            "city" => array(
              "label" => "City",
              "type" => "text",
              "translation" => 'template_address_label_city'
            ),
            "country" => array(
              "label" => "Country",
              "type" => "text",
              "translation" => 'template_address_label_country'
            ),
            "phone" => array(
              "label" => "Phone",
              "type" => "text",
              "translation" => 'template_address_label_phone'
            ),
            "fax" => array(
              "label" => "Fax",
              "type" => "text",
              "translation" => 'template_address_label_fax'
            ),
            "mobile" => array(
              "label" => "Mobile",
              "type" => "text",
              "translation" => 'template_address_label_mobile'
            ),
            "email" => array(
              "label" => "E-Mail",
              "type" => "text",
              "translation" => 'template_address_label_email'
            )
          )
        )
      )
    ),
    "socialmedia" => array(
      "label" => "Social Media block (Icons)",
      "type" => "multiple",
      "value" => array(
        "facebook" => array(
          "label" => "Facebook",
          "type" => "text"
        ),
        "instagram" => array(
          "label" => "Instagram",
          "type" => "text"
        ),
        "twitter" => array(
          "label" => "Twitter",
          "type" => "text"
        ),
        "linkedin" => array(
          "label" => "Linkedin",
          "type" => "text"
        )
      )
    ),
    "contactblock" => array(
      "label" => "Contact block (Icons)",
      "type" => "multiple",
      "value" => array(
        "phone" => array(
          "label" => "Phone",
          "type" => "text"
        ),
        "mail" => array(
          "label" => "Mail",
          "type" => "text"
        ),
        "whatsapp" => array(
          "label" => "WhatsApp",
          "type" => "text"
        )
      )
    ),
    // "placeholder" => array(
    //   "label" => "Placeholder",
    //   "type" => "multiple",
    //   "value" => array(
    //     "active" => array(
    //       "label" => "Activate placeholder",
    //       "type" => "checkbox"
    //     ),
    //     "address" => array(
    //       "label" => "Add Adressblock",
    //       "type" => "checkbox"
    //     ),
    //     "custom" => array(
    //       "label" => "Custom output",
    //       "type" => "textarea"
    //     )
    //   )
    // ),
    "header" => array(
      "label" => "Header",
      "type" => "multiple",
      "value" => array(
        "divider" => array(
          "label" => "Activate divider",
          "type" => "switchbutton"
        ),
        "wrap" => array(
          "label" => "Allow wrap",
          "type" => "switchbutton"
        ),
        "sticky" => array(
          "label" => "Sticky header",
          "type" => "switchbutton"
        ),
        "sticky_onload" => array(
          "label" => "Sticky header on load",
          "type" => "switchbutton"
        ),
        "desktop_menu" => array(
          "label" => "Desktop menu",
          "type" => "switchbutton"
        ),
        "mainmenu_searchform" => array(
          "label" => "Activate menu search form",
          "type" => "switchbutton"
        ),
        "menu_style" => array(
          "label" => "Menu direction",
          "type" => "select",
          "value" => array('horizontal','vertical')
        ),
        "hmenu_style" => array(
          "label" => "Hamburger menu position",
          "type" => "select",
          "value" => array('fullscreen','top_contained','left','left_contained','right','right_contained')
        ),
        "hmenu_containerDirection" => array(
          "label" => "Hamburger container direction",
          "type" => "select",
          "value" => array('horizontal','vertical')
        ),
        "hmenu_text" => array(
          "label" => "Hamburger text",
          "type" => "text",
          "translation" => "template_header_hmenu_text"
        ),
        "hmenu_streched" => array(
          "label" => "Strech main menu verticaly",
          "type" => "switchbutton"
        ),
        "hmenu_visible_head" => array(
          "label" => "Visible header while menu is active",
          "type" => "switchbutton"
        ),
        // "hmenu_scroll" => array(
        //   "label" => "Close hamburger menu on scroll",
        //   "type" => "switchbutton"
        // ),
        "hmenu_toggle" => array(
          "label" => "Hamburger menu toggle able submenus",
          "type" => "switchbutton"
        ),
        "custom" => array(
          "label" => "Custom Element",
          "type" => "textarea"
        ),
        "logo_link" => array(
          "label" => "Custom Logo link",
          "type" => "text"
        ),
        "logo_desktop" => array(
          "label" => "Logo desktop",
          "type" => "multiple",
          "value" => array(
            "img" => array(
              "label" => "URL",
              "type" => "img"
            ),
            "width" => array(
              "label" => "Width",
              "type" => "text"
            ),
            "height" => array(
              "label" => "Height",
              "type" => "text"
            ),
            "alt" => array(
              "label" => "Alternative text",
              "type" => "text",
              "translation" => "template_header_logo_desktop_alt"
            )
          )
        ),
        "logo_mobile" => array(
          "label" => "Logo mobile",
          "type" => "multiple",
          "value" => array(
            "img" => array(
              "label" => "URL",
              "type" => "img"
            ),
            "width" => array(
              "label" => "Width",
              "type" => "text"
            ),
            "height" => array(
              "label" => "Height",
              "type" => "text"
            ),
            "alt" => array(
              "label" => "Alternative text",
              "type" => "text"
            )
          )
        ),
        "logo_scrolled" => array(
          "label" => "Logo on scrolled",
          "type" => "multiple",
          "value" => array(
            "img" => array(
              "label" => "URL",
              "type" => "img"
            ),
            "width" => array(
              "label" => "Width",
              "type" => "text"
            ),
            "height" => array(
              "label" => "Height",
              "type" => "text"
            ),
            "alt" => array(
              "label" => "Alternative text",
              "type" => "text"
            )
          )
        ),
        "logo_svg" => array(
          "label" => "SVG Logo",
          "type" => "textarea"
        ),
        "sort" => array(
          "label" => "Sort and activate",
          "type" => "multiple",
          "css" => "sortable",
          "value" => array(
            "container_start" => array(
              "label" => "Container start",
              "type" => "hr"
            ),
            "logo" => array(
              "label" => "Logo",
              "type" => "switchbutton"
            ),
            "menu" => array(
              "label" => "Menu",
              "type" => "switchbutton"
            ),
            "hamburger" => array(
              "label" => "Hamburger",
              "type" => "switchbutton"
            ),
            "socialmedia" => array(
              "label" => "social media",
              "type" => "switchbutton"
            ),
            "searchform" => array(
              "label" => "Search form",
              "type" => "switchbutton"
            ),
            "languages" => array(
              "label" => "Language switcher",
              "type" => "switchbutton"
            ),
            "custom" => array(
              "label" => "Custom",
              "type" => "switchbutton"
            ),
            "widget_one" => array(
              "label" => "Widget 1",
              "type" => "switchbutton"
            ),
            "widget_two" => array(
              "label" => "Widget 2",
              "type" => "switchbutton"
            ),
            "widget_three" => array(
              "label" => "Widget 3",
              "type" => "switchbutton"
            ),
            "thumbnail" => array(
              "label" => "Thumbnail",
              "type" => "switchbutton"
            ),
            "container_end" => array(
              "label" => "Container end",
              "type" => "hr"
            )
          )
        ),
        "after_header" => array(
          "label" => "Custom content after header",
          "type" => "textarea"
        )
      )
    ),
    "breadcrumbs" => array(
      "label" => "Breadcrumbs",
      "type" => "multiple",
      "value" => array(
        "active" => array(
          "label" => "Activate breadcrumbs",
          "type" => "switchbutton"
        ),
        "inside_content" => array(
          "label" => "Place breadcrumbs inside content and after img (if its the first element)",
          "type" => "switchbutton"
        ),
        "introduction" => array(
          "label" => "Show introduction text",
          "type" => "switchbutton"
        ),
        "home" => array(
          "label" => "Show home link",
          "type" => "switchbutton"
        ),
        "seperator" => array(
          "label" => "Separate by",
          "type" => "text",
          "placeholder" => "&raquo;"
        )
      )
    ),
    "page" => array(
      "label" => "Page",
      "type" => "multiple",
      "value" => array(
        "metablock" => array(
          "label" => "Activate metablock",
          "type" => "multiple",
          "value" => array(
            "page" => array(
              "label" => "Pages",
              "type" => "switchbutton"
            ),
            "post" => array(
              "label" => "Posts",
              "type" => "switchbutton"
            )
          )
        ),
        "videoThumb" => array(
          "label" => "Activate video thumb",
          "type" => "switchbutton"
        ),
        "active" => array(
          "label" => "Activate page options",
          "type" => "switchbutton"
        ),
        "bgColor" => array(
          "label" => "Activate custom background color",
          "type" => "switchbutton"
        ),
        "bgImage" => array(
          "label" => "Activate custom background image",
          "type" => "switchbutton"
        ),
        "add_metablock" => array(
          "label" => "Metablock for CPT",
          "type" => "array_addable"
        ),
        "options" => array(
          "label" => "Page options",
          "type" => "multiple",
          "value" => array(
            "disableDetailpage" => array(
              "label" => "Disable link to detail page & redirect detail page to home",
              "type" => "switchbutton"
            ),
            "header" => array(
              "label" => "Hide header",
              "type" => "switchbutton"
            ),
            "header_fixed" => array(
              "label" => "Header fixed",
              "type" => "switchbutton"
            ),
            "date" => array(
              "label" => "Hide date",
              "type" => "switchbutton"
            ),
            "time" => array(
              "label" => "Hide time",
              "type" => "switchbutton"
            ),
            "author" => array(
              "label" => "Hide author",
              "type" => "switchbutton"
            ),
            "thumbnail" => array(
              "label" => "Hide thumbnail",
              "type" => "switchbutton"
            ),
            "thumbnailWide" => array(
              "label" => "Thumbnail wide",
              "type" => "switchbutton"
            ),
            "thumbnailFull" => array(
              "label" => "Thumbnail full",
              "type" => "switchbutton"
            ),
            "title" => array(
              "label" => "Hide title",
              "type" => "switchbutton"
            ),
            "titleWide" => array(
              "label" => "Title wide",
              "type" => "switchbutton"
            ),
            "comments" => array(
              "label" => "Hide comments",
              "type" => "switchbutton"
            ),
            "sidebar" => array(
              "label" => "Hide sidebar",
              "type" => "switchbutton"
            ),
            "scrolltotop" => array(
              "label" => "Hide scroll to top",
              "type" => "switchbutton"
            ),
            "footer" => array(
              "label" => "Hide footer",
              "type" => "switchbutton"
            ),
            "darkmode" => array(
              "label" => "Darkmode",
              "type" => "switchbutton"
            ),
            "beforeMain" => array(
              "label" => "Code before main block",
              "type" => "switchbutton"
            ),
            "afterMain" => array(
              "label" => "Code after main block",
              "type" => "switchbutton"
            )
          )
        ),
        "additional" => array(
          "label" => "Add page options",
          "type" => "array_addable",
          "value" => array(
            "key" => array(
              "label" => "Option key",
              "type" => "text"
            ),
            "value" => array(
              "label" => "Option label",
              "type" => "text"
            )
          )
        )
      )
    ),
    "blog" => array(
      "label" => "Blog",
      "type" => "multiple",
      "value" => array(
        "type" => array(
          "label" => "Activate blog template options",
          "type" => "switchbutton"
        ),
        "show" => array(
          "label" => "Show on overview pages",
          "type" => "multiple",
          "value" => array(
            "author" => array(
              "label" => "Activate author",
              "type" => "switchbutton"
            ),
            "date" => array(
              "label" => "Activate date",
              "type" => "switchbutton"
            ),
            "time" => array(
              "label" => "Activate time",
              "type" => "switchbutton"
            ),
            "categories" => array(
              "label" => "Activate categories",
              "type" => "switchbutton"
            )
          )
        ),
        "dateformat" => array(
          "label" => "Date format",
          "type" => "text",
          "placeholder" => "d.m.Y"
        )
      )
    ),
    "scrolltotop" => array(
      "label" => "Activate scroll to top",
      "type" => "switchbutton"
    ),
    "footer" => array(
      "label" => "Footer",
      "type" => "multiple",
      "value" => array(
        "active" => array(
          "label" => "Activate footer",
          "type" => "switchbutton"
        ),
        "wrap" => array(
          "label" => "Allow wrap",
          "type" => "switchbutton"
        ),
        "copyright" => array(
          "label" => "Copyright",
          "type" => "text"
        ),
        "custom" => array(
          "label" => "Custom Element",
          "type" => "textarea"
        ),
        "menu" => array(
          "label" => "Menu",
          "type" => "multiple",
          "value" => array(
            "custom" => array(
              "label" => "Additional CSS",
              "type" => "text"
            ),
            "direction" => array(
              "label" => "Menu direction",
              "type" => "select",
              "value" => array('vertical','horizontal')
            ),
            "seperator" => array(
              "label" => "Seperate horizontal menu with line",
              "type" => "switchbutton"
            )
          )
        ),
        "sort" => array(
          "label" => "Sort and activate",
          "type" => "multiple",
          "css" => "sortable",
          "value" => array(
            "container_start" => array(
              "label" => "Container start",
              "type" => "hr"
            ),
            "menu" => array(
              "label" => "Menu",
              "type" => "switchbutton"
            ),
            "socialmedia" => array(
              "label" => "Social media",
              "type" => "switchbutton"
            ),
            "copyright" => array(
              "label" => "Copyright",
              "type" => "switchbutton"
            ),
            "address" => array(
              "label" => "Address block",
              "type" => "switchbutton"
            ),
            "custom" => array(
              "label" => "Custom",
              "type" => "switchbutton"
            ),
            "searchform" => array(
              "label" => "Search form",
              "type" => "switchbutton"
            ),
            "languages" => array(
              "label" => "Language switcher",
              "type" => "switchbutton"
            ),
            "widget_one" => array(
              "label" => "Widget 1",
              "type" => "switchbutton"
            ),
            "widget_two" => array(
              "label" => "Widget 2",
              "type" => "switchbutton"
            ),
            "widget_three" => array(
              "label" => "Widget 3",
              "type" => "switchbutton"
            ),
            "container_end" => array(
              "label" => "Container end",
              "type" => "hr"
            )
          )
        ),
        "before_footer" => array(
          "label" => "Custom content before footer",
          "type" => "textarea"
        ),
        "after_footer" => array(
          "label" => "Custom content after footer",
          "type" => "textarea"
        )
      )
    ),
    "searchform" => array(
      "label" => "Search form",
      "type" => "multiple",
      "value" => array(
        "autocomplete" => array(
          "label" => "Autocomplete",
          "type" => "switchbutton"
        )
      )
    ),
    "languageSwitcher" => array(
      "label" => "Language Switcher",
      "type" => "multiple",
      "value" => array(
        "direction" => array(
          "label" => "Menu direction",
          "type" => "select",
          "value" => array('horizontal','vertical')
        ),
        "separator" => array(
          "label" => "Seperate horizontal with line",
          "type" => "switchbutton"
        ),
        "nameDisplay" => array(
          "label" => "Name display",
          "type" => "select",
          "value" => array('slug','name')
        )
      )
    ),
    'thumbnail' => array(
      "label" => "Thumbnail settings",
      "type" => "multiple",
      "value" => array(
        "div" => array(
          "label" => "Insert IMG into DIV",
          "type" => "switchbutton"
        ),
        "404" => array(
          "label" => "404 Page thumbnail",
          "type" => "img"
        ),
        "search" => array(
          "label" => "Search results page thumbnail",
          "type" => "img"
        ),
        "align" => array(
          "label" => "Align all thumbnail",
          "type" => "select",
          "value" => array('normal','wide','full')
        ),
        "404_align" => array(
          "label" => "404 align thumbnail",
          "type" => "select",
          "value" => array('normal','wide','full')
        ),
        "search_align" => array(
          "label" => "Search results page align thumbnail",
          "type" => "select",
          "value" => array('normal','wide','full')
        )
      )
    ),
    'errorPage' => array(
      "label" => "404 Page",
      "type" => "multiple",
      "value" => array(
        "searchForm" => array(
          "label" => "Display search form",
          "type" => "switchbutton"
        ),
        "BackToHome" => array(
          "label" => "Display back to home button",
          "type" => "switchbutton"
        )
      )
    )
  );


  /* 1.4 PAGE OPTIONS - CREATE META BOX
  /------------------------*/
  function WPtemplate_Metabox() {
    // get core post types
    $core_args = array(
      'public' => true,
      '_builtin' => true
    );
    $core_pt = get_post_types( $core_args );
    // get custom post types
    $custom_args = array(
      'public' => true,
      'publicly_queryable' => true
    );
    $custom_pt = get_post_types( $custom_args );
    // merge & clean post types
    $post_types = array_merge($core_pt, $custom_pt);
    unset($post_types['attachment']);
    unset($post_types['nav_menu_item']);
    // register meta box for all selected post types
    foreach( $post_types as $post_type ){
        add_meta_box(
            'template_page_options',
            __( 'Options', 'devTheme' ),
            array($this, 'WPtemplate_pageoptions'),
            $post_type,
            'side',
            'low'
        );
    }
  }



  /*==================================================================================
    2.0 FUNCTIONS
  ==================================================================================*/

    /* 2.1 GET CONFIGURATION FORM CONFIG FILE
    /------------------------*/
    private function updateVars(){
      // get configuration
      global $configuration;
      // if configuration file exists && class-settings
      if($configuration && array_key_exists('template', $configuration)):
        // class configuration
        $myConfig = $configuration['template'];
        // update vars
        SELF::$template_container_header = array_key_exists('container_header', $myConfig) ? $myConfig['container_header'] : SELF::$template_container_header;
        SELF::$template_container_breadcrumbs = array_key_exists('container_breadcrumbs', $myConfig) ? $myConfig['container_breadcrumbs'] : SELF::$template_container_breadcrumbs;
        SELF::$template_container = array_key_exists('container', $myConfig) ? $myConfig['container'] : SELF::$template_container;
        SELF::$template_container_totop = array_key_exists('container_scrolltotop', $myConfig) ? $myConfig['container_scrolltotop'] : SELF::$template_container_totop;
        SELF::$template_container_footer = array_key_exists('container_footer', $myConfig) ? $myConfig['container_footer'] : SELF::$template_container_footer;
        SELF::$template_container_header_wide = array_key_exists('container_header_wide', $myConfig) ? $myConfig['container_header_wide'] : SELF::$template_container_header_wide;
        SELF::$template_container_footer_wide = array_key_exists('container_footer_wide', $myConfig) ? $myConfig['container_footer_wide'] : SELF::$template_container_footer_wide;
        SELF::$template_coloring = array_key_exists('coloring', $myConfig) ? $myConfig['coloring'] : SELF::$template_coloring;
        SELF::$template_address = array_key_exists('address', $myConfig) ? $myConfig['address'] : SELF::$template_address;
        SELF::$template_socialmedia = array_key_exists('socialmedia', $myConfig) ? $myConfig['socialmedia'] : SELF::$template_socialmedia;
        SELF::$template_contactblock = array_key_exists('contactblock', $myConfig) ? $myConfig['contactblock'] : SELF::$template_contactblock;
        SELF::$template_scrolltotop_active = array_key_exists('scrolltotop', $myConfig) ? $myConfig['scrolltotop'] : SELF::$template_scrolltotop_active;
        if($myConfig && array_key_exists('placeholder', $myConfig)):
          $placeholder = $myConfig['placeholder'];
          SELF::$template_ph_active = array_key_exists('active', $placeholder) ? $placeholder['active'] : SELF::$template_ph_active;
          SELF::$template_ph_address = array_key_exists('address', $placeholder) ? $placeholder['address'] : SELF::$template_ph_address;
          SELF::$template_ph_custom = array_key_exists('custom', $placeholder) ? $placeholder['custom'] : SELF::$template_ph_custom;
        endif;
        if($configuration && array_key_exists('header', $myConfig)):
          $header = $myConfig['header'];
          SELF::$template_header_wrap = array_key_exists('wrap', $header) ? $header['wrap'] : SELF::$template_header_wrap;
          SELF::$template_header_divider = array_key_exists('divider', $header) ? $header['divider'] : SELF::$template_header_divider;
          SELF::$template_header_sticky = array_key_exists('sticky', $header) ? $header['sticky'] : SELF::$template_header_sticky;
          SELF::$template_header_stickyload = array_key_exists('sticky_onload', $header) ? $header['sticky_onload'] : SELF::$template_header_stickyload;
          SELF::$template_header_dmenu = array_key_exists('desktop_menu', $header) ? $header['desktop_menu'] : SELF::$template_header_dmenu;
          SELF::$template_header_menusearchform = array_key_exists('mainmenu_searchform', $header) ? $header['mainmenu_searchform'] : SELF::$template_header_menusearchform;
          SELF::$template_header_menu_style = array_key_exists('menu_style', $header) ? $header['menu_style'] : SELF::$template_header_menu_style;
          SELF::$template_header_hmenu_style = array_key_exists('hmenu_style', $header) ? $header['hmenu_style'] : SELF::$template_header_hmenu_style;
          SELF::$template_header_hmenu_visible_head = array_key_exists('hmenu_visible_head', $header) ? $header['hmenu_visible_head'] : SELF::$template_header_hmenu_visible_head;

          SELF::$template_header_hmenu_containerDirection = array_key_exists('hmenu_containerDirection', $header) ? $header['hmenu_containerDirection'] : SELF::$template_header_hmenu_containerDirection;
          SELF::$template_header_hmenu_text = array_key_exists('hmenu_text', $header) ? $header['hmenu_text'] : SELF::$template_header_hmenu_text;
          SELF::$template_header_hmenu_streched = array_key_exists('hmenu_streched', $header) ? $header['hmenu_streched'] : SELF::$template_header_hmenu_streched;
          SELF::$template_header_hmenu_scroll = array_key_exists('hmenu_scroll', $header) ? $header['hmenu_scroll'] : SELF::$template_header_hmenu_scroll;
          SELF::$template_header_hmenu_toggle = array_key_exists('hmenu_toggle', $header) ? $header['hmenu_toggle'] : SELF::$template_header_hmenu_toggle;
          SELF::$template_header_custom = array_key_exists('custom', $header) ? $header['custom'] : SELF::$template_header_custom;
          SELF::$template_header_sort = array_key_exists('sort', $header) ? $header['sort'] : SELF::$template_header_sort;
          SELF::$template_header_logo_link = array_key_exists('logo_link', $header) ? $header['logo_link'] : SELF::$template_header_logo_link;
          SELF::$template_header_logo_d = array_key_exists('logo_desktop', $header) ? $header['logo_desktop'] : SELF::$template_header_logo_d;
          SELF::$template_header_logo_m = array_key_exists('logo_mobile', $header) ? $header['logo_mobile'] : SELF::$template_header_logo_m;
          SELF::$template_header_logo_scrolled = array_key_exists('logo_scrolled', $header) ? $header['logo_scrolled'] : SELF::$template_header_logo_scrolled;
          SELF::$template_header_logo_svg = array_key_exists('logo_svg', $header) ? $header['logo_svg'] : SELF::$template_header_logo_svg;
          SELF::$template_header_after = array_key_exists('after_header', $header) ? $header['after_header'] : SELF::$template_header_after;
        endif;
        if($configuration && array_key_exists('page', $myConfig)):
          $page = $myConfig['page'];
          SELF::$template_page_active = array_key_exists('active', $page) ? $page['active'] : SELF::$template_page_active;
          SELF::$template_page_metablock = array_key_exists('metablock', $page) ? $page['metablock'] : SELF::$template_page_metablock;
          SELF::$template_page_metablockAdds = array_key_exists('add_metablock', $page) ? $page['add_metablock'] : SELF::$template_page_metablockAdds;
          SELF::$template_page_options = array_key_exists('options', $page) ? array_merge(SELF::$template_page_options, $page['options']) : SELF::$template_page_options;
          SELF::$template_thumbvideo = array_key_exists('videoThumb', $page) ? $page['videoThumb'] : SELF::$template_thumbvideo;
          SELF::$template_page_bgColor = array_key_exists('bgColor', $page) ? $page['bgColor'] : SELF::$template_page_bgColor;
          SELF::$template_page_bgImg = array_key_exists('bgImage', $page) ? $page['bgImage'] : SELF::$template_page_bgImg;
          SELF::$template_page_additional = array_key_exists('additional', $page) ? array_merge(SELF::$template_page_additional, $page['additional']) : SELF::$template_page_additional;
        endif;
        if($configuration && array_key_exists('blog', $myConfig)):
          $blog = $myConfig['blog'];
          SELF::$template_blog_type = array_key_exists('type', $blog) ? $blog['type'] : SELF::$template_blog_type;
          SELF::$template_blog_type_parts = array_key_exists('show', $blog) ? $blog['show'] : SELF::$template_blog_type_parts;
          SELF::$template_blog_dateformat = array_key_exists('dateformat', $blog) ? $blog['dateformat'] : SELF::$template_blog_dateformat;
        endif;
        if($configuration && array_key_exists('footer', $myConfig)):
          $footer = $myConfig['footer'];
          SELF::$template_footer_active = array_key_exists('active', $footer) ? $footer['active'] : SELF::$template_footer_active;
          SELF::$template_footer_wrap = array_key_exists('wrap', $footer) ? $footer['wrap'] : SELF::$template_footer_wrap;
          SELF::$template_footer_cr = array_key_exists('copyright', $footer) ? $footer['copyright'] : SELF::$template_footer_cr;
          SELF::$template_footer_custom = array_key_exists('custom', $footer) ? $footer['custom'] : SELF::$template_footer_custom;
          SELF::$template_footer_menu = array_key_exists('menu', $footer) ? $footer['menu'] : SELF::$template_footer_menu;
          SELF::$template_footer_sort = array_key_exists('sort', $footer) ? $footer['sort'] : SELF::$template_footer_sort;
          SELF::$template_footer_before = array_key_exists('before_footer', $footer) ? $footer['before_footer'] : SELF::$template_footer_before;
          SELF::$template_footer_after = array_key_exists('after_footer', $footer) ? $footer['after_footer'] : SELF::$template_footer_after;
        endif;
        if($configuration && array_key_exists('breadcrumbs', $myConfig)):
          $breadcrumbs = $myConfig['breadcrumbs'];
          SELF::$template_breadcrumbs_active = array_key_exists('active', $breadcrumbs) ? $breadcrumbs['active'] : SELF::$template_breadcrumbs_active;
          SELF::$template_breadcrumbs_inside = array_key_exists('inside_content', $breadcrumbs) ? $breadcrumbs['inside_content'] : SELF::$template_breadcrumbs_inside;
          SELF::$template_breadcrumbs_intro = array_key_exists('introduction', $breadcrumbs) ? $breadcrumbs['introduction'] : SELF::$template_breadcrumbs_intro;
          SELF::$template_breadcrumbs_home = array_key_exists('home', $breadcrumbs) ? $breadcrumbs['home'] : SELF::$template_breadcrumbs_home;
          SELF::$template_breadcrumbs_separator = array_key_exists('seperator', $breadcrumbs) ? $breadcrumbs['seperator'] : SELF::$template_breadcrumbs_separator;
        endif;
        if($configuration && array_key_exists('searchform', $myConfig)):
          $searchform = $myConfig['searchform'];
          SELF::$template_searchform_autocomplete = array_key_exists('autocomplete', $searchform) ? $searchform['autocomplete'] : SELF::$template_searchform_autocomplete;
        endif;
        if($configuration && array_key_exists('languageSwitcher', $myConfig)):
          $languageSwitcher = $myConfig['languageSwitcher'];
          SELF::$template_languageSwitcher_direction = array_key_exists('direction', $languageSwitcher) ? $languageSwitcher['direction'] : SELF::$template_languageSwitcher_direction;
          SELF::$template_languageSwitcher_separat = array_key_exists('separator', $languageSwitcher) ? $languageSwitcher['separator'] : SELF::$template_languageSwitcher_separat;
          SELF::$template_languageSwitcher_nameDisplay = array_key_exists('nameDisplay', $languageSwitcher) ? $languageSwitcher['nameDisplay'] : SELF::$template_languageSwitcher_nameDisplay;
        endif;
        if($configuration && array_key_exists('thumbnail', $myConfig)):
          $thumbnail = $myConfig['thumbnail'];
          SELF::$template_thumbnail_div = array_key_exists('div', $thumbnail) ? $thumbnail['div'] : SELF::$template_thumbnail_div;
          SELF::$template_thumbnail_404 = array_key_exists('404', $thumbnail) ? $thumbnail['404'] : SELF::$template_thumbnail_404;
          SELF::$template_thumbnail_search = array_key_exists('search', $thumbnail) ? $thumbnail['search'] : SELF::$template_thumbnail_search;
          SELF::$template_thumbnail_align = array_key_exists('align', $thumbnail) ? $thumbnail['align'] : SELF::$template_thumbnail_align;
          SELF::$template_404_align = array_key_exists('404_align', $thumbnail) ? $thumbnail['404_align'] : SELF::$template_404_align;
          SELF::$template_search_align = array_key_exists('search_align', $thumbnail) ? $thumbnail['search_align'] : SELF::$template_search_align;
        endif;
        if($configuration && array_key_exists('errorPage', $myConfig)):
          $errorPage = $myConfig['errorPage'];
          SELF::$template_404_searchForm = array_key_exists('searchForm', $errorPage) ? $errorPage['searchForm'] : SELF::$template_404_searchForm;
          SELF::$template_404_backToHome = array_key_exists('BackToHome', $errorPage) ? $errorPage['BackToHome'] : SELF::$template_404_backToHome;
        endif;
      endif;
    }


    /* 2.2 ACTIVATE CONTAINER CSS CLASS FOR HEADER/FOOTER
    /------------------------*/
    // $container to activate, $wrap to add the class attribute
    public static function AddContainer(int $container = 0, bool $wrap = true){
      // fallback if config file is missing
      $active = $container ? $container : SELF::$template_container;
      // check if container is active
      if($active === 1 && $wrap === true):
        return 'class="container"';
      elseif($active === 1):
        return 'container';
      endif;
    }


    /* 2.3 STICKY HEADER
    /------------------------*/
    public static function CheckSticky(int $sticky = 1, int $stickyOnLoad = 1){
      $output = '';
      // sticky active on load
      if($sticky === 1 && $stickyOnLoad === 1):
        $output .= ' sticky';
      endif;
      // sticky able on scroll
      if($sticky === 1 && $stickyOnLoad !== 1):
        $output .= ' stickyable';
      endif;
      return $output;
    }


    /* 2.4 SAVE METABOXES
    /------------------------*/
    public function WPtemplate_meta_Save($post_id) {
      // //Not save if the user hasn't submitted changes
      if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ):
        return;
      endif;
      // Making sure the user has permission
      if( ! current_user_can( 'edit_post', $post_id ) ):
        return;
      endif;
      // Don't update on Quick Edit
      if (defined('DOING_AJAX') ):
        return;
      endif;
      // save page optons
      if(isset($_POST['template_page_options'])):
        //$options = $_POST['template_page_options'] !== '' ? serialize($_POST['template_page_options']) : '';
        //$options = esc_html($get_options);
        update_post_meta($post_id, 'template_page_options', $_POST['template_page_options']);
      else:
        update_post_meta($post_id, 'template_page_options', '');
      endif;
      // save page background color
      if(isset($_POST['template_page_bgColor'])):
        update_post_meta($post_id, 'template_page_bgColor', $_POST['template_page_bgColor']);
      endif;
      // save page backgound img
      if(isset($_POST['template_page_bgImg'])):
        update_post_meta($post_id, 'template_page_bgImg', $_POST['template_page_bgImg']);
      endif;
      // save video thumb settings
      if(get_post_types(array(), 'objects')[get_post_type($post_id)]->show_in_rest == 1):
      else:
        if(isset($_POST['template_page_videothumb_options'])):
          update_post_meta($post_id, 'template_page_videothumb_options', $_POST['template_page_videothumb_options']);
        else:
          update_post_meta($post_id, 'template_page_videothumb_options', '');
        endif;
        if(isset($_POST['template_page_videothumb_videoUrl'])):
          update_post_meta($post_id, 'template_page_videothumb_videoUrl', $_POST['template_page_videothumb_videoUrl']);
        else:
          update_post_meta($post_id, 'template_page_videothumb_videoUrl', '');
        endif;
      endif;
    }


    /* 2.5 REGISTER WIDGETS
    /------------------------*/
    function registerCustomWidgets(){
      // header
      register_sidebar( array(
        'name'          => __( 'Header 1', 'devTheme' ),
        'id'            => 'header_widget_one',
        'description'   => __( 'Widget for the header', 'devTheme' ),
        'before_sidebar' => '<div id="%1$s" class="widget %2$s">',
        'after_sidebar'  => '</div>',
        'before_title'  => '<h5 class="header-widget">',
        'after_title'   => '</h5>',
        'before_widget' => '',
        'after_widget'  => '',
      ) );
      register_sidebar( array(
        'name'          => __( 'Header 2', 'devTheme' ),
        'id'            => 'header_widget_two',
        'description'   => __( 'Widget for the header', 'devTheme' ),
        'before_sidebar' => '<div id="%1$s" class="widget %2$s">',
        'after_sidebar'  => '</div>',
        'before_title'  => '<h5 class="header-widget">',
        'after_title'   => '</h5>',
        'before_widget' => '',
        'after_widget'  => '',
      ) );
      register_sidebar( array(
        'name'          => __( 'Header 3', 'devTheme' ),
        'id'            => 'header_widget_three',
        'description'   => __( 'Widget for the header', 'devTheme' ),
        'before_sidebar' => '<div id="%1$s" class="widget %2$s">',
        'after_sidebar'  => '</div>',
        'before_title'  => '<h5 class="header-widget">',
        'after_title'   => '</h5>',
        'before_widget' => '',
        'after_widget'  => '',
      ) );
      // page
      register_sidebar( array(
        'name'          => __( 'Page Sidebar', 'devTheme' ),
        'id'            => 'sidebar-page',
        'description'   => __( 'Sidebar Widget for pages', 'devTheme' ),
        'before_sidebar' => '<div id="%1$s" class="widget %2$s">',
        'after_sidebar'  => '</div>',
        'before_title'  => '<h5 class="sidebar-widget">',
        'after_title'   => '</h5>',
        'before_widget' => '',
        'after_widget'  => '',
      ) );
      // posts
      register_sidebar( array(
        'name'          => __( 'Posts Sidebar', 'devTheme' ),
        'id'            => 'sidebar-post',
        'description'   => __( 'Sidebar Widget for posts', 'devTheme' ),
        'before_sidebar' => '<div id="%1$s" class="widget %2$s">',
        'after_sidebar'  => '</div>',
        'before_title'  => '<h5 class="sidebar-widget">',
        'after_title'   => '</h5>',
        'before_widget' => '',
        'after_widget'  => '',
      ) );
      // footer
      register_sidebar( array(
        'name'          => __( 'Footer 1', 'devTheme' ),
        'id'            => 'footer_widget_one',
        'description'   => __( 'Widget for the footer', 'devTheme' ),
        'before_sidebar' => '<div id="%1$s" class="widget %2$s">',
        'after_sidebar'  => '</div>',
        'before_title'  => '<h5 class="footer-widget">',
        'after_title'   => '</h5>',
        'before_widget' => '',
        'after_widget'  => '',
      ) );
      register_sidebar( array(
        'name'          => __( 'Footer 2', 'devTheme' ),
        'id'            => 'footer_widget_two',
        'description'   => __( 'Widget for the footer', 'devTheme' ),
        'before_sidebar' => '<div id="%1$s" class="widget %2$s">',
        'after_sidebar'  => '</div>',
        'before_title'  => '<h5 class="footer-widget">',
        'after_title'   => '</h5>',
        'before_widget' => '',
        'after_widget'  => '',
      ) );
      register_sidebar( array(
        'name'          => __( 'Footer 3', 'devTheme' ),
        'id'            => 'footer_widget_three',
        'description'   => __( 'Widget for the footer', 'devTheme' ),
        'before_sidebar' => '<div id="%1$s" class="widget %2$s">',
        'after_sidebar'  => '</div>',
        'before_title'  => '<h5 class="footer-widget">',
        'after_title'   => '</h5>',
        'before_widget' => '',
        'after_widget'  => '',
      ) );
    }


    /* 2.6 REBUILD SEARCH FORM
    /------------------------*/
    public function buildSearchForm(string $type = 'default'){
      $output = '';
      if($type == 'menu'):
        $containerStart = '<li class="menu-item menu-search-form">';
        $containerEnd = '</li>';
      else:
        $containerStart = '<div class="search-form">';
        $containerEnd = '</div>';
      endif;

      $output .= $containerStart;
        $search = get_search_form( false );
        // disable autocomplete
        if(SELF::$template_searchform_autocomplete == 1):
          $autocomplete = 'on';
        else:
          $autocomplete = 'off';
        endif;
        $search = str_replace('name="s"', 'name="s" autocomplete="' . $autocomplete . '"', $search);
        $output .= $search;
      $output .= $containerEnd;

      return $output;
    }


    /* 2.7 ADD VALUES TO REST API
    /------------------------*/
    public function addContentToRestApi(){
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
      // Add the plaintext content to GET requests for individual posts
      register_rest_field(
        $post_types,
        'templateParts',
        array(
          'get_callback' => array($this, 'getAllTemplateParts'),
        )
      );
    }


    /* 2.8 REDIRECT DETAIL PAGE
    /------------------------*/
    function redirectDetailPage() {
      $pageOptions = prefix_template::PageOptions(get_the_id());
      if(is_single() && in_array('disableDetailpage', $pageOptions)):
        wp_redirect( home_url(), 301 );
        exit;
      endif;
    }


    /* 2.9 EXTEND THUMBNAIL
    /------------------------*/
    function extendThumbnailMetabox( $content, $post_id ) {
      $videoThumbActive = SELF::$template_thumbvideo;
      if($videoThumbActive):
        $videoUrl = get_post_meta($post_id, 'template_page_videothumb_videoUrl', true);
        $videoOptions = get_post_meta($post_id, 'template_page_videothumb_options', true);
        $content .= '<div data-id="template_page_videothumb_videoUrl">';
        $content .= '<p><b>' . __( 'Video thumb', 'devTheme' ) . '</b></p>';
        $content .= '<input type="hidden" class="video-saved" id="template_page_videothumb_videoUrl" name="template_page_videothumb_videoUrl" value="' . $videoUrl . '" style="margin-top:5px; width:100%;">';
        $content .= '<button class="wp-single-video" data-action="WPadmin">' . __('Select video','devTheme') . '</button>';
        $content .= '<span class="video-selected">';
          if($videoUrl !== false && $videoUrl !== ''):
            $content .= '<span class="remove_video"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="3" height="32.2"/></svg></span>';
            $content .= '<video src="' . wp_get_attachment_url($videoUrl) . '" autoplay muted playsinline></video>';
          endif;
        $content .= '</span></div>';
        $content .= '<div data-id="template_page_videothumb_options"><ul>';
          $content .= '<p><b>' . __( 'Replace thumb image with video on:', 'devTheme' ) . '</b></p>';
          if(is_string($videoOptions)):
            $videoOptions = unserialize($videoOptions);
          endif;
          $content .= '<li><label><input type="checkbox" name="template_page_videothumb_options[]" value="detailpage" ' . prefix_core_BaseFunctions::setChecked('detailpage', $videoOptions) . '>' . __( 'Detail page', 'devTheme' ) . '</label></li>';
          $content .= '<li><label><input type="checkbox" name="template_page_videothumb_options[]" value="searchresults" ' . prefix_core_BaseFunctions::setChecked('searchresults', $videoOptions) . '>' . __( 'Search results', 'devTheme' ) . '</label></li>';
          $content .= '<li><label><input type="checkbox" name="template_page_videothumb_options[]" value="archive" ' . prefix_core_BaseFunctions::setChecked('archive', $videoOptions) . '>' . __( 'Archive', 'devTheme' ) . '</label></li>';
          $content .= '<li><label><input type="checkbox" name="template_page_videothumb_options[]" value="postsblock" ' . prefix_core_BaseFunctions::setChecked('postsblock', $videoOptions) . '>' . __( 'Posts block', 'devTheme' ) . '</label></li>';
          $content .= '<li><label><input type="checkbox" name="template_page_videothumb_options[]" value="postsfilterblock" ' . prefix_core_BaseFunctions::setChecked('postsfilterblock', $videoOptions) . '>' . __( 'Posts filter block', 'devTheme' ) . '</label></li>';
        $content .= '</ul></div>';
      endif;
      return $content;
    }
    function extendThumbnailOutput( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
      $videoThumbActive = SELF::$template_thumbvideo;
      $videoUrl = get_post_meta($post_id, 'template_page_videothumb_videoUrl', true);
      $videoOptions = get_post_meta($post_id, 'template_page_videothumb_options', true);
      if(is_string($videoOptions)):
        $videoOptions = unserialize($videoOptions);
      endif;
      if($videoThumbActive && $videoUrl && in_array($attr["callingFrom"], $videoOptions)):
        $html = '';
        $html .= $attr["callingFrom"] == 'detailpage' ? '<div class="' . $attr["class"] . '">' : '';
        $html .= $attr["callingFrom"] == 'archive' || $attr["callingFrom"] == 'searchresults' ? '<figure>' : '';
        $html .= '<video src="' . wp_get_attachment_url($videoUrl) . '" autoplay muted playsinline></video>';
        $html .= $attr["callingFrom"] == 'archive' || $attr["callingFrom"] == 'searchresults' ? '</figure>' : '';
        $html .= $attr["callingFrom"] == 'detailpage' ? '</div>' : '';
      endif;
      return $html;
    }




  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

    /* 3.1 SORTABLE HEADER CONTENT
    /------------------------*/
    static public function HeaderContent(){
      // vars
      $order = SELF::$template_header_sort;
      $order = apply_filters( 'template_HeaderContent', $order );
      $css = '';
      $css .= SELF::$template_header_wrap == 1 ? ' wrap' : '';
      $counter = 0;
      $container = '<div class="header-container ' . prefix_template::AddContainer(prefix_template::$template_container_header, false) . $css . '">';
      $container_open = false;
      $container_closed = false;

      // open container for not defined container
      if(!array_key_exists('container_start', $order) && prefix_template::$template_container_header !== 0):
        echo $container;
      endif;

      // open before container
      if(prefix_template::$template_container_header !== 0):
        echo '<div class="before-container">';
      endif;

      foreach ($order as $key => $value) {
        $counter++;
        switch ($key) {
          case 'container_start':
            if(prefix_template::$template_container_header !== 0):
              // close before container
              echo '</div>';
              // open container
              echo $container;
              $container_open = true;
            endif;
            break;
          case 'container_end':
            if($container_open !== false):
              // close container
              echo '</div>';
              $container_closed = true;
              // open after container
              echo '<div class="after-container">';
            endif;
            break;
          case 'thumbnail':
            echo $value == 1 ? SELF::get_thumbnail() : '';
            break;
          case 'menu':
            echo $value == 1 ? SELF::WP_MainMenu(SELF::$template_header_dmenu, 'menu', SELF::$template_header_menu_style, SELF::$template_header_hmenu_style, SELF::$template_header_hmenu_toggle, SELF::$template_header_hmenu_visible_head, SELF::$template_header_hmenu_text, SELF::$template_header_hmenu_streched) : '';
            break;
          case 'hamburger':
            echo $value == 1 ? SELF::WP_MainMenu(SELF::$template_header_dmenu, 'hamburger', SELF::$template_header_menu_style, SELF::$template_header_hmenu_style, SELF::$template_header_hmenu_toggle, SELF::$template_header_hmenu_visible_head, SELF::$template_header_hmenu_text, SELF::$template_header_hmenu_streched) : '';
            break;
          case 'logo':
            echo $value == 1 ? SELF::Logo(SELF::$template_header_logo_link, SELF::$template_header_logo_d, SELF::$template_header_logo_m, SELF::$template_header_logo_scrolled, SELF::$template_header_logo_svg) : '';
            break;
          case 'socialmedia':
            echo $value == 1 ? SELF::SocialMedia() : '';
            break;
          case 'contactblock':
            echo $value == 1 ? SELF::ContactBlock(SELF::$template_contactblock) : '';
            break;
          case 'searchform':
            echo $value == 1 ? SELF::buildSearchForm() : '';
            break;
          case 'languages':
            echo $value == 1 ? SELF::languageSwitcher(array()) : '';
            break;
          case 'widget_one':
            echo $value == 1 ? SELF::getWidget('header_' . $key) : '';
            break;
          case 'widget_two':
            echo $value == 1 ? SELF::getWidget('header_' . $key) : '';
            break;
          case 'widget_three':
            echo $value == 1 ? SELF::getWidget('header_' . $key) : '';
            break;
          case 'custom':
            // WP check
            if (function_exists('do_shortcode')):
              $headerCustom = $value == 1 ? do_shortcode(str_replace("'", '"', SELF::$template_header_custom)) : '';
            else:
              $headerCustom = $value == 1 ? str_replace("'", '"', SELF::$template_header_custom) : '';
            endif;
            $headerCustom = apply_filters( 'template_header_custom', $headerCustom );
            echo $headerCustom;
            break;

          default:
            // code...
            break;
        }
      }
      // check if container been closed
      if($container_closed == false):
        echo '</div>';
      endif;

      // close after container
      if($container_open !== false):
        echo '</div>';
      endif;
    }


    /* 3.2 SORTABLE FOOTER CONTENT
    /------------------------*/
    static public function FooterContent(){
      // vars
      $order = SELF::$template_footer_sort;
      $order = apply_filters( 'template_FooterContent', $order );
      $css = '';
      $css .= SELF::$template_footer_wrap == 1 ? ' wrap' : '';
      $counter = 0;
      $container = '<div class="footer-container ' . prefix_template::AddContainer(prefix_template::$template_container_footer, false) . $css . '">';
      $container_open = false;
      $container_closed = false;

      // open container for not defined container
      if(!array_key_exists('container_start', $order) && prefix_template::$template_container_footer !== 0):
        echo $container;
      endif;

      // open before container
      if(prefix_template::$template_container_footer !== 0):
        echo '<div class="before-container">';
      endif;

      foreach ($order as $key => $value) {
        $counter++;
        switch ($key) {
          case 'container_start':
            if(prefix_template::$template_container_footer !== 0):
              // close before container
              echo '</div>';
              // open container
              echo $container;
              $container_open = true;
            endif;
            break;
          case 'container_end':
            if($container_open !== false):
              // close container
              echo '</div>';
              $container_closed = true;
              // open after container
              echo '<div class="after-container">';
            endif;
            break;
          case 'menu':
            echo $value == 1 ? SELF::WP_FooterMenu($value) : '';
            break;
          case 'address':
            echo $value == 1 ? SELF::AddressBlock(SELF::$template_address, true) : '';
            break;
          case 'copyright':
            echo $value == 1 && !empty(SELF::$template_footer_cr) ? SELF::Copyright(SELF::$template_footer_cr) : '';
            break;
          case 'socialmedia':
            echo $value == 1 ? SELF::Socialmedia() : '';
            break;
          case 'contactblock':
            echo $value == 1 ? SELF::ContactBlock(SELF::$template_contactblock) : '';
            break;
          case 'searchform':
            echo $value == 1 ? SELF::buildSearchForm() : '';
            break;
          case 'languages':
            echo $value == 1 ? SELF::languageSwitcher(array()) : '';
            break;
          case 'widget_one':
            echo $value == 1 ? SELF::getWidget('footer_' . $key) : '';
            break;
          case 'widget_two':
            echo $value == 1 ? SELF::getWidget('footer_' . $key) : '';
            break;
          case 'widget_three':
            echo $value == 1 ? SELF::getWidget('footer_' . $key) : '';
            break;
          case 'custom':
            // WP check
            if (function_exists('do_shortcode')):
              $footerCustom = $value == 1 ? do_shortcode(str_replace("'", '"', SELF::$template_footer_custom)) : '';
            else:
              $footerCustom = $value == 1 ? str_replace("'", '"', SELF::$template_footer_custom) : '';
            endif;
            $footerCustom = apply_filters( 'template_footer_custom', $footerCustom );
            echo $footerCustom;
            break;

          default:
            // code...
            break;
        }
      }
      // check if container been closed
      if($container_open !== false && $container_closed == false):
        echo '</div>';
      endif;

      // close after container
      if($container_open !== false):
        echo '</div>';
      endif;
    }


    /* 3.3 BACKEND PAGE OPTIONS - METABOX
    /------------------------*/
    function WPtemplate_pageoptions($post) {
        // vars
        $output = '';
        $options = get_post_meta($post->ID, 'template_page_options', true);
        $bgColor = get_post_meta($post->ID, 'template_page_bgColor', true);
        $bgImg = get_post_meta($post->ID, 'template_page_bgImg', true);
        if(is_string($options)):
          $options = unserialize($options);
        endif;
        // output
        echo '<div class="wrap metaboxes" id="WPtemplate">';
          // page options
          if(SELF::$template_page_active == 1):
            echo '<p><b>' . __( 'Page options', 'devTheme' ) . '</b></p>';
            echo '<ul>';
              $exeptions = array('beforeMain', 'afterMain');
              foreach (SELF::$template_page_options as $key => $value) {
                // check if option is active
                if($value == 1 && !in_array($key, $exeptions)):
                  $active = prefix_core_BaseFunctions::setChecked($key, $options);
                  // rule for metabox before output
                  if(in_array($key, array('date', 'time', 'author'))):
                    if(in_array($post->post_type, array('page', 'post')) && SELF::$template_page_metablock[$post->post_type] == 1 || !empty(SELF::$template_page_metablockAdds) && in_array($post->post_type, SELF::$template_page_metablockAdds)):
                      $show = true;
                    else:
                      $show = false;
                    endif;
                  else:
                    $show = true;
                  endif;
                  // output
                  if($show == true):
                    echo '<li><label><input type="checkbox" name="template_page_options[]" value="' . $key . '" ' . $active . '>' . SELF::$backend['page']['value']['options']['value'][$key]["label"] . '</label></li>';
                  endif;
                endif;
              }
              foreach (SELF::$template_page_additional as $key => $additional) {
                // check if additional option are available
                if(array_key_exists('key', $additional) && array_key_exists('value', $additional)):
                  $active = prefix_core_BaseFunctions::setChecked($additional["key"], $options);
                  echo '<li><label><input type="checkbox" name="template_page_options[]" value="' . $additional["key"] . '" ' . $active . '>' . $additional["value"] . '</label></li>';
                endif;
              }
            echo '</ul>';
            // return exeptions
            foreach (SELF::$template_page_options as $key => $value) {
              // check if option is active
              if($value == 1 && in_array($key, $exeptions)):
                if($key == 'beforeMain'):
                  $customLabel = 'Code before main block';
                elseif($key == 'afterMain'):
                  $customLabel = 'Code after main block';
                endif;
                echo '<div class="exeption">';
                  echo '<p><label for="exeption-' . $key . '"><b>' . __( $customLabel, 'devTheme' ) . '</b></label></p>';
                  echo '<textarea id="exeption-' . $key . '" name="template_page_options[' . $key . ']">' . $options[$key] . '</textarea>';
                echo '</div>';
              endif;
            }
          endif;

          if(SELF::$template_page_bgColor == 1):
            wp_enqueue_style( 'wp-color-picker' );
            echo '<p><b>' . __( 'Background color', 'devTheme' ) . '</b></p>';
            echo '<input type="text" id="template_page_bgColor" name="template_page_bgColor" value="' . $bgColor . '" class="colorpicker"></input>';
          endif;

          if(SELF::$template_page_bgImg == 1):
            echo '<div data-id="template_page_bgImg">';
              echo '<p><b>' . __( 'Background image', 'devTheme' ) . '</b></p>';
              echo '<input type="hidden" class="img-saved" id="template_page_bgImg" name="template_page_bgImg" value="' . $bgImg . '" style="margin-top:5px; width:100%;">';
              echo '<button class="wp-single-media" data-action="WPadmin">' . __('Select images','devTheme') . '</button>';
              // img
              echo '<span class="img-selected">';
                if($bgImg !== false && $bgImg !== ''):
                  echo '<span class="remove_image"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="3" height="32.2"/></svg></span>';
                  echo '<img src="' . wp_get_attachment_thumb_url($bgImg) . '">';
                endif;
              echo '</span>';
            echo '</div>';
          endif;

        echo '</div>';
    }


    /* 3.4 PAGE OPTIONS
    /------------------------*/
    static public function PageOptions($id) {
        // vars
        $output = array();
        $get_options = get_post_meta($id, 'template_page_options', true);
        if(is_string($get_options)):
          $get_options = unserialize($get_options);
        endif;
        $options = $get_options && $get_options != '' ? $get_options : array();
        $options = apply_filters( 'template_PageOptions', $options );
        // check activity
        foreach (SELF::$template_page_options as $key => $value) {
          // check if option is active
          if($value !== 0 && in_array($key, $options)):
            unset($options[$key]);
          endif;
        }
        // output
        return $options;
    }


    /* 3.5 PLACEHOLDER
    /------------------------*/
    static public function SitePlaceholder(){
      // vars
      $output = '';

      if(SELF::$template_ph_active === true):
        $output .= '<div id="placeholder">';
          $output .= '<h1>' . __( 'Website under construction', 'devTheme' ) . '</h1>';
          $output .= SELF::$template_ph_custom ? SELF::$template_ph_custom : '';
          $output .= SELF::$template_ph_address === true ? SELF::AddressBlock(SELF::$template_address, true) : '';
        $output .= '</div>';

        return $output;
        exit;
      endif;
    }


    /* 3.6 LOGO
    /------------------------*/
    public static function Logo(string $link = "", array $desktop = array(), array $mobile = array(), array $scrolled = array(), $svg = ''){
      // vars
      $output = '';
      $addCss = '';
      $page_name = get_bloginfo();
      $link = function_exists("get_bloginfo") && $link == "" ? get_bloginfo('url') : $link;
      $add_desktop = array_key_exists('img', $mobile) && $mobile['img'] !== "" ? 'desktop' : '';
      $add_container = array_key_exists('img', $desktop) && $desktop['img'] == "" && $mobile['img'] == "" ? ' text_logo' : '';
      $img_desktop = array_key_exists('img', $desktop) && $desktop['img'] !== '' ? wp_get_attachment_image_src($desktop['img'], 'full') : '';
      $img_mobile = array_key_exists('img', $mobile) && $mobile['img'] !== '' ? wp_get_attachment_image_src($mobile['img'], 'full') : '';
      $img_scrolled = array_key_exists('img', $scrolled) && $scrolled['img'] !== '' ? wp_get_attachment_image_src($scrolled['img'], 'full') : '';
      if($img_scrolled !== ""):
        $addCss .= ' hide-on-scrolled';
      endif;
      // output
      $output .= '<a href="' . $link . '" class="logo' . $add_container .'">';
        if($svg !== ''):
          $output .= $svg;
        else:
          if($img_desktop !== ""):
            $desktop_add = '';
            $desktop_add .= array_key_exists('width', $desktop) && $desktop['width'] !== "" ? ' width="' . $desktop['width'] . '"' : '';
            $desktop_add .= array_key_exists('height', $desktop) && $desktop['height'] !== "" ? ' height="' . $desktop['height'] . '"' : '';
            $desktop_add .= array_key_exists('alt', $desktop) && $desktop['alt'] !== "" ? ' alt="' . prefix_core_BaseFunctions::getConfigTranslation('template_header_logo_desktop_alt', $desktop['alt']) . '"' : '';
            $output .= '<img src="' . $img_desktop[0] . '" class="' . $add_desktop . $addCss . '"' . $desktop_add . '>';
            $mobile_add = '';
            $mobile_add .= array_key_exists('width', $mobile) && $mobile['width'] !== "" ? ' width="' . $mobile['width'] . '"' : '';
            $mobile_add .= array_key_exists('height', $mobile) && $mobile['height'] !== "" ? ' height="' . $mobile['height'] . '"' : '';
            $mobile_add .= array_key_exists('alt', $mobile) && $mobile['alt'] !== "" ? ' alt="' . $mobile['alt'] . '"' : '';
            $output .= $img_mobile !== "" ? '<img src="' . $img_mobile[0] . '" class="mobile' . $addCss . '"' . $mobile_add . '>' : '';

            $scrolled_add = '';
            $scrolled_add .= array_key_exists('width', $scrolled) && $scrolled['width'] !== "" ? ' width="' . $scrolled['width'] . '"' : '';
            $scrolled_add .= array_key_exists('height', $scrolled) && $scrolled['height'] !== "" ? ' height="' . $scrolled['height'] . '"' : '';
            $scrolled_add .= array_key_exists('alt', $scrolled) && $scrolled['alt'] !== "" ? ' alt="' . $scrolled['alt'] . '"' : '';
            $output .= $img_scrolled !== "" ? '<img src="' . $img_scrolled[0] . '" class="show-on-scrolled"' . $scrolled_add . '>' : '';
          else:
            $output .= $desktop['alt'] !== "" ? prefix_core_BaseFunctions::getConfigTranslation('template_header_logo_desktop_alt', $desktop['alt']) : $page_name;
          endif;
        endif;
      $output .= '</a>';

      $output = apply_filters( 'template_Logo', $output );

      return $output;
    }


    /* 3.7 MAIN MENU
    /------------------------*/
    public static function WP_MainMenu(int $active = 1, string $request = '', string $direction = '', string $hamburgerStyle = '', int $submenutoggle = 0, int $headvisibility, string $hamburgerText = '', int $menu_stretched = 0){
      if($active === 1):
        $menu_active = 'hidden_mobile';
        $hamburger_active = 'mobile';
      else:
        $menu_active = 'hidden_mobile hidden_desktop';
        $hamburger_active = '';
      endif;
      // layout options
      if($direction !== ''):
        $menu_active .= ' ' . $direction;
      endif;
      if($hamburgerStyle !== ''):
        $menu_active .= ' ' . $hamburgerStyle;
      endif;
      if($headvisibility === 1):
        $menu_active .= ' showHeader';
      endif;
      if($submenutoggle === 1):
        $menu_active .= ' toggle-submenu';
      endif;
      if($menu_stretched === 1):
        $menu_active .= ' stretch';
      endif;
      // output
      $output = '';
      if ( has_nav_menu( 'mainmenu' ) ) :
        // get menu
        if($request !== 'hamburger'):
          $output .= wp_nav_menu([
            'container_class'=> $menu_active,
            'menu_id' => 'menu_main',
            'container'=> 'div',
            'container_id' => 'menu-main-container',
            'theme_location' => 'mainmenu'
          ]);
        endif;
        // get hamburger
        if($request !== 'menu'):
          if($hamburgerText !== ''):
            $output .= '<div class="hamburger-container ' . $hamburger_active . ' ' . prefix_template::$template_header_hmenu_containerDirection . '">';
            $hamburger_active = '';
          endif;
            $output .= '<button class="hamburger ' . $hamburger_active . '" aria-label="Main Menu">';
              $output .= '<span class="menu-icon">&nbsp;</span>';
            $output .= '</button>';
          if($hamburgerText !== ''):
              $output .= '<span class="menu-title">' . prefix_core_BaseFunctions::getConfigTranslation('template_header_hmenu_text', $hamburgerText) . '</span>';
            $output .= '</div>';
          endif;
        endif;
      endif;

      return $output;
    }
    // hook for toggle submenu
    function addToggleElementToMenu( $title, $item ) {
      if( is_object( $item ) && isset( $item->ID ) ) {
        if(isset( $item->classes ) && in_array('menu-item-has-children', $item->classes) ):
          $title .= '<span class="toggle"><svg xmlns="http://www.w3.org/2000/svg" width="15.135" height="11.064" viewBox="0 0 15.135 11.064"><g transform="translate(-331.529 -434.15)"><g><line y1="1.05" x2="9" transform="matrix(-0.574, -0.819, 0.819, -0.574, 338.236, 443.67)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="2"/><line x2="9" y2="1.05" transform="matrix(0.574, -0.819, 0.819, 0.574, 339.096, 443.068)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="2"/></g></g></svg></span>';
        endif;
      }
      return $title;
    }


    /* 3.8 ADDRESS BLOCK
    /------------------------*/
    /**
      * @param array $address: given address content
      * options are company, street, street2, zip, postalCode, city, phone, mobile, email, labels (array with childs)
      * @return string price
    */
    public static function AddressBlock(array $address = array(), bool $translation = false){
      // vars
      $output = '';
      // defaults
      $defaults = array(
        'logo' => array(),
        'company' => '',
        'name' => '',
        'street' => '',
        'street2' => '',
        'postalCode' => '',
        'city' => '',
        'country' => '',
        'phone' => '',
        'fax' => '',
        'mobile' => '',
        'email' => '',
        'labels' => array(
          'company' => '',
          'name' => '',
          'street' => '',
          'street2' => '',
          'postalCode' => '',
          'city' => '',
          'country' => '',
          'phone' => '',
          'fax' => '',
          'mobile' => '',
          'email' => ''
        )
      );
      $config = array_merge($defaults, $address);

      $output .= '<address>';
        if(!empty($config["logo"])):
          // logo
          $logoAttributes = '';
          $logo_img = array_key_exists('img', $config["logo"]) && $config["logo"]['img'] !== '' ? wp_get_attachment_image_src(prefix_core_BaseFunctions::getConfigTranslation('template_address_logo_img', $config["logo"]['img']), 'full') : '';
            $logoAttributes .= array_key_exists('width', $config["logo"]) && $config["logo"]['width'] !== "" ? ' width="' . $config["logo"]['width'] . '"' : '';
            $logoAttributes .= array_key_exists('height', $config["logo"]) && $config["logo"]['height'] !== "" ? ' height="' . $config["logo"]['height'] . '"' : '';
            $logoAttributes .= array_key_exists('alt', $config["logo"]) && $config["logo"]['alt'] !== "" ? ' alt="' . prefix_core_BaseFunctions::getConfigTranslation('template_address_logo_alt', $config["logo"]['alt']) . '"' : '';
            $output .= '<img src="' . $logo_img[0] . '" ' . $logoAttributes . '>';
        endif;
        if($config["company"] !== ''):
          $output .= '<span rel="me" class="company">';
            $output .= $config["labels"] && array_key_exists('company', $config["labels"]) && $config["labels"]["company"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_company', $config["labels"]["company"], 'devTheme') . ' ' : '';
            $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_company', $config["company"]);
          $output .= '</span>';
        endif;
        if($config["name"] !== ''):
          $output .= '<span class="name">';
            $output .= $config["labels"] && array_key_exists('name', $config["labels"]) && $config["labels"]["name"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_name', $config["labels"]["name"]) . ' ' : '';
            $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_name', $config["name"]);
          $output .= '</span>';
        endif;
        if($config["street"] !== ''):
          $output .= '<span class="street">';
            $output .= $config["labels"] && array_key_exists('street', $config["labels"]) && $config["labels"]["street"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_street', $config["labels"]["street"]) . ' ' : '';
            $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_street', $config["street"]);
          $output .= '</span>';
        endif;
        if($config["street2"] !== ''):
          $output .= '<span class="street_add">';
            $output .= $config["labels"] && array_key_exists('street2', $config["labels"]) && $config["labels"]["street2"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_street2', $config["labels"]["street2"]) . ' ' : '';
            $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_street2', $config["street2"]);
          $output .= '</span>';
        endif;
        $output .= $config["postalCode"] !== '' && $config["city"] !== '' ? '<span class="location">' : '';
          if($config["postalCode"] !== ''):
            $output .= '<span class="postalcode">';
              $output .= $config["labels"] && array_key_exists('postalCode', $config["labels"]) && $config["labels"]["postalCode"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_postalCode', $config["labels"]["postalCode"]) . ' ' : '';
              $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_postalCode', $config["postalCode"]);
            $output .= '</span>';
          endif;
          $output .= $config["postalCode"] !== '' && $config["city"] !== '' ? ' ' : '';
          if($config["city"] !== ''):
            $output .= '<span class="city">';
              $output .= $config["labels"] && array_key_exists('city', $config["labels"]) && $config["labels"]["city"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_city', $config["labels"]["city"]) . ' ' : '';
              $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_city', $config["city"]);
            $output .= '</span>';
          endif;
        $output .= $config["postalCode"] !== '' && $config["city"] !== '' ? '</span>' : '';
        if($config["country"] !== ''):
          $output .= '<span class="country">';
            $output .= $config["labels"] && array_key_exists('country', $config["labels"]) && $config["labels"]["country"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_country', $config["labels"]["country"]) . ' ' : '';
            $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_country', $config["country"]);
          $output .= '</span>';
        endif;
        if($config["phone"] !== ''):
          $output .= '<a href="tel:' . prefix_core_BaseFunctions::cleanPhoneNr(prefix_core_BaseFunctions::getConfigTranslation('template_address_', $config["phone"])) . '" class="call phone_nr">';
            $output .= $config["labels"] && array_key_exists('phone', $config["labels"]) && $config["labels"]["phone"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_phone', $config["labels"]["phone"]) . ' ' : '';
            $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_phone', $config["phone"]);
          $output .= '</a>';
        endif;
        if($config["fax"] !== ''):
          $output .= '<a href="tel:' . prefix_core_BaseFunctions::cleanPhoneNr(prefix_core_BaseFunctions::getConfigTranslation('template_address_', $config["fax"])) . '" class="call fax_nr">';
            $output .= $config["labels"] && array_key_exists('fax', $config["labels"]) && $config["labels"]["fax"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_fax', $config["labels"]["fax"]) . ' ' : '';
            $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_fax', $config["fax"]);
          $output .= '</a>';
        endif;
        if($config["mobile"] !== ''):
          $output .= '<a href="tel:' . prefix_core_BaseFunctions::cleanPhoneNr(prefix_core_BaseFunctions::getConfigTranslation('template_address_', $config["mobile"])) . '" class="call mobile_nr">';
            $output .= $config["labels"] && array_key_exists('mobile', $config["labels"]) && $config["labels"]["mobile"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_mobile', $config["labels"]["mobile"]) . ' ' : '';
            $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_mobile', $config["mobile"]);
          $output .= '</a>';
        endif;
        if($config["email"] !== ''):
          $output .= '<a href="mailto:' . prefix_core_BaseFunctions::getConfigTranslation('template_address_', $config["email"]) . '" class="mail">';
            $output .= $config["labels"] && array_key_exists('email', $config["labels"]) && $config["labels"]["email"] !== '' ? prefix_core_BaseFunctions::getConfigTranslation('template_address_label_email', $config["labels"]["email"]) . ' ' : '';
            $output .= $config["labels"] && array_key_exists('email', $config["labels"]) && $config["labels"]["email"] !== '' ? '<span>' : '';
              $output .= prefix_core_BaseFunctions::getConfigTranslation('template_address_email', $config["email"]);
            $output .= $config["labels"] && array_key_exists('email', $config["labels"]) && $config["labels"]["email"] !== '' ? '</span>' : '';
          $output .= '</a>';
        endif;
      $output .= '</address>';

      return $output;
    }


    /* 3.9 DIVIDE HEADER FROM CONTENT
    /------------------------*/
    public static function Divider(int $divider = 1){
      if($divider === 1):
        return '<hr class="divider" />';
      endif;
    }


    /* 3.10 FOOTER MENU
    /------------------------*/
    public static function WP_FooterMenu(bool $active = true){
      if ( has_nav_menu( 'footermenu' ) && $active === true ) :
        // css
        $css = 'wp-menu';
        if(array_key_exists('css', SELF::$template_footer_menu) && SELF::$template_footer_menu['css'] !== ''):
          $css .= ' ' . SELF::$template_footer_menu['css'];
        endif;
        if(SELF::$template_footer_menu['direction'] == 'h' || SELF::$template_footer_menu['direction'] == 'horizontal'):
          $css .= ' horizontal';
        endif;
        if(SELF::$template_footer_menu['seperator'] == 1):
          $css .= ' menu-seperated';
        endif;
        // output
        echo '<nav>';
          echo wp_nav_menu([
            'menu_class'=> $css,
            'menu_id' => 'menu_footer',
            'container'=> false,
            'depth' => 2,
            'theme_location' => 'footermenu'
          ]);
        echo '</nav>';
      endif;
    }


    /* 3.11 COPYRIGHT
    /------------------------*/
    public static function Copyright(string $cr = ""){
      // value fallback
      $value = $cr !== '' ? $cr : SELF::$template_footer_cr;
      // vars
      $output = '';

      $output .= '<span class="copyright">';
        $output .= $value;
      $output .= '</span>';

      return $output;
    }


    /* 3.12 SOCIAL MEDIA
    /------------------------*/
    public static function SocialMedia(){
      // value fallback
      $sm = SELF::$template_socialmedia;
      // check if value given
      if($sm):
        // vars
        $output = '';

        $output .= '<ul class="socialmedia">';
          foreach ($sm as $type => $link) {
            if($link !== ""):
              $output .= '<li class="' . $type . '">';
                $output .= '<a href="' . $link . '" target="_blank">';

                switch ($type) {
                  case 'facebook':
                    $output .= '<svg role="img" xmlns="http://www.w3.org/2000/svg" width="47.904" height="47.904" viewBox="0 0 47.904 47.904"><title>Facebook</title><path d="M115.4,91.452a23.952,23.952,0,1,0-27.695,23.661V98.376H81.628V91.452h6.082V86.175c0-6,3.576-9.319,9.047-9.319a36.824,36.824,0,0,1,5.362.468v5.894H99.1c-2.975,0-3.9,1.846-3.9,3.74v4.493h6.643l-1.062,6.924H95.195v16.737A23.958,23.958,0,0,0,115.4,91.452Z" transform="translate(-67.5 -67.5)"/><path id="Pfad_3025" data-name="Pfad 3025" d="M194.294,160.308l1.062-6.924h-6.643v-4.493c0-1.894.928-3.74,3.9-3.74h3.02v-5.894a36.823,36.823,0,0,0-5.362-.468c-5.471,0-9.047,3.316-9.047,9.319v5.277h-6.082v6.924h6.082v16.737a24.2,24.2,0,0,0,7.485,0V160.308Z" transform="translate(-161.018 -129.433)" fill="none"/></svg>';
                    break;
                  case 'instagram':
                    $output .= '<svg role="img" xmlns="http://www.w3.org/2000/svg" width="47.567" height="47.567" viewBox="0 0 47.567 47.567"><title>Instagram</title><g transform="translate(-449.718 -904.492)"><g transform="translate(461.245 912.44)"><path d="M53.225,40.97A12.257,12.257,0,1,0,65.482,53.227,12.271,12.271,0,0,0,53.225,40.97Zm0,20.293a8.036,8.036,0,1,1,8.036-8.036A8.045,8.045,0,0,1,53.225,61.263Z" transform="translate(-40.968 -37.391)"/><path d="M122.016,28.251a3.093,3.093,0,1,0,2.189.906A3.107,3.107,0,0,0,122.016,28.251Z" transform="translate(-96.988 -28.251)"/></g><path d="M34.44,0H13.127A13.142,13.142,0,0,0,0,13.127V34.44A13.142,13.142,0,0,0,13.127,47.567H34.44A13.142,13.142,0,0,0,47.567,34.44V13.127A13.142,13.142,0,0,0,34.44,0Zm8.907,34.44a8.917,8.917,0,0,1-8.907,8.906H13.127A8.916,8.916,0,0,1,4.22,34.44V13.127A8.917,8.917,0,0,1,13.127,4.22H34.44a8.917,8.917,0,0,1,8.907,8.906V34.44Z" transform="translate(449.718 904.492)"/></g></svg>
';
                    break;
                  case 'linkedin':
                    $output .= '<svg role="img" xmlns="http://www.w3.org/2000/svg" width="47.57" height="47.57" viewBox="0 0 47.57 47.57"><title>Linkedin</title><path d="M112.058,113H71.515A3.463,3.463,0,0,0,68,116.409v40.752a3.465,3.465,0,0,0,3.515,3.409h40.543a3.462,3.462,0,0,0,3.512-3.409V116.409A3.461,3.461,0,0,0,112.058,113ZM82.422,152.82H75.234V131.342h7.188Zm-3.592-24.413h-.05a4.106,4.106,0,1,1,.05,0Zm29.5,24.413h-7.185V141.327c0-2.888-1.043-4.857-3.639-4.857a3.927,3.927,0,0,0-3.688,2.612,4.828,4.828,0,0,0-.237,1.739v12H86.4s.1-19.465,0-21.478h7.185v3.045a7.137,7.137,0,0,1,6.475-3.551c4.728,0,8.274,3.069,8.274,9.668Zm-14.8-18.365a.7.7,0,0,1,.047-.067v.067Zm0,0" transform="translate(-68 -113)" /></svg>';
                    break;
                  case 'twitter':
                    $output .= '<svg role="img" xmlns="http://www.w3.org/2000/svg" width="56.848" height="46.201" viewBox="0 0 56.848 46.201"><title>Twitter</title><path d="M558.058,616.059c21.454,0,33.185-17.773,33.185-33.185q0-.757-.033-1.508a23.718,23.718,0,0,0,5.818-6.04,23.257,23.257,0,0,1-6.7,1.836,11.7,11.7,0,0,0,5.129-6.451,23.389,23.389,0,0,1-7.406,2.831,11.673,11.673,0,0,0-19.875,10.636,33.115,33.115,0,0,1-24.041-12.186,11.674,11.674,0,0,0,3.611,15.571,11.578,11.578,0,0,1-5.282-1.459c0,.049,0,.1,0,.149a11.667,11.667,0,0,0,9.357,11.433,11.644,11.644,0,0,1-5.268.2,11.675,11.675,0,0,0,10.9,8.1,23.4,23.4,0,0,1-14.486,4.992,23.705,23.705,0,0,1-2.782-.161,33.015,33.015,0,0,0,17.879,5.239" transform="translate(-540.179 -569.858)"/></svg>';
                    break;

                  default:
                    // code...
                    break;
                }

                $output .= '</a>';
              $output .= '</li>';
            endif;
          }
        $output .= '</ul>';

        return $output;
      endif;
    }


    /* 3.13 CONTACT BLOCK
    /------------------------*/
    public static function ContactBlock(array $contacts = array()){
      if($contacts):
        // vars
        $output = '';

        $output .= '<ul class="contact-block">';
          foreach ($contacts as $type => $link) {
            if($link !== ""):
              $output .= '<li class="' . $type . '">';

                switch ($type) {
                  case 'phone':
                    $output .= '<a href="tel:' . $link . '">';
                      $output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.967 20"><path data-name="Pfad 18" d="M16.62 15.596l-2.567-2.021a1.251 1.251 0 0 0-1.726.169c-.463.526-.758.884-.863.968-.779.779-2.4-.358-4.125-2.083S4.498 9.303 5.274 8.524c.084-.084.442-.4.968-.863a1.252 1.252 0 0 0 .169-1.726L4.393 3.368a1.279 1.279 0 0 0-1.473-.379A10.787 10.787 0 0 0 .647 4.651c-1.852 1.874.463 6.125 4.5 10.186s8.313 6.377 10.165 4.5a10.755 10.755 0 0 0 1.662-2.269 1.232 1.232 0 0 0-.358-1.472z"/><path data-name="Pfad 19" d="M10.306 6.567a.832.832 0 0 0-1.031.863.878.878 0 0 0 .631.758 2.543 2.543 0 0 1 1.877 1.873.809.809 0 0 0 .758.631.833.833 0 0 0 .863-1.031 3.962 3.962 0 0 0-1.1-1.979 4.134 4.134 0 0 0-2-1.116z"/><path data-name="Pfad 20" d="M15.862 10.945a.835.835 0 0 0 .884-.905A7.415 7.415 0 0 0 9.97 3.264a.834.834 0 0 0-.147 1.662 5.649 5.649 0 0 1 3.6 1.684 5.857 5.857 0 0 1 1.684 3.6.764.764 0 0 0 .757.737z"/><path data-name="Pfad 21" d="M16.872 3.116A10.725 10.725 0 0 0 9.653.004a.817.817 0 0 0-.842.884.84.84 0 0 0 .8.779 9.039 9.039 0 0 1 8.692 8.713.831.831 0 0 0 1.662-.042 10.6 10.6 0 0 0-3.093-7.219z"/></svg>';
                    $output .= '</a>';
                    break;
                  case 'mail':
                    $output .= '<a href="mailto:' . $link . '">';
                      $output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.945 13.874"><defs></defs><g id="noun_Mail_1425138_000000" transform="translate(-7 -976.362)"><path id="Pfad_6" data-name="Pfad 6" class="cls-1" d="M8.251,976.362l10.222,8.554,10.222-8.554H8.251ZM7,977.4v11.748l6.762-6.086L7,977.4Zm22.945,0-6.762,5.661,6.762,6.086V977.4ZM15,984.108l-6.812,6.128H28.753l-6.812-6.128-2.952,2.468a.8.8,0,0,1-1.034,0L15,984.108Z" transform="translate(0 0)"/></g></svg>';
                    $output .= '</a>';
                    break;
                  case 'whatsapp':
                    $output .= '<a href="https://api.whatsapp.com/send?phone=' . $link . '">';
                      $output .= '<svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>WhatsApp</title><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';
                    $output .= '</a>';
                    break;

                  default:
                    // code...
                    break;
                }

                $output .= '</a>';
              $output .= '</li>';
            endif;
          }
        $output .= '</ul>';

        return $output;
      endif;
    }


    /* 3.14 ICON BLOCK
    /------------------------*/
    /**
      * @param array $icons: list of svg icons with link, css clss or additional attributes
      * options are svg, link, target, class, attr
        * @param array $settings: container settings
        * options are class, attr
      * @return string ul with icons
    */
    public static function IconBlock(array $icons = array(), array $settings = array()){
      if(!empty($icons)):
        // container settings
        $container_css = array_key_exists('class', $settings) ? ' ' . $settings['class'] : '';
        $container_attr = '';
        if(array_key_exists('attr', $settings) && is_array($settings['attr'])):
          foreach ($settings['attr'] as $key => $single_attr) {
            $container_attr .= ' ' . $key . '="' . $single_attr . '"';
          }
        endif;
        // output
        $output = '<ul class="iconlist' . $container_css . '"' . $container_attr . '>';
        foreach ($icons as $key => $icon) {
          // svg container - if link is given use a tag else span
          if(array_key_exists('link', $icon)):
            $target = array_key_exists('target', $icon) ? ' target="_' . $icon['target'] . '"' : '';
            $tag = 'a href="' . $icon['link'] . '"' . $target;
          else:
            $tag = 'span';
          endif;
          // additional to the svg container
          $icon_css = array_key_exists('class', $icon) ? ' class="' . $icon['class'] . '"' : '';
          $icon_title = array_key_exists('title', $icon) ? ' title="' . $icon['title'] . '"' : '';
          $icon_attr = '';
          if(array_key_exists('attr', $icon) && is_array($icon['attr'])):
            foreach ($icon['attr'] as $key => $attr) {
              $icon_attr .= ' ' . $key . '="' . $attr . '"';
            }
          endif;
          // output
          $output .= '<li>';
            $output .= '<' . $tag . $icon_css . $icon_attr . $icon_title . ' tabindex="0">';
              $output .= $icon['svg'];
              if(array_key_exists('label', $icon)):
                $output .= '<label>' . $icon['label'] . '</label>';
              endif;
          $output .= '</' . $tag . '>';
          $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
      else:
        $debug_errors['template'][] = "Icon Block is empty";
      endif;
    }


    /* 3.15 CONTENT BLOCK
    /------------------------*/
    public static function ContentBlock(string $content = ''){
      if ($content !== ''):
        echo do_shortcode(str_replace("'", '"', $content));
      endif;
    }


    /* 3.16 BODY CSS
    /------------------------*/
    public static function BodyCSS(){
      $obj = get_queried_object();
      $page_id = get_queried_object_id();
      // base classes
      $classes = 'frontend';
      $classes .= $obj && property_exists($obj, 'post_type') ? ' pt-' . $obj->post_type : '';
      $classes .= $obj && property_exists($obj, 'name') ? ' pt-' . $obj->name : '';
      $classes .= prefix_template::$template_coloring !== '' ? ' ' . prefix_template::$template_coloring : '';
      $classes .= prefix_template::CheckSticky(prefix_template::$template_header_sticky, prefix_template::$template_header_stickyload);
      // dark mode
      if($page_id > 0):
        $options = get_post_meta($page_id, 'template_page_options', true);
        if(is_string($options)):
          $options = unserialize($options);
        endif;
        $classes .= $options && is_array($options) && in_array('darkmode', $options) && SELF::$template_page_options['darkmode'] == 1 ? ' dark' : '';
        $classes .= $options && is_array($options) && in_array('header_fixed', $options) && SELF::$template_page_options['header_fixed'] == 1 ? ' fixed' : '';
      endif;
      // detect home page
      if(is_front_page()):
        $classes .= ' is-front-page';
      endif;
      // header/footer wide setting
      $classes .= prefix_template::$template_container_header_wide == 1 ? ' header-is-wide' : '';
      $classes .= prefix_template::$template_container_footer_wide == 1 ? ' footer-is-wide' : '';
      // apply filter
      $classes .= ' ' . apply_filters( 'template_BodyCSS', $classes );
      // return classes
      echo $classes;
    }


    /* 3.17 BODY ATTRIBUTES
    /------------------------*/
    public static function BodyAttr(){
      $page_id = get_queried_object_id();
      $output = '';
      // add background styles
      if($page_id > 0):
        $bgColor = get_post_meta($page_id, 'template_page_bgColor', true);
        $bgImg = get_post_meta($page_id, 'template_page_bgImg', true);
        if($bgColor && $bgColor !== '' || $bgImg && $bgImg !== ''):
          $output .= ' style="';
            $output .= $bgColor && $bgColor !== '' ? '--main_background:' . $bgColor . '; ' : '';
            $output .= $bgImg && $bgImg !== '' ? '--main_backgroundImg: url(' . wp_get_attachment_thumb_url($bgImg) . '); ' : '';
          $output .= '"';
        endif;
      endif;
      // apply filter
      $output .= ' ' . apply_filters( 'template_BodyAttr', $output );
      // return output
      echo $output;
    }


    /* 3.18 POST META
    /------------------------*/
    public static function postMeta($pt, $options){
      $output = '';
      // if metablock is active for post type
      if(in_array($pt, array('page', 'post')) && SELF::$template_page_metablock[$pt] == 1 || !empty(SELF::$template_page_metablockAdds) && in_array($pt, SELF::$template_page_metablockAdds)):
        // post meta blog
        if(!in_array('date', $options) || !in_array('time', $options) || !in_array('author', $options)):
          $output .= '<div class="post-meta">';
          // meta date and time
          if(!in_array('date', $options) || !in_array('time', $options)):
            $output .= '<time class="entry-date" datetime="' . get_the_time( 'c' ) . '">';
            // if date active
            if(!in_array('date', $options)):
              $output .= '<span class="date">' . get_the_date(prefix_template::$template_blog_dateformat) . '</span>';
            endif;
            // if time active
            if(!in_array('time', $options)):
              $output .= '<span class="time">' . get_the_date('G:i') . '</span>';
            endif;
            $output .= '</time>';
          endif;
          // meta author
          if(!in_array('author', $options)):
            $output .= '<span class="entry-author">' . get_the_author() . '</span>';
          endif;
          $output .= '</div>';
        endif;
      endif;
      return $output;
    }


    /* 3.19 SCROLL TO TOP BUTTON
    /------------------------*/
    static public function scrollToTop(){
      $output = '';
      $output .= '<div id="scroll-to-top">';
        $output .= '<div ' . prefix_template::AddContainer(prefix_template::$template_container_totop, true) . '>';
          $output .= '<span>' . __( 'To top', 'devTheme' ) . '</span>';
        $output .= '</div>';
      $output .= '</div>';
      return $output;
    }


    /* 3.20 MAIN MENU SEARCH FORM
    /------------------------*/
    function addSearchFormToMainmenu($items, $args) {
      if ($args->theme_location == 'mainmenu'):
        $updated_options = SELF::buildSearchForm('menu');
        $updated_options .= $items;
        $items = $updated_options;
      endif;
      return $items;
    }


    /* 3.21 RETURN WIDGET
    /------------------------*/
    function getWidget($key) {
      if(is_active_sidebar( $key )):
          dynamic_sidebar( $key );
      endif;
    }


    /* 3.22 LANGUAGE SWITCHER
    /------------------------*/
    static function languageSwitcher($atts){
      $output = '';
      $config = shortcode_atts( array(
        'echo' => 0,
        'display_names_as' => SELF::$template_languageSwitcher_nameDisplay,
        'hide_if_empty' => 0
      ), $atts );
      // css
      $css = "language-switcher wp-menu";
      if(SELF::$template_languageSwitcher_direction == 'h' || SELF::$template_languageSwitcher_direction == 'horizontal'):
        $css .= ' horizontal';
      endif;
      if(SELF::$template_languageSwitcher_separat == 1):
        $css .= ' menu-seperated';
      endif;
      // build output
      $output .= '<ul class="' . $css . '">';
        if (class_exists('SitePress')):
        elseif(function_exists('pll_the_languages')):
          $output .= pll_the_languages($config);
        endif;
      $output .= '</ul>';
      return $output;
    }


    /* 3.23 THUMBNAIL
    /------------------------*/
    static function get_thumbnail(){
      $output = '';
      $obj = get_queried_object();
      $id = $obj && property_exists($obj, 'ID') ? $obj->ID : 0;
      $id = is_404() ? SELF::$template_thumbnail_404 : $id;
      $id = is_search() ? SELF::$template_thumbnail_search : $id;
      $options = $obj && property_exists($obj, 'ID') ? prefix_template::PageOptions($obj->ID) : array();

      if(in_array('thumbnailWide', $options) || SELF::$template_thumbnail_align && SELF::$template_thumbnail_align == 'wide' || is_404() && SELF::$template_404_align && SELF::$template_404_align == 'wide' || is_search() && SELF::$template_search_align && SELF::$template_search_align == 'wide'):
        $thumbnailCss = 'post-thumb alignwide';
      elseif(in_array('thumbnailFull', $options) || SELF::$template_thumbnail_align && SELF::$template_thumbnail_align == 'full' || is_404() && SELF::$template_404_align && SELF::$template_404_align == 'full' || is_search() && SELF::$template_search_align && SELF::$template_search_align == 'full'):
        $thumbnailCss = 'post-thumb alignfull';
      else:
        $thumbnailCss = 'post-thumb';
       endif;

      if($id > 0):
        $output .= SELF::$template_thumbnail_div == 0 ? get_the_post_thumbnail($id, 'full', ['class' => $thumbnailCss, 'callingFrom' => 'detailpage']) : '';
        $output .= SELF::$template_thumbnail_div == 0 && is_404() || SELF::$template_thumbnail_div == 0 && is_search() ? wp_get_attachment_image($id, 'full', ['class' => $thumbnailCss]) : '';
        $img_url = is_404() || is_search() ? wp_get_attachment_image_url($id, 'full') : get_the_post_thumbnail_url($id, 'full');
        $output .= SELF::$template_thumbnail_div == 1 && $img_url ? '<div class="' . $thumbnailCss . '" style="background-image: url(' . $img_url . ')"></div>' : '';
      endif;

      return $output;
    }


    /* 3.24 BREADCRUMBS
    /------------------------*/
    static function breadcrumbNavigation($content = ''){
      $output = '';
      $bc_output = '';
      // check if breadcrumbs are active and build breadcrumbs
      if(prefix_template::$template_breadcrumbs_active || $content == 'bcOnly'):
        if ( !is_home() && !is_front_page() || is_paged() ):
          // vars
          global $post;
          $homeLink = get_bloginfo('url');

          $delimiter = '<span class="bc-separate">' . prefix_template::$template_breadcrumbs_separator . '</span>';
          $before = '<span class="current-page">';
          $after = '</span>';

          $bc_output .= '<nav class="breadcrumbs">';
            $bc_output .= prefix_template::AddContainer(prefix_template::$template_container_breadcrumbs, false) == 'container' ? '<div ' . prefix_template::AddContainer(prefix_template::$template_container_breadcrumbs, true) . '>' : '';
                // introduction
                $bc_output .= prefix_template::$template_breadcrumbs_intro ? '<span class="introduction">' . __('You are here:', 'devTheme') . ' </span>' : '';
                // home page
                $bc_output .= prefix_template::$template_breadcrumbs_home ? '<a href="' . $homeLink . '">' . __('Home', 'devTheme') . '</a> ' . $delimiter . ' ' : '';
                // additional structure
                if(is_category()):
                  // category
                  global $wp_query;
                  $cat_obj = $wp_query->get_queried_object();
                  $thisCat = $cat_obj->term_id;
                  $thisCat = get_category($thisCat);
                  $parentCat = get_category($thisCat->parent);
                  // check for parents
                  if ($thisCat->parent != 0):
                    $bc_output .= get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
                  endif;
                  // current taxonomy
                  $bc_output .= $before . single_cat_title('', false) . $after;
                elseif(is_day()):
                  // date day structure
                  $bc_output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                  $bc_output .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
                  $bc_output .= $before . get_the_time('d') . $after;
                elseif (is_month()):
                  // date month structure
                  $bc_output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                  $bc_output .= $before . get_the_time('F') . $after;
                elseif (is_year()):
                  // date year structure
                  $bc_output .= $before . get_the_time('Y') . $after;
                elseif (is_single() && !is_attachment()):
                  // detail page
                  if (get_post_type() != 'post'):
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    $bc_output .= '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
                    $bc_output .= $before. get_the_title() . $after;
                  else:
                    $cat = get_the_category(); $cat = $cat[0];
                    $bc_output .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                    $bc_output .= $before . get_the_title() . $after;
                  endif;
                elseif(is_search()):
                  // search results
                  $bc_output .= $before . __('Search:', 'devTheme') . ' "' . get_search_query() . '"' . $after;
                elseif(is_tag()):
                  // tags
                  $bc_output .= $before . __('Posts with the tag', 'devTheme') . ' "' . single_tag_title('', false) . '"' . $after;
                elseif(is_404()):
                  // 404 page
                  $bc_output .= $before . __('404', 'devTheme') . $after;
                elseif(!is_single() && !is_page() && get_post_type() != 'post' && !is_404()):
                  // custom post types
                  $post_type = get_post_type_object(get_post_type());
                  $bc_output .= $before . $post_type->labels->singular_name . $after;
                elseif(is_attachment()):
                  // media attachments
                  $parent = get_post($post->post_parent);
                  $cat = get_the_category($parent->ID); $cat = $cat[0];
                  $bc_output .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                  $bc_output .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
                  $bc_output .= $before . get_the_title() . $after;
                elseif (is_page() && !$post->post_parent):
                  // page without parents
                  $bc_output .= $before . get_the_title() . $after;
                elseif(is_page() && $post->post_parent):
                  // page with parents
                  $parent_id = $post->post_parent;
                  $breadcrumbs = array();
                  while($parent_id):
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                    $parent_id = $page->post_parent;
                  endwhile;
                  $breadcrumbs = array_reverse($breadcrumbs);
                  foreach($breadcrumbs as $crumb):
                    $bc_output .= $crumb . ' ' . $delimiter . ' ';
                  endforeach;
                  $bc_output .= $before . get_the_title() . $after;
                endif;
                // pagination
                if(get_query_var('paged') ):
                  if(is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()):
                    $bc_output .= ' (' . __('site') . ' ' . get_query_var('paged') . ')';
                  endif;
                endif;
            $bc_output .= prefix_template::AddContainer(prefix_template::$template_container_breadcrumbs, false) == 'container' ? '</div>' : '';
          $bc_output .= '</nav>';
        endif;
        // define output
        if(strpos($content, 'FilterBreadcrumbs') !== false):
          $output .= str_replace('FilterBreadcrumbs', '', $content);
        elseif($content == 'bcOnly' || SELF::$template_breadcrumbs_inside == 0 && $content == ''):
          // only breadcrumbs
          $output .= $bc_output;
        elseif(SELF::$template_breadcrumbs_inside == 0 && $content !== '' && doing_filter( 'the_content' )):
          // filter fallback - the_content
          $output .= $content;
        elseif(SELF::$template_breadcrumbs_inside && $content !== '' && doing_filter( 'the_content' )):
          // filter - the_content
          if(is_single() || is_page()):
            // insert breadcrumbs after first block (if its cover or image)
            global $post;
            $blocks = parse_blocks( $post->post_content );
            if('core/cover' === $blocks[0]['blockName'] || 'core/image' === $blocks[0]['blockName']):
              $rendered = apply_filters('the_content', 'FilterBreadcrumbs' . render_block($blocks[0]));
              $rendered = str_replace('<p></p>', '', $blocks[0]['innerHTML']);
              if('core/image' === $blocks[0]['blockName']):
                $pos = strpos($content,'</figure>');
                if($pos !== false):
                  $output .= substr_replace($content, '</figure>' . $bc_output, $pos, strlen('</figure>'));
                else:
                  $output .= $content;
                endif;
              else:
                $pos = strpos($content,'</div></div>');
                if($pos !== false):
                  $output .= substr_replace($content, '</div></div>' . $bc_output, $pos, strlen('</div></div>'));
                else:
                  $output .= $content;
                endif;
              endif;
            else:
              $output .= $bc_output;
              $output .= $content;
            endif;

            // $count = 1;
            // foreach($blocks as $block):
            //   $rendered = render_block( $block );
            //   $sc = do_shortcode($rendered);
            //   if($count === 1):
            //     if('core/cover' === $block['blockName'] || 'core/image' === $block['blockName']):
            //       $output .= $block['innerHTML'];
            //       $output .= $bc_output;
            //     else:
            //       $output .= $bc_output;
            //       $output .= $block['innerHTML'];
            //     endif;
            //   else:
            //     $output .= $block['innerHTML'];
            //   endif;
            //   $count++;
            // endforeach;
          else:
            // if its not the page return return only content
            $output .= $content;
          endif;
        endif;
      endif;

      return $output;
    }


    /* 3.25 ARRAY OF ALL TEMPLATE PARTS
    /------------------------*/
    function getAllTemplateParts($object) {
      $output = array();
      $id = $object["id"];

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
      $output['content'] = ob_get_contents();
      ob_end_clean();

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
      $output['media'] = ob_get_contents();
      ob_end_clean();

      return $output;
    }


}
