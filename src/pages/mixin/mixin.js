  export const mixin1 = {
      data: {
          dataFromMixin: '00:00',
      },
      handler() {
          console.log('handler in mixin was called .')
      }
  }
  export const mixin2 = {
      test() {
          console.log('test in mixin was called .')
      }
  }