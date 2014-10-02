<?php
namespace Library;


class Csv {
    const EXTRACT_FILE = 0;
    const EXTRACT_MEMORY = 1;

    public static function extract($config,$mode = self::EXTRACT_FILE){
        $input = array_key_exists('input',$config) ? $config['input'] : false; // "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod.sql"
        $output = array_key_exists('output',$config) ? $config['output'] : false; // "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device.sql"

//        $strCount = array_key_exists('strCount',$config) ? $config['strCount'] : false; // 333000
//        $maxStrLen = array_key_exists('stringMaxLength',$config) ? $config['stringMaxLength'] : false; // 4096
//        $chunkCountStr = array_key_exists('chunkSize',$config) ? $config['chunkSize'] : false; // 10000

        $columns = array_key_exists('columns',$config) ? $config['columns'] : false; // array(0,16,17,18,19,20,21,22)
        $unique = array_key_exists('unique',$config) ? $config['unique'] : false; // false

        $rows = $rowsChunks = array();

        $handle = fopen($input, "r") or die("Couldn't get handle");

        $strCount = $maxStrLen = $avgStrLen =0;
        while(!feof($handle)){
            $line = stream_get_line($handle, 1000000, "\n");
            $strlen = strlen($line);
            $maxStrLen = ($strlen>$maxStrLen) ? $strlen : $maxStrLen;
            $avgStrLen += $strlen;
            $strCount++;
        }
        $maxStrLen +=10;
        $avgStrLen = floor($avgStrLen/$strCount);
        $chunkCountStr = floor(430000/$avgStrLen);
        rewind($handle);

        switch($mode){
            case self::EXTRACT_FILE:
                file_put_contents($output, "");
                break;
        }
        if ($handle) {
            for($chunk = 0; !feof($handle) && $chunk<$strCount; $chunk+=$chunkCountStr){
                $rows = array();
                for($i = $chunk; !feof($handle) && $i<$strCount && $i<$chunk+$chunkCountStr; $i++){
//                    $buffer = fgets($handle, $maxStrLen);
                    $buffer = stream_get_line($handle, $maxStrLen, "\n");
                    $prepared = str_getcsv($buffer);
                    ArrayHelper::trimQuotes($prepared);
                    if($columns){
                        foreach($columns as $column){
                            $set[$column] = $prepared[$column];
                        }
                    }else{
                        $set = $prepared;
                    }
//                    $set = ($columns)
//                        ? array_intersect_key($prepared,array_flip($columns))
//                        : $prepared;
//                    ;
                    switch($mode){
                        case self::EXTRACT_FILE:
                            $rows[] = '"'.implode('","',$set).'"';
                            break;
                        case self::EXTRACT_MEMORY:
                            $rows[] = $set;
                            break;
                    }
                    $buffer = $prepared = $set = null;
                }
                if($rows){
                    if($unique){
                        $rows = array_unique($rows,SORT_STRING);
                    }
                    switch($mode){
                        case self::EXTRACT_FILE:
                            file_put_contents($output, implode("\n",$rows)."\n",FILE_APPEND);
                            break;
                        case self::EXTRACT_MEMORY:
                            $rowsChunks[] = $rows;
                            break;
                    }
                }
                $rows = null;
            } // chunks interator
            fclose($handle);
        }
        switch($mode){
            case self::EXTRACT_MEMORY:
                return $rowsChunks;
                break;
        }
        $rowsChunks = $rows = null;
        return null;
    }// extract

    public static function unshiftIdColumn($config){
        $input = $config['input']; //"C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device_processed.sql";
        $output = $config['output']; //"C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device_processed_mod.sql";
        $strCount = $config['strCount']; //60500;
        $chunkSize = $config['chunkSize']; //10000;
        $stringMaxLength = $config['stringMaxLength']; //25000;
        $columnName = $config['columnName']; //'"id"';
        $initValue = $config['initValue']; //1;

        $rows = array();
        $handle = fopen($input, "r") or die("Couldn't get handle");
        $buffer = fgets($handle, $stringMaxLength);
        $row = $columnName.','.$buffer;
        file_put_contents($output, $row);
        if ($handle) {
            for($chunk = 0; !feof($handle) && $chunk<$strCount ; $chunk+=$chunkSize){
                for($i = $chunk; !feof($handle) && $i<$strCount && $i<$chunk+$chunkSize; $i++){
                    $buffer = fgets($handle, $stringMaxLength);
                    $rows[] = $initValue.",".$buffer;
                    $initValue++;
                }
                file_put_contents($output, implode("",$rows),FILE_APPEND);
                var_dump($rows);
                $rows = array();
            }
            fclose($handle);
        }

    }

}