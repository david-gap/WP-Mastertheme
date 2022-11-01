# CHANGELOG

## 1.71.35 | 01.11.2022 <📦 NEW: gutenberg blocks stylings, logo title>
* Add missing title style selection on post title
* Add block styles to Customizer
* use same block styles for date on posts and postsfilter block
* Add header logo link title
* Form builder stylings

## 1.70.35 | 24.10.2022 <🐛 FIX: mobile font scaling, font sizes, vimeo dim>
* Set font scaling only on custom font sizing
* Override customizer font size if custom font size exists
* Fix lightbox preview size of videos
* Add lightbox customizer settings for media
* Set range-four-value global value only if on value exists
* Change extended vimeo block dimension to 16:9

## 1.70.34 | 24.10.2022 <🐛 FIX: vimeo embed responsive>
* Fix vimeo embed responsive

## 1.70.33 | 19.10.2022 <🐛 FIX: backend desktop & mobile prev, range uni>
* Fix open and close the customizer range-four-value manager
* Fix customizer range-value and range-four-value unit current value
* Fix backend styling for tablet and mobile preview

## 1.70.32 | 19.10.2022 <💎 IMPROVE: core ajax, 📦 NEW: lightbox info>
* Move core ajax functions to master theme
* Add option to load entry info inside the lightbox
* Add filter for core ajax functions
* Add lightbox entry info styles
* Fix extended vimeo align settings

## 1.69.32 | 16.10.2022 <💎 IMPROVE: posts & -filter breakpoints, 🐛 FIX>
* Add search form label styles to customizer
* Add subtitling in the configurator
* Customizer range + number x4 input extension
* Fix Hamburger close max width
* Rename the list block css name for the customizer styles (old settings are still working till next release)
* Wide width setting for 404, Blog, Archive and Searchresults page
* Backend fallback for the posts block thumbnail type
* Add breakpoint settings to posts and postsfilter block
* Remove on load ajax request for the configuration file

## 1.68.32 | 09.10.2022 <📦 NEW: customizer field type 🐛 FIX: post meta>
* Improve customizer coloring with dark mode live preview
* Add CSS file for touch divices
* Add option to allow comments on pages and posts
* Fix meta output
* Fix svg animation on menu
* Customizer range + number input extension
* Group all customizer extensions in one folder
* Set range-value and range-four-value in customizer class
* Coming soon: customizer input type range-four-value for styles like margin and padding
* Make Configuration messages always visible

## 1.67.32 | 29.09.2022 <🐛 FIX: spacing, youtube 💎 IMPROVE: search>
* Fix youtube embed iframe position
* Add mautic form row styles
* Apply search form styles to search block
* Fix no margin rule

## 1.67.31 | 29.09.2022 <🐛 FIX: title styles 📦 NEW: comment styles>
* Add comments styles to customizer
* Fix posts and postsfilter block title style
* Add posts and postsfilter block title color and border styles
* Add blog and search results title color and border styles

## 1.66.31 | 23.09.2022 <📦 NEW: menu item fields 💎 IMPROVE: customizer>
* Add option for custom scripts inside the footer tag
* Add option to insert SVG code to menu
* Add input range to customizer
* Add b and strong tag to customizer
* Add gap definition for menu level 2-4
* Add menu direction
* Add dashoffset animation
* Fix search form input styles

## 1.65.31 | 23.09.2022 <🐛 FIX: styles set by the customizer>
* Fix title margin rules
* Add JS function to convert image to base64 code
* Fix download all button action
* Label sizes
* Add input boder style to customizer

## 1.65.29 | 22.09.2022 <💎 IMPROVE & 📦 NEW: customizer>
* h1 - h6 title to customizer tag styling
* Label to customizer form styling
* Numbered list to customizer block styling

## 1.64.29 | 21.09.2022 <💎 IMPROVE: customizer 📦 NEW: gallery download>
* Add option to download full gallery
* Add Zip JS library
* Add nesting to customizer
* Rebuild customizer settings
* Additional customizer settings
* Set thumbnail as thumb video poster
* Style customizer dark
* Update react components variables

