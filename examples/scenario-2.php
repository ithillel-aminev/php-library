<?php
set_time_limit(0);

require '../../vendor/autoload.php';

use \TAminev\PhpLibrary\CsvExtractor as Csv;
use \TAminev\PhpLibrary\ArrayHelper;

// PART 1 - extract data from the source csv file to multiple csv files
$csv = new Csv('scenario-2.csv', 1);

$configs = array(
    array('columns' => array(0), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr0.csv'),
    array('columns' => array(2,3), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr1.csv'),
    array('columns' => array(5,6), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr2.csv'),
    array('columns' => array(8,9), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr3.csv'),
    array('columns' => array(11,12), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr4.csv'),
    array('columns' => array(14,15), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr5.csv'),
    array('columns' => array(17,18), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr6.csv'),
    array('columns' => array(20,21), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr7.csv'),
    array('columns' => array(23,24), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr8.csv'),
    array('columns' => array(26,27), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr9.csv'),
    array('columns' => array(29,30), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr10.csv'),
    array('columns' => array(32,33), 'output' => 'C:\Users\taminev\Downloads\Full database 03.11\arr11.csv'),
);

//$csv->extractMultiple($configs);

// PART 2. - remove by 0-key all that present in first (N-1) tables from the last (Nth).

// 2.1 - generating of the list of values - the reference
$configs2 = array(
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr0.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr1.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr2.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr3.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr4.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr5.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr6.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr7.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr8.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr9.csv'),
    array('input' => 'C:\Users\taminev\Downloads\Full database 03.11\arr10.csv'),
);

$values = array();
foreach ($configs2 as $config){
    $csv = new Csv($config['input'], 0);
    $newArr = $csv->extract(array(0));
    $newArr = ArrayHelper::column($newArr, 0);
    $values = array_merge($values, $newArr);
}
var_dump("reference before flip-flip: " . count($values));
$values = array_keys(array_flip($values));
var_dump("reference after flip-flip: " . count($values));

$time=microtime(true);

// 2.2 - rows to filter
$csv = new Csv('C:\Users\taminev\Downloads\Full database 03.11\arr11.csv', 0);
$toFilter = $csv->extract();
foreach ($toFilter as $key => $row) {
    $toFilter[$row[0]] = $row;
    unset ($toFilter[$key]);
}

// 2.3 - removing rows where 0-key values present in the reference
$countBeforeFilter = count($toFilter);
foreach ($values as $value){
    unset($toFilter[$value]);
}
$countAfterFilter = count($toFilter);

// 2.4 - output filtered rows to file
$output = 'C:\Users\taminev\Downloads\Full database 03.11\sally-hansen-filtered.csv';
Csv::write($toFilter, $output);

var_dump("Wrote to " . $output . ". ");
var_dump("Before filter " . $countBeforeFilter . " values. ");
var_dump("After filter " . $countAfterFilter . " values. ");


$time=microtime(true)-$time;
echo "\n".'BenchMark: '.$time."\n";

