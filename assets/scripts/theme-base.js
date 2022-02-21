/*!
 * All template base javascript functions
 *
 * @author      David Voglgsang
 * @version     1.2
 *
 */


/*==================================================================================
  SETTINGS
==================================================================================*/

'use strict';

/* Global values
/------------------------*/
const root = document.querySelector('html'),
      configuration = ajaxCall({action: 'configuration'}),
      language = root.getAttribute('lang'),
      isTouch = 'ontouchstart' in document.documentElement,
      body = root.querySelector('body'),
      header = body.querySelector('header'),
      mainMenu = header.querySelector('#menu-main-container'),
      hamburger = header.querySelector('.hamburger'),
      hamburgertitle = header.querySelector('.hamburger-container .menu-title'),
      main = body.querySelector('main'),
      emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

let position = root.scrollTop,
    scrollPosition = window.scrollY;


/* Touch Device
/------------------------*/
root.setAttribute('data-touch', isTouch);



/*==================================================================================
 BASE FUNCTIONS
==================================================================================*/

/* Debounce function
/------------------------*/
function debounce(func, wait, immediate) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
};


/* Unique id generator
/------------------------*/
let uniqueID = () => {
  return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
}


/* Check if function exists
/------------------------*/
function is_function(func) {
  return typeof window[func] !== 'undefined' && $.isFunction(window[func]);
}


/* Convert RGB color to HEX code
/------------------------*/
function rgb2hex(rgb) {
  rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
  function hex(x) {
    return ("0" + parseInt(x).toString(16)).slice(-2);
  }
  return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}


/* Convert HEX code to RGB color
/------------------------*/
function hex2rgb(hex, opacity) {
  hex = hex.replace('#', '');
  r = parseInt(hex.substring(0,2), 16);
  g = parseInt(hex.substring(2,4), 16);
  b = parseInt(hex.substring(4,6), 16);
  result = 'rgba(' + r + ', ' + g + ', ' + b +', ' + opacity/100 + ')';
  return result;
}


/* Add css rule to stylesheet
/------------------------*/
// Example: addCSSRule(document.styleSheets[0], "header", "float: left");
function addCSSRule(sheet, selector, rules, index) {
  if("insertRule" in sheet) {
    sheet.insertRule(selector + "{" + rules + "}", index);
  }
  else if("addRule" in sheet) {
    sheet.addRule(selector, rules, index);
  }
}

/* Slugify string
/------------------------*/
function slugify(Text){
  return Text.toLowerCase()
  .replace(/ /g,'-')
  .replace(/ä/g,'ae')
  .replace(/Ä/g,'ae')
  .replace(/ö/g,'oe')
  .replace(/Ö/g,'oe')
  .replace(/ü/g,'ue')
  .replace(/Ü/g,'ue')
  .replace(/ß/g,'ss')
  .replace(/[^\w-]+/g,'');
}


/* get form parameter from url
/------------------------*/
function getParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}


/* Check if element is visible
/------------------------*/
function isInViewport(el) {
  const rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}


