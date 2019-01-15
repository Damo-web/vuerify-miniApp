import {
  observer
}
from '../../vendor/observer'
import {
  action
} from '../../vendor/mobx'
import todos from '../../store/todos/index'
import hello from '../../store/hello/index'
hello.seconds = 100
Page(observer({
  props: {
    todos,
    hello
  },
  data: {
    title: ''
  },
  onLoad() {
    this.props.hello.seconds = 1000
  },

  handleCheck(e) {
    let todoId = parseInt(e.target.dataset.id)
    let status = this.props.todos.findByTodoId(todoId).completed
    this.props.todos.findByTodoId(todoId).completed = !status
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
  },
  go() {
    wx.navigateTo({
      url: '/pages/store-1/index',
    })
  }
}))