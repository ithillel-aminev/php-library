<?php
require 'ArrayHelper.php';

set_time_limit(20000);

//$filename = "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device.sql";
//$output = "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device_processed.sql";

$max = 340000;
$chunkSize = 10000;
$columns = array(0,16,17,18,19,20,21,22);
$unique = false;

$data = $rows = array();
$handle = fopen($input, "r") or die("Couldn't get handle");
$buffer = fgets($handle, 4096);
if ($handle) {
//    while (!feof($handle)) {
//    }
    for($chunk = 0; $chunk<$max; $chunk+=$chunkSize){
        for($i = $chunk; $i<$chunk+$chunkSize; $i++){
            $buffer = fgets($handle, 4096);
            $row = str_getcsv($buffer);
            $id = array_shift($row);
            $key = '"'.implode('","',$row).'"';
            $data[$key][] = 'e'.$id.'t';
        }
        foreach($data as $key=>$ids){
            $rows[] = $key.',"'.implode(',',$ids).'"';
        }
        file_put_contents($output, implode("\n",$rows)."\n",FILE_APPEND);
        var_dump($data);
        $data = $rows = array();
    }
    fclose($handle);
}

