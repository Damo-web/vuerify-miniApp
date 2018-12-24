import Base from './Base'
class Img extends Base {
  constructor(params) {
    super(params)
  }
  // 绘制图像到画布
  img({
    path = '',
    dx = 0,
    dy = 0,
    dWidth = 0,
    dHeight = 0,
    sx = 0,
    sy = 0,
    sWidth = 0,
    sHeight = 0
  }, context = this.context) {
    context.drawImage(path, dx, dy, dWidth, dHeight, sx, sy, sWidth, sHeight)
    return this
  }
}

export default Img