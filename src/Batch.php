<?php

namespace Dcolsay\Ciwa;

use Dcolsay\Ciwa\Contract;
use Illuminate\Support\Arr;
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
                $message = $e->getMessage();
                throw new \Exception("Error lors de lecture, Message d'erreur  {$message}");
            }

            $json = json_encode($xmlObject);
            $attribute = json_decode($json, true);

            if($value->contains("</BatchIdentifier>")){

                $batchWriter->addBatchIdentifier($attribute[0]);
                continue;
            }

            if($this->format == 'bic')
            {
                if(Arr::exists($attribute, 'Individual')) {
                    if(Arr::exists($attribute['Individual'], 'PhoneNumber')){
                       $phoneNumber = $attribute['Individual']['PhoneNumber'];
                       unset($attribute['Individual']['PhoneNumber']);
                       $attribute['Individual']['Contacts'] = array_merge($attribute['Individual']['Contacts'], ['PhoneNumber' => $phoneNumber] );
                    }
                }

                if(Arr::exists($attribute, 'ContractData')) {

                    if(Arr::exists($attribute['ContractData'], 'BelongsToGroup')){
                        $attribute['ContractData'] = collect($attribute['ContractData'])->mapWithKeys(function($value, $key) {

                            if($key == 'BelongsToGroup')
                                $key = 'RelatedCustomersGroup';

                            return [$key => $value];
                        })->toArray();
                    }
                }

            }

            $contract = new Contract;
            $contract->fill($attribute);

            $batchWriter->addContract($contract->sort($this->format)->toArray());

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
