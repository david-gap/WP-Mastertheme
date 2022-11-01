wp.blocks.registerBlockStyle( 'core/group', [{
  name: 'fullheight',
  label: 'Full height',
  isDefault: false,
},
{
  name: 'content-container',
  label: 'Content container',
  isDefault: false,
},{
  name: 'content-wide-container',
  label: 'Content wide container',
  isDefault: false,
}] );

wp.blocks.registerBlockStyle( 'core/cover', [{
  name: 'content-container',
  label: 'Content container',
  isDefault: false,
},{
  name: 'content-wide-container',
  label: 'Content wide container',
  isDefault: false,
},{
  name: 'no-spacing',
  label: 'Witout spacing',
  isDefault: false,
},{
  name: 'cover-zoomer',
  label: 'Zoom Animation',
  isDefault: false,
}] );

wp.blocks.registerBlockStyle( 'core/list', [{
  name: 'list-customizer',
  label: 'Customizer'
}] );

wp.blocks.registerBlockStyle( 'core/paragraph', [{
  name: 'lead',
  label: 'Lead'
}] );

wp.blocks.registerBlockStyle( 'core/heading', [{
  name: 'post-title',
  label: 'Seiten Titel',
  isDefault: false,
},{
  name: 'title-one',
  label: 'Title 1',
  isDefault: false,
},{
  name: 'title-two',
  label: 'Title 2',
  isDefault: false,
},{
  name: 'title-three',
  label: 'Title 3',
  isDefault: false,
},{
  name: 'title-four',
  label: 'Title 4',
  isDefault: false,
},{
  name: 'title-five',
  label: 'Title 5',
  isDefault: false,
}] );

wp.blocks.registerBlockStyle( 'core/post-title', [{
  name: 'post-title',
  label: 'Seiten Titel',
  isDefault: false,
},{
  name: 'title-one',
  label: 'Title 1',
  isDefault: false,
},{
  name: 'title-two',
  label: 'Title 2',
  isDefault: false,
},{
  name: 'title-three',
  label: 'Title 3',
  isDefault: false,
},{
  name: 'title-four',
  label: 'Title 4',
  isDefault: false,
},{
  name: 'title-five',
  label: 'Title 5',
  isDefault: false,
}] );

wp.blocks.registerBlockStyle( 'core/columns', [{
  name: 'columns-has-background-gap',
  label: 'Abstand wie mit Hintergrundfarbe'
}] );

wp.blocks.registerBlockStyle( 'core/buttons', [{
  name: 'buttons-absolute-top',
  label: 'Absolute to top'
},{
  name: 'buttons-absolute-bottom',
  label: 'Absolute to bottom'
},{
  name: 'buttons-absolute-right',
  label: 'Absolute to right'
},{
  name: 'buttons-absolute-left',
  label: 'Absolute to left'
}] );
