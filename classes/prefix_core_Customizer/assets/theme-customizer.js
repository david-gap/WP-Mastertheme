// ( function( api ) {
//     'use strict';
// console.log("inside");
//     api.bind( 'ready', function() {
// console.log("ready bin");
//         api( 'theme_sizes', function(setting) {
//           console.log("theming here");
//           console.log(settings);
//             // var linkSettingValueToControlActiveState;
//             //
//             // /**
//             //  * Update a control's active state according to the boxed_body setting's value.
//             //  *
//             //  * @param {api.Control} control Boxed body control.
//             //  */
//             // linkSettingValueToControlActiveState = function( control ) {
//             //     var visibility = function() {
//             //         if ( true === setting.get() || 1 === setting.get() ) {
//             //             control.container.slideDown( 180 );
//             //         } else {
//             //             control.container.slideUp( 180 );
//             //         }
//             //     };
//             //
//             //     // Set initial active state.
//             //     visibility();
//             //     //Update activate state whenever the setting is changed.
//             //     setting.bind( visibility );
//             // };
//             //
//             // // Call linkSettingValueToControlActiveState on the border controls when they exist.
//             // api.control( 'boxed_body_border_width', linkSettingValueToControlActiveState );
//             // api.control( 'boxed_body_border_color', linkSettingValueToControlActiveState );
//             // api.control( 'boxed_body_border_style', linkSettingValueToControlActiveState );
//         });
//
//     });
//
// }( wp.customize ) );



( function( $ ) {
  console.log("new");
    /* Link Color */
    wp.customize( 'wide__left', function( value ) {
      console.log("inside");
        value.bind( function( to ) {
            $( 'body' ).css( 'padding-left', to );
            console.log("binded");
        } );
    } );

    /* Site Title Color */
    wp.customize( 'wide__right', function( value ) {
        value.bind( function( to ) {
            $( 'body' ).css( 'padding-right', to );
        } );
    } );

    wp.customize( 'container__width', function( value ) {
    value.bind( function( to ) {
    var footer = $( 'header' );

     footer.attr( 'data-baba', to );

    } );
} );

} )( jQuery );




( function( $ ) {

    /* Link Color */
    wp.customize( 'wide__left', function( value ) {
      console.log("lefti no?");
        value.bind( function( to ) {
            var color_link_css = 'body{padding-left:' +  to + '}';
            $( '#my-link-color-css' ).html( color_link_css );
        } );
    } );

    /* Site Title Color */
    wp.customize( 'wide__right', function( value ) {
        value.bind( function( to ) {
            var site_title_css = 'body{padding-right:' +  to + '}';
            $( '#my-site-title-color-css' ).html( site_title_css );
        } );
    } );

} )( jQuery );










// "use strict";
//
// const optionsList = [
//   'container__width',
//   'container__side',
//   'content__space',
//   'input__padding',
//   'wide__left',
//   'wide__right',
//   'html__anchor',
//   'html__anchor_mobile',
//   'html__fontfamily',
//   'html__fontsize',
//   'html__lineheight',
//   'html__mobile_fontsize',
//   'html__mobile_lineheight',
//   'gutenberg__font_scale',
//   'mnav__fontsize',
//   'mnav__lineheight',
//   'mnav__mobile_fontsize',
//   'mnav__mobile_lineheight',
//   'footer__fontsize',
//   'footer__lineheight',
//   'color__main',
//   'color__secondary',
//   'light__hamburger_color',
//   'light__main_background',
//   'light__main_color',
//   'light__header_background',
//   'light__headercontainer_background',
//   'light__mnav_background',
//   'light__footer_background',
//   'light__footercontainer_background',
//   'dark__hamburger_color',
//   'dark__main_background',
//   'dark__main_color',
//   'dark__header_background',
//   'dark__headercontainer_background',
//   'dark__mnav_background',
//   'dark__footer_background',
//   'dark__footercontainer_background',
//   'popup__width',
//   'popup__space',
//   'popup_prev_visible'
// ];


// var yourval = wp.customize.value( 'container__width' )();
//
// console.log(yourval);

// console.log(wp.customize._value.container__width);
//
// console.log("davor");
// if(typeof wp.customize._value.container__width === 'function'){
//     console.log("sowas aber auch");
// }
// console.log("danac");


// (function( $ ) {
//   console.log(wp.customize('container__width').get());
// })( jQuery );
// console.log(wp.customize.value('container__width')());


// Array.from(optionsList).forEach(function(option) {
//   wp.customize( option, function( value ) {
//     console.log(value);
//     value.bind( function( to ) {
//       console.log(option + ': ' + to);
//       document.querySelector('body').css( 'backgroundColor', to );
//       document.documentElement.style.setProperty(option, to);
//     } );
//   });
// });





// (function( $ ) {
//
//     console.log(optionsList);
//
//     Array.from(optionsList).forEach(function(option) {
//       wp.customize( option, function( value ) {
//         value.bind( function( to ) {
//           console.log(option + ': ' + to);
//           // $( '.site-header' ).css( 'backgroundColor', to );
//           document.documentElement.style.setProperty(option, to);
//         } );
//       });
//     });
//
//
// })( jQuery );
