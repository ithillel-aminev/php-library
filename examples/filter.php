<?php
// Scenario. Removing by 0-key all that present in first (N-1) tables from the last (Nth).

$time=microtime(true);
set_time_limit(0);
require '../../vendor/autoload.php';
use \TAminev\PhpLibrary\CsvExtractor as Csv;
use \TAminev\PhpLibrary\ArrayHelper;


$configs2 = array(
    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr0.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr1.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr2.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr3.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr4.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr5.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr6.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr7.csv'),
//    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr8.csv'),
//    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr9.csv'),
//    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr10.csv'),
//    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr11.csv'),
//    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr12.csv'),
//    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr13.csv'),
//    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr14.csv'),
//    array('input' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr15.csv'),
);

$values = array();
foreach ($configs2 as $config){
    $csv = new Csv($config['input'], 0);
    $newArr = $csv->extract(array(0));
    $newArr = ArrayHelper::column($newArr, 0);
    $values = array_merge($values, $newArr);
}
$refInfo = ArrayHelper::removeDuplicateValues($values);

$key = 0;
$rows = 'C:\Users\taminev\Downloads\Full database 04.11-2\arr8.csv';
$output = 'C:\Users\taminev\Downloads\Full database 04.11-2\(vegas_nay) 1-4 files.csv';
$info = Csv::removeRowsWhereKeyEqualsValues($rows, $key, $values, $output );


var_dump("reference info: ", $refInfo);
var_dump("data to filter info: ", $info);
$time=microtime(true)-$time;echo "\n".'BenchMark: '.$time."\n";
