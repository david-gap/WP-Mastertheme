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
  postTaxonomyFilterRelation: {
    type: 'string',
    default: 'AND'
  },
  postSum: {
    type: 'number',
    default: 10
  },
  postSortBy: {
    type: 'string',
    default: 'date'
  },
  postSortDirection: {
    type: 'string',
    default: 'desc'
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
  postPopUpNav: {
    type: 'boolean',
    default: false,
  }
}

export default attributes;
