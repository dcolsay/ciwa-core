<?php

namespace Dcolsay\Ciwa\Objects;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Jenssegers\Model\Model;
use ACFBentveld\XML\Data\XMLElement;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class BaseModel extends Model
{
    public function toArray()
    {
        return collect($this->attributesToArray())
            ->map(function($value){
                return ($value instanceof XMLElement)
                ? (array) $value
                : $value;
            })
            ->mapWithKeys(function($value, $key) {
                $transformersKeys = [
                    'RelatedCustomersGroup' => 'RelatedCustomersGroupName'
                ];
                if(array_key_exists($key, $transformersKeys))
                {
                    return [ $transformersKeys[$key] => $value ];
                }

                return [$key => $value ];

            })
            ->sortBy(function($value, $key){
                $sorter = $this->getSorter();
                //   @todo Vérification
                // if(!in_array($key,$sorter))
                //     return;

                try {
                    //code...
                    return $sorter[$key];
                } catch (\Throwable $th) {
                    throw $th;
                }
            })
            ->toArray();
    }

    public function getSettings()
    {
        return SimpleExcelReader::create($this->getSorterFilePath())
            ->noHeaderRow()
            ->getRows();
    }

    public function fields()
    {
        return $this
            ->getSettings()
            ->map(fn($properties) => $properties[0])
            ->toArray();
    }

    public static function makeArraySort($attributes): array
    {
        // @see https://stackoverflow.com/questions/2726487/simplexmlelement-to-php-array
        if($attributes instanceof XMLElement)
            $attributes = (array) $attributes;

        return (new static($attributes))->toArray();
    }

    public function getSorter(): array
    {
        return $this->getSettings()
                ->mapWithKeys(function($row){
                    return [ trim($row[0]) => intval($row[1]) ];
                })
                ->toArray();
    }

    public function getSorterFilePath()
    {
        return $this->getSortFilename(Storage::path('settings\tpl'), true);
    }

    public function getClass()
    {
        return Str::of(get_class($this))
            ->lower()
            ->basename()
            ->before('model');
    }

    public function getSortFilename($path = null, $string = false)
    {
        return $this->getClass()->append('.csv')
            ->when(!is_null($path), function($value) use ($path) {
                return (Str::endsWith($path, DIRECTORY_SEPARATOR))
                    ?  $value->prepend($path)
                    :  $value->prepend($path . DIRECTORY_SEPARATOR);
            })
            ->when($string, function($value){
                return $value->__toString();
            });
    }

    public static function makeFromGenerator($attributes)
    {
        $out = new static;

        $fill = collect($attributes)
            ->only(array_keys($out->getSorter()))
            ->toArray();

        return self::makeArraySort($fill);
    }

    public static function fromArray($attributes)
    {
        // return Arr::only($data, (new static)->fields());
        $out = new static;

        $fill = collect($attributes)
            ->only(array_keys($out->getSorter()))
            ->toArray();

        return self::makeArraySort($fill);
    }
}
