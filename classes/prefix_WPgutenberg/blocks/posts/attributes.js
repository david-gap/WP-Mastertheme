const attributes = {
  anchor: {
    type: 'string'
  },
  postType: {
    type: 'string',
    default: 'post'
  },
  postTaxonomyFilter: {
    type: 'array'
  },
  postIdFilter: {
    type: 'array'
  },
  postTaxonomyFilterRelation: {
    type: 'string',
    default: 'AND'
  },
  postSum: {
    type: 'number',
    default: 10
  },
  postRepeater: {
    type: 'boolean',
    default: false,
  },
  postSortBy: {
    type: 'string',
    default: 'menu_order'
  },
  postSortDirection: {
    type: 'string',
    default: 'asc'
  },
  postTextOne: {
    type: 'string',
    default: 'title'
  },
  postTextTwo: {
    type: 'string',
    default: 'date'
  },
  postColumns: {
    type: 'number',
    default: 1
  },
  postColumnsSpace: {
    type: 'number',
    default: 20
  },
  postThumb: {
    type: 'boolean',
    default: true,
  },
  postSwiper: {
    type: 'boolean',
    default: false,
  },
  postPopUp: {
    type: 'boolean',
    default: false,
  },
  postPopUpInfo: {
    type: 'boolean',
    default: false,
  },
  postPopUpNav: {
    type: 'boolean',
    default: false,
  },
  postSortNav: {
    type: 'boolean',
    default: false,
  },
  postSortNavOptions: {
    type: 'array'
  },
  postTaxonomyFilterOptions: {
    type: 'array'
  },
  postsInsideLoad: {
    type: 'boolean',
    default: false,
  },
  postsInsideLoadFirst: {
    type: 'boolean',
    default: false,
  },
  postsBreakpoints: {
    type: 'array',
    default: []
  }
}

export default attributes;
