/**
 * Script run inside a Customizer control sidebar
*/

(function($) {
  wp.customize.bind('ready', function() {
    rangeValueInput();
  });

  var rangeValueInput = function() {
    var slider = $('.range-four-slider-container'),
        activeEdit = $('.start-editing'),
        inactiveEdit = $('.stop-editing'),
        value = $('.range-four-slider__value.main'),
        range = $('.range-four-slider__range.main'),
        text = $('.range-four-slider__text.main'),
        unit = $('.range-four-slider__unit.main'),
        rangeSplit = $('.range-four-slider__range.row-one, .range-four-slider__range.row-two, .range-four-slider__range.row-three, .range-four-slider__range.row-four'),
        textSplit = $('.range-four-slider__text.row-one, .range-four-slider__text.row-two, .range-four-slider__text.row-three, .range-four-slider__text.row-four'),
        unitSplit = $('.range-four-slider__unit.row-one, .range-four-slider__unit.row-two, .range-four-slider__unit.row-three, .range-four-slider__unit.row-four');

    slider.each(function() {
        activeEdit.on('click', function() {
          $(this).closest('.range-four-slider-container').addClass("active");
        });
        inactiveEdit.on('click', function() {
          $(this).closest('.range-four-slider-container').removeClass("active");
        });
        // main input
        range.on('input', function() {
          var key = $(this).siblings('.range-four-slider__value').attr('data-customize-setting-link');
          var value = this.value + $(this).siblings('.range-four-slider__unit').val();
          $(this).siblings('.range-four-slider__text').val(this.value);
          $(this).siblings('.range-four-slider__value').val(value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-one').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-two').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-three').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-four').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__range.row-one').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__range.row-two').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__range.row-three').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__range.row-four').first().val(this.value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
        text.on('input', function() {
          var key = $(this).siblings('.range-four-slider__value').attr('data-customize-setting-link');
          if(this.value !== ''){
            var value = this.value + $(this).siblings('.range-four-slider__unit').val();
          } else {
            var value = '';
          }
          $(this).siblings('.range-four-slider__range').val(this.value);
          $(this).siblings('.range-four-slider__value').val(value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-one').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-two').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-three').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-four').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__range.row-one').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__range.row-two').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__range.row-three').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__range.row-four').first().val(this.value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
        unit.on('input', function() {
          var key = $(this).siblings('.range-four-slider__value').attr('data-customize-setting-link');
          if($(this).siblings('.range-four-slider__text').val() !== ''){
            var value = $(this).siblings('.range-four-slider__text').val() + this.value;
          } else {
            var value = '';
          }
          $(this).siblings('.range-four-slider__value').val(value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-one').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-two').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-three').first().val(this.value);
          $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-four').first().val(this.value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
        // single input
        rangeSplit.on('input', function() {
          var key = $(this).closest('.range-four-slider-container').find('.range-four-slider__value').attr('data-customize-setting-link');
          $(this).siblings('.range-four-slider__text').val(this.value);
          // build new val
          var valOne = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-one').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-one').first().val();
          var valTwo = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-two').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-two').first().val();
          var valThree = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-three').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-three').first().val();
          var valFour = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-four').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-four').first().val();
          var value = valOne + " " + valTwo + " " + valThree + " " + valFour;
          // insert value
          $(this).closest('.range-four-slider-container').find('.range-four-slider__value').val(value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
        textSplit.on('input', function() {
          var key = $(this).closest('.range-four-slider-container').find('.range-four-slider__value').attr('data-customize-setting-link');
          $(this).siblings('.range-four-slider__range').val(this.value);
          // build new val
          var valOne = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-one').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-one').first().val();
          var valTwo = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-two').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-two').first().val();
          var valThree = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-three').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-three').first().val();
          var valFour = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-four').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-four').first().val();
          var value = valOne + " " + valTwo + " " + valThree + " " + valFour;
          // insert value
          $(this).closest('.range-four-slider-container').find('.range-four-slider__value').val(value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
        unitSplit.on('input', function() {
          var key = $(this).closest('.range-four-slider-container').find('.range-four-slider__value').attr('data-customize-setting-link');
          // build new val
          var valOne = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-one').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-one').first().val();
          var valTwo = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-two').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-two').first().val();
          var valThree = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-three').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-three').first().val();
          var valFour = $(this).closest('.range-four-slider-container').find('.range-four-slider__text.row-four').first().val() + $(this).closest('.range-four-slider-container').find('.range-four-slider__unit.row-four').first().val();
          var value = valOne + " " + valTwo + " " + valThree + " " + valFour;
          // insert value
          $(this).closest('.range-four-slider-container').find('.range-four-slider__value').val(value);
          wp.customize( key, function( obj ) {
            obj.set( value );
          });
        });
    });
  };

})(jQuery);
