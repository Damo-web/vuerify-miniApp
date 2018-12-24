import Base from './Base'
import Line from './Line'
import Text from './Text'
import Rec from './Rec'
import Arc from './Arc'
import Img from './Img'
import {
  mixinClass,
} from '../../utils/index'

class Index extends mixinClass(Base, Line, Rec, Arc, Img, Text) {
  constructor(params) {
    super(params)
  }
}

export default Index