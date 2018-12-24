const app = getApp()
Component({
  properties: {
  },
  data: {
    height: {
      type: Number,
      value: 780
    },
    startClientInfo: {
      clientX: 0,
      clientY: 0,
    },
    timer: 1,
    delay: 1000,
  },

  attached() {
    this.setData({
      height: (app.globalData.g_pageHeight - app.globalData.g_navHeight) * 2
    })
  },
  methods: {
    onTouchStart(e) {
      let {
        clientX,
        clientY,
      } = e && e.changedTouches[0]
      this.setData({
        startClientInfo: {
          clientX,
          clientY,
        }
      })
    },
    onTouchEnd(e) {
      let {
        clientY: clientY0,
      } = this.data.startClientInfo
      let {
        clientY: clientY1,
      } = e.changedTouches[0]
      // 垂直无位移<10，do noth
      if (clientY0 > clientY1 + 10) {
        // console.log('end...')
        this.triggerEvent('onScrollHandler')
      }
    },
  }
})