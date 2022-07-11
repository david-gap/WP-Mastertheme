
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


  /* add attributes to each block
  /------------------------*/
  function addAttributes( settings ) {
    settings.attributes = Object.assign( settings.attributes, attributes);
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
        hideOnDesktop,
        hideOnMobile,
        disabledValue,
        removeSpacing,
        additionalSpacingOne,
        additionalSpacingTwo,
      } = attributes;
      return (
        <Fragment>
          <BlockEdit {...props} />
          { isSelected &&
            <Inspector {...{ setAttributes, ...props }} />
          }
        </Fragment>
      );
    };
  }, 'withAdvancedControls');


  /* add custom element class in save element
  /------------------------*/
  function applyExtraClass( extraProps, blockType, attributes ) {
    const { hideOnDesktop, hideOnMobile, removeSpacing, additionalSpacingOne, additionalSpacingTwo } = attributes;
    if ( typeof hideOnDesktop !== 'undefined' && hideOnDesktop ) {
      extraProps.className = classnames( extraProps.className, 'mobile' );
    }
    if ( typeof hideOnMobile !== 'undefined' && hideOnMobile ) {
      extraProps.className = classnames( extraProps.className, 'desktop' );
    }
    if ( typeof removeSpacing !== 'undefined' && removeSpacing ) {
      extraProps.className = classnames( extraProps.className, 'no-spacing' );
    }
    if ( typeof additionalSpacingOne !== 'undefined' && additionalSpacingOne ) {
      extraProps.className = classnames( extraProps.className, 'spacing-one' );
    }
    if ( typeof additionalSpacingTwo !== 'undefined' && additionalSpacingTwo ) {
      extraProps.className = classnames( extraProps.className, 'spacing-two' );
    }
    return extraProps;
  }


  /* add data values
  /------------------------*/
  function addDataValues(BlockListBlock) {
    return props => {
      const { block } = props;

      return (
        <BlockListBlock {...props} wrapperProps={{
          'data-disabled': props.attributes.disabledValue,
          'data-ismobile': props.attributes.hideOnDesktop,
          'data-isdesktop': props.attributes.hideOnMobile,
          'data-marginBottom': props.attributes.removeSpacing,
          'data-spacingOne': props.attributes.additionalSpacingOne,
          'data-spacingTwo': props.attributes.additionalSpacingTwo,
          'data-swiper': props.attributes.addSwiper,
          'data-popup': props.attributes.addPopUp,
          'data-popuppreview': props.attributes.addPopUpPreview
        }} />
      );
    };
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
    'editor.BlockListBlock',
    'template/addDataValues',
    addDataValues
  );
