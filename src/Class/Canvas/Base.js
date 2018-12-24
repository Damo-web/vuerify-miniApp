import WxAPI from './WxAPI'
class Base extends WxAPI {
  constructor(id) {
    super(id)
  }
  //设置描边颜色,设置线条的宽度
  init(style, lineWidth = 1, alpha = 1, context = this.context) {
    context.setStrokeStyle(style)
    context.setLineWidth(lineWidth)
    // context.globalAlpha(alpha) // 已废弃
    return this
  }
  /*从原始画布中剪切任意形状和尺寸。一旦剪切了某个区域，
  则所有之后的绘图都会被限制在被剪切的区域内（不能访问画布上的其他区域）。可以在使用 clip 方法前通过使用 save 方法对当前画布区域进行保存，并在以后的任意时间通过restore方法对其进行恢复。
  */
  clip(context = this.context) {
    context.clip()
    return this
  }
  //对当前路径中的内容进行填充。默认的填充色为黑色。
  fill(context = this.context) {
    context.fill()
    return this
  }
  // 对指定的图像创建模式的方法，可在指定的方向上重复元图像
  createPattern(path = '', repetition = 1, context = this.context) {
    context.createPattern(path, repetition)
    return this
  }
  // 添加颜色的渐变点。小于最小 stop 的部分会按最小 stop 的 color 来渲染，大于最大 stop 的部分会按最大 stop 的 color 来渲染
  addColorStop({
    stop,
    color
  }, context = this.context) {
    context.addColorStop(stop, color)
    return this
  }
  // 开始创建一个路径。需要调用 fill 或者 stroke 才会使用路径进行填充或描边
  beginPath() {
    this.context.beginPath()
    return this
  }
  //填充一个矩形。用 setFillStyle 设置矩形的填充色，如果没设置默认是黑色。
  fillRect({
    x = 0,
    y = 0,
    width = 200,
    height = 200
  }, context = this.context) {
    context.fillRect(x, y, width, height)
    return this
  }
  //在画布上绘制被填充的文本
  fillText({
    text = '',
    x = 0,
    y = 0,
    maxWidth = 200,
  }, context = this.context) {
    context.fillText(text, x, y, maxWidth)
    return this
  }
  // 测量文本尺寸信息。目前仅返回文本宽度。同步接口。
  measureText(text = '', context = this.context) {
    context.measureText(text)
    return this
  }
  // 关闭一个路径。会连接起点和终点。如果关闭路径后没有调用 fill 或者 stroke 并开启了新的路径，那之前的路径将不会被渲染。
  closePath(context = this.context) {
    context.closePath()
    return this
  }
  // 把路径移动到画布中的指定点，不创建线条。用 stroke 方法来画线条
  move(x, y, context = this.context) {
    context.moveTo(x, y)
    return this
  }
  // 画出当前路径的边框。默认颜色色为黑色。
  stroke(context = this.context) {
    context.stroke()
    return this
  }
  // 画一个矩形(非填充)。 用 setStrokeStyle 设置矩形线条的颜色，如果没设置默认是黑色。
  strokeRec({
    x = 0,
    y = 0,
    width = 200,
    height = 200
  }, context = this.context) {
    context.strokeRect(x, y, width, height)
    return this
  }
  // 恢复之前保存的绘图上下文。
  restore(context = this.context) {
    context.restore()
    return this
  }
  // 以原点为中心顺时针旋转当前坐标轴。多次调用旋转的角度会叠加。原点可以用 translate 方法修改。
  // rotate:旋转角度，以弧度计 degrees * Math.PI/180；degrees 范围为 0-360
  rotate(rotate = 0, context = this.context) {
    context.rotate(rotate)
    return this
  }
  // 给定的(x, y) 位置绘制文本描边的方法
  strokeText({
    text = '',
    x = 0,
    y = 0,
    // maxWidth = '100px'
  }, context = this.context) {
    context.strokeText(text, x, y)
    return this
  }
  // 使用矩阵重新设置（覆盖）当前变换的方法
  setTransform({
    scaleX,
    scaleY,
    skewX,
    skewY,
    translateX,
    translateY
  }, context = this.context) {
    context.setTransform(scaleX, scaleY, skewX, skewY, translateX, translateY)
  }
  // 使用矩阵多次叠加当前变换的方法
  transform({
    scaleX,
    scaleY,
    skewX,
    skewY,
    translateX,
    translateY
  }, context = this.context) {
    context.transform(scaleX, scaleY, skewX, skewY, translateX, translateY)
  }
  // 对当前坐标系的原点 (0, 0) 进行变换。默认的坐标系原点为页面左上角。
  translate(x, y, context = this.context) {
    context.translate(x, y)
  }
  // 在调用后，之后创建的路径其横纵坐标会被缩放。多次调用倍数会相乘。
  // 坐标缩放的倍数(1 = 100 % ，0.5 = 50 % ，2 = 200 % )
  scale(scaleWidth = 50, scaleHeight = 50, context = this.context) {
    context.scale(scaleWidth, scaleHeight)
    return this
  }
  // 将之前在绘图上下文中的描述（ 路径、 变形、 样式） 画到 canvas 中。
  draw(reserve, r = s => s) {
    this.context.draw(reserve, r)
  }
  // 保存绘图上下文。
  save(context = this.context) {
    context.save()
    return this
  }
  exportImg(option = {}) {}
}

export default Base