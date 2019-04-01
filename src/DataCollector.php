<?php

namespace RonasIT\Support\AutoDoc;

use RonasIT\Support\AutoDoc\Interfaces\IDataCollector;

class DataCollector implements IDataCollector
{
    public $prodFilePath;
    public $tempFilePath;

    protected static $data;

    public function __construct()
    {
        $this->prodFilePath = base_path('data-collector');

        if (empty($this->prodFilePath)) {
            throw new \NotFoundException('File not provided');
        }
    }

    public function saveTmpData($tempData)
    {
        self::$data = $tempData;
    }

    public function getTmpData()
    {
        return self::$data;
    }

    public function saveData()
    {
        $content = json_encode(self::$data);

        file_put_contents($this->prodFilePath, $content);

        self::$data = [];
    }

    public function getDocumentation()
    {
        if (!file_exists($this->prodFilePath)) {
            throw new \Exception("prodFilePath is not provided");
        }

        $fileContent = file_get_contents($this->prodFilePath);

        return json_decode($fileContent);
    }
}
