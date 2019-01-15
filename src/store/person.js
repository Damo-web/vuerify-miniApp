import {
  extendObservable,
  action,
  spy
} from '../vendor/mobx'

function Person(firstName, lastName) {
  // 在一个新实例上初始化 observable 属性
  extendObservable(this, {
    firstName: firstName,
    lastName: lastName,
    get fullName() {
      return this.firstName + " " + this.lastName
    },
    setFirstName(firstName) {
      this.firstName = firstName
    }
  }, {
    setFirstName: action
  })
}
spy((event) => {
  if (event.type === 'action') {
    console.log(`${event} with args: ${event.arguments}`)
  }
})

var p = new Person("Matthew", "Henry")

export default p