## 1.63.29 | 13.09.2022 <🐛 FIX: thumb video>
* Fix the thumb video variable calls

## 1.63.29 | 12.09.2022 <🐛 FIX: meta sort 📦 NEW: thumb video>
* Fix sort by meta value in posts block
* Force posts block & posts filter block img width on grid to 100%
* Add post video & post audio fallback
* Remove thumb video support
* Add thumb video
* Add title 4 & 5
* Fix search results replace missing posts

## 1.63.28 | 05.09.2022 <💎 IMPROVE: thumb video support, posts styling>
* Add post thumb video support
* Add posts & postsfilter styling to customizer
* Move custom colors to customizer file and remove it from JS file
* Generate customizer file on configuration save

## 1.62.28 | 05.09.2022 <💎 IMPROVE: pop-up styling 🐛 FIX: img data-id>
* Make sure image block data-id is always
* Add popup style to customizer
* Add figcaption and download button to img pop up content

## 1.61.28 | 31.08.2022 <📦 NEW: img download, Alpha 💎 IMPROVE: customizer>
* Add search form to 404 page
* Manage search form & back to home button on 404 page by the configurator
* Add customizer breadcrumb colors for dark mode
* Fix title background fallbacks
* Customizer font style
* Add alpha canal to customizer color picker
* Add social media customizer settings
* Add all php registered Gutenberg blocks to configuration
* Additional configuration styles
* Add download link to image block
* Scroll to top button to customizer
* Add header & footer padding to before & after container

## 1.60.28 | 28.07.2022 <💎 IMPROVE: blog & archive stylings>
* Add blog and archive styles to customizer
* Use blog styles as search results defaults
* Add pagination to blog and archive pages
* Add flex settings for blog, archive and search results
* Add gap styling for main menu

## 1.59.28 | 28.07.2022 <🐛 FIX: h buttons, TempM 💎 IMPROVE: consent box>
* Fix TemplateMedia block rendering
* Send configurator settings to thme JS
* Repeat posts block query until maximum achieved
* Add pins target option of parent posts block
* DSGVO image placeholder for each block
* Option to select custom DSGVO rules inside Gutenberg
* Fix customizer styles for 404 page visibility
* add consent container styles to customizer
* Add active statement for loaded pin
* Fix search results wp-block alignwide and alignfull
* Fix posts block line height
* Fix Safari Bug on absolute left und right buttons

## 1.58.28 | 19.07.2022 <🐛 FIX: customizer prev, Import 📦 NEW: bullet nav>
* Add bullet navigation as option for the swiper gallery
* Extand JS checkChildPosition function
* Fixed customizer live preview
* Fixed configurator import
* Fixed DSGVO custom consent loading
* Fix loading CPT names sum in pin item block
* Option to redirect detail page
* Extend CleanArray function, to activate stripslash
* Add option to define gap in the checkChildPosition JS function
* Extend checkChildPosition JS function to check if child is not overflowing the parent
* Change gallery margin between images to gap

## 1.57.28 | 12.07.2022 <pins block pos, post block in block loading>
* Update pins block pin position
* Fix pins block fullwidth buttons and pins position
* Fix pins block infobox hover
* Add option to load post block content inside block div

## 1.57.28 | 11.07.2022 <video js, small fixes>
* Fix metabox delete on quik edit
* Add table of content to base js file
* Video JS extension
* Video JS styling added in the customizer
* Add block option to remove spacing
* Add block option for two custom spacings
* Remove vimeo player script from block and add it on enqueue_block_assets if block is active
* Fix template parts flex
* Move theme gutenberg editor classes to master

## 1.56.28 | 29.06.2022 <blocks and new functions>
* Fix backend background color if section color is given
* Search results page pagination position
* fix get template part id
* Open accordion on load if its been called
* Open accordion on anchor link
* fix accordion icon width
* fix menu position
* fix 404 & search results page thumbnail output
* Option to disable wordpress image scaling
* Reactivate file type to uploader
* JS function to locate child element inside parent
* JS function to remove all numbers from string
* Ajax function extended with content target
* Gutenberg Block with image and pins
* Add custom background image page option
* close secondary gutenberg block panels on default
* fix widget container output
* add title and quote styles to customizer

