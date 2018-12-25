class myEvent {
  // 添加事件(sub)
  on(event, cb, ctx) {
    if (!(cb instanceof Function)) {
      console.error('cb must be a function')
      return
    }
    this._stores = this._stores || {}
    this._stores[event] = this._stores[event] || []
    this._stores[event].push({
      cb,
      ctx
    })
  }
  //  触发所有事件（pub）
  emit(event, options) {
    this._stores = this._stores || {}
    let events = (this._stores[event] || []).slice(0)
    if (events) {
      events.forEach(item => {
        item.cb.call(item.ctx, options)
      })
    }
  }
  // 解除事件
  off(event, fn) {
    this._stores = this._stores || {}
    // remove all
    if (!arguments.length) {
      this._stores = {}
      return
    }
    // remove specific event
    let stores = this._stores[event]
    if (!stores) {
      return
    }
    // remove all handlers
    if (arguments.length === 1) {
      Reflect.deleteProperty(this._stores, event)
      return
    }
    // remove specific handler
    let cb
    for (let i = 0, len = stores.length; i < len; i++) {
      cb = stores[i].cb
      if (cb === fn) {
        stores.splice(i, 1)
        break
      }
    }
    return
  }
}

export default new myEvent()