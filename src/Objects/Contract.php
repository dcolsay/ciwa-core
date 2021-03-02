<?php

namespace Dcolsay\Ciwa\Objects;

use Jenssegers\Model\Model;
use ACFBentveld\XML\Casts\Castable;
use Dcolsay\Ciwa\Objects\ContractDataModel;




class Contract extends Model implements Castable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'ContractData'
    ];

    /**
     * Invoked every time this class was cast to XMLElement.
     *
     * @param array $data
     *
     * @return Castable
     */
    public static function fromCast(array $data): self
    {
        return new static($data);
    }

    public static function fromArray(array $attributes): self
    {
        return new self([
            'type' => $attributes['ClientType'],
            'ContractCode' => $attributes['ContractCode'],
            'ContractData' => ContractDataModel::makeFromGenerator($attributes),
            'Individual' => IndividualModel::makeFromGenerator($attributes),
            'Company' => CompanyModel::makeFromGenerator($attributes),
            'Collateral' => CollateralModel::makeFromGenerator($attributes)
        ]);
    }

    public function toArray()
    {
        dd($this->ContractData);
        $value =  [
            'ContractCode' => $this->ContractCode,
            'ContractData' => ContractDataModel::makeArraySort($this->ContractData)
        ];

        if(key_exists('Collateral', $this->attributesToArray()))
            $value['Collateral'] = CollateralModel::makeArraySort($this->Collateral);

        if(key_exists('Individual', $this->attributesToArray()))
            $value['Individual'] = IndividualModel::makeArraySort($this->Individual);

        if(key_exists('Company', $this->attributesToArray()))
        {
            $value['Company'] = CompanyModel::makeArraySort($this->Company);
        }


        $value['SubjectRole'] = (array) $this->SubjectRole;

        return $value;
    }

    public static function makeFromGenerator(array $attributes): self
    {
        return new self([
            'ContractCode' => $attributes['ContractCode'],
            'ContractData' => ContractDataModel::makeFromGenerator($attributes),
            'Individual' => IndividualModel::makeFromGenerator($attributes),
            'Company' => CompanyModel::makeFromGenerator($attributes),
            'Collateral' => CollateralModel::makeFromGenerator($attributes)
        ]);
    }
}
