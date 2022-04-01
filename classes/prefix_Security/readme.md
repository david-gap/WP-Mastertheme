**Version 0.1** (01.04.2022)

Custom class "Security"

## CONFIGURATION OPTIONS
* $WPsecurity_GeoblockAdmin: activate geoblocking for backend
* $WPsecurity_GeoblockAdminAjax: activate geoblocking for backend ajax
* $WPsecurity_SafeCountries: List of all safe countries
* $WPsecurity_getGeoBy: Get IP information from
* $WPsecurity_FallbackContent: Fallback value

## CONFIGURATION FILE
```
"Security": {
  "GeoblockAdmin": 1,
  "GeoblockAdminAjax": 0,
  "SafeCountries": {
    'CH', 'DE', 'FR'
  },
  "getGeoBy": "free geo ip",
  "FallbackContent": "text"
}
```


## USAGE
