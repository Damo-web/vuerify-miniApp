import {
    observer
} from '../../utils/observer'
import {
    action
} from '../../vendor/mobx'
import todos from '../../store/todos/index'
Page(observer({
    props: {
        todos,
    },
    data: {
        title: ''
    },

    handleCheck(e) {
        let todoId = parseInt(e.target.dataset.id)
        let status = this.props.todos.findByTodoId(todoId).completed
        this.props.todos.findByTodoId(todoId).completed = !status
    },

    applyFilter: action(function (e) {
        this.props.todos.filter = e.target.dataset.key
    }),

    todosFiltered() {
        return this.props.todos.filterBy()
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