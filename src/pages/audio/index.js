Page({
  data: {
    node: {
      id: '1',
      title: '英皇考级1级乐理完全备考微积分发大奖时间',
      content: '英皇考级1级乐理完全备考微积分发大奖时间',
      duration: "08:00",
      timer: '时长45:00',
      listened: '00:00', //true |false是否播放
      isPlayingMusic: !true, //true |false是否播放
      src: 'http://ws.stream.qqmusic.qq.com/M500001VfvsJ21xFqb.mp3?guid=ffffffff82def4af4b12b3cd9337d5e7&uin=346897220&vkey=6292F51E1E384E061FF02C31F716658E5C81F5594D561F2E88B854E81CAAB7806D5E4F103E55D33C16F3FAC506D1AB172DE8600B37E43FAD&fromtag=46'
    }
  },
  nodeDateTransporter(e) {
    let myEventDetail = e.detail // detail对象，提供给事件监听函数
    // this.triggerEvent('customevent', myEventDetail, {
    //   bubbles: true
    // })
    // app.globalData.g_curVideo && app.globalData.g_curVideo.pause()
  },
})