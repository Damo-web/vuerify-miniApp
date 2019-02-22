#!/usr/bin/env python3.7
# -*- coding: utf-8 -*-
# import pinyin
import json

import requests

# def to_pinyin(var_str):
#     """
#     汉字[钓鱼岛是中国的]=>拼音[diaoyudaoshizhongguode]\n
#     汉字[我是shui]=>拼音[woshishui]\n
#     汉字[AreYou好]=>拼音[AreYouhao]\n
#     汉字[None]=>拼音[]\n
#     汉字[]=>拼音[]\n
#     :param var_str:  str 类型的字符串
#     :return: 汉字转小写拼音
#     """
#     if isinstance(var_str, str):
#         if var_str == 'None':
#             return ""
#         else:
#             return pinyin.get(var_str, format='strip', delimiter="")
#     else:
#         return '类型不对'
# a = to_pinyin('aaa')

print(a)

def translate(word):
    # 有道词典 api
    url = 'http://fanyi.youdao.com/translate?smartresult=dict&smartresult=rule&smartresult=ugc&sessionFrom=null'
    # 传输的参数，其中 i 为需要翻译的内容
    key = {
        'type': "AUTO",
        'i': word,
        "doctype": "json",
        "version": "2.1",
        "keyfrom": "fanyi.web",
        "ue": "UTF-8",
        "action": "FY_BY_CLICKBUTTON",
        "typoResult": "true"
    }
    # key 这个字典为发送给有道词典服务器的内容
    response = requests.post(url, data=key)
    # 判断服务器是否相应成功
    if response.status_code == 200:
        # 然后相应的结果
        return response.text
    else:
        print("有道词典调用失败")
        # 相应失败就返回空
        return None

def get_reuslt(repsonse):
    # 通过 json.loads 把返回的结果加载成 json 格式
    result = json.loads(repsonse)
    print ("输入的词为：%s" % result['translateResult'][0][0]['src'])
    print ("翻译结果为：%s" % result['translateResult'][0][0]['tgt'])

def main():
    print("本程序调用有道词典的API进行翻译，可达到以下效果：")
    print("外文-->中文")
    print("中文-->英文")
    word = input('请输入你想要翻译的词或句：')
    list_trans = translate(word)
    get_reuslt(list_trans)

if __name__ == '__main__':
    main()
