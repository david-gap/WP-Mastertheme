const attributes = {
  anchor: {
    type: 'string'
  },
  pinPostion: {
    type: 'object',
    default: {"x":"0.5","y":"0.5"}
  },
  pinImgId: {
    type: 'number'
  },
  pinImageURL: {
    type: 'string'
  },
  pinPostType: {
    type: 'string',
    default: 'post'
  },
  pinPostId: {
    type: 'array',
    default: 0
  },
  pinTarget: {
    type: 'string',
    default: 'heritage'
  },
  pinInfo: {
    type: 'string',
    default: 'heritage'
  },
  pinInfoRowOne: {
    type: 'string',
    default: 'heritage'
  },
  pinInfoRowTwo: {
    type: 'string',
    default: 'heritage'
  },
  pinInfoTrigger: {
    type: 'array'
  }
  ,parentAttributes: {
    type: 'object'
  }
}

export default attributes;