## 1.55.28 | 06.06.2022 <GIT URI, WPadmin checkboxes, template>
* Add checkboxes input type to WPadmin
* Change WPgutenberg allowed core blocks from select to checkboxes
* Add Github URI
* Add template parts to Rest API
* Add backed post template output to post & postfilter block
* Add custom background color page option

## 1.54.28 | 04.06.2022 <thumbnail, language, small addons>
* Add thumbnail to header option
* Add align wide option to post title
* Add post template output to post & postfilter block (output not supported in backend)
* Add reset button option to postfilter block
* fix posts & postfilter block language output
* extend form values to ajax function with select options
* Add language switcher to template (polylang only)
* Add thumbnail alignment
* Add header & footer wrap option
* Add Thumbnail for search results & 404 page
* Additional customizer options
* add metabox select option
* Update post template output

## 1.53.28 | 20.05.2022 <section customizer, color and spacing>
* add section styles to customizer
* fix hidden desktop click bug
* fix custom coloring override
* fix swiper block sroll on mobile
* vimeo block spacing
* fix wp menu spacing

## 1.52.28 | 16.05.2022 <customizer, lang-switch, wide options>
* header & footer wide option
* Language switcher with polylang support
* fix menu direction
* add filter for the Logo, custom header, custom footer, header selection annd footer selection
* update customizer menu labels
* additional customizer styles
* fullwidth group & cover content wide position
* hamburger vertical support
* header background color reset if is fixed
* return archive by post format
* fix sticky logo display


## 1.51.28 | 08.05.2022 <import/export, config button position>
* update configurator button positions
* add cutomizer and configurator export and import possibility
* date check set timezone if option is given

## 1.50.28 | 30.04.2022 <customizer options, print defaults>
* fix width on print
* add lead and is style to customizer
* fix wp-menu separator break
* add 404 to customizer

## 1.49.28 | 30.04.2022 <customizer options, dsgvo support>
* new js function, to get element style
* new js function, to get all data attributes
* new js function, to load third party content after consent
* fix swiper and lightbox after WP update 5.9
* fix font size scaler
* fix hamburger
* split sidebar by post types
* add current post class to posts block
* fix input border for shortcode block in backend
* hide empty paragraph in header widgets
* remove figure line-height
* additional customizer settings
* rebuild color separation between light and dark
* fix mobile menu visibility
* add page option to hide thumbnail
* register sidebar for posts
* add beta function to run class custom action on configurator publish
* new class to support dsgvo requirements

## 1.48.28 | 01.04.2022 <customizer options, clean blocks, security>
* add class to improve page security
* fix gutenberg scadule functionality
* vimeo block privew video
* clean blocks
* fix javascript is_function function (remove jquery isFunction)
* new php function to get clients ip address
* fix get config translation function
* fix filter breadcrumbs contained query
* fix css body property check
* fix footer menu custom css query
* logo on scrolled
* show on scroll functionality
* extand customizer
* fix backend styling bugs

## 1.47.28 | 25.02.2022 <breadcrumbs, customizer options>
* Add breadcrumbs
* Menu stretch option
* new customizer styling options

## 1.46.28 | 21.02.2022 <customizer options, var fallback>
* add direction attribute to menu shortcode
* new customizer styling options
* Override language call in base function for configuration translation
* Add String to hamburger menu
* Add fallback value to sizing variables
* menu shortcode direction
* footer menu direction support

## 1.45.28 | 04.02.2022 <config translation>
* add translation support to configuration area
* make addressblock settings to translation
* fix google analytics plugin query
* add gutenberg seperator default color to customizer

## 1.44.28 | 04.02.2022 <dsgvo support>
* add cookie query to analytics code

## 1.43.28 | 04.02.2022 <configudator restructure>
* new js to return parameter by key
* fix menu contained position
* add button to submit styles
* move accordion styles to the configurator
* restructure the configurator
* mautic class with cookie query
* new option to add text to the hamburger
* add autocomplete to search form

