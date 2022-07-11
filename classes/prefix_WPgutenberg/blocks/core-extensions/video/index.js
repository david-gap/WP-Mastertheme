
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
  const allowedBlocks = [ 'core/video' ];


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
        videoJS,
        playCentered,
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
  function applyVideoExtraClass( extraProps, blockType, attributes ) {
    const { videoJS, playCentered } = attributes;
    var addCss = '';
    if ( typeof videoJS !== 'undefined' && videoJS ) {
      addCss += ' jvs-active';
    }
    if ( typeof playCentered !== 'undefined' && playCentered ) {
      addCss += ' jvs-bigplay-centered';
    }
    extraProps.className = classnames( extraProps.className, addCss );
    return extraProps;
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
    applyVideoExtraClass
  );
