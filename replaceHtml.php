<?php

require_once 'replaceConfig.php';

$fileNameArray = array();
if ($handle = opendir($dir)) {
    while (($file = readdir($handle)) !== false){
        if (!in_array($file, array('.', '..')) && !is_dir($dir.$file))
            $fileNameArray[] = $file;
    }
}


foreach ($fileNameArray as $eachFile) {

    $htmlContent = file_get_contents($dir . $eachFile);
    if (!file_exists('backup/')) {
        mkdir('backup/');
    }
    file_put_contents('backup/' .$eachFile, $htmlContent);

    foreach ($replaceArray as $replaceCondition) {
        $frontExpr = $replaceCondition['beginWith'];
        $backExpr = escapeRegularExprString($replaceCondition['endWith']);
        $replaceTo = $replaceCondition['replaceTo'];
        if (!$backExpr) {
            $regExpr = '/' . $frontExpr . '/';
        } else {
            $regExpr = '/' . $frontExpr . '[^\r]+' . $backExpr . '/';
        }
        $htmlContent = preg_replace($regExpr, $replaceTo, $htmlContent);

        echo $htmlContent;
        file_put_contents($dir . $eachFile, $htmlContent);
    }
}


var_dump($fileNameArray);

function escapeRegularExprString ($oriString) {
    $stringNeedToParseArray = array(
        '/'
    );
    foreach ($stringNeedToParseArray as $needToParse) {
        $oriString = str_replace($needToParse, '\/', $oriString);
    }
    return $oriString;
}