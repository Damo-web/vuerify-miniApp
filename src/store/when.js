import {
  observable,
  when,
  action,
  reaction
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

setTimeout(r => {
  whener.age = 30
}, 1000)

export default whener