/* AJAX function
Example of calling ajax:
var configuration = {
  action: 'action to run after ajax request is done',
  path: 'file_path/filename.php',
  other_vars: 'vars content'
};
ajaxCall(configuration);
/------------------------*/
function ajaxCall(getdata) {
  // function file path
  if(getdata.path){
    var ajaxFile = "/" + getdata.path;
  } else {
    var ajaxFile = "/ajax.php";
  }
  // ajax is active - disable reload
  if(event){
    event.preventDefault();
  }
  // get data ready for request
  var access = 'access=granted&';
  var sendData = Object.keys(getdata).map(function (key) {
    return "" + key + "=" + getdata[key]; // line break for wrapping only
  }).join("&");
  // start request
  var request = new XMLHttpRequest();
  request.open('POST', theme_directory + ajaxFile, true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.onload = function() {
  if (this.status >= 200 && this.status < 400) {
      var results = JSON.parse(this.response);
      // console
      if(results.log){
        console.log(results.log);
      }
      // run function
      if(results.action && is_function(results.action)){
        eval(results.action + '(' + this.response + ')');
      } else {
        // DEBUG: console.log("Action not defined in ajax function");
      }
      // rerun event listeners
      runEventListeners();
    } else {
      // DEBUG: console.log("Ajax update failed");
    }
  };
  request.onerror = function() {
    // DEBUG: console.log("Ajax conection failed");
  };
  request.send(access + sendData);
}



/*==================================================================================
 THEME FUNCTIONS
==================================================================================*/

/* Settings from configuration file
/------------------------*/
function themeConfiguration(data){
  // check if file value exists and inline css are disabled
  if(data.content !== false && data.content.wp.HeaderCss !== "1"){
    // set color palette
    if(data.content.gutenberg && Array.isArray(data.content.gutenberg.ColorPalette)){
      // gutenberg is given and colors been added
      var colorPalette = data.content.gutenberg.ColorPalette;
      var keys = Object.keys(data.content.gutenberg.ColorPalette);
      for(var i=0; i<keys.length; i++){
        addCSSRule(document.styleSheets[0], 'body.frontend .has-' + slugify(colorPalette[i].key) + '-background-color', 'background-color: ' + colorPalette[i].value);
        addCSSRule(document.styleSheets[0], 'body.frontend .has-' + slugify(colorPalette[i].key) + '-color', 'color: ' + colorPalette[i].value);
      }
    }
  }
}


/* Sticky menu
/------------------------*/
function StickyHeader(action) {
  // get new scroll position and header height
  var scroll = window.scrollY,
      headerHeight = header.offsetHeight;
  // on load actions
  if(action == "load"){
    // IE FIX
    if(root.classList.contains('InternetExplorer') && body.classList.contains('sticky') && body.classList.contains('fixed') === false){
      main.style.marginTop = headerHeight + 'px';
    }
  }
  // if stickyable set sticky
  if(body.classList.contains('stickyable') && scroll > headerHeight){
    body.classList.add("sticky");
    // IE FIX
    if(root.classList.contains('InternetExplorer') && body.classList.contains('fixed') === false){
      main.style.marginTop = headerHeight + 'px';
    }
  }
  // if stickyable reset sticky
  if(body.classList.contains('stickyable') && scroll < headerHeight){
    body.classList.remove("sticky");
    // IE FIX
    if(root.classList.contains('InternetExplorer') && body.classList.contains('fixed') === false){
      main.style.marginTop = '';
    }
  }
  // update main scroll position
  scrollPosition = scroll;
  // body css if page is not on top
  if(scrollPosition > 0){
    body.classList.add("scrolled");
  } else {
    body.classList.remove("scrolled");
  }
}
var debounceSticky = debounce(function() {
  StickyHeader();
}, 100);
var debounceStickyResize = debounce(function() {
  StickyHeader("load");
}, 100);
window.addEventListener('scroll', debounceSticky);
window.addEventListener('resize', debounceStickyResize);
window.onload = function() {
  StickyHeader("load");
};


/* Hamburger switch
/------------------------*/
function MenuToggler() {
  // show overlay
  mainMenu.classList.toggle("hidden_mobile");
  mainMenu.classList.toggle("hidden_desktop");
  // prevent content scrolling
  root.classList.toggle("noscroll");
  // identify active menu
  body.classList.toggle("active-menu");
}
if(hamburger) {
  hamburger.addEventListener('click', MenuToggler);
  // check for hamburger title
  if(hamburgertitle){
    hamburgertitle.addEventListener('click', MenuToggler);
  }
}


/* Hamburger toggle submenus
/------------------------*/
function subMenuToggler(e) {
  // disable link call
  e.preventDefault();
  // toggle submenu visibility
  this.closest('.menu-item-has-children').classList.toggle("active");
}
if(mainMenu) {
  var menuSub = mainMenu.querySelectorAll('.menu-item-has-children .toggle');
  if(menuSub.length !== 0){
    Array.from(menuSub).forEach(function(submenu) {
      submenu.addEventListener('click', subMenuToggler);
      submenu.addEventListener('keypress', subMenuToggler);
    });
  }
}


/* Close Menu if click outside of menu
/------------------------*/
function closeHamburgerMenu(e){
  const target = e.target;
  if (target.closest("#menu-main-container") == null && target.closest(".hamburger") == null && target.closest(".menu-title") == null && body.classList.contains('active-menu')) {
    MenuToggler();
  }
}
document.addEventListener('click', closeHamburgerMenu);


/* Scroll to top
/------------------------*/
function scrollToTop(){
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
var scrollToTopButtons = document.querySelectorAll('#scroll-to-top span');
if(scrollToTopButtons.length !== 0){
  Array.from(scrollToTopButtons).forEach(function(element) {
    element.addEventListener('click', scrollToTop);
    element.addEventListener('keypress', scrollToTop);
  });
}


/* Action Links
/------------------------*/
// example: <span class="funcCall" data-ajax-action="true" data-action="DEMO" data-id="page">DEMO</span>
function funcCall(){
  // vars
  var get_ajax_action = this.getAttribute('data-ajax-action'),
      get_action = this.getAttribute('data-action'),
      get_id = this.getAttribute('data-id');
  // actions
  if(get_ajax_action){
    // run ajax function
    var config = {
      action: get_action,
      id: get_id
    };
    ajaxCall(config);
  } else if (get_action) {
    // run function
    eval(get_action + '()');
  }
}


/* List all data attributes
/------------------------*/
function getDataAttributes(element) {
    var data = {};
    [].forEach.call(element.attributes, function(attr) {
        if (/^data-/.test(attr.name)) {
            var camelCaseName = attr.name.substr(5).replace(/-(.)/g, function ($0, $1) {
                return $1.toUpperCase();
            });
            data[camelCaseName] = attr.value;
        }
    });
    return data;
}



/*==================================================================================
  THEME BLOCKS
==================================================================================*/

/* Toggle
/------------------------*/
function toggleBlock(){
  this.classList.toggle("active");
}


/* Overlay container
/------------------------*/
function checkOverlayContainers(e){
  const target = e.target;
  if (target.closest(".overlay-container") == null) {
      var overlayContainers = document.querySelectorAll('.overlay-container');
      if(overlayContainers){
        Array.from(overlayContainers).forEach(function(container) {
          container.classList.remove("active-iframe");
        });
      }
  } else {
    target.closest(".overlay-container").classList.add("active-iframe");
  }
}


/* Post sort
/------------------------*/
function runPostSorting(){
  this.closest(".block-posts").querySelector('ul').classList.add("loading");
  // label settings
  if(this.classList.contains('active')){
    var selectedDirection = this.getAttribute('data-sortd');
    if(selectedDirection == 'desc'){
      this.setAttribute('data-sortd', 'asc');
      this.classList.remove("z-a");
      var newDirection = 'asc';
    } else {
      this.setAttribute('data-sortd', 'desc');
      this.classList.add("z-a");
      var newDirection = 'desc';
    }
  } else {
    var labels = this.closest(".sort-options").querySelectorAll('label');
    Array.from(labels).forEach(function(label) {
      label.classList.remove("active");
      label.setAttribute('data-sortd', 'asc');
    });
    this.classList.add("active");
    var newDirection = 'asc';
  }
  // vars
  var id = this.closest(".block-posts").getAttribute('data-id');
  var sortBy = this.getAttribute('data-sort');
  // update vars
  document.querySelector('.block-posts[data-id="' + id + '"] .sort-options input[name="postSortBy"]').value = sortBy;
  document.querySelector('.block-posts[data-id="' + id + '"] .sort-options input[name="postSortDirection"]').value = newDirection;
  // run query
  var config = formValuesToAjax(this.closest('.block-posts[data-id="' + id + '"]').querySelector('form'));
  config['path'] = '../mastertheme/classes/prefix_WPgutenberg/blocks/posts/ajax.php';
  config['action'] = 'loadPosts';
  config['id'] = id;
  // run ajax function
  ajaxCall(config);
}
function insertSortedPosts(data){
  document.querySelector('.block-posts[data-id="' + data.id + '"] ul').innerHTML = data.content;
  document.querySelector('.block-posts[data-id="' + data.id + '"] ul').classList.remove("loading");
}
var postSortLabel = document.querySelectorAll('.sort-options label');
if(postSortLabel.length !== 0){
  Array.from(postSortLabel).forEach(function(label) {
    label.addEventListener('click', runPostSorting);
    label.addEventListener('keypress', runPostSorting);
  });
}


/* Post filter
/------------------------*/
function runPostFilter(input){
  input.closest(".block-postsfilter").querySelector('.results').classList.add("loading");
  // vars
  const id = input.closest(".block-postsfilter").getAttribute('data-id');
  var config = formValuesToAjax(input.closest('.block-postsfilter[data-id="' + id + '"]').querySelector('form'));
  config['path'] = '../mastertheme/classes/prefix_WPgutenberg/blocks/postsfilter/ajax.php';
  config['action'] = 'loadPosts';
  config['id'] = id;
  // run ajax function
  ajaxCall(config);
}
function insertFilteredPosts(data){
  document.querySelector('.block-postsfilter[data-id="' + data.id + '"] .results').innerHTML = data.content;
  document.querySelector('.block-postsfilter[data-id="' + data.id + '"] .results').classList.remove("loading");
}
var postFilterInputs = document.querySelectorAll('.block-postsfilter input');
if(postFilterInputs.length !== 0){
  Array.from(postFilterInputs).forEach(function(input) {
    if(input.type == 'text'){
      input.oninput = function() {
        runPostFilter(input);
      }
    } else if (input.type == 'checkbox') {
      input.addEventListener ("change", function () {
         runPostFilter(input);
      });
    }
  });
}


/* vimeo
/------------------------*/
// get all vimeo blocks
var allVimeoVideos = document.querySelectorAll('.block-vimeo');
// go to selected chapter
function vimeoChapterSelection(link){
  // get settings
  const container = link.closest('.block-vimeo'),
        iframe = container.querySelector('.resp_video iframe'),
        player = new Vimeo.Player(iframe),
        videoStop = link.closest('.table-of-content').getAttribute('data-stop'),
        videoAutoplay = link.closest('.table-of-content').getAttribute('data-autoplay');
  // go to chapter
  const chapterStart = link.getAttribute('data-time');
  const chapterEnd = link.getAttribute('data-end');
  player.setCurrentTime(chapterStart);
  // play if selected
  if(videoAutoplay == "1"){
    player.play();
  } else {
    player.play();
    player.on('timeupdate', function(data) {
      player.pause();
    });
  }
  // set chapter end time
  container.setAttribute('data-stop', chapterEnd);
  // if selected stop video on chapter end
  if(videoStop == 1){
    // reset all events
    player.on('timeupdate', function(data) {
      const stopOn = link.closest('.block-vimeo').getAttribute('data-stop');
      if(data.seconds > parseInt(stopOn)){
        player.pause();
      }
      // if(data.seconds < parseInt(chapterEnd)){
      //   player.play();
      // }
    });

  }
}
// build table of content
if(allVimeoVideos.length !== 0){
  Array.from(allVimeoVideos).forEach(function(video) {
    // call iframe and player api
    const iframe = video.querySelector('.resp_video iframe');
    const player = new Vimeo.Player(iframe);
    //table of content
    if(video.querySelectorAll(".table-of-content").length > 0){
      player.getDuration().then(function(duration) {
        player.getChapters().then(function(chapters) {
          let chapterTimes = [];
          // build list
          var toc = '<ul>';
            Array.from(chapters).forEach(function(chapter, key) {
              var nextkey = key + 1;
              var lastkey = chapters.length - 1;
              if(key == lastkey){
                var nextChapterStart = duration;
              } else {
                var nextChapterStart = chapters[nextkey].startTime;
              }
              toc += '<li><a data-time="' + chapter.startTime + '" data-end="' + nextChapterStart + '">' + chapter.title + '</a></li>';
              chapterTimes.push(chapter.startTime);
            });
          toc += '</ul>';
          // insert list
          video.querySelector(".table-of-content").innerHTML = toc;
          // add click action
          var videoChaptersLink = video.querySelectorAll('.table-of-content ul li a');
          if(videoChaptersLink.length > 0){
            Array.from(videoChaptersLink).forEach(function(link) {
              link.addEventListener('click', function(){
                vimeoChapterSelection(link);
              }, false);
              link.addEventListener('keypress', function(){
                vimeoChapterSelection(link);
              }, false);
            });
          }
        }).catch(function(error) {
          // An error occurred
        });
      });
    }
    // array ended
  });
}



/*==================================================================================
  FORM
==================================================================================*/

/* deselect radio button
/------------------------*/
function deselectRadioButtons(rootElement) {
  if(!rootElement) rootElement = document;
  if(!window.radioChecked) window.radioChecked = null;
  window.radioClick = function(e) {
    const obj = e.target;
    if(e.keyCode) return obj.checked = e.keyCode!=32;
    obj.checked = window.radioChecked != obj;
    window.radioChecked = obj.checked ? obj : null;
  }
  rootElement.querySelectorAll("input[type='radio']").forEach( radio => {
    radio.setAttribute("onclick", "radioClick(event)");
    radio.setAttribute("onkeyup", "radioClick(event)");
  });
}
deselectRadioButtons();


/* form values for ajax
/------------------------*/
function formValuesToAjax(form){
  let array = [];
  // add text, email, textarea and hidden fields
  const formTextFields = form.querySelectorAll('input[type="text"], input[type="email"], input[type="hidden"], textarea');
  if(formTextFields.length !== 0){
    Array.from(formTextFields).forEach(function(input) {
      array[input.name] = input.value;
    });
  }
  // add radio and checkbox values in fieldsets
  const formFieldsets = form.querySelectorAll('fieldset');
  if(formFieldsets.length !== 0){
    Array.from(formFieldsets).forEach(function(fieldset) {
      const fieldsetInputs = fieldset.querySelectorAll('input');
      if(fieldsetInputs.length !== 0){
        let fieldsetArray = [];
        Array.from(fieldsetInputs).forEach(function(input) {
          if(input.checked){
            fieldsetArray.push(input.value);
          }
        });
        array[fieldsetInputs[0].name] = fieldsetArray.join('__');
      // array[input.name] = input.value;});
      }
    });
  }
return array;
}


/* validate formular
/------------------------*/
function validateForm(form){
  var inputs = form.querySelectorAll('input, textarea, select');
  if(inputs.length !== 0){
    Array.from(inputs).forEach(function(element) {
      validateInput(element);
    });
  }
  var requieredFields = form.querySelectorAll('.required');
  if(requieredFields.length !== 0){
    return false;
  } else {
    return true;
  }
}


/* validate input field
/------------------------*/
function validateInput(element){
  var parent = element.closest('li, span, div');
  if(parent.hasAttribute("data-validation")){
    var validationType = parent.dataset.validation;
    if (validationType == 'true' || validationType == 'optional') {
      var inputType = element.type;
      var inputValue = element.value;
      var inputName = element.name;
      var valid = false;
      // validate
      if (inputType == 'text' && inputValue !== '' || inputType == 'textarea' && inputValue !== '' || inputType == 'select-one' && inputValue !== '' || inputType == 'select-multiple' && inputValue !== ''){
        valid = true;
      } else if (inputType == 'email' && inputValue !== '' && emailReg.test( inputValue )){
        valid = true;
      } else if (inputType == 'checkbox' || inputType == 'radio'){
        var checkbox = document.getElementsByName(inputName), i, checked;
        for (i = 0; i < checkbox.length; i += 1) {
          checked = (checkbox[i].checked||checked===true)?true:false;
        }
        if (checked !== false) {
          valid = true;
        }
      }
      // validate optional field
      if(validationType == 'optional' && inputValue == ''){
        valid = true;
      }
      // handle required class
      if(valid){
        parent.classList.remove("required");
      } else {
        parent.classList.add("required");
      }
    }
  }
}


/* TEXTAREA HEIGHT
/------------------------*/
function adjustHeight(el){
    el.style.height = (el.scrollHeight > el.clientHeight) ? (el.scrollHeight)+"px" : (el.scrollHeight)+"px";
}



/*==================================================================================
  POP UP
==================================================================================*/

/* Create
/------------------------*/
function closePopUp(){
  // enable scrolling
  root.classList.remove('popup-noscroll');
  // hide and remove popup
  var popup = document.querySelector('.popup');
  popup.classList.add('closed');
  popup.remove();
}


/* Create
/------------------------*/
function loadPopUp(){
  const popup_close = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" style="enable-background:new 0 0 24.9 24.9;" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#fff" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#fff" width="3" height="32.2"/></svg>',
        popup_content = '<div class="popup closed" data-content="img-popup"><div class="popup-container"><span class="close">' + popup_close + '</span><div class="popup-content"></div></div></div>';
  // inser pop up
  body.insertAdjacentHTML('beforeend', popup_content);
  // disable scrolling and show popup
  setTimeout(function() {
    var popup = document.querySelector('.popup');
    root.classList.add('popup-noscroll');
    popup.classList.remove('closed');
    // add closing event
    var closePopUpButtons = document.querySelectorAll('.popup > .popup-container > .close');
    if(closePopUpButtons.length > 0){
      Array.from(closePopUpButtons).forEach(function(closeButton) {
        closeButton.addEventListener('click', closePopUp);
        closeButton.addEventListener('keypress', closePopUp);
      });
    }
  }, 500);
}


/* Load
/------------------------*/
function loadImagePopUp(){
  // load pop up
  loadPopUp();
  // load content
  setTimeout(function(self) {
    // insert image and arrows
    var popupContainer = document.querySelector('.popup > .popup-container > .popup-content');
    popupContainer.insertAdjacentHTML('beforebegin', galleryArrowBefore);
    popupContainer.appendChild(self.cloneNode());
    popupContainer.insertAdjacentHTML('afterend', galleryArrowAfter);
    // add id of current gallery
    var currentGallery = self.closest('.add-popup');
    popupContainer.setAttribute('data-id', currentGallery.getAttribute('data-id'));
    // check for preview images
  }, 100, this);
}


/* open
/------------------------*/
var activeImagePopUps = document.querySelectorAll('.wp-block-image.add-popup img');
if(activeImagePopUps.length > 0){
  Array.from(activeImagePopUps).forEach(function(popup) {
    // open pop-up
    popup.addEventListener('click', loadImagePopUp);
    popup.addEventListener('keypress', loadImagePopUp);
  });
}



/*==================================================================================
  EVENT LISTENERS
==================================================================================*/

/* load all event listeners for blocks on load or after ajax
/------------------------*/
function runEventListeners(){

  /* Action Links
  /------------------------*/
  var actionButtons = document.querySelectorAll('.funcCall');
  if(actionButtons.length !== 0){
    Array.from(actionButtons).forEach(function(element) {
      element.addEventListener('click', funcCall);
      element.addEventListener('keypress', funcCall);
    });
  }

  /* Toggle
  /------------------------*/
  var toggleButtons = document.querySelectorAll('.block-accordion > .accordion-item > .accordion-label, .arrow-toggle > .label');
  if(toggleButtons.length !== 0){
    Array.from(toggleButtons).forEach(function(element) {
      element.addEventListener('click', toggleBlock);
      element.addEventListener('keypress', toggleBlock);
    });
  }

  /* Overlay container
  /------------------------*/
  var getOverlayContainers = document.querySelectorAll('.overlay-container');
  if(getOverlayContainers.length !== 0){
    document.onfocusout = function(){
      setTimeout(function(){
        // using the 'setTimout' to let the event pass the run loop
        if (document.activeElement instanceof HTMLIFrameElement) {
          // Do your logic here..
          document.querySelectorAll('.overlay-container').classList.add("active-iframe");
        } else {
          document.querySelectorAll('.overlay-container').classList.remove("active-iframe");
        }
      },0);
    };
    document.addEventListener('click', checkOverlayContainers);
  }

}
runEventListeners();
