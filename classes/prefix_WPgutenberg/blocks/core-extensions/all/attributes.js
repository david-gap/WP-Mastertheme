const attributes = {
  hideOnDesktop: {
    type: 'boolean',
    default: false
  },
  hideOnMobile: {
    type: 'boolean',
    default: false
  },
  disabledValue: {
    type: 'boolean',
    default: false
  },
  scaduleStart: {
    type: 'string',
    default: ''
  },
  scaduleEnd: {
    type: 'string',
    default: ''
  },
  removeSpacing: {
    type: 'boolean',
    default: false
  },
  additionalSpacingOne: {
    type: 'boolean',
    default: false
  },
  additionalSpacingTwo: {
    type: 'boolean',
    default: false
  },
  dsgvoImgId: {
    type: 'number'
  },
  dsgvoImageURL: {
    type: 'string'
  },
  dsgvoCookie: {
    type: 'string'
  }
}

export default attributes;
