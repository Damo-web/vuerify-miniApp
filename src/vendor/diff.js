// https://github.com/Tencent/westore/blob/master/utils/diff.js

const ARRAYTYPE = "[object Array]";
const OBJECTTYPE = "[object Object]";
const FUNCTIONTYPE = "[object Function]";

export default function diff(current, pre) {
  const result = {};
  syncKeys(current, pre);
  _diff(current, pre, "", result);
  return result;
}
// 针对前对象作数据对齐：拿当前对象各个成员对应前对象相应成员，当前没有则用null占位（为diff作准备）
function syncKeys(current, pre) {
  if (current === pre) return;
  const rootCurrentType = type(current);
  const rootPreType = type(pre);
  if (rootCurrentType == OBJECTTYPE && rootPreType == OBJECTTYPE) {
    if (Object.keys(current).length >= Object.keys(pre).length) {
      for (let key in pre) {
        if (current[key] === undefined) {
          current[key] = null;
        } else {
          syncKeys(current[key], pre[key]);
        }
      }
    }
  } else if (rootCurrentType == ARRAYTYPE && rootPreType == ARRAYTYPE) {
    if (current.length >= pre.length) {
      pre.forEach((item, index) => {
        syncKeys(current[index], item);
      });
    }
  }
}
// diff属性
function _diff(current, pre, path, result) {
  if (current === pre) {
    return
  }
  const rootCurrentType = type(current);
  const rootPreType = type(pre);
  if (rootCurrentType == OBJECTTYPE) {
    // 如果根对象类型变或者根对象长度变小了
    if (rootPreType != OBJECTTYPE || Object.keys(current).length < Object.keys(pre).length) {
      setResult(result, path, current);
    } else { //否则
      for (let key in current) {
        const currentValue = current[key];
        const preValue = pre[key];
        const currentType = type(currentValue);
        const preType = type(preValue);
        if (currentType != ARRAYTYPE && currentType != OBJECTTYPE) {
          if (currentValue != pre[key]) {
            setResult(result, (path == "" ? "" : path + ".") + key, currentValue)
          }
        } else if (currentType == ARRAYTYPE) {
          if (preType != ARRAYTYPE) {
            setResult(result, (path == "" ? "" : path + ".") + key, currentValue);
          } else {
            if (currentValue.length < preValue.length) {
              setResult(result, (path == "" ? "" : path + ".") + key, currentValue);
            } else {
              currentValue.forEach((item, index) => {
                _diff(item, preValue[index], (path == "" ? "" : path + ".") + key + "[" + index + "]", result);
              });
            }
          }
        } else if (currentType == OBJECTTYPE) {
          if (preType != OBJECTTYPE || Object.keys(currentValue).length < Object.keys(preValue).length) {
            setResult(result, (path == "" ? "" : path + ".") + key, currentValue);
          } else {
            for (let subKey in currentValue) {
              _diff(currentValue[subKey], preValue[subKey], (path == "" ? "" : path + ".") + key + "." + subKey, result);
            }
          }
        }
      }
    }
  } else if (rootCurrentType == ARRAYTYPE) {
    if (rootPreType != ARRAYTYPE || current.length < pre.length) {
      setResult(result, path, current);
    } else {
      current.forEach((item, index) => {
        _diff(item, pre[index], path + "[" + index + "]", result);
      })
    }
  } else {
    setResult(result, path, current);
  }
}

function setResult(result, k, v) {
  if (type(v) != FUNCTIONTYPE) {
    result[k] = v;
  }
}

function type(obj) {
  return Object.prototype.toString.call(obj);
}