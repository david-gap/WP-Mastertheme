
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
  const { createHigherOrderComponent, withState } = wp.compose;
  const { select, withSelect, setState, useSelect, useDispatch } = wp.data;
  const {
    ColorPalette,
    PanelColorSettings,
    ContrastChecker
  } = wp.editor;

  const {
    MediaUploadCheck,
    MediaUpload
  } = wp.blockEditor;

  const {
    CheckboxControl,
    PanelBody,
    PanelRow,
    RadioControl,
    RangeControl,
    TextControl,
    TextareaControl,
    ToggleControl,
    SelectControl,
    DateTimePicker,
    ResponsiveWrapper,
    Button,
    Spinner
  } = wp.components;



/*==================================================================================
  BLOCKS
==================================================================================*/

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
        dsgvoImgId,
        dsgvoImageURL,
        dsgvoCookie
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
    const { hideOnDesktop, hideOnMobile, removeSpacing, additionalSpacingOne, additionalSpacingTwo, dsgvoCookie } = attributes;
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
    if ( typeof dsgvoCookie !== 'undefined' && dsgvoCookie ) {
      extraProps.className = classnames( extraProps.className, dsgvoCookie );
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
