<?php

namespace Dcolsay\Ciwa;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Jenssegers\Model\Model;
use Dcolsay\Ciwa\Sorters\FileSorter;
use Dcolsay\Ciwa\Sorters\SorterService;
use Illuminate\Support\Facades\Storage;

class Contract extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'ContractData'
    ];

    public function sort($format = 'bceao')
    {
        // Ordonner les clés principals
        $data = $this->sortByArray($this->attributesToArray(), config('ciwa.contract.keys'));

        // Correction en cas de BIC
        if($format == 'bic')
            {
                if(Arr::exists($data, 'Individual')) {
                    if(Arr::exists($data['Individual'], 'PhoneNumber')){
                       $phoneNumber = $data['Individual']['PhoneNumber'];
                       unset($data['Individual']['PhoneNumber']);
                       $data['Individual']['Contacts'] = array_merge($data['Individual']['Contacts'], ['PhoneNumber' => $phoneNumber] );
                    }
                }

                if(Arr::exists($data, 'ContractData')) {

                    if(Arr::exists($data['ContractData'], 'BelongsToGroup')){
                        $data['ContractData'] = collect($data['ContractData'])->mapWithKeys(function($value, $key) {

                            if($key == 'BelongsToGroup')
                                $key = 'RelatedCustomersGroup';

                            return [$key => $value];
                        })->toArray();
                    }
                }

            }
    
        return collect($data)
            ->map(function($attribute, $key) use ($format){
                $key = Str::of($key);
                if($key->contains('ContractCode') || $key->contains('SubjectRole') || $key->contains('SubjectRelation') )
                    return $attribute;
                
                $struct = $key->lower();

                // Traitement des valeurs multiples
                // Plusieurs Company ou Collateral
                if(is_array($attribute) && !Arr::isAssoc($attribute))
                {
                    return collect($attribute)
                        ->map(fn($item) => $this->sortByArray($item,StructureService::studlyArray($struct)))
                        // ->map(fn($item) => SorterService::makeSort($item, $key, $format) )
                        ->toArray();
                }

                return $this->sortByArray($attribute,StructureService::studlyArray($struct));
                // return SorterService::makeSort($attribute, $key, $format);

            });
    }

    public function sortContractKeys()
    {
        $keys = array_keys($this->attributesToArray());
        $orders = config('ciwa.contract.keys');
        // dd($this->sortByArray($this->attributesToArray(), $orders));
        $keyOrder = array_intersect ($orders, $keys);
        return array_merge(array_flip($keyOrder), $this->attributesToArray());
    }

    public function sortByArray(array $array, array $order)
    {
        $ordered = [];

        foreach ($order as $key) {
            if (array_key_exists($key, $array)) {
                $ordered[$key] = $array[$key];
                unset($array[$key]);
            }
        }

        return $ordered + $array;
    }
}
