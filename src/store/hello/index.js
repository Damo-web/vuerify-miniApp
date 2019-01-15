import {
  action,
  autorun,
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
const store = new Store()
autorun(() => {
  if (store.seconds > 1000) {
    console.log(store.seconds)
  }
}, {
  onError(e) {
    console.error("Please debug!")
  }
})

export default store