jQuery(document).ready(function($){

    /* Global Settings
    /––––––––––––––––––––––––*/
    // custom vars that need to be global



    /*==================================================================================
      FUNCTIONS
    ==================================================================================*/

    /* unserialize array
    /––––––––––––––––––––––––*/
    function unserialize(serializedString){
      var str = decodeURI(serializedString);
      var pairs = str.split('&');
      var obj = {}, p, idx, val;
      for (var i=0, n=pairs.length; i < n; i++) {
        p = pairs[i].split('=');
        idx = p[0];
        if (idx.indexOf("[]") == (idx.length - 2)) {
          // Eh um vetor
          var ind = idx.substring(0, idx.length-2)
          if (obj[ind] === undefined) {
            obj[ind] = [];
          }
          obj[ind].push(p[1]);
        }
        else {
          obj[idx] = p[1];
        }
      }
      return obj;
    };


    /* AJAX
    /––––––––––––––––––––––––*/
    function ajaxCall(getdata) {
      $.ajax({
        url: Ajax_File,
        type: 'POST',
        data: getdata,
        dataType: "json",
        success: function(data) {
          // DEBUG: console.log("Ajax update success");
          // DEBUG: console.log(data);
          $('#configuration').removeClass('loading');
          // console
          if(data.log){
            console.log(data.log);
          }
          // message
          if(data.message){
            $('#configuration #config-message').html(data.message);
          }
          // css
          if(data.type){
            $('#configuration #config-message').attr('class', data.type);
          }
          // css
          if(data.file && data.name){
            var $a = $("<a>");
            $a.attr("href",data.file);
            $("#configuration #config-message").append($a);
            $a.attr("download",data.name);
            $a[0].click();
            $a.remove();
          }
        },
        error:function(){
          // DEBUG: console.log("Ajax update failed");
        }
      });
    }

    /* page options
    /––––––––––––––––––––––––*/
    function updatePageUptions() {
      // get selected page options
      var page_options = $('#WPtemplate').find('input:checked').map(function(_, el) {return $(el).val();}).get();
      // dark mode
      if($.inArray('darkmode', page_options) > -1){
        $('.editor-styles-wrapper').addClass('dark');
      } else {
        $('.editor-styles-wrapper').removeClass('dark');
      }
      // title - smaller
      if($.inArray('title', page_options) > -1){
        $('.editor-post-title__input').addClass('small');
      } else {
        $('.editor-post-title__input').removeClass('small');
      }
    }
    setTimeout(function(){
      updatePageUptions();
    },2000);



    /*==================================================================================
      CALL ACTIONS
    ==================================================================================*/

    /* recheck dark mode
    /––––––––––––––––––––––––*/
    $(document).on('click', '#WPtemplate input', function (event) {
      updatePageUptions();
    });

    /* save form
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration input[type="submit"]', function (event) {
      // get content
      var get_action = $(this).data('action');
      var get_formData = $('#configuration form').serialize();
      // build data array
      var data = {
        action: get_action,
        formdata: get_formData
      };
      $('#configuration').addClass('loading');
      event.preventDefault();
      ajaxCall(data);
    });


    /* select media
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration .wp-single-media', function (e) {
      // get action
      var action = $(this).attr('data-action');
      var input_id = $(this).siblings('.img-saved').attr('id');
      var container = $(this).parents('div').data('id');
      var meta_gallery_frame;
      // check if right action is active for img selection
      if(action == "WPadmin"){
        // stop page reload
        e.preventDefault();
        // if the frame already exists, re-open it.
        if ( meta_gallery_frame ) {
          meta_gallery_frame.open();
          return;
        }
        // Sets up the media library frame
        meta_gallery_frame = wp.media.frames.meta_gallery_frame = wp.media({
          title: input_id.title,
          button: { text:  input_id.button },
          library: { type: 'image' },
          multiple: true
        });
        // get already selected images
        meta_gallery_frame.on('open', function() {
          var selection = meta_gallery_frame.state().get('selection');
          var library = meta_gallery_frame.state('gallery-edit').get('library');
          var ids = $('div[data-id="' + container + '"]').find('.img-saved').val();
          if (ids) {
            idsArray = ids.split(',');
            idsArray.forEach(function(id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add( attachment ? [ attachment ] : [] );
            });
          }
        });
        //When an image is selected, run a callback.
        meta_gallery_frame.on('select', function() {
                var imageIDArray = [];
                var imageHTML = '';
                var metadataString = '';
                images = meta_gallery_frame.state().get('selection');
                images.each(function(attachment) {
                        imageIDArray.push(attachment.attributes.id);
                        imageHTML += '<span class="remove_image"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="3" height="32.2"/></svg></span><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'">';
                });
                metadataString = imageIDArray.join(",");
                if (metadataString) {
                  $('div[data-id="' + container + '"]').find('.img-saved').val(metadataString);
                  $('div[data-id="' + container + '"]').find('.img-selected').html(imageHTML);
                }
        });
        // Finally, open the modal
        meta_gallery_frame.open();
      }
    });


    /* remove selected media
    /------------------------*/
    $(document).on('click', '#configuration .img-selected .remove_image', function (e) {
      event.preventDefault();
      if (confirm('Are you sure you want to remove this image?')) {
        $(this).parents('.img-selected').siblings('.img-saved').val('');
        $(this).parents('.img-selected').html('');
      }
    });


    /* Generate configuration file
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration button.ajax-action', function (event) {
      event.preventDefault();
      // vars
      var get_action = $(this).attr('data-action');
      // build data array
      var data = {
        action: get_action
      };
      // run ajax
      ajaxCall(data);
    });


    /* duplicate rows
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration button.input-fields-adder', function (event) {
      event.preventDefault();
      // vars
      var get_main_parent = $(this).siblings('ul');
      var current_last_id = $(get_main_parent).children('li').last().attr('data-row');
      var new_row_id = parseFloat(current_last_id) + 1;
      // copy
      var $clone = $(get_main_parent).children('li').last().clone();
      // clear values
      $clone.find('input').val('');
      // reset color picker
      var $colorpicker = $('.wp-picker-container .wp-picker-input-wrap label input', $clone).clone();
      $('.wp-picker-container', $clone).html($colorpicker);
      $('.wp-picker-container .colorpicker', $clone).wpColorPicker();
      // inset copy
      $clone.appendTo(get_main_parent);
      // remove css class if array has now more then 1 values
      $(get_main_parent).removeClass('disable-remove');
      // update row number
      $(get_main_parent).children('li').last().attr('data-row', new_row_id);
      $(get_main_parent).children('li').last().find('input').attr('value', '');
      $(this).siblings('ul').find('li[data-row="' + new_row_id + '"] input').each(function() {
        var type = $( this ).attr( "type" );
        if(type !== 'button' && type !== 'submit'){
          var name = $( this ).attr( "name" );
          var new_name = name.replace("[" + current_last_id + "]", "[" + new_row_id + "]");
          $( this ).attr( "name", new_name );
        }
      });
    });


    /* delete rows
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration .addable .remove', function (event) {
      var confirm1 = confirm('Are you sure you want to delete this entry?');
      if (confirm1) {
        // add css class if array has now only 1 value
        if ( $(this).parents('ul').children('li').length == 2 ) {
          $(this).parents('ul').addClass('disable-remove');
        }
        // remove row
        $(this).parents('li').remove();
      }
  	});


    /* Color picker
    /------------------------*/
    function RunColorPicker(){
      $('.colorpicker').each(function(){
        $(this).wpColorPicker();
      });
    }
    RunColorPicker();


    /* sortable multi fields
    /------------------------*/
    if($('.sortable').length!==0){
      $('.sortable').sortable({
        update: function( event, ui ) {
          // create array
          // var img_ids = [];
          // // push ids into array
          // $( ".galleriesImages_list li" ).each(function() {
          //   var img_id = $(this).attr("data-id");
          //   img_ids.push(img_id);
          // });
          // // array to string
          // var newSort = img_ids.join();
          // // insert new value
          // $("#galleriesImages").val(newSort);
        }
      });
    }


});
