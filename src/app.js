require('./Extend/mixin.js')
App({
  globalData: {
    backgroundAudioManager: wx.getBackgroundAudioManager(),
    g_trackAudioProgress: new Map(),

  }
})