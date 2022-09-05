/*!
 * All template base javascript functions
 *
 * @author      David Voglgsang
 * @version     1.4
 *
 */

 /*=======================================================
 Table of Contents:
 –––––––––––––––––––––––––––––––––––––––––––––––––––––––––
   1.0 SETTINGS
   2.0 BASE FUNCTIONS
   3.0 THEME FUNCTIONS
   4.0 THEME BLOCKS
   5.0 FORM
   6.0 POP UP
   7.0 EVENT LISTENERS
 =======================================================*/


/*==================================================================================
  1.0 SETTINGS
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


/* Open accordion on load if its been called
/------------------------*/
if (window.location.hash) {
  var hash = window.location.hash;
  var toToggleOnLoad = document.querySelector(hash);
  if(toToggleOnLoad && toToggleOnLoad.classList.contains('accordion-item')){
    toToggleOnLoad.querySelector('.accordion-label').classList.add('active');
  }
}


/* Open accordion on anchor link
/------------------------*/
function openAccordionByAnchor(){
  var target = this.getAttribute("href");
  var accordionToOpen = document.querySelector(target);
  if(accordionToOpen && accordionToOpen.classList.contains('accordion-item')){
    accordionToOpen.querySelector('.accordion-label').classList.add('active');
  }
}



/*==================================================================================
 2.0 BASE FUNCTIONS
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
  if (typeof func !== 'undefined') {
    return true;
  } else {
    return false;
  }
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


/* Clean string from letters and convert lefting numbers into int
/------------------------*/
function stringToNumberCoverter(string){
  string = string.replace(/\D/g,'');
  return parseInt(string);
}


