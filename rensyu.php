<?php
// 現在のユーザー名を取得
echo 'My username is ' . $_ENV['USER'] . '!<br>';

// ホームディレクトリを取得
echo 'My home directory is ' . $_ENV['HOME'] . '!<br>';

// PHPの実行パスを取得
echo 'PHP is running from ' . $_ENV['PATH'] . '!<br>';

// 使用されているシェルを取得
echo 'My shell is ' . $_ENV['SHELL'] . '!<br>';
