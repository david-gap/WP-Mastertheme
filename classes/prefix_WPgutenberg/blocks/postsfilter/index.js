
/*==================================================================================
  SETTINGS
==================================================================================*/

  /* import needed files and constant
  /------------------------*/
  import classnames from 'classnames';
  import attributes from "./attributes";
  import Inspector from "./inspector";

  const { __ } = wp.i18n;
  const { registerBlockType } = wp.blocks;
  const { RichText } = wp.editor;
  const { Spinner, withAPIData, TextControl, CheckboxControl } = wp.components;
  const { select, withSelect } = wp.data;

  const htmlToElem = ( html ) => wp.element.RawHTML( { children: html } );
  const meta = wp.data.select('core/editor').getEditedPostAttribute('meta');


  /* atts changed from attributes, see below
  /------------------------*/
  function getSettings(atts) {
    let settings = [];
    // The following code sorts the list alphabetically
    let attributes = {};
    Object.keys(atts)
      .sort()
      .forEach(function(key) {
        attributes[key] = atts[key];
      });
    // End updated code
    for (let attribute in attributes) {
      let value = attributes[attribute];
      if ("boolean" === typeof attributes[attribute]) {
        value = value.toString();
      }
      settings.push(
        <li>
          {attribute}: {value}
        </li>
      );
    }
    return settings;
  }



