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
        postTaxonomyFilterRelation
      },
      setAttributes
    } = this.props;

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
    if(posts){
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
    // update taxonomy filter
    let postTaxonomies = [];
    if(posts){
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
