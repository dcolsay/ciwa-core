<?php

namespace Dcolsay\Ciwa;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Jenssegers\Model\Model;
use Dcolsay\Ciwa\Sorters\FileSorter;
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
        // @todo Mettre cette variable dans un variable de configuration
        $basePath = Storage::path('settings\tpl');

        
        // Ordonner les clés
        $keys = array_keys($this->attributesToArray());
        $orders = ['ContractCode', 'ContractData', 'Collateral', 'Company', 'Individual', 'SubjectRole', 'SubjectRelation'];
        $keyOrder = array_intersect ($orders, $keys);
        $data = array_merge(array_flip($keyOrder), $this->attributesToArray());

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
            ->map(function($attribute, $key) use ($basePath, $format){
                $key = Str::of($key);
                if($key->contains('ContractCode') || $key->contains('SubjectRole') || $key->contains('SubjectRelation') )
                    return $attribute;


                $path = $key->lower()
                    ->prepend(DIRECTORY_SEPARATOR)
                    ->prepend($basePath)
                    ->append('-')
                    ->append(strtolower($format))
                    ->append('.csv');

                // Traitement des valeurs multiples
                // Plusieurs Company ou Collateral
                if(is_array($attribute) && !Arr::isAssoc($attribute))
                {
                    return collect($attribute)
                        ->map(fn($item) => (new FileSorter($path))->order($item))
                        ->toArray();
                }

                return (new FileSorter($path))->order($attribute);

            });
    }
}
