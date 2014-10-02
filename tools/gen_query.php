<?php
require '../Library/ArrayHelper.php';
require '../Library/Csv.php';
require '../Library/Sql.php';

set_time_limit(20000);

function genInsertStatements($tableName,$rowsChunks,$columns,$outputFilename){
    file_put_contents($outputFilename,"");
    $countOfChunks = count($rowsChunks);
    for($chunk=0; $chunk<$countOfChunks; $chunk++){
        file_put_contents(
            $outputFilename,
            \Library\Sql::batchInsert($tableName,$rowsChunks[$chunk],$columns),
            FILE_APPEND
        );
    }
}

$insertConfigs = array(
    array('table'=>'venue','input'=>"C:\\Users\\Dmitriy\\Downloads\\venue.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertVenues.sql"),
    array('table'=>'company','input'=>"C:\\Users\\Dmitriy\\Downloads\\company.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertCompanies.sql"),
    array('table'=>'mtag','input'=>"C:\\Users\\Dmitriy\\Downloads\\mtags.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertMtags.sql"),
    array('table'=>'device','input'=>"C:\\Users\\Dmitriy\\Downloads\\devices.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertDevices.sql"),
    array('table'=>'campaign','input'=>"C:\\Users\\Dmitriy\\Downloads\\campaign_new.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertCampaigns.sql"),
    array('table'=>'content','input'=>"C:\\Users\\Dmitriy\\Downloads\\content_new.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertContents.sql"),
    array('table'=>'engagement','input'=>"C:\\Users\\Dmitriy\\Downloads\\engagements1of4.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertEngagements1of4.sql"),
    array('table'=>'engagement','input'=>"C:\\Users\\Dmitriy\\Downloads\\engagements2of4.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertEngagements2of4.sql"),
    array('table'=>'engagement','input'=>"C:\\Users\\Dmitriy\\Downloads\\engagements3of4.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertEngagements3of4.sql"),
    array('table'=>'engagement','input'=>"C:\\Users\\Dmitriy\\Downloads\\engagements4of4.sql",'output'=>"C:\\Users\\Dmitriy\\Downloads\\insertEngagements4of4.sql"),
//    array('table'=>'','input'=>'','output'=>''),
);


foreach($insertConfigs as $insertConfig){
    $itemsChunks = \Library\Csv::extract(array('input'=>$insertConfig['input']), \Library\Csv::EXTRACT_MEMORY);
    $firstChunk = &$itemsChunks[0];
    $itemsColumns = array_shift($firstChunk);
    genInsertStatements($insertConfig['table'],$itemsChunks,$itemsColumns,$insertConfig['output']);
    $itemsChunks = $firstChunk = $itemsColumns = null;
}

unset($itemsChunks);

