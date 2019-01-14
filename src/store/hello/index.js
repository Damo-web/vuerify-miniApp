import {
  observable,
  computed,
  action,
  decorate,
  extendObservable
} from '../../vendor/mobx'

function Store() {
  extendObservable(this, {
    seconds: 0,
    get color() {
      return this.seconds % 2 === 0 ? "red" : "green";
    }
  })
  this.tick = action(e => this.seconds++)
}

export default new Store