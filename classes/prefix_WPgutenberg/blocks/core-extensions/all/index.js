/**
 * Internal block libraries
*/
import classnames from 'classnames';
import attributes from "./attributes";
import Inspector from "./inspector";

const { __ } = wp.i18n;
const { addFilter } = wp.hooks;
const { Fragment }	= wp.element;
const { createHigherOrderComponent } = wp.compose;


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


// Add custom element class in save element
function applyExtraClass( extraProps, blockType, attributes ) {
  const { hideOnDesktop, hideOnMobile } = attributes;
  if ( typeof hideOnDesktop !== 'undefined' && hideOnDesktop ) {
    extraProps.className = classnames( extraProps.className, 'mobile' );
  }
  if ( typeof hideOnMobile !== 'undefined' && hideOnMobile ) {
    extraProps.className = classnames( extraProps.className, 'desktop' );
  }
  return extraProps;
}

// add filters
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