/*==================================================================================
  CONTENT BUILDING
==================================================================================*/

  /* define block css
  /------------------------*/
  function getCssClasses(atts) {
    let cssClasses = 'block-postsfilter';
    cssClasses += " filter-" + atts["postFilterPosition"];

    return cssClasses;
  }


  /* define column spacing
  /------------------------*/
  function getcolumnSpacing(atts) {
    let columnSpacing = '';
    columnSpacing += atts["postColumns"] > 1 ? atts["postColumnsSpace"] : "0";

    return columnSpacing;
  }


  /* define column spacing
  /------------------------*/
  function getcolumnSum(atts) {
    let columnSum = '';
    columnSum += atts["postListTemplate"] === 'list' ? "1" : atts["postColumns"];

    return columnSum;
  }


  /* return post thumbnail
  /------------------------*/
  function PostImg(postThumb, postTaxonomyFilterOptions, id, media){
    if(postThumb === true && media){
      let themedia = media.source_url;
      if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes('link_img') && postTaxonomyFilterOptions.indexOf('link_box') < 1){
        return (
          <a href="#">
            <figure>
              <img src={themedia} data-id={ id } width="100%" />
            </figure>
          </a>
        );
      } else {
        return (
          <figure>
            <img src={themedia} data-id={ id } width="100%" />
          </figure>
        );
      }
    }
  }


  /* return post values
  /------------------------*/
  function PostValues(type, post, postTaxonomyFilterOptions, row, taxonomy){
    var value = '';
    switch (type) {
      case "title":
        value += '<h4>';
          if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
            value += '<a href="#">';
          }
            value += post.title.rendered;
          if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
            value += '</a>';
          }
        value += '</h4>';
        break;
      case "date":
        var setdate = new Date(post.date);
        var dd = ((setdate.getDate())>=10)? setdate.getDate() : '0' + setdate.getDate();
        var mm = ((setdate.getMonth())>=9)? (setdate.getMonth()+1) : '0' + (setdate.getMonth()+1);
        var yyyy = setdate.getFullYear();
        if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
          value += '<a href="#">';
        }
          value += dd + '.' + mm + '.' + yyyy;
        if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
          value += '</a>';
        }
        break;
      case "template":
        if (post.hasOwnProperty("templateParts") && post.templateParts.hasOwnProperty('content')) {
          if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
            value += '<a href="#">';
          }
            value += post.templateParts.content;
          if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
            value += '</a>';
          }
        }
        break;
      case "templateMedia":
        if (post.hasOwnProperty("templateParts") && post.templateParts.hasOwnProperty('media')) {
          if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
            value += '<a href="#">';
          }
            value += post.templateParts.media;
          if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
            value += '</a>';
          }
        }
        break;
      case "excerpt":
        if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
          value += '<a href="#">';
        }
          value += post.excerpt.rendered;
        if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
          value += '</a>';
        }
        break;
      default:
        if(type.startsWith("tax__")){
          // taxonomies
          // update core taxonomy names
          var cleanType = type.replace("tax__", "");
          if(cleanType == 'category'){
            var cleanType = 'categories';
          } else if (cleanType == 'post_tag') {
            var cleanType = 'tags';
          }
          // list selection
          if (post.hasOwnProperty(cleanType)) {
            var getValue = post[cleanType];
            var buildvalue = '';
            getValue.forEach(tax => {
              if(taxonomy[ tax ]){
                buildvalue += taxonomy[ tax ];
                if(getValue[getValue.length-1] !== tax){
                  buildvalue += ', ';
                }
              }
            });
            if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
              value += '<a href="#">';
            }
              value += buildvalue;
            if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
              value += '</a>';
            }
          }
        } else {
          // meta boxes
          if (post.hasOwnProperty("meta") && post.meta.hasOwnProperty(type)) {
            if(type.includes("Image")){
              let img = select('core').getMedia( post.meta[type] );
              if(img){
                if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
                  value += '<a href="#">';
                }
                  value += '<figure><img src="' + img.source_url + '" width="100%" /></figure>';
                if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
                  value += '</a>';
                }
              }
            } else {
              if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
                value += '<a href="#">';
              }
                value += post.meta[type];
              if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes(row) && postTaxonomyFilterOptions.indexOf('link_box') < 1){
                value += '</a>';
              }
            }
          }
        }
        break;
    }
    if(value !== ''){
      return (
        htmlToElem( value )
      );
    }
  }


  /* return text search
  /------------------------*/
  function searchBox(atts){
    if(atts["postTextSearch"] === true){
      var output = '<div class="textsearch">';
      output += '<label for="textsearch">' + __( 'Textsearch', 'devTheme' ) + '</label>';
      output += '<input type="text" id="textsearch" name="textsearch" placeholder="' + __( 'Search for', 'devTheme' ) + '">';
      output += '</div>';
      return (
        htmlToElem( output )
      );
    }
  }


  /* return taxonomy fieldset
  /------------------------*/
  function getTaxonomyFiedset(atts) {
    // show legend
    if(atts["postTaxonomyFilter"]){
      return [
        atts["postTaxonomyFilter"].map(
          ( tax ) => {
            return (
              taxonomyFiedset(tax, atts)
            )
          }
        )
      ]
    }
  }


  /* return reset button
  /------------------------*/
  function getResetButton(atts) {
    if(atts["postTaxonomyFilterOptions"] && atts["postTaxonomyFilterOptions"].includes('restButton')){
      let output = '<input type="rest" value="' + __( 'Reset', 'devTheme' ) + '">';
      return (
        htmlToElem( output )
      );
    }
  }


  /* build taxonomy fieldset
  /------------------------*/
  function taxonomyFiedset(taxonomy, atts) {
    let output = '<fieldset>';
        // show legend
        if(atts["postTaxonomyFilterOptions"] && atts["postTaxonomyFilterOptions"].includes('legend')){
          output += '<legend>';
            if(taxonomy == 'category'){
              output += 'categories';
            } else if (taxonomy == 'post_tag') {
              output += 'tags';
            } else {
              output += taxonomy;
            }
          output += '</legend>';
        }
        output += '<ul>';
        // show empty taxonomies
        let getEntityRecordsOptions = {
          'hide_empty': true
        };
        if(atts["postTaxonomyFilterOptions"] && atts["postTaxonomyFilterOptions"].includes('emptytax')){
          getEntityRecordsOptions['hide_empty'] = false;
        }
        const getTaxvalues = select( 'core' ).getEntityRecords( 'taxonomy', taxonomy, getEntityRecordsOptions );
        if(getTaxvalues && getTaxvalues.length > 0){
          getTaxvalues.map(
            (tax, setState) => {
                output += '<li>';
                  output += '<input type="checkbox">';
                  output += '<label>';
                    output += tax.name;
                  output += '</label>';
                output += '</li>';
          })
        }
        output += '</ul>';
    output += '</fieldset>';
    if(getTaxvalues && getTaxvalues.length > 0){
      return (
          htmlToElem( output )
      );
    }
  }


  /* return grif fix
  /------------------------*/
  function getGridFixer(atts){
    let fix = [];
    if(atts["postColumns"] > 1 && atts["postListTemplate"] == 'grid'){
      for (let i = 1; i < atts["postColumns"]; i++) {
        fix.push(i)
      }
      return [
        fix.map(
          ( num ) => {
            return (
              <div class="grid-fixer"></div>
            )
          }
        )
      ]
    }
  }



