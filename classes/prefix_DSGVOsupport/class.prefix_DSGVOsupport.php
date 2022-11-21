<?php
/**
 *
 *
 * Backend area to manage configuration file
 * Author:      David Voglgsnag
 * @version     1.4.8
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
   2.1 ADD BACKEND PAGE
   2.2 ENQUEUE BACKEND SCRIPTS/STYLES
 3.0 OUTPUT
   3.1 FILTER GUTENBERG BLOCKS
   3.2 BLOCK CONSANT REQUEST
   3.3 FILTER CONTENT
   3.4 EMBED CONSANT REQUEST
 =======================================================*/


class prefix_DSGVOsupport {

  /*==================================================================================
    1.0 INIT & VARS
  ==================================================================================*/

  /* 1.1 CONFIGURATION
  /------------------------*/
  /**
    * default vars
    * @param static int $dsgvo_active: activate dsgvo addons
    * @param static int $dsgvo_reloadAfterConsent: reload page after consent
    * @param static string $dsgvo_vimeoCookie: vimeo cookie name
    * @param static string $dsgvo_youtubeCookie: youtube cookie name
    * @param static array $dsgvo_addRules: additional rules
  */
  static $dsgvo_active             = 0;
  static $dsgvo_reloadAfterConsent = 0;
  static $dsgvo_vimeoCookie        = 'cookielawinfo-checkbox-thirdparty';
  static $dsgvo_youtubeCookie      = 'cookielawinfo-checkbox-thirdparty';
  static $dsgvo_addRules           = array();


  /* 1.2 ON LOAD RUN
  /------------------------*/
  public function __construct() {
    // update default vars with configuration file
    SELF::updateVars();
    // support is active
    if(SELF::$dsgvo_active == 1 && !is_admin()):
      // gutenberg block filter
      add_filter( 'render_block', array($this, 'filterGutenbergBlocks'), 90, 2);
      // embed filter
      add_filter('the_content', array($this, 'fiterEmbeds'), 90);
    endif;
  }