## 1.42.28 | 18.01.2022 <posts and postsfilter filters, event listeners>
* move all content js event listeners into a function, so it can be reruned after ajax updates
* add filter options for posts and postsfilter block on query, results and taxonomy sorting
* configurator builder, ignore classes without any fields

## 1.41.28 | 14.01.2022 <posts and posts filter block sorting>
* remove string sensitivity from multidimensinal sorting
* rename posts and posts filter block functions
* add taxonomy support (frontend only) to posts and posts filter block sorting

## 1.40.28 | 06.01.2022 <add translation, configurator style>
* add translation file for de_CH
* optimize customizer mobile values
* Configurator styles

## 1.39.28 | 05.01.2022 <customizer, sidebar and localization>
* reduce string text domain into one
* register sidebar for header, sidebar and footer
* add customizer class (live preview is on process)

## 1.38.28 | 28.12.2021 <block scadule and disabling, core config>
* move configuration php file to mastertheme
* optimize current time by wordpress timezone in dateCheck function
* rename gallery item block in swiper item
* option to scadule gutenberg blocks
* option to disable gutenberg block from returning

## 1.37.28 | 27.12.2021 <ie fix, header, blocks>
* fix posts parts return
* ie11 fix for css properties
* change header sticky from fixed to sticky with ie fix
* add chapter navigation to vimeo block
* add link options to vimeo block for background video linking
* css block arrow-toggle and variable usage on theme-blocks.scss
* new hamburger navigation positions
* option to keep header visible, while hamburger menu is active
* add variable template_header_hmenu_scroll for future features
* fix posts and postfilter taxonomy selection

## 1.36.28 | 29.10.2021 <taxonomy strings, block extension>
* fix taxonomy base function string name
* Rename popup to lightbox
* fix posts block first row h4
* add mute to vimeo block
* remove swisstopo demo from page.php

## 1.35.28 | 29.10.2021 <php open, blocks fixes>
* replace all php short open tag with long
* fix postsfilter block prefilter
* fix posts block max sum
* fix gallery custom class name return
* fix accordion custom class name return

## 1.35.27 | 10.10.2021 <postfilter block preselection>
* extend taxonomy group function for custom preselection
* rename init labels for backend
* add default rest prepare for pages
* add preselection to postfilter block
* modify sort label translation inside post block

## 1.34.27 | 10.10.2021 <posts & postsfilter sorting>
* add sort options to posts block
* add sort by meta value to posts and postsfilter block
* set "to top" button default to 0

## 1.33.27 | 05.10.2021 <alignwide, posts block flexfix>
* align wide width
* disable flex fix from posts block

## 1.33.26 | 02.10.2021 <searchbox, post block attachments>
* add search form options
* add attachments to posts block
* fix post filter hirarchical
* fix popup error caused by flex-fix elements
* change string call

## 1.32.26 | 23.09.2021 <translate strings>
* change string call

## 1.32.25 | 23.09.2021 <scroll to top, backend enqueue>
* Add line-height support to gutenberg as default
* js check for toggle able submenues if menu exists
* Add scroll to top element
* Add backend theme files

## 1.31.25 | 09.08.2021 <addressblock img, popup close, cr>
* Add image to the adressblock
* fix popup close button position
* add copyright value fallback and shortcode

## 1.31.24 | 09.08.2021 <hamburger, popup and core image block>
* add hamburger color to customizer
* update core image block inspector title
* fix popup responsive close button position

## 1.31.23 | 09.08.2021 <gutenberg core blocks hook>
* block hook to all blocks to hide on desktop/mobile
* image block hook to activate popup
* gallery block hook to activate swiper, popup and popup preview
* js function to load popup on image block
* fix mobile css class for backend

## 1.30.23 | 09.08.2021 <outside hamburger toggle>
* close hamburger menu by click outside the menu

## 1.30.22 | 09.08.2021 <toggle submenu>
* add submenu toggle inside hamburger menu

## 1.29.22 | 09.08.2021 <main menu fullscreen position>
* remove margin top from hamburger menu fullscreen style

