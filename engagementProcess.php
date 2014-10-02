<?php
require 'ArrayHelper.php';
require 'Csv.php';

set_time_limit(20000);

$input = "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_engagement.sql";
$output = "C:\\Users\\Dmitriy\\Downloads\\engagements.sql";
$campaignTable = "C:\\Users\\Dmitriy\\Downloads\\campaign_new.sql";

//------ MTAGS -------------
$configExtractLocation = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\location_subset_mod.sql",
    'strCount' => 33677,
    'chunkSize' => 10000,
    'stringMaxLength' => 4096
);
$mtagsChunks = \Library\Csv::extract($configExtractLocation, \Library\Csv::EXTRACT_MEMORY);
$firstChunk = &$mtagsChunks[0];
array_shift($firstChunk);
reset($firstChunk);

$countOfChunks = count($mtagsChunks);
$mtagsChunksProccessed = array();
for($chunk=0; $chunk<$countOfChunks; $chunk++){
    $count = count($mtagsChunks[$chunk]);
    for($mtag=0; $mtag<$count; $mtag++){
        $mtagsChunksProccessed[$mtagsChunks[$chunk][$mtag][1]] = $mtagsChunks[$chunk][$mtag][0];
    }
}
//------ READY MTAGS -------------

//----- CAMPAIGN-------------
$campaigns = array_map('str_getcsv',file($campaignTable));
$campaignColumns = array_shift($campaigns);
foreach($campaigns as $key=>$campaign){
    $campaigns[$campaign[1]] = $campaign[0];
    unset($campaigns[$key]);
}
//----- READY CAMPAIGN-------------

//------ DEVICE-------------
$configExtractDevice = array(
    'input' => "C:\\Users\\Dmitriy\\Downloads\\current_campaign_mod_device_processed_mod.sql",
    'strCount' => 60377,
    'chunkSize' => 10000,
    'stringMaxLength' => 25000,
    'columns' => array(0,8)
);
$devicesChunks = \Library\Csv::extract($configExtractDevice, \Library\Csv::EXTRACT_MEMORY);
$firstChunk = &$devicesChunks[0];
reset($firstChunk);

$countOfChunks = count($devicesChunks);
$devicesChunksProccessed = array();
for($chunk=0; $chunk<$countOfChunks; $chunk++){
    $count = count($devicesChunks[$chunk]);
    for($device=0; $device<$count; $device++){
        $engs = explode(',',$devicesChunks[$chunk][$device][8]);
        foreach($engs as $eng){
            $devicesChunksProccessed[$eng] = $devicesChunks[$chunk][$device][0];
        }
    }
}
//------ READY DEVICE-------------

//var_dump(reset($campaigns),end($campaigns));
//var_dump(reset(reset($mtagsChunks)),end(end($mtagsChunks)));
//var_dump(reset(reset($devicesChunks)),end(end($devicesChunks)));die;
//var_dump(findDeviceByEngagement($devicesChunks,'e332052t'));die;


$engagements = array();
$engagementsColumns = array('id','mtag_id','time','campaign_id','device_id','interaction_type');


//$max = 10000;
$max = 332445;
$chunkSize = 15000;

$rows = array();
$handle = fopen($input, "r") or die("Couldn't get handle");
$buffer = fgets($handle, 4096);
file_put_contents($output, '"'.implode('","',$engagementsColumns).'"'."\n");
if ($handle) {
    for($chunk = 0; !feof($handle) && $chunk<$max; $chunk+=$chunkSize){
        for($i = $chunk;  !feof($handle) && $i<$max && $i<$chunk+$chunkSize; $i++){
            $buffer = fgets($handle, 4096);
            $row = str_getcsv($buffer);
            $rows[] = '"'.implode('","',array(
                    'id' => $row[0],
                    'mtag_id' => $mtagsChunksProccessed[$row[1]],
                    'time' => $row[2]." ".$row[3],
                    'campaign_id' => $campaigns[$row[5]],
                    'device_id' => $devicesChunksProccessed["e$row[0]t"],
                    'interaction_type' => $row[4]
            )).'"';
        }
        $prepared = implode("\n",$rows)."\n";
        echo count($rows)." strings are processed\n";
        file_put_contents($output, $prepared, FILE_APPEND);
        $rows = array();
    }
    fclose($handle);
}

