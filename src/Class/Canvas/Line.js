import Base from './Base'
class Line extends Base {
  constructor(params) {
    super(params)
    this.linearGradient = null //线性渐变上下文
  }
  // 增加一个新点，然后创建一条从上次指定点到目标点的线。用 stroke 方法来画线条
  line(x, y, context = this.context) {
    context.lineTo(x, y)
    return this
  }
  // 创建二次贝塞尔曲线路径。曲线的起始点为路径中前一个点。
  quadraticCurveTo({
    cpx,
    cpy,
    x,
    y
  }, context = this.context) {
    context.quadraticCurveTo(cpx, cpy, x, y)
    return this
  }
  // 创建三次方贝塞尔曲线路径。曲线的起始点为路径中前一个点。
  bezierCurveTo({
    xo = 0,
    yo = 0,
    xm = 0,
    ym = 0,
    xt = 0,
    yt = 0,
  }, context = this.context) {
    context.bezierCurveTo(xo, yo, xm, ym, xt, yt)
    return this
  }
  // 创建一个线性的渐变颜色。返回的CanvasGradient对象需要使用 CanvasGradient.addColorStop() 来指定渐变点，至少要两个。
  createLinearGradient({
    xo,
    yo,
    xt,
    yt
  }, context = this.context) {
    this.linearGradient = context.createLinearGradient(xo, yo, xt, yt)
    return this
  }
}

export default Line