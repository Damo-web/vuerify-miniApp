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
/*
相较于之前，增加了几行代码，我们声明了一个变量来保存所有在变化时需要执行的函数，在 set 时执行每一个函数，因为此时 this.data.test 的值还未改变，使用 setTimeout 在下一轮再执行。现在就有一个问题，怎么将函数添加到 subs 中。不知道各位还是否记得上面我们说到的在 reduce 里的那两行代码。

因为在执行计算 test1 和 test2 第一次 computed 值的时候，会调用 test 的 getter 方法，此刻就是一个好机会将函数注入到 subs 中，在 data 上声明一个 $target 变量，并将需要执行的函数赋值给该变量，这样在 getter 中就可以判断 data 上有无 target 值，从而就可以 push 进 subs。

要注意的是需要马上将 target 设为 null，这就是第二句的用途，这样就达到了一石二鸟的作用。当然，这其实就是 vue 里的原理，只不过这里没那么复杂。

到此为止已经实现了 watch 和 computed，但是还没完，有个问题。当同时使用这两者的时候，watch 里的对象的键也同时存在于 data 中，这样就会重复在该变量上调用 Object.defineProperty ，后面会覆盖前面。因为这里不像 vue 里可以决定两者的调用顺序，因此我们推荐先写 computed 再写 watch，这样可以 watch computed 里的值。这样就有一个问题，computed 会因覆盖而无效。

思考一下为什么？

很明显，这时因为之前的 subs 被重新声明为空数组了。这时，我们想一个简单的方法就是把之前 computed 里的 subs 存在一个地方，下一次调用 defineReactive 的时候看对应的 key 是否已经有了 subs，这样就可以解决问题。修改一下代码。
*/

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