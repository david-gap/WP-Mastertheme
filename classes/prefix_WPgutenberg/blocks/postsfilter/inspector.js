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
        postTaxonomyFilterOptions,
        postTaxonomyPreFilter
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
      { value: "title", label: __( 'Title', 'devTheme' ) },
      { value: "date", label: __( 'Date', 'devTheme' ) },
      { value: "excerpt", label: __( 'Excerpt', 'devTheme' ) }
    ];
    const query = {
      'status': 'publish',
      'per_page': 1,
      'order': postSortDirection
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
    // sort options
    let postSortOptions = [
      { value: "menu_order", label: __( 'Menu order', 'devTheme' ) },
      { value: "date", label: __( 'Date', 'devTheme' ) },
      { value: "title", label: __( 'Title', 'devTheme' ) }
    ];
    if(posts && posts.length > 0){
      if(posts[0].meta !== undefined){
        Object.entries(posts[0].meta).forEach(([key, value]) => {
          postSortOptions.push( { value: key, label: "Meta: " + key } );
        });
      }
      // if(posts[0]._links["wp:term"] !== undefined){
      //   const terms = posts[0]._links["wp:term"];
      //   Object.entries(terms).forEach(([key, value]) => {
      //     if(value.taxonomy == "post_tag"){
      //       postSortOptions.push( { value: 'tax__post_tag', label: "Taxonomy: Tags" } );
      //     } else {
      //       postSortOptions.push( { value: 'tax__' + value.taxonomy, label: "Taxonomy: " + value.taxonomy } );
      //     }
      //   });
      // }
    }
    // update taxonomy filter
    let postTaxonomies = [];
    let currentTaxVal;
    if(posts && posts.length > 0){
      if(posts[0]._links["wp:term"] !== undefined){
        const terms = posts[0]._links["wp:term"];
        Object.entries(terms).forEach(([key, value]) => {
          // get taxonomies
          const getTaxvalues = select( 'core' ).getEntityRecords( 'taxonomy', value.taxonomy, { per_page: -1 } );
          let sectionOptions = [];
          let selectedOptions = [];
          if(getTaxvalues){
            if(value.taxonomy == "post_tag"){
              var cleanTax = 'tags';
            } else if(value.taxonomy == "category") {
              var cleanTax = 'categories';
            } else {
              var cleanTax = value.taxonomy;
            }
            // set selection options
            sectionOptions = getTaxvalues.map( ( tax ) => tax.name );
            // insert selection
            if(postTaxonomyPreFilter && postTaxonomyPreFilter.length >= 1){
              selectedOptions[cleanTax] = postTaxonomyPreFilter.map( ( taxID ) => {
                var stringToArray = taxID.split("-");
                if(cleanTax == stringToArray[0]){
                  let wantedPost = getTaxvalues.find( ( tax ) => {
                    return tax.id === parseInt(stringToArray[1]);
                  } );
                  if ( wantedPost === undefined || ! wantedPost ) {
                    return false;
                  }
                  return wantedPost.name;
                } else {
                  return false;
                }
              } );
            }
            if(selectedOptions[cleanTax] && selectedOptions[cleanTax].length >= 1){
              var theSelectedOptions = selectedOptions[cleanTax].filter(Boolean);
            } else {
              var theSelectedOptions = [];
            }
            postTaxonomies.push( { name: cleanTax, value: value.taxonomy, options: sectionOptions, query: getTaxvalues, values: theSelectedOptions } );
          }
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
      { value: "legend", label: __( 'Show taxonomy legend', 'devTheme' ) },
      { value: "hirarchical", label: __( 'Hirarchical taxonomies', 'devTheme' ) },
      { value: "emptytax", label: __( 'Show empty taxonomies', 'devTheme' ) },
      { value: "link_img", label: __( 'Link image', 'devTheme' ) },
      { value: "link_row1", label: __( 'Link row 1', 'devTheme' ) },
      { value: "link_row2", label: __( 'Link row 2', 'devTheme' ) },
      { value: "link_box", label: __( 'Link box', 'devTheme' ) }
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
          <PanelBody title={ __( 'Posts query', 'devTheme' ) } >
            <PanelRow>
              <SelectControl
                label={__("Post type", "devTheme")}
                value={postType}
                options={postTypes}
                onChange={postType => setAttributes({ postType })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Sort by", "devTheme")}
                value={postSortBy}
                options={postSortOptions}
                onChange={postSortBy => setAttributes({ postSortBy })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Sort direction", "devTheme")}
                value={postSortDirection}
                options={[
                  { value: "asc", label: __( 'ASC', 'devTheme' ) },
                  { value: "desc", label: __( 'DESC', 'devTheme' ) }
                ]}
                onChange={postSortDirection => setAttributes({ postSortDirection })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Relation", "devTheme")}
                value={postTaxonomyFilterRelation}
                options={[
                  { value: "AND", label: __( 'AND', 'devTheme' ) },
                  { value: "OR", label: __( 'OR', 'devTheme' ) }
                ]}
                onChange={postTaxonomyFilterRelation => setAttributes({ postTaxonomyFilterRelation })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Text row 1", "devTheme")}
                value={postTextOne}
                options={fieldSelection}
                onChange={postTextOne => setAttributes({ postTextOne })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Text row 2", "devTheme")}
                value={postTextTwo}
                options={fieldSelection}
                onChange={postTextTwo => setAttributes({ postTextTwo })}
              />
            </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Layout', 'devTheme' ) } >
            <PanelRow>
              <SelectControl
                label={__("Filter position", "devTheme")}
                value={postFilterPosition}
                options={[
                  { value: "top", label: __( 'Top', 'devTheme' ) },
                  { value: "left", label: __( 'Left', 'devTheme' ) },
                  { value: "right", label: __( 'Right', 'devTheme' ) }
                ]}
                onChange={postFilterPosition => setAttributes({ postFilterPosition })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Template", "devTheme")}
                value={postListTemplate}
                options={[
                  { value: "grid", label: __( 'Grid', 'devTheme' ) },
                  { value: "list", label: __( 'List', 'devTheme' ) }
                ]}
                onChange={postListTemplate => setAttributes({ postListTemplate })}
              />
            </PanelRow>
            <PanelRow>
              <RangeControl
                label={__("Column sum", "devTheme")}
                value={postColumns}
                onChange={postColumns => setAttributes({ postColumns })}
                min={1}
                max={10}
              />
            </PanelRow>
            <PanelRow>
              <RangeControl
                label={__("Column spacing", "devTheme")}
                value={postColumnsSpace}
                onChange={postColumnsSpace => setAttributes({ postColumnsSpace })}
                min={1}
                max={100}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-thumb"
                  label={ __( 'Show thumbnails', 'devTheme' ) }
                  checked={ postThumb }
                  onChange={postThumb => setAttributes({ postThumb })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-textsearch"
                  label={ __( 'Show Textsearch', 'devTheme' ) }
                  checked={ postTextSearch }
                  onChange={postTextSearch => setAttributes({ postTextSearch })}
              />
            </PanelRow>
            <PanelRow>
              <div>
                <label><strong>{ __( 'Filteroptions', 'devTheme' ) }</strong></label>
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
                <label><strong>{ __( 'Show', 'devTheme' ) }</strong></label>
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
          <PanelBody title={ __( 'Pre filter', 'devTheme' ) } >
            <PanelRow>
              <div>
                { postTaxonomies.map(
                  (taxonomy, setState) => {
                  return(
                    <PanelRow>
                      <FormTokenField
                        label={taxonomy.name}
                        value={ taxonomy.values }
                        suggestions={ taxonomy.options }
                        maxSuggestions={ 20 }
                        onFocus= { ( index ) => {
                          currentTaxVal = postTaxonomyPreFilter;
                        } }
                        onChange={ ( postTaxonomyPreFilter ) => {
                          // build array of selected posts from other taxonomies
                          let postTaxFilterArray = [];
                          if(currentTaxVal && currentTaxVal.length >= 1){
                            // query.concat(props.attributes.postTaxonomyPreFilter);
                            currentTaxVal.forEach(function(allTaxSelections) {
                              var stringToArray = allTaxSelections.split("-");
                              if( stringToArray[0] !== taxonomy.name ) {
                                postTaxFilterArray.push( allTaxSelections );
                              }
                            });
                          }
                          // add to selection from current taxonomy
                          postTaxonomyPreFilter.map(
                            ( taxSelection ) => {
                              const matchingTax = taxonomy.query.find( ( tax ) => {
                                return tax.name === taxSelection;
                              } );
                              if ( matchingTax !== undefined ) {
                                postTaxFilterArray.push( taxonomy.name + "-" + matchingTax.id );
                              }
                            }
                          )
                          setAttributes( { postTaxonomyPreFilter: postTaxFilterArray } );
                        } }
                      />
                    </PanelRow>
                  );
                }) }
              </div>
            </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
