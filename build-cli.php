<?php
/*
 * @Author: gogoend
 * @Date: 2020-07-04 00:05:17
 * @LastEditors: gogoend
 * @LastEditTime: 2020-07-04 01:34:54
 * @FilePath: \git-webhook\build-cli.php
 * @Description: 
 */

// var_dump($argv);
if (array_key_exists(1, $argv)) {
    $repoName = $argv[1];
} else {
    echo '发生错误 - 参数中未指定仓库名称\n';
    exit(1);
}
if (file_exists('auth-config.php')) {
    include('auth-config.php');
} else {
    echo '发生错误 - 配置文件无效\n';
    exit(1);
}

$runBuildFilePath = PROJECT_BASE_FOLDER . $repoName;
if(!is_dir($runBuildFilePath)){
    echo "发生错误 - 找不到 $repoName 仓库\n";
    exit(1);
}
if (!file_exists($runBuildFilePath . '/runbuild.sh')) {
    echo "发生错误 - 找不到 $repoName 仓库根目录下的runbuild.sh\n";
    exit(1);
}

echo (shell_exec("cd $runBuildFilePath && ./runbuild.sh 2>&1"));