  /* 1.3 BACKEND ARRAY
  /------------------------*/
  static $classtitle = 'DSGVO support';
  static $classkey = 'dsgvo';
  static $backend = array(
    "activate" => array(
      "label" => "Activate support",
      "type" => "switchbutton"
    ),
    "reloadAfterConsent" => array(
      "label" => "Reload after consent",
      "type" => "switchbutton"
    ),
    "vimeoCookie" => array(
      "label" => "Vimeo cookie",
      "type" => "text",
      "placeholder" => "cookielawinfo-checkbox-thirdparty"
    ),
    "youtubeCookie" => array(
      "label" => "Youtube cookie",
      "type" => "text",
      "placeholder" => "cookielawinfo-checkbox-thirdparty"
    ),
    "addRules" => array(
      "label" => "Additional rules",
      "type" => "array_addable",
      "value" => array(
        "cssClass" => array(
          "label" => "CSS class",
          "type" => "text"
        ),
        "cookieName" => array(
          "label" => "Cookie name",
          "type" => "text"
        )
      )
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
      if($configuration && array_key_exists('dsgvo', $configuration)):
        // class configuration
        $myConfig = $configuration['dsgvo'];
        SELF::$dsgvo_active = array_key_exists('activate', $myConfig) ? $myConfig['activate'] : SELF::$dsgvo_active;
        SELF::$dsgvo_reloadAfterConsent = array_key_exists('reloadAfterConsent', $myConfig) ? $myConfig['reloadAfterConsent'] : SELF::$dsgvo_reloadAfterConsent;
        SELF::$dsgvo_vimeoCookie = array_key_exists('vimeoCookie', $myConfig) ? $myConfig['vimeoCookie'] : SELF::$dsgvo_vimeoCookie;
        SELF::$dsgvo_youtubeCookie = array_key_exists('youtubeCookie', $myConfig) ? $myConfig['youtubeCookie'] : SELF::$dsgvo_youtubeCookie;
        SELF::$dsgvo_addRules = array_key_exists('addRules', $myConfig) ? $myConfig['addRules'] : SELF::$dsgvo_addRules;
      endif;
    }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

    /* 3.1 FILTER GUTENBERG BLOCKS
    /------------------------*/
    public static function filterGutenbergBlocks($block_content, $block){
      if(is_admin() && prefix_DSGVOsupport::$dsgvo_active !== 1):
        // dont filter in admin area
        $consent = true;
      else:
        if("templates/vimeo" == $block['blockName'] || "core/embed" == $block['blockName'] && $block["attrs"]["providerNameSlug"] == "vimeo"):
            if(isset($_COOKIE[SELF::$dsgvo_vimeoCookie]) && $_COOKIE[SELF::$dsgvo_vimeoCookie] == 'yes'):
              // consent given to vimeo blocks
              $consent = true;
            else:
              $consent = false;
              $consentRequest = SELF::$dsgvo_vimeoCookie;
            endif;
        elseif("core/embed" == $block['blockName'] && $block["attrs"]["providerNameSlug"] == "youtube"):
            if(isset($_COOKIE[SELF::$dsgvo_youtubeCookie]) && $_COOKIE[SELF::$dsgvo_youtubeCookie] == 'yes'):
              // consent given to vimeo blocks
              $consent = true;
            else:
              $consent = false;
              $consentRequest = SELF::$dsgvo_youtubeCookie;
            endif;
        else:
          // default return
          $consent = true;
          if(!empty(SELF::$dsgvo_addRules) && !empty($block["attrs"]) && array_key_exists('className', $block["attrs"])):
            foreach (SELF::$dsgvo_addRules as $ruleKey => $rule) {
              if(str_contains($block["attrs"]["className"], $rule["cssClass"])):
                if(isset($_COOKIE[$rule["cookieName"]]) && $_COOKIE[$rule["cookieName"]] == 'yes'):
                else:
                  $consent = false;
                  $consentRequest = $rule["cookieName"];
                endif;
                break;
              endif;
            }
          endif;
        endif;
      endif;

      if($consent):
        $output = $block_content;
      else:
        $output = SELF::returnConsentRequest($consentRequest, $block_content, $block);
      endif;

      return $output;
    }


    /* 3.2 BLOCK CONSANT REQUEST
    /------------------------*/
    public static function returnConsentRequest($consentRequest, $block_content, $block){
      // block additions
      $blockClasses = '';
      $blockAdds = '';
      if("templates/vimeo" == $block['blockName']):
        $dimensionX = $block["attrs"]["videoDimensionX"] ? $block["attrs"]["videoDimensionX"] : 16;
        $dimensionY = $block["attrs"]["videoDimensionY"] ? $block["attrs"]["videoDimensionY"] : 9;
        $paddingTop = 100 / $dimensionX * $dimensionY;
        $blockAdds .= ' style="padding-top: ' . str_replace(",", ".", $paddingTop) . '%"';
        $blockClasses .= ' video-embed';
      endif;
      if("core/embed" == $block['blockName'] && $block["attrs"]["providerNameSlug"] == "vimeo" || $block["attrs"]["providerNameSlug"] == "youtube"):
        $blockWidth = 16;
        if (preg_match("/width=\"(\\d+)/", $block_content, $matches)):
          $blockWidth = $matches[1] * 1;
        endif;
        $blockHeight = 9;
        if (preg_match("/height=\"(\\d+)/", $block_content, $matches)):
          $blockHeight = $matches[1] * 1;
        endif;
        $paddingTop = 100 / $blockWidth * $blockHeight;
        $blockAdds .= ' style="padding-top: ' . str_replace(",", ".", $paddingTop) . '%"';
        $blockClasses .= ' video-embed';
      endif;
      // container additions
      $containerAdds = '';
      // convert data-embed
      $not_embedded = $block['attrs']['url'];
      $toInsert = str_replace( $not_embedded, wp_oembed_get($not_embedded), $block_content );
      $toInsert = str_replace(array('&', '<', '>', '"', '«', '»'), array('&amp;', '&lt;', '&gt;', '&quot;', '&quot;', '&quot;'), $toInsert);
      // build output
      $output = '';
      $output .= '<div class="consent-request' . $blockClasses . '"' . $blockAdds . '>';
        if(array_key_exists('dsgvoImgId', $block["attrs"])):
          $output .= '<img src="' . wp_get_attachment_image_src($block["attrs"]["dsgvoImgId"], 'full')[0] . '" class="dsgvo-placeholder">';
        endif;
        $output .= '<div class="consent-request-container"' . $containerAdds . '>';
          $output .= '<p>';
            if(strpos($block_content, 'youtube') !== false):
              $output .= __('This content is provided by YouTube.com. YouTube.com is a service of the Google group. To view the content, cookies from YouTube.com must be accepted. By clicking the button, you agree to the use of these cookies by YouTube.com. The provider of this website has no influence on the information loaded by YouTube.com. No information is sent to YouTube.com from this website. For more information, see the <a href="https://policies.google.com/privacy" target="_blank">privacy policy</a> of Google.com.', 'DSGVO support');
            elseif(strpos($block_content, 'vimeo') !== false):
              $output .= __('This content is provided by Vimeo.com. To view the content, cookies must be accepted by Vimeo.com. By clicking the button, you agree to the use of these cookies and the execution of a script by Vimeo.com. The provider of this website has no influence on the information loaded by Vimeo.com. No information is sent to Vimeo.com from this website. For more information, see the <a href="https://vimeo.com/privacy" tatget="_blank">privacy policy</a> of Vimeo.com.', 'DSGVO support');
            else:
              $output .= __('This content is provided by a third party provider. To view the content, cookies from this provider must be accepted. By clicking the button, you agree to the use of these cookies. The provider of this website has no influence on the information loaded by the third-party provider. No information is sent from this website to the third-party provider.', 'DSGVO support');
            endif;
          $output .= '</p>';
          $output .= '<button class="funcCall" data-action="consentGiven" data-cookie="' . $consentRequest . '" data-embed="' . $toInsert . '" data-reload="' . SELF::$dsgvo_reloadAfterConsent . '">';
            $output .= __('Accept cookies', 'DSGVO support');
          $output .= '</button>';
        $output .= '</div>';
      $output .= '</div>';
      return $output;
    }


    /* 3.3 FILTER CONTENT
    /------------------------*/
    public static function fiterEmbeds( $content ) {
      // check if gutenberg blocks exists
      if(has_blocks(get_the_id())):
        return $content;
      else:
        $output = '';
        $defaultEmbeds = array();
        $updateEmbeds = array();
        $embeds = get_media_embedded_in_content($content);
        foreach ($embeds as $key => $embed):

          if(strpos($embed, 'vimeo') !== false):
            if(isset($_COOKIE[SELF::$dsgvo_vimeoCookie]) && $_COOKIE[SELF::$dsgvo_vimeoCookie] == 'yes'):
              // no need to replace
              $consent = true;
            else:
              $consent = false;
              $consentRequest = SELF::$dsgvo_vimeoCookie;
            endif;
          elseif(strpos($embed, 'youtube') !== false):
            if(isset($_COOKIE[SELF::$dsgvo_youtubeCookie]) && $_COOKIE[SELF::$dsgvo_youtubeCookie] == 'yes'):
              // no need to replace
              $consent = true;
            else:
              $consent = false;
              $consentRequest = SELF::$dsgvo_youtubeCookie;
            endif;
          else:
            $consent = true;
          endif;
          // add to replace list
          $defaultEmbeds[$key] =  $embed;
          $updateEmbeds[$key] = SELF::returnEmbedConsentRequest($consent, $embed, $consentRequest);
        endforeach;

        if(empty($updateEmbeds)):
          return $content;
        else:
          return str_replace($defaultEmbeds, $updateEmbeds, $content);
        endif;

      endif;
    }


    /* 3.4 EMBED CONSANT REQUEST
    /------------------------*/
    public static function returnEmbedConsentRequest( $consent, $embed, $consentRequest ) {
      $output = '';
      // block additions
      $blockClasses = '';
      $blockAdds = '';
      if(strpos($embed, 'vimeo') !== false || strpos($embed, 'youtube') !== false):
        $blockWidth = 16;
        if (preg_match("/width=\"(\\d+)/", $embed, $matches)):
          $blockWidth = $matches[1] * 1;
        endif;
        $blockHeight = 9;
        if (preg_match("/height=\"(\\d+)/", $embed, $matches)):
          $blockHeight = $matches[1] * 1;
        endif;
        $paddingTop = 100 / $blockWidth * $blockHeight;
        $blockAdds .= ' style="padding-top: ' . str_replace(",", ".", $paddingTop) . '%"';
        $blockClasses .= ' video-embed';
      endif;
      // container additions
      $containerAdds = '';
      if($consent == false):
        // convert data-embed
        $toInsert = str_replace(array('&', '<', '>', '"'), array('&amp;', '&lt;', '&gt;', '&quot;'), '<div class="resp_video"' . $blockAdds . '>' . $embed . '</div>');
        // build output
        $output .= '<div class="consent-request' . $blockClasses . '"' . $blockAdds . '>';
          $output .= '<div class="consent-request-container"' . $containerAdds . '>';
            $output .= '<p>';
              if(strpos($embed, 'youtube') !== false):
                $output .= __('This content is provided by YouTube.com. YouTube.com is a service of the Google group. To view the content, cookies from YouTube.com must be accepted. By clicking the button, you agree to the use of these cookies by YouTube.com. The provider of this website has no influence on the information loaded by YouTube.com. No information is sent to YouTube.com from this website. For more information, see the <a href="https://policies.google.com/privacy" target="_blank">privacy policy</a> of Google.com.', 'DSGVO support');
              elseif(strpos($embed, 'vimeo') !== false):
                $output .= __('This content is provided by Vimeo.com. To view the content, cookies must be accepted by Vimeo.com. By clicking the button, you agree to the use of these cookies and the execution of a script by Vimeo.com. The provider of this website has no influence on the information loaded by Vimeo.com. No information is sent to Vimeo.com from this website. For more information, see the <a href="https://vimeo.com/privacy" tatget="_blank">privacy policy</a> of Vimeo.com.', 'DSGVO support');
              else:
                $output .= __('This content is provided by a third party provider. To view the content, cookies from this provider must be accepted. By clicking the button, you agree to the use of these cookies. The provider of this website has no influence on the information loaded by the third-party provider. No information is sent from this website to the third-party provider.', 'DSGVO support');
              endif;
            $output .= '</p>';
            $output .= '<button class="funcCall" data-action="consentGiven" data-cookie="' . $consentRequest . '" data-embed="' . $toInsert . '" data-reload="' . SELF::$dsgvo_reloadAfterConsent . '">';
              $output .= __('Accept cookies', 'DSGVO support');
            $output .= '</button>';
          $output .= '</div>';
        $output .= '</div>';
      else:
        $output .= '<div class="resp_video"' . $blockAdds . '>' . $embed . '</div>';
      endif;

      return $output;
    }

}
?>
