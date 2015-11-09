<?php
// Scenario. Removing by 0-key all that present in first (N-1) tables from the last (Nth).

$time=microtime(true);
set_time_limit(0);
require '../../vendor/autoload.php';
use \TAminev\PhpLibrary\CsvExtractor as Csv;
use \TAminev\PhpLibrary\ArrayHelper;


$dir = "C:\\Users\\taminev\\Downloads\\Full database 05.11\\";
$refFilesMask = 'arr*.csv';
$toFilterFileName = 'arr5.csv';
$outputFileName = 'Tamanna Roashan  1-6 files.csv';

process($dir, $refFilesMask, $toFilterFileName, $outputFileName);

$time=microtime(true)-$time;echo "\n".'BenchMark: '.$time."\n";


function process($dir, $refFilesMask, $toFilterFileName, $outputFileName)
{
    $refFiles = glob($dir . $refFilesMask);
    $toFilterFile = $dir . $toFilterFileName;

    $configs2 = array_filter($refFiles, function($path) use($toFilterFileName) { return strpos($path, $toFilterFileName) === false;});
    $configs2 = array_map(function($path){ return array('input' => $path); }, $configs2);

    $values = array();
    foreach ($configs2 as $config){
        $csv = new Csv($config['input'], 0);
        $newArr = $csv->extract(array(0));
        $newArr = ArrayHelper::column($newArr, 0);
        $values = array_merge($values, $newArr);
    }
    $refInfo = ArrayHelper::removeDuplicateValues($values);

    $key = 0;
    $rows = $toFilterFile;
    $output = $dir . $outputFileName;
    $info = Csv::removeRowsWhereKeyEqualsValues($rows, $key, $values, $output);

    var_dump("reference info: ", $refInfo);
    var_dump("data to filter info: ", $info);
}
