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

        return collect($this->attributesToArray())
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
