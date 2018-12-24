// promise 化小程序API
function wxPromisify(fn) {
  return (function (params = {}) {
    return new Promise((resolve, reject) => {
      params.success = res => {
        params.showModal && wx.hideLoading();
        resolve(res)
      }
      params.fail = rej => {
        reject(rej)
      }
      fn(params)
    })
  })()
}
// 获取微信用户信息，须在登录之后调用
export function wxGetUserInfo() {
  return wxPromisify(wx.getUserInfo)
}
// 获取系统信息
export function wxGetSystemInfo() {
  return wxPromisify(wx.getSystemInfo)
}
// 获取设置信息
export function wxGetSetting() {
  return wxPromisify(wx.getSetting)
}
// 获取相册信息
export function wxChooseImage() {
  return wxPromisify(wx.chooseImage)
}