/*==================================================================================
REGISTER BLOCK
==================================================================================*/

  /* register
  /------------------------*/
  export default registerBlockType( 'templates/postsfilter', {
    title: __( 'Posts Filter', 'devTheme' ),
    description: __( 'Return posts', 'devTheme' ),
    category: 'widgets',
    icon: 'format-aside',
    keywords: [
      __( 'Posts Filter', 'devTheme' ),
      __( 'Beiträge Filter', 'devTheme' )
    ],
    supports: {
      html: false,                // Remove support for an HTML mode
      anchor: true,               // Declare support for anchor links
      customClassName: true,      // Remove the support for the custom className
      className: false,           // Remove the support for the generated className
      align: true,                // Declare support for block's alignment
      alignWide: true,            // Remove the support for wide alignment
      defaultStylePicker: false,  // Remove the Default Style picker
      inserter: true,             // Hide this block from the inserter
      multiple: true,             // Use the block just once per post
      reusable: true              // Don't allow the block to be converted into a reusable block
    },
    attributes,
    edit: withSelect( ( select, props ) => {
      let defalutSort = ['menu_order', 'title', 'date'];
      let query = {
        'status': 'publish',
        'per_page': -1,
        'order': props.attributes.postSortDirection,
        'tax_relation': props.attributes.postTaxonomyFilterRelation
      };
      if(props.attributes.postSortBy && defalutSort.includes(props.attributes.postSortBy)){
        query['orderby'] = props.attributes.postSortBy;
      } else if (props.attributes.postSortBy && props.attributes.postSortBy.startsWith("tax__")) {
        // query['orderby'] = props.attributes.postSortBy;
      } else if (props.attributes.postSortBy) {
        query['meta_key'] = props.attributes.postSortBy;
        query['orderby'] = 'meta_value';
      }
      // taxonomy pre filter
      if(props.attributes.postTaxonomyPreFilter && props.attributes.postTaxonomyPreFilter.length >= 1){
        props.attributes.postTaxonomyPreFilter.forEach(function(element) {
          var stringToArray = element.split("-");
          if( query[stringToArray[0]] === undefined ) {
              query[stringToArray[0]] = [];
          }
            query[stringToArray[0]].push(stringToArray[1]);
        });
      }
      // posts
      const posts = select( 'core' ).getEntityRecords( 'postType', props.attributes.postType, query );
      let media = {};
      let taxOne = {};
      let taxTwo = {};
      if(posts){
        posts.forEach( post => {
          media[ post.id ] = select('core').getMedia( post.featured_media );
        });
      }
      if(props.attributes.postTextOne.startsWith("tax__")){
        var cleanTextOne = props.attributes.postTextOne.replace("tax__", "");
        const getTaxOne = select( 'core' ).getEntityRecords( 'taxonomy', cleanTextOne );
        if(getTaxOne){
          getTaxOne.forEach( tax => {
            taxOne[ tax.id ] = tax.name;
          });
        }
      }
      if(props.attributes.postTextTwo.startsWith("tax__")){
        var cleanTextTwo = props.attributes.postTextTwo.replace("tax__", "");
        const getTaxTwo = select( 'core' ).getEntityRecords( 'taxonomy', cleanTextTwo );
        if(getTaxTwo){
          getTaxTwo.forEach( tax => {
            taxTwo[ tax.id ] = tax.name;
          });
        }
      }
      return {
        posts, media, taxOne, taxTwo
      };
    } )( props => {
      // set values
      const {
        attributes: { anchor, postType, postSortBy, postTextOne, postTextTwo, postTaxonomyFilter, postTaxonomyPreFilter, postTaxonomyFilterOptions, postColumns, postFilterPosition, postListTemplate, postColumnsSpace, postTextSearch, postThumb, postTaxonomyFilterRelation, postSortDirection, postsBreakpoints },
        attributes,
        className,
        setAttributes,
        posts,
        media,
        taxOne,
        taxTwo
      } = props;
      let settings = getSettings(attributes);
      let cssClasses = getCssClasses(attributes);
      let columnSpacing = getcolumnSpacing(attributes);
      let columnSum = getcolumnSum(attributes);
      // loading posts
      if ( ! posts ) {
          return (
              <p>
                  <Spinner />
                  { __( 'Loading Posts', 'devTheme' ) }
              </p>
          );
      }
      // query is empty
      if ( 0 === posts.length ) {
          return [
            <Inspector {...{ setAttributes, ...props }} />,
            <p>{ __( 'No Posts', 'devTheme' ) }</p>
          ]
      }

      return [
        <Inspector {...{ setAttributes, ...props }} />,
        <div id={anchor} className={classnames(
          cssClasses, className
        )}>
          {
            // <ul>{settings}</ul>
          }
          <form class="thefilter">
            {searchBox(attributes)}
            {getTaxonomyFiedset(attributes)}
            {getResetButton(attributes)}
          </form>
          <div className={postListTemplate + ' results'} style={{'--postColumns': columnSum, '--postColumnsSpace': columnSpacing + 'px'}} data-columnspace={columnSpacing} data-columns={columnSum}>
            { posts.map(
              ( post ) => {
                // console.log(post);
                if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.indexOf('link_box') >= 1){
                  return (
                    <div data-id={post.id}>
                      <a href="#">
                          {PostImg(postThumb, postTaxonomyFilterOptions, post.id, media[ post.id ])}
                          <div class="post-content">
                            {PostValues(postTextOne, post, postTaxonomyFilterOptions, "link_row1", taxOne)}
                            {PostValues(postTextTwo, post, postTaxonomyFilterOptions, "link_row2", taxTwo)}
                          </div>
                      </a>
                    </div>
                  )
                } else {
                  return (
                    <div data-id={post.id}>
                        {PostImg(postThumb, postTaxonomyFilterOptions, post.id, media[ post.id ])}
                        <div class="post-content">
                          {PostValues(postTextOne, post, postTaxonomyFilterOptions, "link_row1", taxOne)}
                          {PostValues(postTextTwo, post, postTaxonomyFilterOptions, "link_row2", taxTwo)}
                        </div>
                    </div>
                  )
                }
              }
            ) }
          </div>
        </div>
      ];
    } ),
    save: props => {
      const {
        attributes: { anchor, postType, postSortBy, postTextOne, postTextTwo, postTaxonomyFilter, postTaxonomyPreFilter, postTaxonomyFilterOptions, postColumns, postFilterPosition, postListTemplate, postColumnsSpace, postTextSearch, postThumb, postTaxonomyFilterRelation, postSortDirection, postsBreakpoints },
        attributes
      } = props;

      return null;
    }

  });
