import {
  observable,
  autorun,
  action,
  reaction
} from '../vendor/mobx'

const todos = observable([{
    title: "Make coffee",
    done: true,
  },
  {
    title: "Find biscuit",
    done: false
  }
])
// reaction 的错误用法: 对 length 的变化作出反应, 而不是 title 的变化!
const reaction1 = reaction(
  () => todos.length,
  length => console.log("reaction 1:", todos.map(todo => todo.title).join(", "))
);

// reaction 的正确用法: 对 length 和 title 的变化作出反应
const reaction2 = reaction(
  () => todos.map(todo => todo.title),
  titles => console.log("reaction 2:", titles.join(", "))
);

// autorun 对它函数中使用的任何东西作出反应
const autorun1 = autorun(
  () => console.log("autorun 1:", todos.map(todo => todo.title).join(", "))
);

todos.push({
  title: "explain reactions",
  done: false
});

export default todos