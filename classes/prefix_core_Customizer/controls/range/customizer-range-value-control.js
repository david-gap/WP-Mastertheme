/**
 * Script run inside a Customizer control sidebar
*/

(function($) {
  wp.customize.bind('ready', function() {
    rangeValueInput();
  });

  var rangeValueInput = function() {
    var slider = $('.range-slider'),
        value = $('.range-slider__value'),
        range = $('.range-slider__range'),
        text = $('.range-slider__text'),
        unit = $('.range-slider__unit');

    slider.each(function() {

        range.on('input', function() {
          var key = $(this).siblings('.range-slider__value').attr('data-customize-setting-link');
          var value = this.value + $(this).siblings('.range-slider__unit').val();
          $(this).siblings('.range-slider__text').val(this.value);
          $(this).siblings('.range-slider__value').val(value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
        text.on('input', function() {
          var key = $(this).siblings('.range-slider__value').attr('data-customize-setting-link');
          if(this.value !== ''){
            var value = this.value + $(this).siblings('.range-slider__unit').val();
          } else {
            var value = '';
          }
          $(this).siblings('.range-slider__range').val(this.value);
          $(this).siblings('.range-slider__value').val(value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
        unit.on('input', function() {
          var key = $(this).siblings('.range-slider__value').attr('data-customize-setting-link');
          if($(this).siblings('.range-slider__text').val() !== ''){
            var value = $(this).siblings('.range-slider__text').val() + this.value;
          } else {
            var value = '';
          }
          $(this).siblings('.range-slider__value').val(value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
    });
  };

})(jQuery);
