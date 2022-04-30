/*!
 * Swiper & Grid gallery with popup
 *
 * @author      David Voglgsang
 * @version     1.3
 *
 */


/*==================================================================================
  SETTINGS
==================================================================================*/

/* Global values
/------------------------*/
const galleryArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="60.043" height="113.137" viewBox="0 0 60.043 113.137"><path id="np_arrow_53562_FFFFFF" d="M30.457,114.121a3.473,3.473,0,0,1-4.912-4.912l50.635-50.64L25.545,7.929a3.475,3.475,0,0,1,4.917-4.912l53.089,53.1a3.476,3.476,0,0,1,0,4.917Z" transform="translate(84.57 115.138) rotate(180)" opacity="0.606"/></svg>',
      galleryArrowBefore = '<span class="arrow back hidden">' + galleryArrow + '</span>',
      galleryArrowAfter = '<span class="arrow next hidden">' + galleryArrow + '</span>';


/* Add ID to gallery
/------------------------*/
var activeGalleries = document.querySelectorAll('.gallery-swiper, .gallery-grid, .wp-block-gallery.add-popup');
if(activeGalleries.length > 0){
  Array.from(activeGalleries).forEach(function(gallery) {
    // open pop-up
    gallery.setAttribute('data-id', uniqueID());
  });
}



/*==================================================================================
  SWIPER
==================================================================================*/

/* Add navigation arrows
/------------------------*/
function addNavArrows(gallery){
  gallery.insertAdjacentHTML('afterbegin', galleryArrowBefore);
  gallery.insertAdjacentHTML('beforeend', galleryArrowAfter);
  var getcolumnssum    = gallery.closest(".gallery-swiper").getAttribute('data-columns'),
      columnssum       = getcolumnssum === null ? 1 : parseInt(getcolumnssum);
  // show next arrow if more elements exist
  if(gallery.classList.contains('wp-block-gallery-container')){
    var galleryChildren = gallery.querySelectorAll('figure figure');
  } else {
    var galleryChildren = gallery.querySelectorAll('ul li');
  }
  if (galleryChildren.length > 1 && columnssum < galleryChildren.length) {
    var arrowNext = gallery.querySelector('.next');
    arrowNext.classList.remove('hidden');
  }
  // add events to each arrow
  var arrows = document.querySelectorAll('.gallery-swiper .arrow');
  if(arrows.length > 0){
    Array.from(arrows).forEach(function(arrow) {
      arrow.addEventListener('click', clickArrow);
      arrow.addEventListener('keypress', clickArrow);
    });
  }
}


/* Click on arrow
/------------------------*/
function clickArrow(){
  // get values
  var parent           = this.closest(".gallery-swiper"),
      parentID         = parent.getAttribute('data-id'),
      getcolumnssum    = this.closest(".gallery-swiper").getAttribute('data-columns'),
      getcolumnspacing = this.closest(".gallery-swiper").getAttribute('data-columnspace'),
      arrowBack        = parent.querySelector('.back'),
      arrowNext        = parent.querySelector('.next');
  // get container
  if(parent.classList.contains('wp-block-gallery-container')){
    // define column spacing
    var container = document.querySelector('[data-id="' + parentID + '"] > figure');
    var getMarginRight = getStyle(container.children.[0], 'margin-right');
    getcolumnspacing = getMarginRight.replace(/\D/g,'');
    // define column sum
    if(container.classList.contains('columns-4')){
      var getcolumnssum = 4;
    } else if (container.classList.contains('columns-3')) {
      var getcolumnssum = 3;
    } else if (container.classList.contains('columns-2')) {
      var getcolumnssum = 2;
    } else if (container.classList.contains('columns-1')) {
      var getcolumnssum = 1;
    } else {
      var getcolumnssum = 1;
    }
  } else {
    var container = document.querySelector('[data-id="' + parentID + '"] > ul');
  }
  // do math
  var columnssum       = getcolumnssum === null ? 1 : parseInt(getcolumnssum),
      columnspacing    = getcolumnspacing === null ? 0 : parseInt(getcolumnspacing),
      totalWidth       = container.scrollWidth,
      stepSize         = container.children.[0].clientWidth + (isNaN(columnspacing) ? 0 : columnspacing),
      backStep         = container.scrollLeft - stepSize,
      nextStep         = container.scrollLeft + stepSize,
      maxRight         = totalWidth - (stepSize * columnssum);
      // noRight          = totalWidth - maxRight - stepSize;
  // move slider
  if (this.classList.contains('back')) {
    var offset = backStep;
  } else if (this.classList.contains('next')) {
    var offset = nextStep;
  }
  container.scroll({
    left: offset,
    behavior: 'smooth'
  })
  // toggle arrow visibility
  if(offset == 0 || offset < stepSize){
    arrowBack.classList.add('hidden');
  } else {
    arrowBack.classList.remove('hidden');
  }
  if(offset == maxRight || offset > maxRight){
    arrowNext.classList.add('hidden');
  } else {
    arrowNext.classList.remove('hidden');
  }
  // debug
  // console.log("total width: " + totalWidth);
  // console.log("columns: " + columnssum);
  // console.log("columns spacing: " + columnspacing);
  // console.log("child size: " + container.children.[0].clientWidth);
  // console.log("step size: " + stepSize);
  // console.log("offset: " + offset);
  // console.log("max right: " + maxRight);
}


/* Check for active swipers
/------------------------*/
var activeSwipers = document.querySelectorAll('.gallery-swiper');
if(activeSwipers.length > 0){
  Array.from(activeSwipers).forEach(function(swiper) {
    // add arrows to dom
    addNavArrows(swiper);
  });
}



/*==================================================================================
POP-UP
==================================================================================*/

