import {
  observable,
  autorun,
  action
} from '../vendor/mobx'
var person = observable({
  // observable 属性:
  name: "John",
  age: 42,
  showAge: !false,
  // 计算属性(小程序不支持):
  get labelText() {
    return this.showAge ? `${this.name} (age: ${this.age})` : this.name;
  },
  // 动作:
  setAge(age) {
    this.age = age;
  }
})

// 对象属性没有暴露 'observe' 方法,
// 但不用担心, 'mobx.autorun' 功能更加强大
autorun(() => console.log(person.labelText));

person.name = "Dave";
// 输出: 'Dave'

person.setAge(21);
// 等等

person.showAge = true;


export default person