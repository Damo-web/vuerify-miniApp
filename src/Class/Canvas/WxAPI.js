class WxAPI {
  constructor(id) {
    this.id = id
    this.context = this.createCanvasContext(id)
  }
  // 创建 canvas 的绘图上下文 CanvasContext 对象
  createCanvasContext(id, context = this) {
    return wx.createCanvasContext(id, context)
  }
  //获取 canvas 区域隐含的像素数据。
  canvasGetImageData(obj, context = this) {
    obj.canvasId = this.id
    return wx.canvasGetImageData(obj, context)
  }
  //将像素数据绘制到画布。在自定义组件下，第二个参数传入自定义组件实例 this，以操作组件内 <canvas> 组件
  canvasPutImageData(obj, context = this) {
    obj.canvasId = this.id
    return wx.canvasPutImageData(obj, context)
  }
  //把当前画布指定区域的内容导出生成指定大小的图片。在 draw() 回调里调用该方法才能保证图片导出成功。
  canvasToTempFilePath(obj, context = this) {
    obj.canvasId = this.id
    return wx.canvasToTempFilePath(obj, context)
  }
  // 保存图片到系统相册。
  saveImageToPhotosAlbum(filePath = '', s = r => r, f = r => r) {
    return wx.saveImageToPhotosAlbum({
      filePath,
      success(res) {
        s(res)
      },
      fail(rej) {
        f(rej)
      }
    })
  }
}

export default WxAPI