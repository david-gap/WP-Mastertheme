
/*==================================================================================
  SETTINGS
==================================================================================*/

  /* import needed files and constant
  /------------------------*/
  import classnames from 'classnames';
  import attributes from "./attributes";
  import Inspector from "./inspector";

  const { __ } = wp.i18n;
  const { addFilter } = wp.hooks;
  const { Fragment }	= wp.element;
  const { createHigherOrderComponent } = wp.compose;


  /* restrict to specific block names
  /------------------------*/
  const allowedBlocks = [ 'core/gallery' ];


  /* add attributes to each block
  /------------------------*/
  function addAttributes( settings ) {
    if( allowedBlocks.includes( settings.name ) ){
      settings.attributes = Object.assign( settings.attributes, attributes);
    }
    return settings;
  }

  const withAdvancedControls = createHigherOrderComponent( ( BlockEdit ) => {
    return ( props ) => {
      const {
        name,
        attributes,
        setAttributes,
        isSelected,
      } = props;
      const {
        addSwiper,
        addBulletNav,
        addPopUp,
        addPopUpPreview,
        addDownloadButton,
        addDownloadAllButton,
      } = attributes;
      return (
        <Fragment>
          <BlockEdit {...props} />
          { isSelected && allowedBlocks.includes( name ) &&
            <Inspector {...{ setAttributes, ...props }} />
          }
        </Fragment>
      );
    };
  }, 'withAdvancedControls');


  /* add custom element class in save element
  /------------------------*/
  function applyExtraClass( extraProps, blockType, attributes ) {
    const { addSwiper, addPopUp, addPopUpPreview } = attributes;
    if ( typeof addSwiper !== 'undefined' && addSwiper && allowedBlocks.includes( blockType.name ) ) {
      extraProps.className = classnames( extraProps.className, 'inside-gallery-swiper' );
    }
    if ( typeof addPopUp !== 'undefined' && addPopUp && allowedBlocks.includes( blockType.name ) ) {
      extraProps.className = classnames( extraProps.className, 'add-popup' );
    }
    if ( typeof addPopUpPreview !== 'undefined' && addPopUpPreview && allowedBlocks.includes( blockType.name ) ) {
      extraProps.className = classnames( extraProps.className, 'popup-preview' );
    }
    return extraProps;
  }


  /* add a div container
  /------------------------*/
  function galleryModifyGetSaveContentExtraProps( element, blockType, attributes ) {
    const { addSwiper, addBulletNav, addPopUp, addPopUpPreview, align } = attributes;
    if (typeof addSwiper !== 'undefined' && addSwiper && allowedBlocks.includes(blockType.name)) {
      if(align == 'wide' || align == 'full'){
        var addCss = 'align' + align;
      } else {
        var addCss = '';
      }
      if ( typeof addBulletNav !== 'undefined' && addBulletNav ) {
        var addCss = addCss + ' bullet-nav';
      }
      return (
        <div className={classnames(
          'wp-block-gallery-container gallery-swiper', addCss
        )} >
          { element }
        </div>
      );
    } else {
      return element;
    }
  }


  /* add filters
  /------------------------*/
  addFilter(
    'blocks.registerBlockType',
    'template/custom-attributes',
    addAttributes
  );
  addFilter(
    'editor.BlockEdit',
    'template/custom-advanced-control',
    withAdvancedControls
  );
  addFilter(
    'blocks.getSaveContent.extraProps',
    'template/applyExtraClass',
    applyExtraClass
  );
  addFilter(
    'blocks.getSaveElement',
    'template/modify-get-save-content-extra-props',
    galleryModifyGetSaveContentExtraProps
  );