/* Check arrows
/------------------------*/
function checkImgArrows(imgParent){
  var popupArrowBack = document.querySelector('.popup > .popup-container > .back');
  var popupArrowNext = document.querySelector('.popup > .popup-container > .next');
  // back
  if (imgParent.previousElementSibling === null) {
    popupArrowBack.classList.add('hidden');
  } else {
    popupArrowBack.classList.remove('hidden');
  }
  // next
  if (imgParent.nextElementSibling === null) {
    popupArrowNext.classList.add('hidden');
  } else {
    popupArrowNext.classList.remove('hidden');
  }
}


/* Get next image
/------------------------*/
function getNextImg(){
  // get current img
  var currentPopUp = document.querySelector('.popup > .popup-container > .popup-content'),
      currentPopUpID = currentPopUp.getAttribute('data-id'),
      currentImg = document.querySelector('.popup > .popup-container > .popup-content > img, .popup > .popup-container > .popup-content > audio, .popup > .popup-container > .popup-content > video'),
      currentImgID = currentImg.getAttribute('data-id'),
      currentImgParent = document.querySelector('[data-id="' + currentPopUpID + '"]');

  if(currentImgParent.classList.contains('wp-block-gallery')){
    var imgInGallery = document.querySelector('[data-id="' + currentPopUpID + '"] figure img[data-id="' + currentImgID + '"]'),
        imgInGalleryParent = imgInGallery.closest('figure');
  } else {
    var imgInGallery = document.querySelector('[data-id="' + currentPopUpID + '"] li[data-id="' + currentImgID + '"] figure'),
        imgInGalleryParent = imgInGallery.closest('li');
  }
  // get next img
  if(this.classList.contains('next')){
    var newImgParent = imgInGalleryParent.nextElementSibling;
  } else if (this.classList.contains('back')) {
    var newImgParent = imgInGalleryParent.previousElementSibling;
  }
  var newImg = newImgParent.querySelector('img, audio, video');
  document.querySelector('.popup > .popup-container > .popup-content').innerHTML = '';
  document.querySelector('.popup > .popup-container > .popup-content').appendChild(newImg.cloneNode());
  // update arrows
  checkImgArrows(newImgParent);
  // update preview images
  if(currentImgParent.classList.contains('popup-preview')){
    if(currentImgParent.classList.contains('wp-block-gallery')){
      var newImgID = newImgParent.querySelector('img').getAttribute('data-id');
    } else {
      var newImgID = newImgParent.getAttribute('data-id');
    }
    PreviewImages(newImgID, currentPopUpID);
  }
}


/* Get preview images
/------------------------*/
function PreviewImages(imgID, galleryID){
  var gallery = document.querySelector('[data-id="' + galleryID + '"]');
  // get images
  if(gallery.classList.contains('wp-block-gallery')){
    var currentImg = gallery.querySelector('figure img[data-id="' + imgID + '"]'),
        imgInGalleryParent = currentImg.closest('figure');
  } else {
    var currentImg = gallery.querySelector('li[data-id="' + imgID + '"] figure'),
        imgInGalleryParent = currentImg.closest('li');
  }
  var nextImg = imgInGalleryParent.nextElementSibling;
  var prevImg = imgInGalleryParent.previousElementSibling;
  // preview containers
  var popupNextPreview = document.querySelector('.popup > .popup-next-preview');
  var popupBackPreview = document.querySelector('.popup > .popup-back-preview');
  // reset preview
  if(popupNextPreview){
    // reset next preview image
    document.querySelector('.popup > .popup-next-preview').innerHTML = '';
    // insert next preview image
    if (nextImg !== null) {
      document.querySelector('.popup > .popup-next-preview').appendChild(nextImg.querySelector('img, audio, video').cloneNode());
    }
  }
  if(popupBackPreview){
    // reset back preview image
    document.querySelector('.popup > .popup-back-preview').innerHTML = '';
    // insert back preview image
    if (prevImg !== null) {
      document.querySelector('.popup > .popup-back-preview').appendChild(prevImg.querySelector('img, audio, video').cloneNode());
    }
  }
}


/* Create
/------------------------*/
function loadGalleryPopUp(){
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
    if(currentGallery.classList.contains('popup-preview')){
      // insert container for preview images
      document.querySelector('.popup').insertAdjacentHTML('afterbegin', '<div class="popup-back-preview"></div>');
      document.querySelector('.popup').insertAdjacentHTML('beforeend', '<div class="popup-next-preview"></div>');
      // define popup to be with preview
      document.querySelector('.popup > .popup-container').classList.add('popup-preview');
      // get preview images
      if(currentGallery.classList.contains('wp-block-gallery')){
        var imgID = self.getAttribute('data-id');
      } else {
        var imgID = self.closest('li').getAttribute('data-id');
      }
      PreviewImages(imgID, currentGallery.getAttribute('data-id'));
    }
    // check popup arrows
    if(currentGallery.classList.contains('wp-block-gallery')){
      var parentLi = self.closest('figure');
    } else {
      var parentLi = self.closest('li');
    }
    checkImgArrows(parentLi);
    // event for arrows
    var arrows = document.querySelectorAll('.popup > .popup-container > .arrow');
    if(arrows.length > 0){
      Array.from(arrows).forEach(function(arrow) {
        arrow.addEventListener('click', getNextImg);
        arrow.addEventListener('keypress', getNextImg);
      });
    }
  }, 100, this);
}


/* Check for active swipers/grid without url
/------------------------*/
var activeGalleryPopUps = document.querySelectorAll('.add-popup figure > img');
if(activeGalleryPopUps.length > 0){
  Array.from(activeGalleryPopUps).forEach(function(popup) {
    // open pop-up
    popup.addEventListener('click', loadGalleryPopUp);
    popup.addEventListener('keypress', loadGalleryPopUp);
  });
}
