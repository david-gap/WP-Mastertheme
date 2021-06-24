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
  SelectControl,
  MyFormTokenField
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
        postType,
        postSum,
        postSortDirection,
        postSortBy,
        postTextOne,
        postTextTwo,
        postColumns,
        postThumb,
        postSwiper,
        postPopUp,
        postPopUpNav,
        postColumnsSpace,
        postTaxonomyFilter,
        postTaxonomyFilterRelation,
        postTaxonomyFilterOptions,
        postIdFilter
      },
      setAttributes
    } = this.props;

    // update text selection options
    let fieldSelection = [
      { value: "", label: "-" },
      { value: "title", label: __( 'Title', 'WPgutenberg' ) },
      { value: "date", label: __( 'Date', 'WPgutenberg' ) },
      { value: "excerpt", label: __( 'Excerpt', 'WPgutenberg' ) }
    ];
    const query = {
      'status': 'publish',
      'per_page': -1,
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
    // post id selection
    let postNames = [];
    let postsFieldValue = [];
    if ( posts !== null ) {
      postNames = posts.map( ( post ) => post.title.raw );
      if(postIdFilter){
        postsFieldValue = postIdFilter.map( ( postId ) => {
          let wantedPost = posts.find( ( post ) => {
            return post.id === postId;
          } );
          if ( wantedPost === undefined || ! wantedPost ) {
            return false;
          }
          return wantedPost.title.raw;
        } );
      }
    }
    // update taxonomy filter
    let postTaxonomies = [];
    if(posts && posts.length > 0){
      if(posts[0]._links["wp:term"] !== undefined){
        const terms = posts[0]._links["wp:term"];
        Object.entries(terms).forEach(([key, value]) => {
          // get taxonomies
          const getTaxvalues = select( 'core' ).getEntityRecords( 'taxonomy', value.taxonomy );
          if(getTaxvalues){
            if(value.taxonomy == "post_tag"){
              var cleanTax = 'tags';
            } else if(value.taxonomy == "category") {
              var cleanTax = 'categories';
            } else {
              var cleanTax = value.taxonomy;
            }
            postTaxonomies.push( { name: cleanTax, values: getTaxvalues } );
          }
        });
      }
    }
    // options
    const postOptions = [
      { value: "link_img", label: __( 'Link image', 'WPgutenberg' ) },
      { value: "link_row1", label: __( 'Link row 1', 'WPgutenberg' ) },
      { value: "link_row2", label: __( 'Link row 2', 'WPgutenberg' ) },
      { value: "link_box", label: __( 'Link box', 'WPgutenberg' ) }
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
    // taxonomy check
    function checkFilter(id){
      if (postTaxonomyFilter && postTaxonomyFilter.length >= 1 && postTaxonomyFilter.includes(id)) {
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
                  { value: "menu_order", label: __( 'Menu order', 'WPgutenberg' ) },
                  { value: "date", label: __( 'Date', 'WPgutenberg' ) },
                  { value: "title", label: __( 'Title', 'WPgutenberg' ) }
                ]}
                onChange={postSortBy => setAttributes({ postSortBy })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Sort direction", "WPgutenberg")}
                value={postSortDirection}
                options={[
                  { value: "asc", label: __( 'ASC', 'WPgutenberg' ) },
                  { value: "desc", label: __( 'DESC', 'WPgutenberg' ) }
                ]}
                onChange={postSortDirection => setAttributes({ postSortDirection })}
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
            <PanelRow>
              <RangeControl
                // beforeIcon="arrow-left-alt2"
                // afterIcon="arrow-right-alt2"
                label={__("Item sum", "WPgutenberg")}
                value={postSum}
                onChange={postSum => setAttributes({ postSum })}
                min={1}
                max={100}
              />
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
          <PanelBody title={ __( 'Layout', 'WPgutenberg' ) } >
            <PanelRow>
              <RangeControl
                // beforeIcon="arrow-left-alt2"
                // afterIcon="arrow-right-alt2"
                label={__("Column sum", "WPgutenberg")}
                value={postColumns}
                onChange={postColumns => setAttributes({ postColumns })}
                min={1}
                max={10}
              />
            </PanelRow>
            <PanelRow>
              <RangeControl
                // beforeIcon="arrow-left-alt2"
                // afterIcon="arrow-right-alt2"
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
                  id="posts-swiper"
                  label={ __( 'Activate Swiper', 'WPgutenberg' ) }
                  checked={ postSwiper }
                  onChange={postSwiper => setAttributes({ postSwiper })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-popup"
                  label={ __( 'Activate Pop-Up', 'WPgutenberg' ) }
                  checked={ postPopUp }
                  onChange={postPopUp => setAttributes({ postPopUp })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-popup"
                  label={ __( 'Image preview inside Pop-Up', 'WPgutenberg' ) }
                  checked={ postPopUpNav }
                  onChange={postPopUpNav => setAttributes({ postPopUpNav })}
              />
            </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Posts Filter', 'WPgutenberg' ) } >
            <PanelRow>
              <FormTokenField
                label={__("Select posts", "WPgutenberg")}
                value={ postsFieldValue }
                suggestions={ postNames }
                maxSuggestions={ 20 }
                onChange={ ( postIdFilter ) => {
                  // Build array of selected posts.
                  let postIdFilterArray = [];
                  postIdFilter.map(
                    ( postName ) => {
                      const matchingPost = posts.find( ( post ) => {
                        return post.title.raw === postName;
                      } );
                      if ( matchingPost !== undefined ) {
                        postIdFilterArray.push( matchingPost.id );
                      }
                    }
                  )
                  setAttributes( { postIdFilter: postIdFilterArray } );
                } }
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Relation", "WPgutenberg")}
                value={postTaxonomyFilterRelation}
                options={[
                  { value: "AND", label: __( 'AND', 'WPgutenberg' ) },
                  { value: "OR", label: __( 'OR', 'WPgutenberg' ) }
                ]}
                onChange={postTaxonomyFilterRelation => setAttributes({ postTaxonomyFilterRelation })}
              />
            </PanelRow>
            <PanelRow>
              <div>
                { postTaxonomies.map(
                  (taxonomy, setState) => {
                  return(
                    <div>
                    <label><strong>{taxonomy.name}</strong></label>
                    <ul>
                      { taxonomy.values.map(
                        (tax, setState) => {
                        return(
                          <li>
                            <CheckboxControl
                              label={tax.name}
                              key={tax.id}
                              value={taxonomy.name + "-" + tax.id}
                              name='getPostTaxonomyFilter[]'
                              checked={ checkFilter(taxonomy.name + "-" + tax.id) }
                              // class= {'components-checkbox-control__input filtercheckbox' + tax.id}
                              onChange={ onchangeFilter }
                            />
                          </li>
                        );
                      }) }
                    </ul>
                    </div>
                  );
                }) }
              </div>
            </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
