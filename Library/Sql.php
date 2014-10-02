<?php
namespace Library;

class Sql
{
    const DUPLICATE_ERROR = 0;
    const DUPLICATE_IGNORE = 1;
    const DUPLICATE_UPDATE = 2;

    public static function batchInsert($tableName, array $data, $columns = null, $duplicateMode = self::DUPLICATE_ERROR) {
        if(count($data) == 0) { return false; }
        if(!$columns) {
            $columns = array_keys(current($data));
        }
        $columnsStr = sprintf('`%s`', implode('`,`', $columns));

        $str = '';
        foreach ($data as $values) {
            foreach ($values as &$val) {
                if (is_null($val)) {
                    $val = 'NULL';
                    continue;
                }
                if (is_string($val)) {
                    $val = "'".addslashes($val)."'";
                }
            }
            $str .= sprintf('(%s),', implode(',', $values))."\n";
        }
        $str = rtrim($str,",\n");
        $str .= ";\n";

        $ignore = "";
        $update = "";
        switch($duplicateMode){
            case self::DUPLICATE_ERROR: break;
            case self::DUPLICATE_IGNORE:
                $ignore = "IGNORE";
                break;
            case self::DUPLICATE_UPDATE:
                $arr = array();
                foreach($columns as $column){
                    $arr[] = $column." = IFNULL(VALUES($column), $column)";
                }
                $update = "ON DUPLICATE KEY UPDATE " . implode(',', $arr);
                break;
        }

        $query = sprintf("INSERT %s INTO `%s` \n(%s) VALUES \n%s %s",
            $ignore,
            $tableName,
            $columnsStr,
            $str,
            $update
        );

        $str = $columnsStr = null;
        return $query;
    } // -- end of method
}
