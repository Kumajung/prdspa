<?php
function date_times($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    return "$strDay/$strMonth/$strYear $strHour:$strMinute:$strSeconds";
}

function formatNumber($number) {
    if (intval($number) == $number) {
        return number_format(intval($number));
    } else {
        return number_format($number, 2);
    }
}

function date_inters($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    return "$strDay/$strMonth/$strYear";
}

function date_months($bDay)
{
    $month_recent  = substr("$bDay", 5, 2);
    $year_recent = substr("$bDay", 0, 4);
    $month_years_thai = "$month_recent" . "/$year_recent";
    return $month_years_thai;
}