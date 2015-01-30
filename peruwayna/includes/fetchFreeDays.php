<?php

// ajax.todos.php
$i = 0; // counter prevents infinite loop
$cutoff = '61'; // limit on timespan (in days)
$result = array();
 
// if date is provided, use it, otherwise default to today
$start_date = (!empty($start_date)) ? mysql_real_escape_string($start_date) : date('mm-dd-yyyy');
$check_date = $start_date;
$end_date = date('mm-dd-yyyy', strtotime("$start_date +$cutoff days")); // never retrieve more than 2 months
 
while ($check_date != $end_date)
{
    // check if any incomplete todos exist on this date
    if (mysql_result(mysql_query("SELECT COUNT(id_teacher) FROM wp_bs_availability WHERE available_date = '$check_date'"), 0) == 0)
    {
        $result[] = array('freeDate' => $check_date);
    }
 
    // +1 day to the check date
    $check_date = date('mm-dd-yyyy', strtotime("$check_date +1 day"));
 
    // break from loop if its looking like an infinite loop
    $i++;
    if ($i > $cutoff) break;
}
 
header('Content-type: application/json');
echo $result;

?>