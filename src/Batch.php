<?php

namespace Dcolsay\Ciwa;

use Dcolsay\Ciwa\Contract;
use Illuminate\Support\Str;
use Prewk\XmlStringStreamer;

class Batch
{
    protected $format = 'bceao';

    protected $path;

    public function __construct($filePath)
    {
        $this->path = $filePath;
    }

    /**
     * Récupération du BatchIdentifier
     *
     * @return array
     */
    // public function getBatchIdentifier()
    // {
    //     return $this->get()['BatchIdentifier'];
    // }

    public function write($path)
    {
        // Création du Flux de lecture
        $streamer = XmlStringStreamer::createStringWalkerParser($this->path);

        $batchWriter = new BatchXMLWriter($path . DIRECTORY_SEPARATOR . 'contracts.xml');

        // $row = 0;
        while ($node = $streamer->getNode()) {
            $value = Str::of($node)->trim();

            try {
                $xmlObject = simplexml_load_string((string) $value);
            } catch (\Exception $e) {
                throw new \Exception('Error lors de lecture');
                // dd($e->getMessage(), $value);
                // dd('Failed to load', $value);
            }

            $json = json_encode($xmlObject);
            $attribute = json_decode($json, true);

            if($value->contains("</BatchIdentifier>")){

                $batchWriter->addBatchIdentifier($attribute[0]);
                continue;
            }

            $contract = new Contract;
            $contract->fill($attribute);

            $batchWriter->addContract($contract->sort($this->format)->toArray());

            // $row++;
        }

        $batchWriter->close();
    }

    /**
     * Set the value of format
     *
     * @return  self
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }
}