## 1.29.21 | 09.08.2021 <main menu style options>
* backend selection for horizontal / vertical menu
* hamburger menu position (left, right, side contained, fullscreen)
* add checkbox field to meta blocks

## 1.28.21 | 26.07.2021 <post block tax selection, gallery block>
* change post block taxonomy selection
* add gallery block

## 1.27.21 | 19.07.2021 <post & post filter block id>
* add id information into post and post filter block
* swiper li styles

## 1.26.21 | 19.07.2021 <small layout fixes>
* wrong container variable name
* gutenberg resizer line height by variable
* post filter swiper ul style only for first ul

## 1.26.20 | 14.07.2021 <deploy issues part two>
* moving default color, form and font styles to mastertheme
* clean css from unnecessary variables
* load base and customizer css file

## 1.25.20 | 14.07.2021 <deploy issues>
* split theme JS from custom JS
* always load theme scripts
* split responsive styles from base files

## 1.24.20 | 06.07.2021 <fix gutenberg posts img loading, container>
* container sizing on first group inner
* load gutenberg posts source_url in case Thumb is missing

## 1.24.19 | 29.06.2021 <fix gutenberg posts filter block>
* disable hidden fields if categorie is empty
* add accordion to structure styles

## 1.24.18 | 27.06.2021 <fix gutenberg editor configuration loading>
* remove wp-icon from custom blocks

## 1.24.17 | 26.06.2021 <accordion block>
* add accordion and accordion item blocks
* update accordion/toggle css/js
* add is-type-video to responsive video styles

## 1.23.17 | 25.06.2021 <posts block fixes>
* backend scroll inside swiper
* swiper spacing

## 1.23.16 | 24.06.2021 <meta fields, meta post blocks support>
* move loading animation into frontend Body
* add base function for meta blocks
* post block results alternative selection by posts
* fix post blocks backend swiper result with columns
* post and filter post blocks supports meta values as image or alternative link

## 1.22.16 | 22.06.2021 <js data values, box sizing fix>
* JS function to get element data attributes as array
* css fix box sizing
* add custom blocks sort by menu

## 1.22.15 | 20.06.2021 <fix posts filter block text search>
* WPgutenberg class version 2.6.7

## 1.22.14 | 20.06.2021 <posts filter block, default css, fieldset>
* add loading animation
* add grid fixer for posts block
* add post filter block
* BaseFunctions class version 2.10.3

## 1.21.14 | 19.06.2021 <class and block fixes, overlay container, toogle>
* add overlay container
* add general styles to backend
* toggle arrow to icon
* fix posts block taxonomies
* add link options and menu order to posts block

## 1.20.14 | 11.06.2021 <default css to master, class fixes>
* add after footer code area
* move default theme styles to master theme
* BaseFunctions class version 2.9.3
* template class version 2.14.14
* WPinit class version 2.8.7
* WPadmin class version 1.3.2

## 1.19.14 | 03.06.2021 <post block, mail attachment, contact name>
* WPgutenberg class version 2.5.5
* template class version 2.14.13
* mail class class version 1.1.2

## 1.18.14 | 29.04.2021 <gutenberg class block selection fix>
* WPgutenberg class version 2.4.5

## 1.18.13 | 06.04.2021 <mautic class shortcode fix>
* Mautic class version 0.2.2

## 1.18.12 | 06.04.2021 <gutenberg class fix>
* WPgutenberg class version 2.4.4

## 1.18.11 | 31.03.2021 <gutenberg class fix>
* WPgutenberg class version 2.4.3

## 1.18.10 | 24.03.2021 <gutenberg class clean up>
* WPgutenberg class version 2.4.2

## 1.18.9 | 23.03.2021 <gutenberg custom blocks, class fixes>
* template class version 2.13.13
* WPgutenberg class version 2.4.1

## 1.17.9 | 17.03.2021 <base class date function fix>
* base class version 2.8.3

## 1.17.8 | 08.03.2021 <template class sticky fix, mautic sc>
* template class version 2.13.12
* mautic class version 0.2.1

