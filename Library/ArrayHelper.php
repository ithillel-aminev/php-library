<?php

namespace TAminev\PhpLibrary;


class ArrayHelper {

    public static function column($array, $column){
        $ret = array();
        foreach ($array as $key=>$row) $ret[$key] = $row[$column];
        return $ret;
    }

    public static function columns($array, $columns){
        return array_map(function($row) use ($columns){ return array_intersect_key($row, array_flip($columns)); }, $array);
    }

    public static function combine($keys, $values){
        if(count($keys) != count($values)){
            return false;
        }
        $result = array();
        foreach($keys as $index => $key){
            $result[$key] = $values[$index];
        }
        return $result;
    }

    public static function set($array, $data){
        foreach($data as $key => $value){
            if(array_key_exists($key,$array)){
                $array[$key] = $value;
            }
        }
        return $array;
    }

    public static function multiSearch($marray, $searchKey, $searchValue){
        foreach($marray as $key => $array){
            if($array[$searchKey] == $searchValue){
                return $key;
            }
        }
        return -1;
    }

    public static function uniqueColumnValues($marray, $column){
        return array_filter(array_unique(array_map('trim',ArrayHelper::column($marray, $column))));
    }

    public static function deleteColumn(&$array, $offset) {
        return array_walk($array, function (&$v) use ($offset) {
            array_splice($v, $offset, 1);
        });
    }

    public static function pregGrepKeys($pattern, $input, $flags = 0) {
        return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
    }

    /**
     * Replaces array values on new values.
     * $array - array to make replacements
     * $replacements - key => value array
     * $defaultValue - value to set if null happens
     */
    public static function replaceValues(&$array, $replacements, $defaultValue = ''){
        foreach($array as $key=>$value){
            $array[$key] = ($replacements[$value])?:$defaultValue;
        }
        return $array;
    }

    public static function makeVertical($array){
        return array_map(function($value){ return array($value);}, $array);
    }

    public static function trimQuotes(&$array){
        $count = count($array);
        for($i=0; $i<$count; $i++){
            $array[$i] = trim(trim($array[$i]),"'\"");
        }
//        return array_map(function($value){return trim(trim($value),"'\"");},$array);
    }

    public static function removeRowsByKeyWithEmptyValue(&$marray, $key)
    {
        foreach ($marray as $mkey=>$array){
            if (empty ($array[$key])){
                unset ($marray[$mkey]);
            }
        }
    }

    public static function removeRowsWhereKeyEqualsValue(&$marray, $key, $value)
    {
        foreach ($marray as $mkey=>$array){
            if ($array[$key] === $value){
                unset ($marray[$mkey]);
            }
        }
    }

    public static function indexRowsByColumn(&$marray, $column)
    {
        $count = count($marray);
        for ($i = $count-1; $i>=0; $i--){
            $newK = $marray[$i][$column];
            $marray[$newK] =  $marray[$i];
            unset ($marray[$i]);
        }
    }

    public static function removeKeys(&$array, $keys)
    {
        $before = count($array);
        foreach ($keys as $key){
            unset($array[$key]);
        }
        $after = count($array);
        return array(
            'info' => array('before' => $before, 'after' => $after),
        );
    }

    /**
     * Remove duplicates values in one-dimension array. No keys persisted i.e. keys are refreshed.
     * @param array $array
     * @return array Information about
     */
    public static function removeDuplicateValues(array &$array)
    {
        $before = count($array);
        $array = array_keys(array_flip($array));
        $after = count($array);
        return array(
            'info' => array('before' => $before, 'after' => $after),
        );
    }



} 