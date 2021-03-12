<?php

namespace Dcolsay\Ciwa;

use XMLWriter;
use Illuminate\Support\Arr;

class BatchXMLWriter extends XMLWriter
{
    public function __construct($filePath)
    {
        $this->openUri($filePath);
        $this->startDocument('1.0', 'UTF-8');
        $this->startElement('Batch');
        $this->setIndent(true);
        //Write Root Element

    }

    public function open()
    {

    }

    public function addBatchIdentifier($value)
    {
        $this->writeElement('BatchIdentifier', $value);
        $this->flush();
    }

    public function addContract($contract)
    {
        $this->startElement('Contract');
            foreach($contract as $key => $item)
            {
                if($key == 'ContractCode')
                    $this->writeElement($key, $item);

                if($key == 'ContractData'){
                    $this->startElement($key);
                    $this->fromArray($item);
                    $this->endElement();
                }

                if($key == 'Collateral')
                {
                    if(Arr::isAssoc($item))
                    {
                        $this->startElement($key);
                        $this->fromArray($item);
                        $this->endElement();
                    }else{
                        foreach($item as $field)
                        {
                            $this->startElement($key);
                            $this->fromArray($field);
                            $this->endElement();
                        }
                    }

                }

                if($key == 'Individual')
                {
                    if(Arr::isAssoc($item))
                    {
                        $this->startElement($key);
                        $this->fromArray($item);
                        $this->endElement();
                    }else{
                        foreach($item as $field)
                        {
                            $this->startElement($key);
                            $this->fromArray($field);
                            $this->endElement();
                        }
                    }

                }

                if($key == 'Company')
                {
                    if(Arr::isAssoc($item))
                    {
                        $this->startElement($key);
                        $this->fromArray($item);
                        $this->endElement();
                    }else{
                        foreach($item as $field)
                        {
                            $this->startElement($key);
                            $this->fromArray($field);
                            $this->endElement();
                        }
                    }

                }
                if($key == 'SubjectRole')
                {
                    if(Arr::isAssoc($item))
                    {
                        $this->startElement($key);
                        $this->fromArray($item);
                        $this->endElement();
                    }else{
                        foreach($item as $field)
                        {
                            $this->startElement($key);
                            $this->fromArray($field);
                            $this->endElement();
                        }
                    }

                }
                if($key == 'SubjectRelation')
                {
                    if(Arr::isAssoc($item))
                    {
                        $this->startElement($key);
                        $this->fromArray($item);
                        $this->endElement();
                    }else{
                        foreach($item as $field)
                        {
                            $this->startElement($key);
                            $this->fromArray($field);
                            $this->endElement();
                        }
                    }

                }

            }
        $this->endElement();
    }

     /**
    * Set an element with a text to a current xml document.
    * @access public
    * @param string $prm_elementName An element's name
    * @param string $prm_ElementText An element's text
    * @return null
    */
    public function setElement($prm_elementName, $prm_ElementText){
        $this->startElement($prm_elementName);
        $this->text($prm_ElementText);
        $this->endElement();
    }

    public function fromArray($prm_array){
        if(is_array($prm_array)){
          foreach ($prm_array as $index => $element){
            if(is_array($element)){
                try {
                    //code...
                    $this->startElement($index);
                } catch (\Throwable $th) {
                   dd($prm_array, $index, $element);
                }
              $this->fromArray($element);
              $this->endElement();
            }
            else
              $this->setElement($index, $element);

          }
        }
    }

    public function close()
    {
        $this->endElement();
        $this->endDocument();
    }
}
