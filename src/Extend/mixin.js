/**
 * @yanli
 */
const extendedPage = Page
Page = options => {
  const mixins = options.mixins
  if (Array.isArray(mixins)) {
    Reflect.deleteProperty(options, 'mixins') // 去除Page对mixins的处理
    merge(mixins, options) // 合并混入的mixins
  }
  extendedPage(options)
}

// 合并mixins属性到Page的options中
function merge(mixins, options) {
  mixins.forEach(mixin => {
    if (Object.prototype.toString.call(mixin).slice(8, -1) === 'Object') {
      for (let key of Object.keys(mixin)) { // 没用新语法，向下兼容
        let value = mixin[key]
        if (key === 'data') {
          options.data = Object.assign({}, value, options.data)
        } else {
          let native = options[key]
          options[key] = function (...args) {
            value.call(this, ...args)
            native && native.call(this, ...args)
          }
        }
      }
    }
  })
}