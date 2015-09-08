# README

## Install

1. import the sql files "taoyizhang.sql" to the local database
2. change the database information in "\phphomework\boot\config.php" and "phphomework\admin\boot\config.php"
$array['host'] = 'phpmyadmin.helios.csesalford.com';
$array['database'] = 'wbsd12';
$array['user'] = 'wbsd12';
$array['password'] = 'php54';
3. change the folder name in "\phphomework\admin\index.php" and "\phphomework\index.php"
define('DIR', '/phphomework/');
4. the front-page url is "localhost/phphomework/" and the back-page url is "localhost/phphomework/admin/
and the admin username:admin password:8888

## Introduction

This is a online electronic product shop.
Some introduction about the code is shown below.

1. All class is named according to "path_filename" such as for controller order, the class name is controllers_order.
2. The "layout" folder is put some "javascript" and "css" files.
