<?php
/**
 *
 *
 * WORDPRESS GUTENBERG SUPPORT
 * https://github.com/david-gap/classes
 *
 * @author      David Voglgsang
 * @version     1.0
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
3.0 OUTPUT
  3.1 TRACKING CODE
  3.2 MAUTIC CONTENT EMBED
=======================================================*/

class prefix_Mautic {

  /*==================================================================================
    1.0 INIT & VARS
  ==================================================================================*/

    /* 1.1 CONFIGURATION
    /------------------------*/
    /**
      * default vars
      * @param private string $Mautic_URL: URL to Mautic installation
      * @param private int $Mautic_inlineTracking: Embed tracking code inside html
      * @param private int $Mautic_inlineFormScript: Embed form tracking code inside html
    */
    private $Mautic_URL  = '';
    private $Mautic_inlineTracking  = 0;
    private $Mautic_inlineFormScript  = 0;


    /* 1.2 ON LOAD RUN
    /------------------------*/
    public function __construct() {
      // update default vars with configuration file
      SELF::updateVars();
      // add tracking code
      add_action( 'wp_footer', array($this, 'mauticTracking'), 100 );
      // mautic shortcode
      if ( shortcode_exists( 'mautic' ) ):
      else:
        add_shortcode( 'mautic', array( $this, 'mauticContent' ) );
      endif;
      // register strings
      $backendStrings = array(
        __('Mautic', 'devTheme'),
        __('Mautic URL', 'devTheme'),
        __('Inline tracking code', 'devTheme'),
        __('Inline formular script', 'devTheme')
      );
    }

    /* 1.3 BACKEND ARRAY
    /------------------------*/
    static $classtitle = 'Mautic';
    static $classkey = 'mautic';
    static $backend = array(
      "url" => array(
        "label" => "Mautic URL",
        "type" => "text"
      ),
      "trackingInline" => array(
        "label" => "Inline tracking code",
        "type" => "switchbutton"
      ),
      "formInline" => array(
        "label" => "Inline formular script",
        "type" => "switchbutton"
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
    if($configuration && array_key_exists('mautic', $configuration)):
      // class configuration
      $myConfig = $configuration['mautic'];
      // update vars
      $this->Mautic_URL = array_key_exists('url', $myConfig) ? $myConfig['url'] : $this->Mautic_URL;
      $this->Mautic_inlineTracking = array_key_exists('trackingInline', $myConfig) ? $myConfig['trackingInline'] : $this->Mautic_inlineTracking;
      $this->Mautic_inlineFormScript = array_key_exists('formInline', $myConfig) ? $myConfig['formInline'] : $this->Mautic_inlineFormScript;
    endif;
  }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

  /* 3.1 TRACKING CODE
  /------------------------*/
  function mauticTracking(){
    // vars
    $output = '';
    $scripts = '';
    // check if mautic url is given
    if($this->Mautic_URL !== ''):
      // mautic tracking
      if($this->Mautic_inlineTracking == 1):
        $scripts .= "(function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;";
        $scripts .= "w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},a=d.createElement(t),";
        $scripts .= "m=d.getElementsByTagName(t)[0];a.async=1;a.src=u;m.parentNode.insertBefore(a,m)";
        $scripts .= "})(window,document,'script','" . $this->Mautic_URL . "/mtc.js','mt');";
        $scripts .= "mt('send', 'pageview');";
      endif;
      // form embed
      if($this->Mautic_inlineFormScript == 1):
        $scripts .= "if (typeof MauticSDKLoaded == 'undefined') {";
            $scripts .= "var MauticSDKLoaded = true;";
            $scripts .= "var head = document.getElementsByTagName('head')[0];";
            $scripts .= "var script = document.createElement('script');";
            $scripts .= "script.type = 'text/javascript';";
            $scripts .= "script.src = '" . $this->Mautic_URL . "/media/js/mautic-form.js';";
            $scripts .= "script.onload = function() {";
                $scripts .= "MauticSDK.onLoad();";
            $scripts .= "};";
            $scripts .= "head.appendChild(script);";
            $scripts .= "var MauticDomain = '" . $this->Mautic_URL . "';";
            $scripts .= "var MauticLang = {";
                $scripts .= "'submittingMessage': ' '";
            $scripts .= "}";
        $scripts .= "} else if (typeof MauticSDK != 'undefined') {";
            $scripts .= "MauticSDK.onLoad();";
        $scripts .= "}";
      endif;
    endif;
    // check if cookie solution is active
    $pluginPath = 'cookie-law-info/cookie-law-info.php';
    if (is_plugin_active( $pluginPath )):
      // Plugin is activ
      $return = false;
      if (isset($_COOKIE['CookieLawInfoConsent'])):
        // consent given
        if (isset($_COOKIE['cookielawinfo-checkbox-advertisement']) && $_COOKIE['cookielawinfo-checkbox-advertisement'] == 'yes'):
            // consent for marketing given
            $return = true;
        endif;
      endif;
    else:
      // plugin is not active
      $return = true;
    endif;
    // return
    if($scripts !== '' && $return == true):
      $output .= "<script>";
        $output .= $scripts;
      $output .= "</script>";
    endif;
    echo $output;
  }

  /* 3.2 MAUTIC CONTENT EMBED
  /------------------------*/
  /**
    * @param array $atts: list with all attributes
    * @return string placeholder for mautic content
    * usage [mautic type="content" slot="ContentSlot"]
  */
  function mauticContent($atts, $content = null){
    // vars
    $output = '';
    $config = shortcode_atts( array(
      'slot' => '',
      'type' => '',
      'id' => ''
    ), $atts );

    switch ( $config['type'] ) {
      case 'form':
        if($config['id'] !== ''):
          $output .= '<script type="text/javascript" src="' . $this->Mautic_URL . '/form/generate.js?id=' . $config['id'] . '"></script>';
        else:
          $output .= 'Mautic form id is missing';
        endif;
        break;
      case 'content':
        if($config['slot'] !== ''):
          $output .= '<div class="mautic-slot" data-slot-name="' . $config['slot'] . '">';
            if($content !== null):
              $output .= $content;
            endif;
          $output .= '</div>';
        else:
          $output .= 'Mautic slot name is missing';
        endif;
        break;
    }

    return $output;
  }


}
