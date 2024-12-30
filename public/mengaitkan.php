<?php

$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/../laravel/storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/public/storage';
symlink($targetFolder,$linkFolder);
echo 'Symlink process successfully completed';
?>