# CHANGELOG

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
