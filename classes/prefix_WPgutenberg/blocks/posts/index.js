
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
  const { Spinner, withAPIData } = wp.components;
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
    let cssClasses = 'block-posts';
    cssClasses += atts["postSwiper"] === true ? " gallery-swiper" : " gallery-grid";
    cssClasses += atts["postPopUp"] === true ? " add-popup" : "";
    cssClasses += atts["postPopUpNav"] === true ? " popup-preview" : "";

    return cssClasses;
  }


  /* define column spacing
  /------------------------*/
  function getcolumnSpacing(atts) {
    let columnSpacing = '';
    columnSpacing += atts["postColumnsSpace"];

    return columnSpacing;
  }


  /* define column spacing
  /------------------------*/
  function getcolumnSum(atts) {
    let columnSum = '';
    columnSum += atts["postSwiper"] === true ? atts["postColumns"] : atts["postColumns"];

    return columnSum;
  }


  /* return post thumbnail
  /------------------------*/
  function PostImg(postThumb, postTaxonomyFilterOptions, id, media){
    if(postThumb === true && media){

      var imgType = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/x-icon'];
      var audioType = ['audio/mpeg3', 'audio/x-mpeg-3', 'video/mpeg', 'video/x-mpeg', 'audio/m4a', 'audio/ogg', 'audio/wav', 'audio/x-wav', 'audio/mpeg'];
      var videoType = ['video/mp4', 'video/x-m4v', 'video/quicktime', 'video/x-ms-asf', 'video/x-ms-wmv', 'application/x-troff-msvideo', 'video/avi', 'video/msvideo', 'video/x-msvideo', 'video/ogg', 'video/3gpp', 'audio/3gpp', 'video/3gpp2', 'audio/3gpp2', 'video/mpeg'];
      let themedia = media.source_url;

      if(imgType.includes(media.mime_type)){
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
      } else if(audioType.includes(media.mime_type)) {
        if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes('link_img') && postTaxonomyFilterOptions.indexOf('link_box') < 1){
          return (
            <a href="#">
              <figure class="wp-block-audio">
                <audio controls src={themedia} data-id={ id } width="100%" />
              </figure>
            </a>
          );
        } else {
          return (
            <figure class="wp-block-audio">
              <audio controls src={themedia} data-id={ id } width="100%" />
            </figure>
          );
        }
      } else if(videoType.includes(media.mime_type)) {
        if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.includes('link_img') && postTaxonomyFilterOptions.indexOf('link_box') < 1){
          return (
            <a href="#">
              <figure class="is-block-video">
                <video controls src={themedia} data-id={ id } width="100%" />
              </figure>
            </a>
          );
        } else {
          return (
            <figure class="is-block-video">
              <video controls src={themedia} data-id={ id } width="100%" />
            </figure>
          );
        }
      } else {
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


  /* return grif fix
  /------------------------*/
  function getGridFixer(atts){
    let fix = [];
    if(atts["postColumns"] > 1 && atts["postSwiper"] === false){
      for (let i = 1; i < atts["postColumns"]; i++) {
        fix.push(i)
      }
      return [
        fix.map(
          ( num ) => {
            return (
              <li class="grid-fixer"></li>
            )
          }
        )
      ]
    }
  }


  /* return sort options
  /------------------------*/
  function sortNavigation(atts){
    let output = '';
    output += '<div class="sort-options">';
      if(atts["postSortNavOptions"]){
        atts["postSortNavOptions"].forEach( option => {
          if(option.startsWith("tax__")){
            var cleanType = option.replace("tax__", "");
            if(cleanType == 'category'){
              var cleanType = 'categories';
            } else if (cleanType == 'post_tag') {
              var cleanType = 'tags';
            }
          } else if(option.startsWith("acf__")) {
            var cleanType = option.replace("acf__", "");
          } else {
            cleanType = option;
          }
          output += '<label data-sort="' + option + '" data-sortd="ASC" tabindex="0">';
            output += '<span class="sort-name">' + __( cleanType, 'WPgutenberg-' + atts["postType"] ) + '</span>';
            output += '<span class="sort-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="16.679" height="12.609" viewBox="0 0 16.679 12.609"><g transform="translate(-330.757 -433.378)"><g><line y1="1.05" x2="9" transform="matrix(-0.574, -0.819, 0.819, -0.574, 338.236, 443.67)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="3"/><line x2="9" y2="1.05" transform="matrix(0.574, -0.819, 0.819, 0.574, 339.096, 443.068)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="3"/></g></g></svg></span>';
          output += '</label>';
        });
      }
    output += '</div>';
    if(atts["postSortNav"] && atts["postSortNav"] === true){
      return [
        htmlToElem( output )
      ]
    }
  }



/*==================================================================================
REGISTER BLOCK
==================================================================================*/

  /* register
  /------------------------*/
  export default registerBlockType( 'templates/posts', {
    title: __( 'Posts', 'devTheme' ),
    description: __( 'Return posts', 'devTheme' ),
    category: 'widgets',
    icon: 'format-aside',
    keywords: [
      __( 'Posts', 'devTheme' ),
      __( 'Beiträge', 'devTheme' )
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
        'per_page': props.attributes.postSum,
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
      if(props.attributes.postType && props.attributes.postType == 'attachment'){
        query['status'] = 'inherit';
      }
      // add filter
      if(props.attributes.postIdFilter && props.attributes.postIdFilter.length >= 1){
        query['include'] = props.attributes.postIdFilter;
      } else {
        // taxonomy filter
        if(props.attributes.postTaxonomyFilter && props.attributes.postTaxonomyFilter.length >= 1){
          // query.concat(props.attributes.postTaxonomyFilter);
          props.attributes.postTaxonomyFilter.forEach(function(element) {
            var stringToArray = element.split("-");
            if( query[stringToArray[0]] === undefined ) {
                query[stringToArray[0]] = [];
            }
              query[stringToArray[0]].push(stringToArray[1]);
          });
        }
      }
      // posts
      const posts = select( 'core' ).getEntityRecords( 'postType', props.attributes.postType, query );
      let media = {};
      let taxOne = {};
      let taxTwo = {};
      if(posts){
        posts.forEach( post => {
          if(props.attributes.postType && props.attributes.postType == 'attachment'){
            media[ post.id ] = post;
          } else {
            media[ post.id ] = select('core').getMedia( post.featured_media );
          }
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
        attributes: { postType, postTaxonomyFilter, postIdFilter, postTaxonomyFilterRelation, postSum, postSortDirection, postSortBy, postTextOne, postTextTwo, postColumns, anchor, postThumb, postSwiper, postPopUp, postPopUpNav, postSortNav, postSortNavOptions, postColumnsSpace, postTaxonomyFilterOptions },
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
              <Inspector {...{ setAttributes, ...props }} />,
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
        <div style={{'--postColumns': columnSum, '--postColumnsSpace': columnSpacing + 'px'}} data-columnspace={columnSpacing} data-columns={columnSum} id={anchor} className={classnames(
          cssClasses, className
        )}>
          {
            // <ul>{settings}</ul>
          }
          {sortNavigation(attributes)}
        <ul>
          { posts.map(
            ( post ) => {
              // console.log(post);
              if(postTaxonomyFilterOptions && postTaxonomyFilterOptions.indexOf('link_box') >= 1){
                return (
                  <li data-id={post.id}>
                    <a href="#">
                        {PostImg(postThumb, postTaxonomyFilterOptions, post.id, media[ post.id ])}
                        <div class="post-content">
                          {PostValues(postTextOne, post, postTaxonomyFilterOptions, "link_row1", taxOne)}
                          {PostValues(postTextTwo, post, postTaxonomyFilterOptions, "link_row2", taxTwo)}
                        </div>
                    </a>
                  </li>
                )
              } else {
                return (
                  <li data-id={post.id}>
                      {PostImg(postThumb, postTaxonomyFilterOptions, post.id, media[ post.id ])}
                      <div class="post-content">
                        {PostValues(postTextOne, post, postTaxonomyFilterOptions, "link_row1", taxOne)}
                        {PostValues(postTextTwo, post, postTaxonomyFilterOptions, "link_row2", taxTwo)}
                      </div>
                  </li>
                )
              }
            }
          ) }
        </ul>
        </div>
      ];
    } ),
    save: props => {
      const {
        attributes: { postType, postTaxonomyFilter, postIdFilter, postTaxonomyFilterRelation, postSum, postSortDirection, postSortBy, postTextOne, postTextTwo, postColumns, anchor, postThumb, postSwiper, postPopUp, postPopUpNav, postSortNav, postSortNavOptions, postColumnsSpace, postTaxonomyFilterOptions },
        attributes
      } = props;

      return null;
    }

  });
