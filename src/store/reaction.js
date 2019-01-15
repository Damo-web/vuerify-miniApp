import {
  observable,
  autorun,
  action,
  reaction
} from '../vendor/mobx'

const counter = observable({
  count: 0
});

// 只调用一次并清理掉 reaction : 对 observable 值作出反应。
const reaction3 = reaction(
  () => counter.count,
  (count, reaction) => {
    console.log("reaction 3: invoked. counter.count = " + count);
    reaction.dispose();
  }
);

counter.count = 1;
// 输出:
// reaction 3: invoked. counter.count = 1

counter.count = 2;
// 输出:
// (There are no logging, because of reaction disposed. But, counter continue reaction)

console.log(counter.count);

export default counter