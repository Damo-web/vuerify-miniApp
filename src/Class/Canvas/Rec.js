import Base from './Base'
class Rec extends Base {
  constructor(params) {
    super(params)
  }
  rec({
    x = 0,
    y = 0,
    width = 200,
    height = 200
  }, context = this.context) {
    this.init('red', 3)
    context.rect(x, y, width, height)
    return this
  }
}

export default Rec