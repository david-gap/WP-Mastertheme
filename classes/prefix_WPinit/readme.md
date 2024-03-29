**Version 2.18.15** (19.10.2022)

Custom class "WPinit" basic functions

## CONFIGURATION OPTIONS
* $WPinit_support: select theme support
* $WPinit_css: activate theme styling
* $WPinit_cachebust: activate cachebust styling file
* $WPinit_css_version: theme styling version
* $WPinit_css_path: theme styling path (theme is root)
* $WPinit_js: activate theme js
* $WPinit_js_version: theme js version
* $WPinit_js_path: theme js path (theme is root)
* $WPinit_jquery: activate jquery
* $WPinit_upload_svg: enable svg upload
* $WPinit_admin_menu: disable backend menus from not admins
* $WPinit_EditorMenu: make menu visible for editors
* $WPinit_EditorWidget: make widgets visible for editors
* $WPinit_EditorCustomizer: make customizer visible for editors
* $WPinit_menus: list of all wanted WP menus
* $WPinit_typekit_id: typekit fonts
* $WPinit_google_fonts: google fonts
* $WPinit_HeaderCss: Load cutom theme css in header
* $WPinit_imgScaling: Disable default image scaling

## CONFIGURATION FILE
```
"wp": {
  "support": {
    "0": "title-tag",
    "1": "menus",
    "2": "html5"
  },
  "css" : "1",
  "cachebust" : "1",
  "css_version" : 1.0,
  "css_path" : "/dist/style.min.css",
  "js" : "1",
  "js_version" : 1.0,
  "js_path" : "/dist/script.min.js",
  "jquery" : "1",
  "admin_menu": {
    "0": "users.php"
  },
  "menus": {
    "0": {
      "key": "mainmenu"
      "value": "Main Menu"
    },
    "1": {
      "key": "footermenu"
      "value": "Footer Menu"
    }
  },
  "typekit_id" : "",
  "google_fonts": {
    "0": "Roboto"
  }
}
```

## USAGE
### Wordpress Shortcode
Call wordpress menu by slug
```
[menu slug="mainmenu"]

Enable container
[menu container="1"]

Disable nav tag
[menu nav="0"]

Add custom css
[menu css="css_class"]
```
