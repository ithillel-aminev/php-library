<?php
require '../Library/ArrayHelper.php';
require '../Library/Csv.php';
set_time_limit(20000);

$configExtractLocation = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\location.sql",
    'output' => "C:\\Users\\Dmitriy\\Downloads\\location_subset.sql",
    'strCount' => 33677,
    'chunkSize' => 10000,
    'columns' => array(0),
    'unique' => false,
    'stringMaxLength' => 4096
);

$configExtractDevice = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device_processed_mod.sql",
    'output' => "C:\\Users\\Dmitriy\\Downloads\\devices.sql",
    'strCount' => 60377,
    'chunkSize' => 10000,
    'columns' => array(0,1,2,3,4,5,7,6),
    'unique' => false,
    'stringMaxLength' => 25000
);

$configExtractCompany = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\partnernamelist.sql",
    'output' => "C:\\Users\\Dmitriy\\Downloads\\partnernamelist_subset.sql",
    'strCount' => 81,
    'chunkSize' => 81,
    'columns' => array(0),
    'unique' => false,
    'stringMaxLength' => 4096
);

$configExtractVenue = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\location_mod.sql",
    'output' => "C:\\Users\\Dmitriy\\Downloads\\location_mod_subset.sql",
    'strCount' => 33677,
    'chunkSize' => 10000,
    'columns' => array(4,5),
    'unique' => true,
    'stringMaxLength' => 4096
);

\Library\Csv::extract($configExtractVenue);



//$rows = array();
//$handle = fopen($filename, "r") or die("Couldn't get handle");
//file_put_contents($output, "");
//if ($handle) {
////    while (!feof($handle)) {
////    }
//    for($chunk = 0; $chunk<$max; $chunk+=$chunkSize){
//        for($i = $chunk; ($i<$chunk+$chunkSize); $i++){
//            $buffer = fgets($handle, 4096);
//            $rows[] = '"'.implode('","',array_intersect_key(\Library\ArrayHelper::trimQuotes(str_getcsv($buffer)),array_flip($columns))).'"';
//        }
//        if($unique){
//            $rows = array_unique($rows,SORT_STRING);
//        }
//        file_put_contents($output, implode("\n",$rows)."\n",FILE_APPEND);
////        end($rows);var_dump($chunk+key($rows),current($rows));
//        $rows = array();
//    }
//    fclose($handle);
//}

