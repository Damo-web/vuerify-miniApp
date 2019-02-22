# -*- coding: utf-8 -*
#!/usr/local/bin/python3

import re
import os
import pinyin

PATH= '/Users/yanli28/Documents/vipMobileWebsite/vue-admin/src/assets/app/'


def toPinyin(var_str):
    """
    汉字[钓鱼岛是中国的]=>拼音[diaoyudaoshizhongguode]\n
    汉字[我是shui]=>拼音[woshishui]\n
    汉字[AreYou好]=>拼音[AreYouhao]\n
    汉字[None]=>拼音[]\n
    汉字[]=>拼音[]\n
    :param var_str:  str 类型的字符串
    :return: 汉字转小写拼音
    """
    if isinstance(var_str, str):
        if var_str == 'None':
            return ""
        else:
            return pinyin.get(var_str, format='strip', delimiter="")
    else:
        return '类型不对'


def fileFilter(path,prefix='') :
  for file in os.listdir(path):
      lens = len(path)
      old_filePath = os.path.join(path, file)
      new_filePath =  old_filePath.replace(' ', '')
      if old_filePath.endswith('@2x.png') or old_filePath.endswith('@2x.jpg'):
        os.remove(old_filePath)
      if os.path.exists(old_filePath):
        # os.rename(old_filePath, toPinyin(new_filePath[0:lens] + prefix +new_filePath[lens: -1]))
        pass
fileFilter(PATH, 'hello')