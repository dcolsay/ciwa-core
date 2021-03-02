<?php

namespace Dcolsay\Ciwa;

use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Facades\Storage;

class BatchWriter
{
    protected $filename = 'contracts.xml';

    protected $path;

    protected $disk = 'local';


    public function rootElement()
    {
        return [
            'rootElementName' => 'Batch',
            '_attributes' => [
                 'xmlns' => 'http://creditinfo.com/schemas/CB5/WestAfrica/contract',
                 'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                 'xsi:schemaLocation' => 'http://creditinfo.com/schemas/CB5/WestAfrica/contract',
            ],
        ];
    }

    public function createFile($data)
    {
        $arrayToXml = new ArrayToXml($data, $this->rootElement());
        $arrayToXml->setDomProperties(['formatOutput' => true]);
        Storage::disk($this->disk)->put($this->filename, $arrayToXml->toXml());

        return Storage::disk($this->disk)->path($this->filename);
    }

    public function saveXML(array $data)
    {
        $filepath = $this->createFile($data);
        $this->createZip($filepath);
        
        // File::put(getcwd() . DIRECTORY_SEPARATOR . $this->getFilename(),$arrayToXml->toXml());
        // File::put($this->output_path($this->getFilename()),$arrayToXml->toXml());
    }

    public function createZip($path)
    {
        $zip = new \ZipArchive();
        $zipName = 'MY_DATA.ZIP';
        $zipPath = Storage::path($zipName);

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            // $contractsFile = $this->output_path($this->getFilename());
            $zip->addFile($path, $this->filename);
            $zip->close();
        }

        Storage::put("{$zipName}.MD5",$this->hash($zipPath));
    }

    public function hash($filePath)
    {
        return md5_file($filePath);
    }

}
