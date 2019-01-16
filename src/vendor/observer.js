import {
  autorun,
  observable,
  isObservable,
  isObservableArray,
  isObservableObject,
  isObservableValue,
  isObservableMap,
} from './mobx'
import diff from './diff'
// 合并getter值
function _mergeGetterValue(res, object) {
  Object.getOwnPropertyNames(object).forEach(function (propertyName) {
    if (propertyName === "$mobx") {
      return
    };
    var descriptor = Object.getOwnPropertyDescriptor(object, propertyName);
    if (descriptor && !descriptor.enumerable && !descriptor.writable) {
      res[propertyName] = toJS(object[propertyName]);
    }
  })
}
// dump observer对象
function toJS(source, detectCycles, __alreadySeen) {
  if (detectCycles === void 0) {
    detectCycles = true;
  }
  if (__alreadySeen === void 0) {
    __alreadySeen = [];
  }

  function cache(value) {
    if (detectCycles)
      __alreadySeen.push([source, value]);
    return value;
  }

  if (isObservable(source)) {
    if (detectCycles && __alreadySeen === null)
      __alreadySeen = [];
    if (detectCycles && source !== null && typeof source === "object") {
      for (var i = 0, l = __alreadySeen.length; i < l; i++)
        if (__alreadySeen[i][0] === source)
          return __alreadySeen[i][1];
    }
    if (isObservableArray(source)) {
      var res = cache([]);
      var toAdd = source.map(function (value) {
        return toJS(value, detectCycles, __alreadySeen);
      });
      res.length = toAdd.length;
      for (var i = 0, l = toAdd.length; i < l; i++)
        res[i] = toAdd[i];
      return res;
    }
    if (isObservableObject(source)) {
      var res = cache({});
      for (var key in source)
        res[key] = toJS(source[key], detectCycles, __alreadySeen);
      _mergeGetterValue(res, source);
      return res;
    }
    if (isObservableMap(source)) {
      var res_1 = cache({});
      source.forEach(function (value, key) {
        return res_1[key] = toJS(value, detectCycles, __alreadySeen);
      });
      return res_1;
    }
    if (isObservableValue(source))
      return toJS(source.get(), detectCycles, __alreadySeen);
  }

  if (Array.isArray(source)) {
    return source.map(value => toJS(value))
  }
  if (source !== null && typeof source === 'object') {
    return Object.keys(source).reduce((target, key) => target[key] = toJS(source[key]), {})
  }
  return source
}
// 扩展的小程序observer
function observer(options) {
  var oldOnLoad = options.onLoad;
  var oldOnUnload = options.onUnload;
  options._update = function () {
    var props = this.props || {};
    var diffProps = diff(toJS(props), this.data.props);
    console.log(diffProps); //diff props
    if (Object.keys(diffProps).length > 0) {
      var hash = {};
      for (var key in diffProps) {
        var hash_key = 'props' + '.' + key;
        hash[hash_key] = diffProps[key]
      }
      this.setData(hash);
    }
  }
  options.onLoad = function () {
    var that = this
    // support observable props here
    that.props = observable(that.props)
    that._autorun = autorun(function () {
      // console.log('autorun');
      that._update()
    })
    if (oldOnLoad) {
      oldOnLoad.apply(this, arguments)
    }
  }
  options.onUnload = function () {
    // clear autorun
    this._autorun();
    if (oldOnUnload) {
      oldOnUnload.apply(this, arguments)
    }
  }
  return options;
}

export {
  observer,
  toJS,
}