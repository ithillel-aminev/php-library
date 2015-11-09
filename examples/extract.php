<?php
set_time_limit(0);

require '../../vendor/autoload.php';
//require '../Library/CsvExtractor.php';
//require '../Library/ArrayHelper.php';

use \TAminev\PhpLibrary\CsvExtractor as Csv;

// PART 1 - extract data from the source csv file to multiple csv files
$source = 'Full database 05.11.xlsx.csv';
$dir = "C:\\Users\\taminev\\Downloads\\Full database 05.11\\";

$csv = new Csv($dir . $source, 1);

$configs = array(
    array('columns' => array(0), 'output' => $dir . 'qsarr0.csv'),
    array('columns' => array(2,3), 'output' => $dir . 'qsarr1.csv'),
    array('columns' => array(5,6), 'output' => $dir . 'qsarr2.csv'),
    array('columns' => array(8,9), 'output' => $dir . 'qsarr3.csv'),
    array('columns' => array(11,12), 'output' => $dir . 'qsarr4.csv'),
    array('columns' => array(14,15), 'output' => $dir . 'qsarr5.csv'),
//    array('columns' => array(17,18), 'output' => $dir . 'arr6.csv'),
//    array('columns' => array(20,21), 'output' => $dir . 'arr7.csv'),
//    array('columns' => array(23,24), 'output' => $dir . 'arr8.csv'),
//    array('columns' => array(26,27), 'output' => $dir . 'arr9.csv'),
//    array('columns' => array(29,30), 'output' => $dir . 'arr10.csv'),
//    array('columns' => array(32,33), 'output' => $dir . 'arr11.csv'),
//    array('columns' => array(35,36), 'output' => $dir . 'arr12.csv'),
//    array('columns' => array(38,39), 'output' => $dir . 'arr13.csv'),
//    array('columns' => array(41,42), 'output' => $dir . 'arr14.csv'),
//    array('columns' => array(44,45), 'output' => $dir . 'arr15.csv'),
);

$csv->extractMultiple($configs);