**Version 2.39.20** (01.12.2022)

Custom class "template" with template parts and header / footer builder

## CONFIGURATION OPTIONS
* $template_container_header: activate container for the header
* $template_container_breadcrumbs: activate container for the breadcrumbs
* $template_container: activate container for the content
* $template_container_totop: activate container for the scroll to top button
* $template_container_footer: activate container for the footer
* $template_container_header_wide: Set header container to wide width
* $template_container_blog_wide: Set blog container to wide width
* $template_container_archive_wide: Set archive container to wide width
* $template_container_searchresults_wide: Set search results container to wide width
* $template_container_errorpage_wide: Set 404 container to wide width
* $template_container_footer_wide: Set footer container to wide width
* $template_coloring: template coloring (dark/light)
* $template_ph_active: activate placeholder
* $template_ph_address: placeholder show address block
* $template_ph_custom: placeholder custom content
* $template_address: address block content
* $template_socialmedia: social media
* $template_header_wrap: Allow the header content to wrap
* $template_header_divider: Activate header divider
* $template_header_sticky: activate sticky header
* $template_header_stickyload: activate sticky header on load
* $template_header_dmenu: Activate header hamburger for desktop
* $template_header_menusearchform: Activate searchform inside the main menu
* $template_header_menu_style: Select menu direction (options: horizontal/vertical)
* $template_header_hmenu_style: Select hamburger menu style (options: fullscreen, top, top_contained, left, left_contained, right, right_contained)
* $template_header_hmenu_text: Show text on hamburger menu button
* $template_header_hmenu_streched: Strech main menu verticaly
* $template_header_hmenu_visible_head: Define if header is visible on active hamburger menu
* $template_header_hmenu_scroll: Define if hamburger menu close by scrolling (Desktop only)
* $template_header_hmenu_toggle: Hamburger Menü toggle able submenus
* $template_header_custom:  Custom header html
* $template_header_sort: Sort and activate blocks inside header builder
* $template_header_logo_link: Logo link with wordpress fallback
* $template_header_logo_title: Logo link title
* $template_header_logo_d: desktop logo configuration
* $template_header_logo_m: mobile logo configuration
* $template_header_logo_scrolled: scrolled logo configuration
* $template_header_logo_svg: Insert SVG code as logo
* $template_header_after: html code after header
* $template_page_active: activate page options
* $template_page_additional: additional custom fields template elements
* $template_page_options: show/hide template elements
* $template_thumbvideo: Activate video as thumbnail
* $template_page_bgColor: Activate custom background color
* $template_page_bgImg: Activate custom background image
* $template_scrolltotop_active: activate scroll to top
* $template_footer_active: activate footer
* $template_footer_wrap: Allow the footer content to wrap
* $template_footer_cr: copyright text
* $template_footer_custom: custom html
* $template_footer_menu: footer menu settings
* $template_footer_sort: Sort and activate blocks inside footer builder
* $template_footer_before: html code before footer
* $template_footer_end: html code before footer end
* $template_searchform_autocomplete: configure the autocomplete in the search form
* $template_breadcrumbs_active: activate breadcrumbs
* $template_breadcrumbs_inside: Place breadcrumbs inside page content and if first element is image than after image
* $template_breadcrumbs_intro: Show introduction text
* $template_breadcrumbs_home: Show home link
* $template_breadcrumbs_separator: Separate crumbs by string
* $template_languageSwitcher_separat: Separat languages
* $template_languageSwitcher_direction: Select direction
* $template_languageSwitcher_nameDisplay: Select what should be displayed in the language switcher
* $template_menu_svgIcon: Add menu custom meta field for a svg icon
* $template_menu_svgIcon_position: Set menu item svg position
* $template_menu_description: Add menu custom meta field for a description
* $template_menu_description_position: Set menu item description position
* $template_thumbnail_div: return thumbnail in a div to repeat it
* $template_thumbnail_align: align all thumbnails
* $template_404_align: align 404 page thumbnail
* $template_search_align: align search results page thumbnail
* $template_404_searchForm: Display search form on 404 page
* $template_404_backToHome: Display back to home page button on 404 page
* $template_comments_activeBlog: Activate comments on blog
* $template_comments_activePages: Activate comments on pages
* $template_meta_metablock: activate metablock on detail page/posts
* $template_meta_metablockAdds: Add metabox to CPT by slugs

