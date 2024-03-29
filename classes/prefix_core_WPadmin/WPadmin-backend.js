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
    function adminAjaxCall(getdata) {
      $.ajax({
        url: Ajax_File,
        type: 'POST',
        data: getdata,
        dataType: "json",
        success: function(data) {
          // DEBUG: console.log("Ajax update success");
          // DEBUG: console.log(data);
          $(getdata.parent).removeClass('loading');
          // console
          if(data.log){
            console.log(data.log);
          }
          // message
          if(data.message){
            $(getdata.parent + ' #config-message').html(data.message);
          }
          // css
          if(data.type){
            $(getdata.parent + ' #config-message').attr('class', data.type);
          }
          // css
          if(data.file && data.name){
            var $a = $("<a>");
            $a.attr("href",data.file);
            $(getdata.parent + " #config-message").append($a);
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
    function updatePageOptions() {
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
      updatePageOptions();
    },2000);

    /* page background color & img
    /––––––––––––––––––––––––*/
    function setBackgroundColor(){
      var getPageColorElement = document.getElementById("template_page_bgColor");
      if(getPageColorElement){
        var pageColor = getPageColorElement.value;
        document.querySelector(".editor-styles-wrapper").style.backgroundColor = pageColor;
      }
    }
    function setBackgroundImage(){
      if(document.querySelector('div[data-id="template_page_bgImg"]')){
        var getPageImgElement = document.querySelector('div[data-id="template_page_bgImg"] .img-selected img');
        if(getPageImgElement){
          var pageBgImg = getPageImgElement.src;
          document.querySelector(".editor-styles-wrapper").style.backgroundImage = "url('" + pageBgImg + "')";
        } else {
          document.querySelector(".editor-styles-wrapper").style.backgroundImage = "none";
        }
      }
    }
    setTimeout(function(){
      setBackgroundColor();
      setBackgroundImage();
    },2000);



    /*==================================================================================
      CALL ACTIONS
    ==================================================================================*/

    /* recheck dark mode
    /––––––––––––––––––––––––*/
    $(document).on('click', '#WPtemplate input', function (event) {
      updatePageOptions();
    });

    /* change background color & img
    /––––––––––––––––––––––––*/
    $("#template_page_bgColor").change(function() {
      setBackgroundColor();
    });

    /* save form
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration input[type="submit"]', function (event) {
      // get content
      var get_action = $(this).data('action');
      var get_formData = $('#configuration form').serialize();
      // build data array
      var data = {
        parent: '#configuration',
        action: get_action,
        formdata: get_formData
      };
      $('#configuration').addClass('loading');
      event.preventDefault();
      adminAjaxCall(data);
    });

    /* import form
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configurationImportExport input[type="submit"]', function (event) {
      event.preventDefault();
      $('#configurationImportExport').addClass('loading');
      // get content
      var get_action = $(this).data('action');
      var file_data = $(this).parent('form').find('input[name="uploadFile"]').prop("files")[0];
      // run if
      if(file_data){
        var readFile = new FileReader();
        readFile.onload = function(e){
          var contents = e.target.result;
          var jsonContent = JSON.parse(contents);
          var get_formData = jsonContent;
          // build data array
          var data = {
            parent: '#configurationImportExport',
            action: get_action,
            formdata: get_formData
          };
          adminAjaxCall(data);
        };
        readFile.readAsText(file_data);
      } else {
        var data = {
          parent: '#configurationImportExport',
          action: get_action,
          formdata: ''
        };
        adminAjaxCall(data);
      }
    });


    /* select img
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration .wp-single-media, .metaboxes .wp-single-media, #postimagediv .wp-single-media', function (e) {
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
                        imageHTML += '<span class="remove_image"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="3" height="32.2"/></svg></span><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.full.url+'">';
                });
                metadataString = imageIDArray.join(",");
                if (metadataString) {
                  $('div[data-id="' + container + '"]').find('.img-saved').val(metadataString);
                  $('div[data-id="' + container + '"]').find('.img-selected').html(imageHTML);
                }
                if("template_page_bgImg" == input_id){
                  setBackgroundImage();
                }
        });
        // Finally, open the modal
        meta_gallery_frame.open();
      }
    });


    /* select video
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration .wp-single-video, .metaboxes .wp-single-video, #postimagediv .wp-single-video', function (e) {
      // get action
      var action = $(this).attr('data-action');
      var input_id = $(this).siblings('.video-saved').attr('id');
      var container = $(this).parents('div').data('id');
      var meta_gallery_frame;
      // check if right action is active for video selection
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
          library: { type: 'video' },
          multiple: true
        });
        // get already selected images
        meta_gallery_frame.on('open', function() {
          var selection = meta_gallery_frame.state().get('selection');
          var library = meta_gallery_frame.state('gallery-edit').get('library');
          var ids = $('div[data-id="' + container + '"]').find('.video-saved').val();
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
                        imageHTML += '<span class="remove_video"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="3" height="32.2"/></svg></span><video src="' + attachment.attributes.url + '" autoplay muted playsinline></video>';
                });
                metadataString = imageIDArray.join(",");
                if (metadataString) {
                  $('div[data-id="' + container + '"]').find('.video-saved').val(metadataString);
                  $('div[data-id="' + container + '"]').find('.video-selected').html(imageHTML);
                }
        });
        // Finally, open the modal
        meta_gallery_frame.open();
      }
    });


    /* remove selected video
    /------------------------*/
    $(document).on('click', '#configuration .video-selected .remove_video, .metaboxes .video-selected .remove_video, #postimagediv .video-selected .remove_video', function (e) {
      event.preventDefault();
      if (confirm('Are you sure you want to remove this video?')) {
        $(this).parents('.video-selected').siblings('.video-saved').val('');
        $(this).parents('.video-selected').html('');
      }
    });


    /* remove selected media
    /------------------------*/
    $(document).on('click', '#configuration .img-selected .remove_image, .metaboxes .img-selected .remove_image', function (e) {
      event.preventDefault();
      if (confirm('Are you sure you want to remove this image?')) {
        $(this).parents('.img-selected').siblings('.img-saved').val('');
        $(this).parents('.img-selected').html('');
        setBackgroundImage();
      }
    });


    /* Generate configuration file
    /––––––––––––––––––––––––*/
    $(document).on('click', '#configuration button.ajax-action, #configurationImportExport button.ajax-action', function (event) {
      event.preventDefault();
      // vars
      var get_action = $(this).attr('data-action');
      if($('#configurationImportExport').length > 0){
        get_parent = '#configurationImportExport';
      } else if($('#configuration').length > 0) {
        get_parent = '#configuration';
      }
      console.log(get_parent);
      // build data array
      var data = {
        parent: get_parent,
        action: get_action
      };
      // run ajax
      adminAjaxCall(data);
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
        $(this).wpColorPicker({
          change: function(event, ui){
            var theColor = ui.color.toString();
            var inputID = $(this).attr('id');
            document.getElementById(inputID).setAttribute('value',theColor);
            if('template_page_bgColor' == inputID){
              document.querySelector(".editor-styles-wrapper").style.backgroundColor = theColor;
            }
          }
        }
        );
      });
    }
    RunColorPicker();


    /* sortable multi fields
    /------------------------*/
    if($('ul.sortable').length!==0){
      $('ul.sortable').sortable({
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


    /* drag and drop pins
    /------------------------*/
    $( ".block-image-pins" ).draggable({
      appendTo: ".block-editor-block-list__layout"
    });



    /* toggle all check boxes
    /------------------------*/
    function toggleCheckboxes(){
      var target = this.getAttribute("data-name");
      var checkboxes = document.querySelectorAll('input[name="' + target + '[]"]');
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i] != this)
              checkboxes[i].checked = this.checked;
      }
    }
    var toggleAllCheckboxes = document.querySelectorAll('.select-all');
    if(toggleAllCheckboxes.length !== 0){
      // click to toggle
      Array.from(toggleAllCheckboxes).forEach(function(box) {
        box.addEventListener('click', toggleCheckboxes);
        box.addEventListener('keypress', toggleCheckboxes);
      });
    }



});
