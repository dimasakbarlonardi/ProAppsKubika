<?php

use Carbon\Carbon;

function HumanDate($date)
{
    $date =  date('d M Y', strtotime($date));

    return $date;
}

function HumanDateOnly($date)
{
    $date =  date('d F', strtotime($date));

    return $date;
}

function HumanTime($time)
{
    $time =  date('H:i A', strtotime($time));

    return $time;
}

function HumanDateTime($time)
{
    $time =  date('d M Y - H:i A', strtotime($time));

    return $time;
}

function HumanYear($time)
{
    $time = date('Y', strtotime($time));

    return $time;
}

function TimeAgo($time)
{
    $time = Carbon::createFromTimeStamp(strtotime($time))->diffForHumans();

    return $time;
}
