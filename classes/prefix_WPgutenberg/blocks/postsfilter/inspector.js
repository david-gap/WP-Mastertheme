/**
 * Internal block libraries
*/
const { __ } = wp.i18n;
const { Component, useState } = wp.element;
const { registerBlockType } = wp.blocks;
const { select, withSelect, setState } = wp.data;
const {withState} = wp.compose;
const {
  ColorPalette,
  PanelColorSettings,
  ContrastChecker
} = wp.editor;

const {
  InspectorControls
} = wp.blockEditor;

const {
  CheckboxControl,
  FormTokenField,
  PanelBody,
  PanelRow,
  RadioControl,
  RangeControl,
  TextControl,
  TextareaControl,
  ToggleControl,
  SelectControl
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component
*/
export default class Inspector extends Component {
  constructor() {
    super(...arguments);
  }
  render() {
    const {
      attributes: {
        anchor,
        postType,
        postSortBy,
        postSortDirection,
        postTaxonomyFilterRelation,
        postTextOne,
        postTextTwo,
        postFilterPosition,
        postListTemplate,
        postColumns,
        postColumnsSpace,
        postThumb,
        postTextSearch,
        postTaxonomyFilter,
        postTaxonomyFilterOptions
      },
      setAttributes
    } = this.props;

    // update post type selection options
    let postTypes = [];
    const getposttypes = select('core').getPostTypes();
    if(getposttypes){
      getposttypes.forEach( type => {
        if(type.slug !== "attachment" && type.slug !== "wp_block"){
          postTypes.push( { value: type.slug, label: type.labels.name } );
        }
      });
    }
    // update text selection options
    let fieldSelection = [
      { value: "", label: "-" },
      { value: "title", label: "title" },
      { value: "date", label: "date" },
      { value: "excerpt", label: "excerpt" }
    ];
    const query = {
      'status': 'publish',
      'per_page': 1,
      'order': postSortDirection,
      'orderby': postSortBy
    };
    const posts = select( 'core' ).getEntityRecords( 'postType', postType, query );
    if(posts && posts.length > 0){
      if(posts[0].meta !== undefined){
        Object.entries(posts[0].meta).forEach(([key, value]) => {
          fieldSelection.push( { value: key, label: "Meta: " + key } );
        });
      }
      if(posts[0]._links["wp:term"] !== undefined){
        const terms = posts[0]._links["wp:term"];
        Object.entries(terms).forEach(([key, value]) => {
          if(value.taxonomy == "post_tag"){
            fieldSelection.push( { value: 'tax__post_tag', label: "Taxonomy: Tags" } );
          } else {
            fieldSelection.push( { value: 'tax__' + value.taxonomy, label: "Taxonomy: " + value.taxonomy } );
          }
        });
      }
    }
    // update taxonomy filter
    let postTaxonomies = [];
    if(posts && posts.length > 0){
      if(posts[0]._links["wp:term"] !== undefined){
        const terms = posts[0]._links["wp:term"];
        Object.entries(terms).forEach(([key, value]) => {
          // get taxonomies
          if(value.taxonomy == "post_tag"){
            var cleanTax = 'tags';
          } else if(value.taxonomy == "category") {
            var cleanTax = 'categories';
          } else {
            var cleanTax = value.taxonomy;
          }
          postTaxonomies.push( { name: cleanTax, value: value.taxonomy } );
        });
      }
    }
    // taxonomies checking functions
    function checkFilter(name){
      if (postTaxonomyFilter && postTaxonomyFilter.length >= 1 && postTaxonomyFilter.includes(name)) {
        return true;
      } else {
        return false;
      }
    };
    const onchangeFilter = (check) => {
      const value = window.event.target.defaultValue;
      const newSelection = [];
      if (postTaxonomyFilter && postTaxonomyFilter.length >= 1) {
        postTaxonomyFilter.forEach(function(element) {
            newSelection.push(element);
        });
      }
      if(check){
        newSelection.push(value);
      } else {
        var index = newSelection.indexOf(value);
        newSelection.splice(index, 1);
      }
      setAttributes({ postTaxonomyFilter: newSelection });
    };
    // options
    const postOptions = [
      { value: "legend", label: "Show legend" },
      { value: "hirarchical", label: "Hirarchical taxonomies" },
      { value: "emptytax", label: "Show empty taxonomies" },
      { value: "link_img", label: "Link image" },
      { value: "link_row1", label: "Link row 1" },
      { value: "link_row2", label: "Link row 2" },
      { value: "link_box", label: "Link box" }
    ]
    function checkOptions(name){
      if (postTaxonomyFilterOptions && postTaxonomyFilterOptions.length >= 1 && postTaxonomyFilterOptions.includes(name)) {
        return true;
      } else {
        return false;
      }
    };
    const onchangeOptions = (check) => {
      const value = window.event.target.defaultValue;
      const newSelection = [];
      if (postTaxonomyFilterOptions && postTaxonomyFilterOptions.length >= 1) {
        postTaxonomyFilterOptions.forEach(function(element) {
            newSelection.push(element);
        });
      }
      if(check){
        newSelection.push(value);
      } else {
        var index = newSelection.indexOf(value);
        newSelection.splice(index, 1);
      }
      setAttributes({ postTaxonomyFilterOptions: newSelection });
    };

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Posts query', 'WPgutenberg' ) } >
            <PanelRow>
              <SelectControl
                label={__("Post type", "WPgutenberg")}
                value={postType}
                options={postTypes}
                onChange={postType => setAttributes({ postType })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Sort by", "WPgutenberg")}
                value={postSortBy}
                options={[
                  { value: "date", label: "Date" },
                  { value: "title", label: "Title" }
                ]}
                onChange={postSortBy => setAttributes({ postSortBy })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Sort direction", "WPgutenberg")}
                value={postSortDirection}
                options={[
                  { value: "desc", label: "DESC" },
                  { value: "asc", label: "ASC" }
                ]}
                onChange={postSortDirection => setAttributes({ postSortDirection })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Relation", "WPgutenberg")}
                value={postTaxonomyFilterRelation}
                options={[
                  { value: "AND", label: "AND" },
                  { value: "OR", label: "OR" }
                ]}
                onChange={postTaxonomyFilterRelation => setAttributes({ postTaxonomyFilterRelation })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Text row 1", "WPgutenberg")}
                value={postTextOne}
                options={fieldSelection}
                onChange={postTextOne => setAttributes({ postTextOne })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Text row 2", "WPgutenberg")}
                value={postTextTwo}
                options={fieldSelection}
                onChange={postTextTwo => setAttributes({ postTextTwo })}
              />
            </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Layout', 'WPgutenberg' ) } >
            <PanelRow>
              <SelectControl
                label={__("Filter position", "WPgutenberg")}
                value={postFilterPosition}
                options={[
                  { value: "top", label: "Top" },
                  { value: "left", label: "Left" },
                  { value: "right", label: "Right" }
                ]}
                onChange={postFilterPosition => setAttributes({ postFilterPosition })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Template", "WPgutenberg")}
                value={postListTemplate}
                options={[
                  { value: "grid", label: "Grid" },
                  { value: "list", label: "List" }
                ]}
                onChange={postListTemplate => setAttributes({ postListTemplate })}
              />
            </PanelRow>
            <PanelRow>
              <RangeControl
                label={__("Column sum", "WPgutenberg")}
                value={postColumns}
                onChange={postColumns => setAttributes({ postColumns })}
                min={1}
                max={10}
              />
            </PanelRow>
            <PanelRow>
              <RangeControl
                label={__("Column spacing", "WPgutenberg")}
                value={postColumnsSpace}
                onChange={postColumnsSpace => setAttributes({ postColumnsSpace })}
                min={1}
                max={100}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-thumb"
                  label={ __( 'Show thumbnails', 'WPgutenberg' ) }
                  checked={ postThumb }
                  onChange={postThumb => setAttributes({ postThumb })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-textsearch"
                  label={ __( 'Show Textsearch', 'WPgutenberg' ) }
                  checked={ postTextSearch }
                  onChange={postTextSearch => setAttributes({ postTextSearch })}
              />
            </PanelRow>
            <PanelRow>
              <div>
                <label><strong>{ __( 'Filteroptions', 'WPgutenberg' ) }</strong></label>
                  <ul>
                { postTaxonomies.map(
                  (taxonomy, setState) => {
                  return(
                    <li>
                      <CheckboxControl
                        label={taxonomy.name}
                        key={taxonomy.value}
                        value={taxonomy.value}
                        name='getPostTaxonomyFilter[]'
                        checked={ checkFilter(taxonomy.value) }
                        onChange={ onchangeFilter }
                      />
                    </li>
                  );
                }) }
                </ul>
              </div>
            </PanelRow>
            <PanelRow>
              <div>
                <label><strong>{ __( 'Show', 'WPgutenberg' ) }</strong></label>
                  <ul>
                { postOptions.map(
                  (options, setState) => {
                  return(
                    <li>
                      <CheckboxControl
                        label={options.label}
                        key={options.value}
                        value={options.value}
                        name='getpostTaxonomyFilterOptions[]'
                        checked={ checkOptions(options.value) }
                        onChange={ onchangeOptions }
                      />
                    </li>
                  );
                }) }
                </ul>
              </div>
            </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
