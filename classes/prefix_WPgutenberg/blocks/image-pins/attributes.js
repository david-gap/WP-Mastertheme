const attributes = {
  anchor: {
    type: 'string'
  },
  imageId: {
    type: 'number'
  },
  imageURL: {
    type: 'string'
  },
  pinsTarget: {
    type: 'string',
    default: 'self'
  },
  pinsInfo: {
    type: 'string',
    default: ''
  },
  pinsInfoRowOne: {
    type: 'string',
    default: 'title'
  },
  pinsInfoRowTwo: {
    type: 'string',
    default: ''
  },
  pinsInfoTrigger: {
    type: 'array',
    default: {}
  }
}

export default attributes;
