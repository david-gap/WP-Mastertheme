const attributes = {
  zoomActive: {
    type: 'boolean',
    default: false,
  },
  zoomMax: {
    type: 'number',
    default: 2,
  },
  zoomSteps: {
    type: 'number',
    default: 0.5,
  },
  zoomPosition: {
    type: 'string',
    default: 'bottom-right',
  }
}

export default attributes;
