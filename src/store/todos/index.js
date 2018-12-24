import {
  action,
  extendObservable
} from '../../vendor/mobx'
import Todo from './todo'

function TodoStore() {
  extendObservable(this, {
    todos: ['引入前端工程化工具（目前gulp），使npm可用，改善开发体验。', 'promise化成功失败回调', 'canvas绘图，封装成AOP风格', 'mixin 扩展', 'watch 添加', 'computed 添加', 'store 引入， 计划引入mobx', 'filter 引入， todo', '常用组件[上拉加载， 音频，，，]'].map(title => new Todo(title)),
    filters: [{
      key: 'SHOW_ALL',
      text: '全部'
    }, {
      key: 'SHOW_ACTIVE',
      text: '正在进行'
    }, {
      key: 'SHOW_COMPLETED',
      text: '已完成'
    }],
    filter: 'SHOW_ALL',
    get filterTodos() {
      switch (this.filter) {
        case this.filters[0].key:
          return this.todos
        case this.filters[1].key:
          return this.todos.filter(t => !t.completed)
        case this.filters[2].key:
          return this.todos.filter(t => t.completed)
        default:
          throw new Error('Unknown filter: ' + filter)
      }
    },
    get totalCount() {
      return this.todos.length
    },
    get currentCount() {
      return this.filterTodos.length
    }
  })

  this.addTodo = action(title => this.todos.push(new Todo(title)))
  this.findByTodoId = action(id => this.todos.find(element => element.id === id))
}

export default new TodoStore