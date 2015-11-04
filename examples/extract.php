<?php
set_time_limit(0);

require '../../vendor/autoload.php';

use \TAminev\PhpLibrary\CsvExtractor as Csv;

// PART 1 - extract data from the source csv file to multiple csv files
$csv = new Csv('C:\Users\taminev\Downloads\Full database 04.11-2\Full database 04.11.xlsx.csv', 1);

$configs = array(
    array('columns' => array(0), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr0.csv'),
    array('columns' => array(2,3), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr1.csv'),
    array('columns' => array(5,6), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr2.csv'),
    array('columns' => array(8,9), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr3.csv'),
    array('columns' => array(11,12), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr4.csv'),
    array('columns' => array(14,15), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr5.csv'),
    array('columns' => array(17,18), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr6.csv'),
    array('columns' => array(20,21), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr7.csv'),
    array('columns' => array(23,24), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr8.csv'),
//    array('columns' => array(26,27), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr9.csv'),
//    array('columns' => array(29,30), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr10.csv'),
//    array('columns' => array(32,33), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr11.csv'),
//    array('columns' => array(35,36), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr12.csv'),
//    array('columns' => array(38,39), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr13.csv'),
//    array('columns' => array(41,42), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr14.csv'),
//    array('columns' => array(44,45), 'output' => 'C:\Users\taminev\Downloads\Full database 04.11-2\arr15.csv'),
);

$csv->extractMultiple($configs);