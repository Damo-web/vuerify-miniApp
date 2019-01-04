# 项目初衷及简介

> 初衷： 保持小程序开发不脱离主流，回归H5标准规范，拥抱npm庞大丰富优秀的生态。
使自己在小程序开发中既保持顺利高效完成任务，又保持职业竞争力。


## 做法及尝试

### 改善开发体验第一步：引入前端工程化工具（目前gulp。

> 说明：适用gulp纯粹是因为其比较简单轻便（完全可以用webpack，parcel等工具）。
本项目仅仅引入了scss，less，sourcemap及babel等常用小程序实用包，其它注入ts等可根据项目特点自行扩展。


### promise化成功失败回调

> Promise常用于数据请求，Promise封装小程序原生api，避免callback hell之类的弊端，对提升开发体验及效率非常有意义。
本文只做了最简单的封装。诸如请求拦截可参考axios自行扩展。

### canvas绘图，封装成AOP风格

> canvas 在小程序和 H5 中的 API 基本都是一致的，但有几点不同：

- canvas 上下文的获取方式不同，h5 中是直接从 dom 中获取；
- 小程序里要通过调用 Taro.createCanvasContext 来手动创建；

本文主要针对小程序canvas，根据AOP思想，实现绘图过程的pipline，优化开发体验。 各个绘图类模块相互独立，既可以综合引入，又可以按需引入。

### mixin 扩展

> 与JS传统的扩展一样，采用侵入式扩展了Page构造函数。

### watch 及 computed 添加

> 由于小程序中没有watch及computed的实现（Component的observer算个鸡肋）。由于小程序语法层尚未支持Proxy，本文参考vue思路，根据ES5的Object.defineProperty实现了watch及computed。

### 实现sub-pub模式的页面通讯；store 引入 ，计划引入mobx

> 由于小程序中没有状态机的概念，跨组件跨页面的通讯尚未实现（恶心的路由传参及利用全局变量通讯满足不了稍微复杂的场景），首先考虑到的是利用自定义事件（custom-event，鉴于Polymer思路），但小程序阉割了浏览器document及window对象，万般无奈之下，只能手动实现了一个最简单的数据集散中心对象，类似vue的event-bus，基于发布-订阅设计模式。

而对于复杂场景，还是拥抱轻便灵活mobx。

### filter 引入，todo

### 常用组件[上拉加载，音频播放器，，，]

> 不得不吐槽，小程序组件系统做的真差。建议不要搞多于三层级别的组件。 另外由于window及document对象的被阉割，很多组件如果涉及这俩对象上的东西，比如（scroll等），很难独立适用，也很难成为严格意义上的组件。

> 封装组件的初衷在于模块化分工及代码复用，本文将来会尽可能集成更多的组件。
