const attributes = {
  videoID: {
    type: 'string',
    default: '',
  },
  videoAutoPlay: {
    type: 'boolean',
    default: true,
  },
  videoBackgroud: {
    type: 'boolean',
    default: false,
  },
  videoLoop: {
    type: 'boolean',
    default: false,
  },
  videoDimensionX: {
    type: 'string',
    default: '4',
  },
  videoDimensionY: {
    type: 'string',
    default: '3',
  }
}

export default attributes;
