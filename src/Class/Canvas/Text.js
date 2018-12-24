import Base from './Base'
class Text extends Base {
  constructor(params) {
    super(params)
  }
  text({
    text = '',
    x = 0,
    y = 0,
    color = 'red',
    fontSize = '20px',
    align = 'left',
    baseline = 'top'
    // maxWidth = '100px'
  }, context = this.context) {
    context.fillStyle = color;
    context.setFontSize(fontSize)
    this.fillText({
      text,
      x,
      y
    })
    context.setTextAlign(align)
    context.setTextBaseline(baseline)
    return this
  }
}

export default Text