## CONFIGURATION FILE
```
"template": {
  "container_header": 1,
  "container": 1,
  "container_footer": 1,
  "coloring": "light",
  "placeholder": {
    "active": true,
    "address": true,
    "notification": "",
    "custom": ""
  },
  "address": {
    'logo': {
      "img": "Logo ID from the media library",
      "width": "Image width",
      "height": "Image height",
      "alt": "Alternative text for the Image"
    },
    'company': 'Company name',
    'name': 'Name of a person',
    'street': 'Adress line 1',
    'street2': 'Adress line 2',
    'postalCode': 'Zip code',
    'city': 'Location/City',
    'country': 'Country',
    'phone': 'Phone number',
    'fax': 'Fax number',
    'mobile': 'Mobile phone number',
    'email': 'Email adress',
    'labels': {
      'company': 'Label for company name',
      'name': 'Label for name of a person',
      'street': 'Label for the adress line 1',
      'street2': 'Label for the adress line 2',
      'postalCode': 'Label for the zip code',
      'city': 'Label for the location/city',
      'country': 'Label for the country',
      'phone': 'Label for the phone number',
      'fax': 'Label for the fax number',
      'mobile': 'Label for the mobile phone number',
      'email': 'Label for the email address'
    }
  },
  "contactblock": {
    "phone": "",
    "mail": "",
    "whatsapp": ""
  },
  "socialmedia": {
    "facebook": "",
    "instagram": ""
  },
  "header": {
    "sort": {
      "logo": 1,
      "container_start": 1,
      "menu": 1,
      "socialmedia": 1,
      "custom": 0,
      "container_end": 1,
      "hamburger": 1
    },
    "logo_link": "",
    "logo_desktop": {
      "img": "",
      "width": "",
      "height": ""
    },
    "logo_mobile": {
      "img": "",
      "width": "",
      "height": ""
    },
    "divider": 1,
    "sticky": 1,
    "sticky_onload": 0;
    "desktop_menu": 0,
    "menu_style": 'horizontal',
    "hmenu_style": 'fullscreen',
    "hmenu_toggle": 1,
    "custom": "",
    "after_header": ""
  },
  "page": {
    "active": 1,
    "metablock": {
      "page": 1,
      "post": 1
    }
    "options": {
      "header": 1,
      "time": 1,
      "author": 1,
      "title": 1,
      "title": 1,
      "sidebar": 1,
      "footer": 1,
      "darkmode": 1,
      "beforeMain"; 1,
      "afterMain"; 1
    },
    "additional":  {
      "0": {
        "key": "Custom var"
        "value": "Custom name"
      }
    }
  },
  "blog": {
    "type": 1
  },
  "footer": {
    "active": 1,
    "copyright": "Copyright © Text",
    "custom": "<div>custom</div>",
    "sort": {
      "container_start": 1,
      "menu": 1,
      "socialmedia": 1,
      "copyright": 1,
      "address": 1,
      "custom": 0,
      "container_end": 1
    },
    "before_footer": ""
  }
}
```


## USAGE

### HEADER BUILDER
Inside header tag
```php
echo prefix_template::HeaderContent();
```

### FOOTER BUILDER
Inside footer tag
```php
echo prefix_template::FooterContent();
```

### STICKY
Add to the body tag
```php
echo prefix_template::CheckSticky(prefix_template::$template_header_sticky, prefix_template::$template_header_stickyload);
```

### CONTAINER
First variable to set container true or false
Set the second variable to 1 if you would like to use the wide width container
Set last variable to true if you would like to add class attribute to the output
```php
echo prefix_template::AddContainer(prefix_template::$template_container, 1, true);
```

### PAGE OPTIONS
Enter page id to get backend settings
```php
echo prefix_template::PageOptions($page_id);
```

### SITE PLACEHOLDER
If the Website is under construction return the placeholder
```php
echo prefix_template::SitePlaceholder();
```

### LOGO CONTAINER
Logo container, with alternative mobile logo
```php
$deskop_logo = array(
  "img" => "your/img/logo.jpg",
  "width" => "100",
  "height" => "40"
);
$mobile_logo = array(
  "img" => "your/img/logo.jpg",
  "width" => "50",
  "height" => "20"
);
echo prefix_template::Logo("https://website-link.com", $deskop_logo, $mobile_logo);
```

### WP MAINMANU WITH HAMBURGER
Get the WP Menu mainmenu with the hamburger button
```php
echo prefix_template::WP_MainMenu();
```

### ADDRESSBLOCK
Addressblock with/without labels, call links with desktop disabler
```php
$address = array(
  'company' => 'Company name',
  'street' => 'Address',
  'street2' => 'Additional address line',
  'postalCode' => '00000',
  'city' => 'City name',
  'phone' => 'Phone number',
  'mobile' => 'Mobile number',
  'email' => 'your@mail.com',
  'labels' => array(
    'company' => '',
    'street' => '',
    'street2' => '',
    'postalCode' => '',
    'city' => '',
    'phone' => 'Phone label',
    'mobile' => 'Mobile label',
    'email' => 'E-Mail label'
  )
);
echo prefix_template::AddressBlock($address);
```

### DIVIDER
Return a hr element
```php
echo prefix_template::Divider();
```

### FOOTER MENU
Get WP Menu footermenu
```php
echo prefix_template::WP_FooterMenu();
```

### COPYRIGHT
Span element for the copyright information
```php
echo prefix_template::Copyright("my copyright text");
```

### SOCIAL MEDIA BLOCK
Social media inline icons block (supports: facebook, instagram)
```php
$sm = array(
  "facebook" => "https://facebook.com/your-slug",
  "instagram" => "https://instagram.com/your-slug"
);
echo prefix_template::SocialMedia($sm);
```

### CONTACT BLOCK
Gives contact options as inline icon links (supports: phone, mail, whatsapp)
```php
$contacts = array(
  "phone" => "000000000",
  "mail" => "your@mail.com",
  "whatsapp" => "000000000"
);
echo prefix_template::ContactBlock($contacts);
```

### ICON BLOCK
A list of given inline icons
```php
$icons = array(
  // for each svg
  array(
    "svg" => 'SVG-CONTENT',
    "link" => "https://your-link.com",
    "target" => "blank",
    "class" => "custom-css-class",
    "attr" => array(
      "data-example" => "attribute content",
      "data-example-two" => "attribute content"
    )
  )
);
$settings = array(
  "class" => "custom-css-class",
  "attr" => array(
    "data-example" => "attribute content",
    "data-example-two" => "attribute content"
  )
);
echo prefix_template::IconBlock($icons, $settings);
```

## FILTERS
To Add custom options by Template (ACF for example)
template_PageOptions

Add header content filter
template_HeaderContent

Add logo filter
template_Logo

Add custom header filter
template_header_custom

Add footer content filter
template_FooterContent

Add custom footer filter
template_footer_custom

Add Custom CSS by template
template_BodyCSS

Add custom attributes to body tag
template_BodyAttr
