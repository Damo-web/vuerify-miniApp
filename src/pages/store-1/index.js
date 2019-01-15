import {
  observer
} from '../../vendor/observer'
import todos from '../../store/todos/index'
import hello from '../../store/hello/index'
import person from '../../store/person'
import personObject from '../../store/personObject'
import todos2 from '../../store/todos2'
import counter from '../../store/reaction'

Page(observer({
  props: {
    todos,
    hello,
    person,
    personObject,
    todos2,
    counter
  },
  data: {
    title: '',
  },
  onLoad() {
    // let that = this
    // setInterval(r => {
    //   that.handleSeconds()
    // }, 1000)
  },

  handleSeconds() {
    this.props.hello.tick()
  },

  addTodo(e) {
    const title = e.detail.value
    if (!title) {
      wx.showToast({
        title: '输入内容不能为空',
        icon: 'none',
        duration: 1000
      })
      return
    }
    this.props.todos.addTodo(title)
    this.setData({
      title: ''
    })
  }
}))