## 1.16.8 | 16.02.2021 <post format, seo class fix>
* template class version 2.13.11
* seo class version 2.2.6

## 1.15.8 | 12.01.2021 <template class fix>
* template class version 2.12.11

## 1.15.7 | 12.01.2021 <template class fix>
* template class version 2.12.10

## 1.15.6 | 12.01.2021 <template class fix>
* template class version 2.12.9

## 1.15.5 | 03.10.2020 <post meta block, class update>
* template class version 2.12.8
* meta block output und pages and posts

## 1.14.5 | 03.10.2020 <post before/after code, class update>
* header custom content block before main tag
* footer custom content block after main tag
* backend styling for template fields
* template class version 2.11.8

## 1.13.5 | 03.10.2020 <WPinit class update>
* WPinit class version 2.8.6

## 1.13.4 | 02.10.2020 <page title class, mautic class update>
* Add css class to post title
* Mautic class version 0.1.1

## 1.13.3 | 02.10.2020 <fix gutenberg action>
* remove future action from gutenberg class

## 1.13.2 | 02.10.2020 <class update, pingback>
* template class version 2.10.8
* WPgutenberg class version 2.4.1
* add pingback url to header

## 1.12.2 | 22.09.2020 <mautic support>
* Mautic class version 0.1

## 1.11.2 | 22.09.2020 <tempalte class update>
* template class version 2.9.8

## 1.11.1 | 17.09.2020 <tempalte class update>
* template class version 2.9.7

## 1.10.1 | 17.09.2020 <tempalte class bug fix>
* template class version 2.8.7

## 1.10 | 17.09.2020 <object query fix, classes update>
* fix object query for page/post ID
* BaseFunctions class version 2.8.2
* template class version 2.8.6
* WPseo class version 2.2.5

## 1.9 | 07.09.2020 <blog template, classes update>
* fix sidebar position
* Blog/Search template by post type
* WPadmin add placeholder option
* BaseFunctions class version 2.8.1
* template class version 2.8.5
* WPinit class version 2.8.5

## 1.8 | 02.09.2020 <header & footer, classes update>
* header & footer container improved with before and after container
* WPseo class version 2.2.4
* WPinit class version 2.7.5
* WPgutenberg class version 2.3.1
* template class version 2.7.5
* WPinit class version 1.2.1

## 1.7 | 13.08.2020 <page options, classes update>
* Backend page/post options darkmode and hide title
* BaseFunctions class version 2.8
* template class version 2.6.5

## 1.6 | 13.08.2020 <container, classes update>
* set header, main und footer container apart
* Ajax option to download generated file
* Add color picker to backend configurator
* Ajax action to generate css file from all classes custom css
* BaseFunctions class version 2.7
* WPinit class version 2.7.4
* template class version 2.5.5
* WPgutenberg class version 2.2.1

## 1.5 | 11.08.2020 <assets, classes update>
* Add assets folder with the current jquery version 3.5.1
* WPinit class version 2.6.4
* WPseo class version 2.2.3
* template class version 2.5.4

## 1.4 | 10.08.2020 <clean admin, classes update>
* Remove duplicate class from WPadmin folder
* WPinit class version 2.5.4
* template class version 2.4.4
* imgDC class version 2.1.2

## 1.3 | 07.08.2020 <cleaning, classes update>
* post/blog comments
* clean files from not needed code
* PageOptions fallback
* Add template element after header and before footer
* Search results pagination
* Body css from BodyCSS function & filterable
* WPadmin fallback for classes with no backend input
* WPadmin ajax success output improvement & delete not needed function
* WPadmin clean ajax file
* WPinit class version 2.5.3
* template class version 2.4.3

## 1.2 | 28.07.2020 <html broser name, classes update>
* add browser name as css class to html
* imgDC class version 2.1.1
* template class version 2.3.3
* WPseo class version 2.1.3

## 1.1 | 28.07.2020 <template header, classes update>
* add frontend css class to body
* WPinit class version 2.5.2
* template class version 2.3.2

## 1.0 | 03.07.2020 <root files>
* all wordpress root files for theme directory
* classes folder
