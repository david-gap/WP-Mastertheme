<?php
/**
 *
 *
 * All about security
 * https://github.com/david-gap/classes
 *
 * @author      David Voglgsang
 * @version     0.1
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
  2.2 CECK FOR GEO AUTHORIZATION
3.0 OUTPUT
  3.1 FALLBACK TEXT
=======================================================*/


class prefix_Security {

  /*==================================================================================
    1.0 INIT & VARS
  ==================================================================================*/

    /* 1.1 CONFIGURATION
    /------------------------*/
    /**
      * default vars (if configuration file is missing or broken)
      * @param private int $WPsecurity_GeoblockAdmin: activate geoblocking for backend
      * @param private int $WPsecurity_GeoblockAdminAjax: activate geoblocking for backend ajax
      * @param private array $WPsecurity_SafeCountries: List of all safe countries
      * @param private string $WPsecurity_getGeoBy: Get IP information from
      * @param private string $WPsecurity_FallbackContent: Fallback value
    */
    private static $WPsecurity_GeoblockAdmin       = 0;
    private static $WPsecurity_GeoblockAdminAjax   = 0;
    private static $WPsecurity_SafeCountries       = array('CH');
    private static $WPsecurity_getGeoBy            = 'free geo ip';
    private static $WPsecurity_FallbackContent     = '<h1>Nice try!</h1><p>you are not authorized to access this page</p>';


    /* 1.2 ON LOAD RUN
    /------------------------*/
    public function __construct() {
      // update default vars with configuration file
      SELF::updateVars();
      // backend blocking
      if(SELF::$WPsecurity_GeoblockAdmin == 1):
        add_action('init', array($this, 'wpAdminAuthorization'));
      endif;
      //
    }

    /* 1.3 BACKEND ARRAY
    /------------------------*/
    static $classtitle = 'Security';
    static $classkey = 'security';
    static $backend = array(
      "GeoblockAdmin" => array(
        "label" => "Admin Geoblock",
        "type" => "switchbutton"
      ),
      "GeoblockAdminAjax" => array(
        "label" => "Admin Ajax Geoblock",
        "type" => "switchbutton"
      ),
      "SafeCountries" => array(
        "label" => "Safe countries",
        "type" => "array_addable"
      ),
      "getGeoBy" => array(
        "label" => "Validate with",
        "type" => "select",
        "value" => array('IP who is','free geo ip')
      ),
      "FallbackContent" => array(
        "label" => "Fallback text",
        "type" => "textarea"
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
      if($configuration && array_key_exists('security', $configuration)):
        // class configuration
        $myConfig = $configuration['security'];
        // update vars
        SELF::$WPsecurity_GeoblockAdmin = array_key_exists('GeoblockAdmin', $myConfig) ? $myConfig['GeoblockAdmin'] : SELF::$WPsecurity_GeoblockAdmin;
        SELF::$WPsecurity_GeoblockAdminAjax = array_key_exists('GeoblockAdminAjax', $myConfig) ? $myConfig['GeoblockAdminAjax'] : SELF::$WPsecurity_GeoblockAdminAjax;
        SELF::$WPsecurity_SafeCountries = array_key_exists('SafeCountries', $myConfig) ? $myConfig['SafeCountries'] : SELF::$WPsecurity_SafeCountries;
        SELF::$WPsecurity_getGeoBy = array_key_exists('getGeoBy', $myConfig) ? $myConfig['getGeoBy'] : SELF::$WPsecurity_getGeoBy;
        SELF::$WPsecurity_FallbackContent = array_key_exists('FallbackContent', $myConfig) ? $myConfig['FallbackContent'] : SELF::$WPsecurity_FallbackContent;
      endif;
    }


    /* 2.2 CECK FOR GEO AUTHORIZATION
    /------------------------*/
    /**
      * @param array $countries: witch countries (Shortname) are safe to enter the area
      * @return bool access granted or denied
    */
    public static function checkGeoAuthorization(array $countries = array()){
      $countries = empty($countries) ? SELF::$WPsecurity_SafeCountries : $countries;
      $getClientIp = prefix_core_BaseFunctions::getClientIpAddress();
      if($_SERVER["REMOTE_ADDR"] == "127.0.0.1"):
        // fallback for local enviroment
        return true;
      elseif($getClientIp == ''):
        // disable backend if IP does not exist
        return false;
      else:
        // id exists
        switch (SELF::$WPsecurity_getGeoBy) {
          case 'free geo ip':
            $apiURL = 'https://freegeoip.app/json/' . $getClientIp;
            break;
          case 'IP who is':
            $apiURL = 'http://ipwhois.app/json/' . $getClientIp;
            break;
          default:
            $apiURL = 'https://freegeoip.app/json/' . $getClientIp;
            break;
        }
        // get information from api request
        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($ch);
        curl_close($ch);
        $geoInformation = json_decode($apiResponse, true);
        // validate results
        if(!empty($geoInformation)):
          $countryCode = $geoInformation['country_code'];
          if(in_array($countryCode, $countries)):
            return true;
          else:
            return false;
          endif;
        else:
          return false;
        endif;
      endif;
    }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

    /* 3.1 FALLBACK TEXT
    /------------------------*/
    /**
      * @return string fallback textif access been denied
    */
    public static function fallBackValue(){
      // vars
      $output = SELF::$WPsecurity_FallbackContent;

      echo $output;
    }


    /* 3.2 BACKEND AUTHORIZATION
    /------------------------*/
    public static function wpAdminAuthorization(){
      if(is_admin() && SELF::$WPsecurity_GeoblockAdminAjax !== 1 && !defined('DOING_AJAX') && SELF::checkGeoAuthorization() == false || is_admin() && SELF::$WPsecurity_GeoblockAdminAjax == 1 && defined('DOING_AJAX') && SELF::checkGeoAuthorization() == false):
        echo SELF::fallBackValue();
        exit();
      endif;
    }



}
