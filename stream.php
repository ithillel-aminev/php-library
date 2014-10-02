<?php

$handle = fopen("C:\\Users\\Dmitriy\\Downloads\\engagements1of4.sql",'r') or die('Can\'t find such file');

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();
$count = $max = 0;
$avgStrLeng = 0;
while(!feof($handle)){
    $line = stream_get_line($handle, 1000000, "\n");
    $strlen = strlen($line);
    $max = ($strlen>$max) ? $strlen : $max;
    $avgStrLeng += $strlen;
    $count++;
}
$avgStrLeng /= $count;
$time_end = microtime_float();

$time = $time_end - $time_start;

fclose($handle);
echo("Time: ".$time."<br>");
echo("Max str len: ".$max."<br>");
echo("Avg str len: ".(int)$avgStrLeng."<br>");
echo("Str count: ".$count."<br>");
