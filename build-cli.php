<?php
/*
 * @Author: gogoend
 * @Date: 2020-07-04 00:05:17
 * @LastEditors: gogoend
 * @LastEditTime: 2020-07-04 00:13:19
 * @FilePath: \git-webhook\build-cli.php
 * @Description: 
 */ 

 var_dump($argv);

 $repoName = $argv[1];
 if (file_exists('auth-config.php')) {
    include('auth-config.php');
} else {
    echo '发生错误 - 配置文件无效';
    exit(1);
}
 if(!$argv[1]){
     echo '未指定仓库';
     exit(1);
 }

 echo (exec(PROJECT_BASE_FOLDER.$repoName.'/runbuild.sh'));
