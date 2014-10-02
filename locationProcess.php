<?php
require 'Library/ArrayHelper.php';
require 'Library/Csv.php';

set_time_limit(20000);

$input = "C:\\Users\\Dmitriy\\Downloads\\location_mod.sql";
$output = "C:\\Users\\Dmitriy\\Downloads\\mtags.sql";

$handle = fopen($input, "r") or die("Couldn't get handle");
$outputHandle = fopen($output, "w") or die("Couldn't get handle");

//----- COMPANY-------------
$companies = array_map('str_getcsv',file("C:\\Users\\Dmitriy\\Downloads\\partnernamelist_subset_mod.sql"));
$companyColumns = array_shift($companies);
foreach($companies as $key=>$company){
    $companies[$company[1]] = $company[0];
    unset($companies[$key]);
}
//----- READY COMPANY -------------


//----- VENUE-------------
$venues = array_map('str_getcsv',file("C:\\Users\\Dmitriy\\Downloads\\location_mod_subset_mod.sql"));
$venueColumns = array_shift($venues);
foreach($venues as $key=>$venue){
    $venues[$venue[1]][$venue[2]] = $venue[0];
    unset($venues[$key]);
}
//----- READY VENUE -------------


$mtagsColumns = array('id','tag_id','address','location','company_id','asset_id','asset_type','venue_id',
    'demographic_id','nfc','qr','beacon','geofence','sms','wifi'
    ,'keywords','notes','dma_code','date_created','date_modified'
);

//$max = 10000;
$max = 33676;
$chunkSize = 10000;

$rows = array();
$buffer = fgets($handle, 4096);
//file_put_contents($output, '"'.implode('","',$mtagsColumns).'"'."\n");
fputcsv($outputHandle,$mtagsColumns);
if ($handle) {
    for($chunk = 0; !feof($handle) && $chunk<$max; $chunk+=$chunkSize){
        for($i = $chunk;  !feof($handle) && $i<$max && $i<$chunk+$chunkSize; $i++){
            $buffer = fgets($handle, 4096);
            $row = str_getcsv($buffer);
            \Library\ArrayHelper::trimQuotes($row);
            $rows[] = array(
                'id' => $row[0],
                'tag_id' => $row[1],
                'address' => json_encode(array(
                    'street'=>$row[6],
                    'city'=>$row[7],
                    'state'=>$row[8],
                    'zip'=>$row[10],
                    'country'=>$row[9],
                )),
                'location' => null,
                'company_id' => $companies[$row[2]],
                'asset_id' => $row[3],
                'asset_type' => null,
                'venue_id' => $venues[$row[4]][$row[5]],
                'demographic_id' => null,
                'nfc' => null,
                'qr' => null,
                'beacon' => null,
                'geofence' => null,
                'sms' => null,
                'wifi' => null,
                'keywords' => null,
                'notes' => $row[21],
                'dma_code' => $row[22],
                'date_created' => $row[13],
                'date_modified' => $row[14]
            );
        }
        echo count($rows)." strings are processed\n";
        foreach($rows as $row){
            fputcsv($outputHandle,$row);
        }
//        file_put_contents($output, implode("\n",$rows)."\n", FILE_APPEND);

        $rows = array();
    }
    fclose($handle);
}

fclose($outputHandle);