/* Check if element overflows parent element
/------------------------*/
function checkChildPosition(parent, child, action = 'statement', gap = 0) {
  // get elements position
  var box1coords = parent.getBoundingClientRect();
  var box2coords = child.getBoundingClientRect();
  // check if child overflows parent
  if(action == 'update'){
    if(box2coords.top < box1coords.top) {
      // child.style.top = '';
    }
    if(box2coords.right > box1coords.right && box2coords.left > box1coords.left) {
      var currentLeft = stringToNumberCoverter(getStyle(child, 'left'));
      var newLeft =  box1coords.right - box2coords.right - currentLeft - gap;
      child.style.left = newLeft + "px";
    }
    if(box2coords.bottom > box1coords.bottom && box2coords.top > box1coords.top) {
      child.style.bottom = "calc(100% + " + gap + "px)";
    } else {
      var maxPos = box2coords.bottom + box2coords.height + gap;
      if(maxPos < box1coords.bottom){
        child.style.bottom = "calc((" + box2coords.height + "px + " + gap + "px) * -1)";
      }
    }
    if(box2coords.left < box1coords.left && box2coords.right < box1coords.right) {
      var currentLeft = stringToNumberCoverter(getStyle(child, 'left'));
      var newLeft =  box1coords.left - box2coords.left - currentLeft + gap;
      child.style.left = newLeft + "px";
    }
  } else if(action == 'inside') {
    if(
      box2coords.top >= box1coords.top &&
      box2coords.right <= box1coords.right &&
      box2coords.bottom <= box1coords.bottom &&
      box2coords.left + 1 >= box1coords.left) {
      return true;
    } else {
      return false;
    }
  } else {
    // give statement
    if(box2coords.top < box1coords.top || box2coords.right > box1coords.right || box2coords.bottom > box1coords.bottom || box2coords.left < box1coords.left) {
      return true;
    } else {
      return false;
    }
  }
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
      // inset content to element
      if(results.content && results.targetContent && results.targetContent !== ''){
        var signsResult = document.querySelector(results.targetContent);
        if(signsResult){
          signsResult.classList.remove('dn');
          signsResult.classList.remove('loading');
          signsResult.innerHTML = results.content;
        }
      }
      // download file
      if(results.file){
        // check for requiredproperties
        if(results.file.hasOwnProperty("name") && results.file.hasOwnProperty("type") && results.file.hasOwnProperty("data")){
          var fileData = '';
          if(results.file.type == 'csv'){
            var separator = ',',
                hrefData = 'text/csv';
            // change column seperation
            if(results.file.hasOwnProperty("separator")){
              var separator = results.file.separator;
            }
            // build file content
            if(Array.isArray(results.file.data)){
              results.file.data.forEach(function(row){
                fileData += row.join(separator);
                fileData += "\n";
              });
            } else {
              console.log("file download: content is not a array");
            }
          } else if(results.file.type == 'string'){
            fileData += results.file.data;
          } else {
            console.log("file download: given type " + results.file.type + " is not supported");
          }
          if(results.file.hasOwnProperty("name") && fileData !== ''){
            if(results.file.hasOwnProperty("charset")){
              var charset = results.file.charset;
            } else {
              var charset = "utf-8";
            }
            if(results.file.hasOwnProperty("hrefData")){
              var hrefData = results.file.hrefData;
            }
            // trigger download
            var hiddenElement = document.createElement('a');
            hiddenElement.href = 'data:' + hrefData + ';charset=' + charset + ',' + encodeURI(fileData);
            hiddenElement.target = '_blank';
            hiddenElement.download = results.file.name;
            hiddenElement.click();
          }
        }
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


/* get element style
Example:
var element = document.querySelector('div.target');
var marginRight = getStyle(element, 'margin-right');
/------------------------*/
var getStyle = function(e, styleName) {
  var styleValue = "";
  if (document.defaultView && document.defaultView.getComputedStyle) {
    styleValue = document.defaultView.getComputedStyle(e, "").getPropertyValue(styleName);
  } else if (e.currentStyle) {
    styleName = styleName.replace(/\-(\w)/g, function(strMatch, p1) {
      return p1.toUpperCase();
    });
    styleValue = e.currentStyle[styleName];
  }
  return styleValue;
}



/*==================================================================================
 3.0 THEME FUNCTIONS
==================================================================================*/

/* Settings from configuration file
/------------------------*/
function themeConfiguration(data){
  // check if file value exists and inline css are disabled
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


/* close active elements
/------------------------*/
function closeActiveElement(e){
  const target = e.target;
  // main menu
  if (target.closest("#menu-main-container") == null && target.closest(".hamburger") == null && target.closest(".menu-title") == null && body.classList.contains('active-menu')) {
    MenuToggler();
  }
  // vimeo block previews
  if (target.closest(".block-vimeo") == null) {
    var vimeoPreviews = document.querySelectorAll('.block-vimeo > .video-container.video-preview');
    if(vimeoPreviews.length !== 0){
      Array.from(vimeoPreviews).forEach(function(video) {
        video.classList.remove("active");
        // get settings
        let container = video.closest('.block-vimeo'),
            iframe = container.querySelector('.vimeo-video'),
            player = new Vimeo.Player(iframe),
            videoAutoplay = container.getAttribute('data-autoplay');
        // play if autoplay is true
        if(videoAutoplay == "true"){
          player.pause();
        }
      });
    }
  }
}
document.addEventListener('click', closeActiveElement);


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


/* Load content after consent
/------------------------*/
function consentGiven(e) {
  // get clicked element
  var e = e || window.event,
      cookie = e.target.getAttribute('data-cookie'),
      reload = e.target.getAttribute('data-reload'),
      affectedEl = document.querySelectorAll('[data-cookie="' + cookie + '"]');
  // update cookie
  document.cookie = cookie + "=yes; path=/";
  // load content
  if(reload == 1){
    location.reload();
  } else {
    if(affectedEl.length !== 0){
      Array.from(affectedEl).forEach(function(element) {
        // get embed value
        var embed = element.getAttribute('data-embed');
        embed.replaceAll('&amp;', '&');
        embed.replaceAll('&lt;', '<');
        embed.replaceAll('&gt;', '>');
        embed.replaceAll('&quot;', '"');
        // create new element and insert embed code
        var temp = document.createElement('div');
        temp.innerHTML = embed;
        // apply code
        var toInsert = temp.querySelector(':first-child');
        element.closest('.consent-request').replaceWith(toInsert);
      });
      runEventListeners();
    }
  }
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



/*==================================================================================
  4.0 THEME BLOCKS
==================================================================================*/

/* Toggle
/------------------------*/
function toggleBlock(){
  this.classList.toggle("active");
  // video preview - autoplay
  if (this.classList.contains("video-container")) {
    // get settings
    let container = this.closest('.block-vimeo'),
        iframe = container.querySelector('.vimeo-video'),
        player = new Vimeo.Player(iframe),
        videoAutoplay = container.getAttribute('data-autoplay');
    // play if autoplay is true
    if(videoAutoplay == "true"){
      player.play();
    }
  }
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


/* Post load content inside block
/------------------------*/
function loadPostsContent(){
  var currentID = this.closest('li').getAttribute("data-id"),
      container = this.closest('.block-posts').getAttribute("data-id");
  this.closest('.block-posts').querySelector('.posts-target .wp-block-group__inner-container').classList.add('loading');
  // run ajax function
  var config = {
    action: 'loadPageContent',
    targetContent: '.block-posts[data-id="' + container + '"] .posts-target .wp-block-group__inner-container',
    id: currentID
  };
  // if pin content should be loaded too
  if(this.hasAttribute('data-loadpin')){
    config['loadPin'] = this.getAttribute("data-loadpin");
  }
  ajaxCall(config);
  // active statement for loaded post
  var allPosts = document.querySelectorAll('.block-posts[data-id="' + container + '"] > ul li');
  if(allPosts.length !== 0){
    Array.from(allPosts).forEach(function(post) {
      if(currentID == post.getAttribute('data-id')){
        post.classList.add('active');
      } else {
        post.classList.remove('active');
      }
    });
  }
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
  if(input.closest(".block-postsfilter").querySelectorAll('input[type="checkbox"]:checked').length >= 1 || input.closest(".block-postsfilter").querySelector('#textsearch') && input.closest(".block-postsfilter").querySelector('#textsearch').value !== ""){
    input.closest(".block-postsfilter").querySelector('#resetSelection').classList.remove('hidden');
  } else {
    input.closest(".block-postsfilter").querySelector('#resetSelection').classList.add('hidden');
  }
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
var postFilterReset = document.querySelectorAll('.block-postsfilter input[type="reset"], .block-postsfilter input[type="submit"]');
if(postFilterReset.length !== 0){
  Array.from(postFilterReset).forEach(function(button) {
    button.addEventListener("click", function(){
      button.closest("form").reset();
      runPostFilter(button);
    });
    button.addEventListener("keypress", function(){
      button.closest("form").reset();
      runPostFilter(button);
    });
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


/* Image pins
/------------------------*/
// to open/close clickable info windows
function imagePinsToggle(){
  var currentID = this.closest('.block-image-pin').getAttribute("data-id");
  var imgPins = document.querySelectorAll('.block-image-pins .pins .block-image-pin');
  if(imgPins.length !== 0){
    Array.from(imgPins).forEach(function(pin) {
      var pinId = pin.getAttribute("data-id"),
          pinInfo = pin.getAttribute("data-info");
      if(pinId == currentID && pinInfo == 'click'){
        pin.classList.toggle("active");
      } else {
        pin.classList.remove("active");
      }
    });
  }
}
// close clickable info window
function imgPinsInfoClose(){
  this.closest('.block-image-pin').classList.remove("active");
}
// load the content inside block
function imagePinsLoadContent(){
  var currentID = this.closest('.block-image-pin').getAttribute("data-id");
  if(this.getAttribute('data-load') == 'parentcontent'){
    var container = this.closest('.block-posts').getAttribute("data-id");
    var target = '.block-posts[data-id="' + container + '"] .posts-target .wp-block-group__inner-container';
  } else {
    var container = this.closest('.block-image-pins').getAttribute("data-id");
    var target = '.block-image-pins[data-id="' + container + '"] .pin-target';
  }
  // run ajax function
  var config = {
    action: 'loadPageContent',
    targetContent: target,
    id: currentID
  };
  ajaxCall(config);
  if(this.getAttribute('data-load') == 'parentcontent'){
    // active statement for loaded post
    var allPosts = document.querySelectorAll('.block-posts[data-id="' + container + '"] > ul li');
    if(allPosts.length !== 0){
      Array.from(allPosts).forEach(function(post) {
        if(currentID == post.getAttribute('data-id')){
          post.classList.add('active');
        } else {
          post.classList.remove('active');
        }
      });
    }
  } else {
    // active statement for loaded pin
    var allPins = document.querySelectorAll('.block-image-pins[data-id="' + container + '"] .pins .block-image-pin');
    if(allPins.length !== 0){
      Array.from(allPins).forEach(function(pin) {
        if(currentID == pin.getAttribute('data-id')){
          pin.classList.add('loadedPin');
        } else {
          pin.classList.remove('loadedPin');
        }
      });
    }
  }
}


/* Video JS
/------------------------*/
function runVideoJS(videoblock){
  var video = videoblock.querySelector('video');
  if(video){
    // fallback for video source
    if(video.hasAttribute("src")){
      var source = document.createElement('source');
      source.setAttribute('src', video.getAttribute('src'));
      video.appendChild(source);
    }
    // center play button
    if(videoblock.classList.contains("jvs-bigplay-centered")){
      video.classList.add('vjs-big-play-centered');
    }
    // run video js
    video.classList.add('video-js');
    var player = videojs(video);
    // var videoWidth = video.offsetWidth;
    // var videoHeight = video.offsetHeight;
    // if(videoWidth && videoHeight){
    //   // make video responsive
    //   var responsive = 100 / videoWidth * videoHeight;
    //   videoblock.style.paddingTop = responsive + '%';
    // }
  }
}



/*==================================================================================
  5.0 FORM
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
  rootElement.querySelectorAll("input[type='radio'].deselect").forEach( radio => {
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
  // add select options
  const formSelect = form.querySelectorAll('select');
  if(formSelect.length !== 0){
    Array.from(formSelect).forEach(function(select) {
      const selectOptions = select.querySelectorAll('option:checked');
      if(selectOptions.length !== 0){
        let selectArray = [];
        Array.from(selectOptions).forEach(function(input) {
          selectArray.push(input.value);
        });
        array[select.name] = selectArray.join('__');
      // array[input.name] = input.value;});
      }
    });
  }
  // add radio and checkbox values in fieldsets
  const formFieldsets = form.querySelectorAll('fieldset, .radio-group, .checkbox-group');
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
  6.0 POP UP
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
  const popup_close = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" width="3" height="32.2"/></svg>',
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
    var currentGallery = self.closest('.add-popup'),
    clone = currentGallery.cloneNode(true),
    popupContainer = document.querySelector('.popup > .popup-container > .popup-content');
    popupContainer.insertAdjacentHTML('beforebegin', galleryArrowBefore);
    popupContainer.appendChild(clone);
    popupContainer.insertAdjacentHTML('afterend', galleryArrowAfter);
    // add id of current gallery
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
  7.0 EVENT LISTENERS
==================================================================================*/

/* load all event listeners for blocks on load or after ajax
/------------------------*/
function runEventListeners(){

  /* Browser support - columns gap
  /------------------------*/
  var allColumnsContainer = document.querySelectorAll('.wp-block-columns');
  if(allColumnsContainer.length !== 0){
    Array.from(allColumnsContainer).forEach(function(columnsContainer) {
      // add columns children sum
      var allColumns = columnsContainer.querySelectorAll('.wp-block-column');
      if(allColumns.length !== 0){
        columnsContainer.setAttribute('data-columns', allColumns.length);
      }
      // has background gap
      if (columnsContainer.querySelectorAll(".wp-block-column.has-background").length > 0){
        columnsContainer.classList.add("is-style-columns-has-background-gap");
      }
    });
  }


  /* Toggle consent placeholder
  /------------------------*/
  var consentPlaceholder = document.querySelectorAll('.consent-request .dsgvo-placeholder');
  if(consentPlaceholder.length !== 0){
    Array.from(consentPlaceholder).forEach(function(placeholder) {
      placeholder.addEventListener('click', toggleBlock);
      placeholder.addEventListener('keypress', toggleBlock);
    });
  }


  /* Reset consent placeholder
  /------------------------*/
  function closeActiveConsentElement(e){
    const target = e.target;
    // main menu
    if (target.closest(".consent-request") == null) {
      var consentPlaceholder = document.querySelectorAll('.consent-request .dsgvo-placeholder');
      if(consentPlaceholder.length !== 0){
        Array.from(consentPlaceholder).forEach(function(placeholder) {
          placeholder.classList.remove('active');
        });
      }
    }
  }
  document.addEventListener('click', closeActiveConsentElement);


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

  /* Image pins
  /------------------------*/
  // add data-id to container
  var activeImageWithPins = document.querySelectorAll('.block-image-pins');
  if(activeImageWithPins.length > 0){
    Array.from(activeImageWithPins).forEach(function(container) {
      container.setAttribute('data-id', uniqueID());
    });
  }
  // info window
  var imgPinsInfoToggle = document.querySelectorAll('.block-image-pins .pins .block-image-pin > span');
  if(imgPinsInfoToggle.length !== 0){
    Array.from(imgPinsInfoToggle).forEach(function(element) {
      element.addEventListener('click', imagePinsToggle);
      element.addEventListener('keypress', imagePinsToggle);
      // update position
      if (element.nextElementSibling !== null) {
        checkChildPosition(element.closest('.pins'), element.nextElementSibling, "update", 10);
      }
    });
  }
  // info window close
  var imgPinsInfoToClose = document.querySelectorAll('.block-image-pins .pins .block-image-pin .pin-info .close');
  if(imgPinsInfoToClose.length !== 0){
    Array.from(imgPinsInfoToClose).forEach(function(element) {
      element.addEventListener('click', imgPinsInfoClose);
      element.addEventListener('keypress', imgPinsInfoClose);
    });
  }
  // load pins content
  var imgPinsToLoadContent = document.querySelectorAll('.block-image-pins .pins .block-image-pin [data-load="content"], .block-image-pins .pins .block-image-pin [data-load="parentcontent"]');
  if(imgPinsToLoadContent.length !== 0){
    Array.from(imgPinsToLoadContent).forEach(function(element) {
      element.addEventListener('click', imagePinsLoadContent);
      element.addEventListener('keypress', imagePinsLoadContent);
    });
  }


  /* Posts block
  /------------------------*/
  // load target content inside block
  var postsLoadContent = document.querySelectorAll('.block-posts li [data-load="content"]');
  if(postsLoadContent.length !== 0){
    Array.from(postsLoadContent).forEach(function(post) {
      post.addEventListener('click', loadPostsContent);
      post.addEventListener('keypress', loadPostsContent);
    });
  }
  // load first post content inside block
  var postsLoadContentTarget = document.querySelectorAll('.block-posts .posts-target .wp-block-group__inner-container');
  if(postsLoadContentTarget.length !== 0){
    Array.from(postsLoadContentTarget).forEach(function(target) {
      if(target.getAttribute('data-load') && target.getAttribute('data-load') == 'true'){
        var currentID = target.closest('.block-posts').querySelector('ul > li').getAttribute("data-id"),
        container = target.closest('.block-posts').getAttribute("data-id");
        target.setAttribute("data-load", "false");
        target.closest('.block-posts').querySelector('ul > li').classList.add('active');
        // run ajax function
        var config = {
          action: 'loadPageContent',
          targetContent: '.block-posts[data-id="' + container + '"] .posts-target .wp-block-group__inner-container',
          id: currentID
        };
        ajaxCall(config);
      }
    });
  }


  /* Open accordion on anchor link
  /------------------------*/
  var toggleAnchors = document.querySelectorAll('a[href^="#"]');
  if(toggleAnchors.length !== 0){
    Array.from(toggleAnchors).forEach(function(anchor) {
      anchor.addEventListener('click', openAccordionByAnchor);
      anchor.addEventListener('keypress', openAccordionByAnchor);
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

  /* close preview video
  /------------------------*/
  var vimeoPreviews = document.querySelectorAll('.block-vimeo > .video-container.video-preview');
  if(vimeoPreviews.length !== 0){
    // click to toggle
    Array.from(vimeoPreviews).forEach(function(video) {
      video.addEventListener('click', toggleBlock);
      video.addEventListener('keypress', toggleBlock);
    });
  }


  /* Video JS
  /------------------------*/
  var selectVideoBlocks = document.querySelectorAll('.wp-block-video.jvs-active');
  if(selectVideoBlocks.length !== 0){
    // click to toggle
    Array.from(selectVideoBlocks).forEach(function(videoblock) {
      runVideoJS(videoblock);
    });
  }


  /* Run theme-grid-swiper event listeners
  /------------------------*/
  allGalleryEventListeners();

}
// runEventListeners();
