<?php

use Carbon\Carbon;

function HumanDate($date)
{
    $date =  date('d M Y', strtotime($date));

    return $date;
}

function HumanTime($time)
{
    $time =  date('H:i A', strtotime($time));

    return $time;
}

function TimeAgo($time)
{
    $time = Carbon::createFromTimeStamp(strtotime($time))->diffForHumans();

    return $time;
}
