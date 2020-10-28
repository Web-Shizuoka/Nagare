#!/bin/bash

cd `dirname $0`  #カレントディレクトリに移動

npm init -y  #package.jsonの生成

npm install -D webpack webpack-cli babel-loader @babel/core @babel/preset-env  #モジュールのインストール

npm install jquery  #jQueryのインストール

npm run build  #webpackの実行