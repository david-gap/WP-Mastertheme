const attributes = {
  anchor: {
    type: 'string'
  },
  postType: {
    type: 'string',
    default: 'post'
  },
  postSortBy: {
    type: 'string',
    default: 'date'
  },
  postSortDirection: {
    type: 'string',
    default: 'desc'
  },
  postTaxonomyFilterRelation: {
    type: 'string',
    default: 'AND'
  },
  postTextOne: {
    type: 'string',
    default: 'title'
  },
  postTextTwo: {
    type: 'string',
    default: 'date'
  },

  postFilterPosition: {
    type: 'string',
    default: 'left'
  },
  postListTemplate: {
    type: 'string',
    default: 'grid'
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
  postTextSearch: {
    type: 'boolean',
    default: false,
  },
  postTaxonomyFilter: {
    type: 'array'
  },
  postTaxonomyFilterOptions: {
    type: 'array'
  },
  postTaxonomyPreFilter: {
    type: 'array'
  }
}

export default attributes;
