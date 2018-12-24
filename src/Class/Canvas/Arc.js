import Base from './Base'
class Arc extends Base {
  constructor(params) {
    super(params)
    this.circularGradient = null //圆性渐变上下文
  }
  // 创建一个圆形的渐变颜色。起点在圆心，终点在圆环。返回的CanvasGradient对象需要使用 CanvasGradient.addColorStop() 来指定渐变点，至少要两个。
  createCircularGradient({
    x,
    y,
    r,
  }, context = this.context) {
    this.init('green', 2)
    this.circularGradient = context.createCircularGradient(x, y, r)
    return this
  }
  // 创建一条弧线。
  arc({
    x,
    y,
    r,
    sAngle,
    eAngle,
    counterclockwise = true
  }, context = this.context) {
    this.init('green', 2)
    context.arc(x, y, r, sAngle, eAngle, counterclockwise)
    return this
  }
  // 根据控制点和半径绘制圆弧路径。
  arcTo({
    x1,
    y1,
    x2,
    y2,
    radius
  }, context = this.context) {
    // this.init('green', 2)
    context.arcTo(x1, y1, x2, y2, radius)
    return this
  }
}

export default Arc