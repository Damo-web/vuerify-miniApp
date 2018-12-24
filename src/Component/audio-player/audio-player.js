import {
  convertTimeToSeconds,
  processTotalDuration,
} from '../../utils/index'
const app = getApp()
Component({
  properties: {
    node: {
      type: Object,
    },
    id: {
      type: String,
    },
  },
  data: {
    audioInfo: {
      src: 'http://ws.stream.qqmusic.qq.com/M500001VfvsJ21xFqb.mp3?guid=ffffffff82def4af4b12b3cd9337d5e7&uin=346897220&vkey=6292F51E1E384E061FF02C31F716658E5C81F5594D561F2E88B854E81CAAB7806D5E4F103E55D33C16F3FAC506D1AB172DE8600B37E43FAD&fromtag=46', //音频的数据源（ 2.2 .3 开始支持云文件ID）。 默认为空字符串， 当设置了新的 src 时， 会自动开始播放， 目前支持的格式有 m4a, aac, mp3, wav。
      startTime: 0, //音频开始播放的位置（ 单位： s）。
      title: 'ewrw', //音频标题， 用于原生音频播放器音频标题（ 必填）。 原生音频播放器中的分享功能， 分享出去的卡片标题， 也将使用该值。
      epname: '324', //专辑名， 原生音频播放器中的分享功能， 分享出去的卡片简介， 也将使用该值。
      singer: 'asgr243', //歌手名， 原生音频播放器中的分享功能， 分享出去的卡片简介， 也将使用该值。
      coverImgUrl: 'http://y.gtimg.cn/music/photo_new/T002R300x300M000003rsKF44GyaSk.jpg?max_age=2592000', // 封面图 URL， 用于做原生音频播放器背景图。 原生音频播放器中的分享功能， 分享出去的卡片配图及背景也将使用该图。
      webUrl: '324', // 页面链接， 原生音频播放器中的分享功能， 分享出去的卡片简介， 也将使用该值。
      protocol: '324', //基础库 1.9 .94 开始支持， 低版本需做兼容处理。
      duration: 200, //当前音频的长度（ 单位： s）， 只有在有合法 src 时返回。（ 只读）
      currentTime: 5, //当前音频的播放位置（ 单位： s）， 只有在有合法 src 时返回。（ 只读）
      paused: false, // 当前是否暂停或停止。（ 只读）
      isPlaying: false, // 当前是否暂停或停止。（ 只读）
      buffered: 5, //音频已缓冲的时间， 仅保证当前播放时间点到此时间点内容已缓冲。（ 只读）
    },
    currentTime: '00:00',
    duration: '00:00'
  },
  attached() {
    this.audioInit()
  },

  methods: {
    audioInit() {
      const audio = app.globalData.backgroundAudioManager
      audio.src = this.data.audioInfo.src
      audio.onCanplay = e => {
        //监听背景音频进入可播放状态事件。 但不保证后面可以流畅播放
      }
      audio.onWaiting = e => {
        //监听音频加载中事件。 当音频因为数据不足， 需要停下来加载时会触发
      }
      audio.onError = e => {
        //监听背景音频播放错误事件
        console.log('error...')
      }
      audio.onPlay = e => {
        //监听背景音频播放事件
        console.log('playing...')
        this.onMusicTap()
      }
      audio.onPause = e => {
        //监听背景音频暂停事件 监听背景音频播放事件
        console.log('pausing...')
        this.onMusicTap()
      }
      audio.onSeeking = e => {
        //监听背景音频开始跳转操作事件
      }
      audio.onSeeked = e => {
        //监听背景音频完成跳转操作事件
      }
      audio.onEnded = e => {
        //监听背景音频自然播放结束事件
        console.log('endding...')
      }
      audio.onStop = e => {
        //监听背景音频停止事件
        console.log('stopping...')
      }
      audio.onTimeUpdate(e => {
        //监听背景音频播放进度更新事件
        let patchCurrentTime = ''
        if (audio.duration > 1.5) {
          patchCurrentTime = audio.currentTime < audio.duration - 1.50 ? audio.currentTime + 1.50 : 0
        } else {
          patchCurrentTime = audio.currentTime
        }
        this.setData({
          duration: processTotalDuration(audio.duration),
          currentTime: processTotalDuration(patchCurrentTime),
          percent: (audio.currentTime / audio.duration) * 100
        })
      })
      audio.onNext = e => {
        //监听用户在系统音乐播放面板点击下一曲事件（ 仅iOS）
        console.log('next...')
      }
      audio.onPrev = e => {
        // 监听用户在系统音乐播放面板点击上一曲事件（ 仅iOS）
        console.log('prev...')
      }
    },
    onMusicTap() {
      const audio = app.globalData.backgroundAudioManager
      let isPlaying = !this.data.audioInfo.isPlaying

      if (isPlaying) {
        audio.src = this.data.audioInfo.src
        audio.title = this.data.audioInfo.title
        console.log('play')
        audio.play()
      } else {
        console.log('pause')
        audio.pause()
      }
      this.setData()
      this.setData({
        ['audioInfo.isPlaying']: isPlaying
      })
    },
  }

})