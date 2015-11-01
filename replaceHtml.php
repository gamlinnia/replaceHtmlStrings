<?php

$htmlContent = file_get_contents('index199b.html');

$frontExpr = '<div id=top>';
$backExpr = '<script type="text\/javascript">';

if (!$backExpr) {
    $regExpr = '/' . $frontExpr . '/';
} else {
    $regExpr = '/' . $frontExpr . '[^\r]+' . $backExpr . '/';
}

$replacedHtmlContent = preg_replace($regExpr, 'yes, i did it', $htmlContent);

echo $replacedHtmlContent;