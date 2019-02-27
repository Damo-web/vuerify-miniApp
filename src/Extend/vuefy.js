function watch(ctx, obj) {
  Object.keys(obj).forEach(key => {
    reactComputed(ctx.data, key, ctx.data[key], function (value) {
      obj[key].call(ctx, value)
    })
  })
}

function computed(ctx, obj) {
  let targetKeys = Object.keys(obj)
  let keys = Object.keys(ctx.data)
  keys.forEach(key => {
    reactComputed(ctx.data, key, ctx.data[key])
  })
  let computedTarget = targetKeys.reduce((prev, next) => {
    ctx.data.$target = function () {
      ctx.setData({
        [next]: obj[next].call(ctx)
      })
    }
    prev[next] = obj[next].call(ctx)
    ctx.data.$target = null
    return prev
  }, {})
  ctx.setData(computedTarget)
}

function reactComputed(data, key, val, fn) {
  let subs = data['$' + key] || []
  Object.defineProperty(data, key, {
    configurable: true,
    enumerable: true,
    get() {
      if (data.$target) {
        subs.push(data.$target)
        data['$' + key] = subs
      }
      return val
    },
    set(newVal) {
      if (newVal === val) return
      fn && fn(newVal)
      if (subs.length) {
        // 用 microtask 因为此时 this.data 还没更新
        Promise.resolve().then(res => {
          subs.forEach(sub => sub())
        })
      }
      val = newVal
    },
  })
}

export {
  watch,
  computed
}