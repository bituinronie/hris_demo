<?php
namespace App\Traits\Scopes;

trait ModelScope {
    public function scopeFilter($query, $key, $value){
        return $query->where($key,'LIKE',"%$value%");
    }

    public function scopeOrFilter($query, $key, $value){
        return $query->orWhere($key,'LIKE',"%$value%");
    }

    public function scopeOrderDesc($query, $key){
        return $query->orderBy($key, 'DESC');
    }

    public function scopeWhereArray($query,$key,$array,$arg = '=')
    {
        foreach ($array as $item) {
            $query = $query->where($key, $arg, $item);
        }

        return $query;
    }

    public static function generateAutoSuggest($columnName){
        return self::where($columnName, '!=',null)->groupBy($columnName)->pluck($columnName);
    }

    public static function findEvenTrashed($id){
        return self::whereId($id)->withTrashed()->first();
    }
}