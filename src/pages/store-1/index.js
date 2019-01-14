import {
  observer
}
from '../../vendor/observer'
import {
  action
} from '../../vendor/mobx'
import todos from '../../store/todos/index'
import globalStore from '../../store/hello/index'
Page(observer({
  props: {
    todos,
    globalStore
  },
  data: {
    title: '',
  },
  onLoad() {
    let that = this
    setInterval(r => {
      that.handleSeconds()
    }, 1000)
  },

  handleCheck(e) {
    let todoId = parseInt(e.target.dataset.id)
    let status = this.props.todos.findByTodoId(todoId).completed
    this.props.todos.findByTodoId(todoId).completed = !status
  },

  handleSeconds() {
    this.props.globalStore.tick()
  },

  applyFilter: action(function (e) {
    this.props.todos.filter = e.target.dataset.key
  }),

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