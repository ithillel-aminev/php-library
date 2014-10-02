<?php
require 'Library/ArrayHelper.php';
require 'Library/Sql.php';

$route = "C:\\Users\\Dmitriy\\Downloads\\";
$filename = "C:\\Users\\Dmitriy\\Downloads\\campaign_data_unique.sql";
$campaignsFilename = "C:\\Users\\Dmitriy\\Downloads\\campaigns_extracted.sql";
$outputCampaign = "C:\\Users\\Dmitriy\\Downloads\\campaigns_new.sql";
$outputContent = "C:\\Users\\Dmitriy\\Downloads\\content_new.sql";

$data = array_map('str_getcsv',file($filename));
$columns = array_shift($data);

// $transformedData. as-is
$transformedData = array();
$initId = 456;
foreach($data as $item){
    $key = $item[1];
    if(array_key_exists($key,$transformedData) == false){
        $transformedData[$key] = array(
            'id' => $initId++,
            'name' => $item[1]
        );
    }
    $transformedData[$key]['content'][] = $item[0];
    $transformedData[$key]['parent'][] = $item[2];
}

// $reducedData. leave last parent company and place campaign_id instead of campaign_name, remove duplicate content
$reducedData = $transformedData;
foreach($reducedData as &$rdItem){
    $rdItem['content'] = array_unique($rdItem['content'],SORT_STRING);
    $key = (string)end($rdItem['parent']);
    $rdItem['parent'] = end($rdItem['parent']);
}

// Campaigns Reference from dump
$temp = array_map('str_getcsv',file($campaignsFilename));
array_shift($temp);
$campaignTableData = array();
foreach($temp as $row){
    $campaignTableData[$row[1]] = array('id'=>$row[0],'name'=>$row[1]);
}

// attach to $campaignTableData parent data and content data
foreach($campaignTableData as &$ctRow){
    $name = $ctRow['name'];
    $parentName = (array_key_exists($name,$reducedData)) ? $reducedData[$name]['parent'] : null;
    $parenId = (array_key_exists($parentName,$campaignTableData)) ? $campaignTableData[$parentName]['id'] : null;
    $ctRow['parent'] = $parenId;
    $ctRow['content'] = (array_key_exists($name,$reducedData)) ? $reducedData[$name]['content'] : array();
}

// $campaignTableData is broken into two: $campaignData and $contentData
$campaignData = array();
$campaignColumns = array('id','name','parent');
$contentData = array();
foreach($campaignTableData as $key=>$item){
    foreach($item['content'] as $content){
        $contentData[] = array('url'=>$content,'campaign_id'=>$item['id']);
    }
    $campaignData[$key] = array_intersect_key($item,array_flip($campaignColumns));
}

//var_dump($campaignData);die;


    foreach($contentData as $row){
        var_dump($row);
        $str = '"'.implode('","',$row).'"'."\n";
        file_put_contents($outputContent,$str,FILE_APPEND);
    }

//// export
//file_put_contents($route.'insert-content.sql', \Library\Sql::batchInsert('content',$contentData));
//file_put_contents($route.'insert-campaign.sql', \Library\Sql::batchInsert('campaign',$campaignData));





