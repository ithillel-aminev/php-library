<?php
require '../Library/ArrayHelper.php';
require '../Library/Csv.php';
set_time_limit(20000);

$configUnshiftLocation = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\location.sql",
    'output' => "C:\\Users\\Dmitriy\\Downloads\\location_mod.sql",
    'strCount' => 33677,
    'chunkSize' => 10000,
    'stringMaxLength' => 4096,
    'columnName' => '"id"',
    'initValue' => 1
);

$configUnshiftCompany = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\partnernamelist_subset.sql",
    'output' => "C:\\Users\\Dmitriy\\Downloads\\partnernamelist_subset_mod.sql",
    'strCount' => 81,
    'chunkSize' => 81,
    'stringMaxLength' => 4096,
    'columnName' => '"id"',
    'initValue' => 1
);

$configUnshiftCompany = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\location_mod_subset.sql",
    'output' => "C:\\Users\\Dmitriy\\Downloads\\location_mod_subset_mod.sql",
    'strCount' => 2691,
    'chunkSize' => 2691,
    'stringMaxLength' => 4096,
    'columnName' => '"id"',
    'initValue' => 1
);

\Library\Csv::unshiftIdColumn($configUnshiftCompany);

//$filename = "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device_processed.sql";
//$output = "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device_processed_mod.sql";
//$max = 60500;
//$chunkSize = 10000;
//$stringMaxLength = 20000;
//
//$rows = array();
//$handle = fopen($filename, "r") or die("Couldn't get handle");
//
//$buffer = fgets($handle, $stringMaxLength);
//$row = '"id",'.$buffer;
//file_put_contents($output, $row);
//if ($handle) {
//    for($chunk = 0; ($chunk<$max) && !feof($handle) ; $chunk+=$chunkSize){
//        for($i = $chunk; ($i<$chunk+$chunkSize) && ($i<$max); $i++){
//            $buffer = fgets($handle, $stringMaxLength);
//            $id = $i+1;
//            $rows[] = $id.",".$buffer;
//        }
//        file_put_contents($output, implode("",$rows),FILE_APPEND);
//        var_dump($rows);
//        $rows = array();
//    }
//    fclose($handle);
//}
//
