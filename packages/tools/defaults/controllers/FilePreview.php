<?php

namespace Packages\tools\defaults\controllers;


use Packages\bikiran\FileUpload;
use Packages\mysql\QuerySelect;

class FilePreview
{
    private string $defaultMode = "inline";
    private array $modeAr = [
        'inline' => 'inline',
        'attachment' => 'attachment',
    ];

    function previewFileById()
    {
        $mode = $this->modeAr[$_GET['mode']] ?: $this->defaultMode;

        $fileId = route()->getUriVariablesAr()['fileId'];
        //$fileName = route()->getUriVariablesAr()['fileName'];

        //--Collect File Path
        $filePath = FileUpload::getFilePathById($fileId);

        //--Collect File Info
        $select = new QuerySelect("system_files");
        $select->setQueryString("
        SELECT * 
        FROM `system_files` 
        WHERE `file_id`=" . quote($fileId) . "
        ");
        $select->pull();
        $fileInfo_ar = $select->getRow();

        header("Content-Disposition: {$mode}; filename=\"{$fileInfo_ar['name']}\"");
        header("Cache-Control: max-age=604800, public");
        header("Pragma: cache");
        header("Content-Type: {$fileInfo_ar['type']}");
        header("Expires: " . date("D, d M Y H:i:s GMT", getTime() + 24 * 3600 * 365));
        header("Last-Modified: " . date("D, d M Y H:i:s GMT", getTime()));
        header("Etag: " . md5($fileId));

        return file_get_contents($filePath);
    }
}