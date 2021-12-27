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
  videoMute: {
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
  },
  videoTableOfContent: {
    type: 'boolean',
    default: false,
  },
  videoTOCtoggle: {
    type: 'boolean',
    default: false,
  },
  videoTOCposition: {
    type: 'string',
    default: 'left'
  },
  videoTOCautoplay: {
    type: 'boolean',
    default: false,
  },
  videoTOCstop: {
    type: 'boolean',
    default: false,
  },
  videoLink: {
    type: 'string',
    default: '',
  },
  videoLinkTarget: {
    type: 'string',
    default: '_self',
  }
}

export default attributes;
