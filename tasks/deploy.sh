#!/bin/bash

git add .
git ci -m $1 $2 $3
git push
