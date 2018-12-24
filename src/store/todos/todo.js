import {
  extendObservable
} from '../../vendor/mobx'

let uuid = 0

function TodoItemStore(title) {
  uuid++
  extendObservable(this, {
    title,
    id: uuid,
    completed: false,
    get ids() {
      return this.id + ": " + this.title
    }
  })
}

export default TodoItemStore