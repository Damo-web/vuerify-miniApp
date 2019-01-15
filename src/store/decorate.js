import {
  observable,
  computed,
  action,
  decorate
}
from '../vendor/mobx'
// not surpport here in miniApp...
class Timer {
  constructor(){
    this.start = Date.now();
    this.current = Date.now();
  }
  get elapsedTime() {
    return this.current - this.start + "milliseconds";
  }

  tick() {
    this.current = Date.now()
  }
}
decorate(Timer, {
  start: observable,
  current: observable,
  elapsedTime: computed,
  tick: action
})

export default new Timer()