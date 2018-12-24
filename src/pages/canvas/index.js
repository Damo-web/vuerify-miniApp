import DrawCanvas from '../../Class/Canvas/Index'
Page({
  onReady() {
    this.draw()
  },
  draw() {
    const context = new DrawCanvas('canvas')
    context
      .rec({
        x: 40,
        y: 0,
        width: 300,
        height: 500
      })
      .stroke()
      .beginPath()
      .move(160, 100)
      .arc({
        x: 140,
        y: 100,
        r: 80,
        sAngle: 0,
        eAngle: 2 * Math.PI,
      })
      .stroke()
      .move(160, 100)
      .bezierCurveTo({
        xo: 60,
        yo: 20,
        xm: 20,
        ym: 20,
        xt: 100,
        yt: 100,
      })
      .move(120, 80)
      .arc({
        x: 120,
        y: 80,
        r: 5,
        sAngle: 0,
        eAngle: 2 * Math.PI,
      })
      .move(165, 80)
      .arc({
        x: 160,
        y: 80,
        r: 5,
        sAngle: 0,
        eAngle: 2 * Math.PI,
      })
      .text({
        text: 'Hello!',
        x: 130,
        y: 130,
        color: 'red',
        fontSize: '20px'
      })
      .stroke()
      .draw()


    this.setData({
      canvasContext: context
    })
  },
  save() {
    this.data.canvasContext.canvasToTempFilePath({
      x: 0,
      y: 20,
      width: 300,
      height: 500,
      destWidth: 500,
      destHeight: 500,
      success: res => {
        // console.log(res.tempFilePath)
        this.data.canvasContext.saveImageToPhotosAlbum(res.tempFilePath)
      }
    })
  }
})