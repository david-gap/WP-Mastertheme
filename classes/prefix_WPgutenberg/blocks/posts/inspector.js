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
        postSortNav,
        postsInsideLoad,
        postsInsideLoadFirst,
        postSortNavOptions,
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
      { value: "title", label: __( 'Title', 'devTheme' ) },
      { value: "date", label: __( 'Date', 'devTheme' ) },
      { value: "excerpt", label: __( 'Excerpt', 'devTheme' ) },
      { value: "template", label: __( 'Post template', 'devTheme' ) },
      { value: "templateMedia", label: __( 'Post template (media only)', 'devTheme' ) }
    ];
    const query = {
      'status': 'publish',
      'per_page': 100,
      'order': postSortDirection
    };
    if(postType && postType == 'attachment'){
      query['status'] = 'inherit';
    }
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
      if(posts[0]._links["wp:term"] !== undefined){
        const terms = posts[0]._links["wp:term"];
        Object.entries(terms).forEach(([key, value]) => {
          if(value.taxonomy == "post_tag"){
            postSortOptions.push( { value: 'tax__post_tag', label: "Taxonomy: Tags" } );
          } else {
            postSortOptions.push( { value: 'tax__' + value.taxonomy, label: "Taxonomy: " + value.taxonomy } );
          }
        });
      }
    }
    // update post type selection options
    let postTypes = [];
    const getposttypes = select('core').getPostTypes({ per_page: -1 });
    if(getposttypes){
      getposttypes.forEach( type => {
        if(type.slug !== "wp_block"){
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
            if(postTaxonomyFilter && postTaxonomyFilter.length >= 1){
              selectedOptions[cleanTax] = postTaxonomyFilter.map( ( taxID ) => {
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
            postTaxonomies.push( { name: cleanTax, options: sectionOptions, query: getTaxvalues, values: theSelectedOptions } );
            // if(selectedOptions[cleanTax]){
            //   postTaxonomies.push( { name: cleanTax, options: sectionOptions, values: selectedOptions[cleanTax] } );
            // } else {
            // }
          }
        });
      }
    }
    // sort nav options
    let sortnavoptions = [
      { value: "title", label: __( 'Title', 'devTheme' ) },
      { value: "date", label: __( 'Date', 'devTheme' ) }
    ];
    let sortnavsuggestions = [];
    let sortnavoptionsValue = [];
    if(posts && posts.length > 0){
      if(posts[0].meta !== undefined){
        Object.entries(posts[0].meta).forEach(([key, value]) => {
          sortnavoptions.push( { value: key, label: "Meta: " + key } );
        });
      }
      if(posts[0]._links["wp:term"] !== undefined){
        const terms = posts[0]._links["wp:term"];
        Object.entries(terms).forEach(([key, value]) => {
          if(value.taxonomy == "post_tag"){
            sortnavoptions.push( { value: 'tax__post_tag', label: "Taxonomy: Tags" } );
          } else {
            sortnavoptions.push( { value: 'tax__' + value.taxonomy, label: "Taxonomy: " + value.taxonomy } );
          }
        });
      }
      Object.entries(sortnavoptions).forEach(([key, value]) => {
        sortnavsuggestions.push( value.label );
      });
      if(postSortNavOptions){
        sortnavoptionsValue = postSortNavOptions.map( ( option ) => {
          let wantedOption = sortnavoptions.find( ( options ) => {
            return options.value === option;
          } );
          if ( wantedOption === undefined || ! wantedOption ) {
            return false;
          }
          return wantedOption.label;
        } );
      }
    }
    // options
    const postOptions = [
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
            <PanelRow>
              <RangeControl
                // beforeIcon="arrow-left-alt2"
                // afterIcon="arrow-right-alt2"
                label={__("Item sum", "devTheme")}
                value={postSum}
                onChange={postSum => setAttributes({ postSum })}
                min={-1}
                max={101}
              />
            </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Layout', 'devTheme' ) } >
            <PanelRow>
              <RangeControl
                // beforeIcon="arrow-left-alt2"
                // afterIcon="arrow-right-alt2"
                label={__("Column sum", "devTheme")}
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
                  id="posts-swiper"
                  label={ __( 'Activate Swiper', 'devTheme' ) }
                  checked={ postSwiper }
                  onChange={postSwiper => setAttributes({ postSwiper })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-popup"
                  label={ __( 'Activate Lightbox', 'devTheme' ) }
                  checked={ postPopUp }
                  onChange={postPopUp => setAttributes({ postPopUp })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-popup"
                  label={ __( 'Image preview inside Lightbox', 'devTheme' ) }
                  checked={ postPopUpNav }
                  onChange={postPopUpNav => setAttributes({ postPopUpNav })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-sortnav"
                  label={ __( 'Show the sort options', 'devTheme' ) }
                  checked={ postSortNav }
                  onChange={postSortNav => setAttributes({ postSortNav })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-inside-block"
                  label={ __( 'Load selected post inside block', 'devTheme' ) }
                  checked={ postsInsideLoad }
                  onChange={postsInsideLoad => setAttributes({ postsInsideLoad })}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                  id="posts-inside-block"
                  label={ __( 'Load first result inside block', 'devTheme' ) }
                  checked={ postsInsideLoadFirst }
                  onChange={postsInsideLoadFirst => setAttributes({ postsInsideLoadFirst })}
              />
            </PanelRow>
            <PanelRow>
              <div>
                <label><strong>{ __( 'Linking', 'devTheme' ) }</strong></label>
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
            <PanelRow>
              <FormTokenField
                label={__("Select sort options", "devTheme")}
                value={ sortnavoptionsValue }
                suggestions={ sortnavsuggestions }
                maxSuggestions={ 20 }
                onChange={ ( postSortNavOptions ) => {
                  // Build array of selected posts.
                  let postSortNavOptionsArray = [];
                  postSortNavOptions.map(
                    ( option ) => {
                      const matchingOptions = sortnavoptions.find( ( options ) => {
                        return options.label === option;
                      } );
                      if ( matchingOptions !== undefined ) {
                        postSortNavOptionsArray.push( matchingOptions.value );
                      }
                    }
                  )
                  setAttributes( { postSortNavOptions: postSortNavOptionsArray } );
                } }
              />
            </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Posts Filter', 'devTheme' ) } >
            <PanelRow>
              <FormTokenField
                label={__("Select posts", "devTheme")}
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
                          currentTaxVal = postTaxonomyFilter;
                        } }
                        onChange={ ( postTaxonomyFilter ) => {
                          // build array of selected posts from other taxonomies
                          let postTaxFilterArray = [];
                          if(currentTaxVal && currentTaxVal.length >= 1){
                            // query.concat(props.attributes.postTaxonomyFilter);
                            currentTaxVal.forEach(function(allTaxSelections) {
                              var stringToArray = allTaxSelections.split("-");
                              if( stringToArray[0] !== taxonomy.name ) {
                                postTaxFilterArray.push( allTaxSelections );
                              }
                            });
                          }
                          // add to selection from current taxonomy
                          postTaxonomyFilter.map(
                            ( taxSelection ) => {
                              const matchingTax = taxonomy.query.find( ( tax ) => {
                                return tax.name === taxSelection;
                              } );
                              if ( matchingTax !== undefined ) {
                                postTaxFilterArray.push( taxonomy.name + "-" + matchingTax.id );
                              }
                            }
                          )
                          setAttributes( { postTaxonomyFilter: postTaxFilterArray } );
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
