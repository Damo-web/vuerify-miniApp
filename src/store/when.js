import {
  observable,
  when,
  toJS,
  isObservableObject
} from '../vendor/mobx'

const whener = observable({
  firstName: 'Matt',
  lastName: 'Ruby',
  age: 1
});

when(
  function () {
    console.log('Age: ' + whener.age);
    return whener.age >= 20;
  },
  function () {
    console.log('You\'re too old now.  I\'m done watching.');
  }
)

var clone = toJS(whener);

console.log(whener,isObservableObject(whener)); // true
console.log(clone,isObservableObject(clone)); // false
whener.age = 10

setTimeout(r => {
  whener.age = 30
}, 1000)

export default whener