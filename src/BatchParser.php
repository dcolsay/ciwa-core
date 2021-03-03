<?php

namespace Dcolsay\Ciwa;

use ACFBentveld\XML\XML;
use Dcolsay\Ciwa\Objects\Contract;

class BatchParser
{
    /**
     * Xml file representation
     *
     * @var \ACFBentveld\XML\Data\XMLCollection|\ACFBentveld\XML\Data\XMLElement
     */
    protected $xml;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        
    }

    public function cast()
    {
        // @todo Prendre la version
        return $this->read()->cast('Contract')
            ->to(Contract::class);
    }

    /**
     * Undocumented function
     *
     * @return \ACFBentveld\XML\Data\XMLCollection|\ACFBentveld\XML\Data\XMLElement
     */
    public function read()
    {
        return  XML::import($this->filePath);
    }

    public function contracts()
    {
        return $this->cast()
            ->Contract;
    }

    public function getBatchIdentifier()
    {
        return $this->cast()['BatchIdentifier'];
    }

    public function presentToXml()
    {
        return [
            'BatchIdentifier' => $this->getBatchIdentifier(),
            'Contract' => $this->contractsToXml()
        ];
    }
    
    public function contractsToXml(): array
    {
        return collect($this->contracts())
            ->map
            ->toArray()
            ->toArray();
    }

    public function saveXML()
    {
        $xmlWriter = new BatchWriter();
        $xmlWriter->saveXML($this->presentToXml());
        // $xmlWriter->zip($this->getBatchIdentifier());
    }
}
