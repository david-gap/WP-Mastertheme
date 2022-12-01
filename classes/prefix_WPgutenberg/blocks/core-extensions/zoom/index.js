
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
  const allowedBlocks = [ 'core/image', 'templates/image-pins' ];


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
        zoomActive,
        zoomMax,
        zoomSteps,
        zoomPosition
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
