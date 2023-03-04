<?php

namespace App\Http\Controllers\Template;

Class TemplateController 
{
    private static $baseTemplate = "uikit";
    private static $basetemplateFolderName = "uikit";
    public string $template;
    public string $templateFolderName;
    public string $templateFolderPath;

    public function __construct($template = null, $foldername = null)
    {
        if ($template == null){
            $this->template = self::$baseTemplate;
            $this->templateFolderName = self::$basetemplateFolderName;
        } else {
            $path = $_SERVER['DOCUMENT_ROOT'] . "resources" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . $foldername . DIRECTORY_SEPARATOR . "template.blade.php";
            if (file_exists($path)){
                $this->template = $template;
                $this->templateFolderName = $foldername;
            } else {
                $this->template = self::$baseTemplate;
                $this->templateFolderName = self::$basetemplateFolderName;
            }
        }
        $this->templateFolderPath = $_SERVER['DOCUMENT_ROOT'] . "resources" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . $this->templateFolderName . DIRECTORY_SEPARATOR . "template.blade.php";
    }
}
