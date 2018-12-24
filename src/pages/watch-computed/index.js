import {
    watch,
    computed
} from '../../Extend/vuefy'
Page({
    data: {
        test: 2345,
        test1: 'test1',
    },
    onLoad() {
        computed(this, {
            test2: function () {
                return this.data.test + '--test2'
            },
            test3: function () {
                return this.data.test + '--test3'
            }
        })
        watch(this, {
            test: function (newVal) {
                console.log('invoke watch', newVal)
                this.setData({
                    test1: newVal + '--test'
                })
            }
        })
    },
    changeTest() {
        this.setData({
            // ['test.a']: Math.random().toFixed(5), not surport this ones
            test: Math.random().toFixed(5),
        })
    },
})