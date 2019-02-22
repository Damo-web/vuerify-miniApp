# -*- coding: utf-8 -*
#!/usr/local/bin/python3

import re
import os
import shutil

PATH= '/Users/yanli28/Documents'

import os
import shutil


os.chdir(PATH+"/cur/factory")
path1 = os.chdir(PATH+"/cur/factory")
path2 = os.chdir(PATH+"/factory")

# print(os.getcwd())                                    # 确保当前工作目录
# os.rmdir("test1")                                     # 删除 test1 文件夹（空文件夹）
# print(os.listdir(os.getcwd()))
# os.chdir("..\\")
# print(os.getcwd())                                    # 切换到上级目录
# print(os.listdir(os.getcwd()))
# shutil.rmtree("test_mkdir")                           # 删除 test_mkdir 及其下所有文件
# def folderHandler(target,source):
#     shutil.rmtree(target)
#     shutil.copy(target,source)

# folderHandler(path1,path2)
shutil.copy(path1,path2)
