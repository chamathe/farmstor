
<?php
function getAge($time)
{
    // get the time
    $timestamp = new DateTime($time);
    
    // get the current date and time
    $today = new DateTime();

    // calculate the difference
    $diff = $today->diff($timestamp);

    // check if the timestamp is in the future
    if ($timestamp > $today) {
        return '-';
    }

    // calculate total days and remaining hours
    $totalDays = $diff->days;
    $remainingHours = $diff->h;

    // construct the result string
    $result = '';

    if ($totalDays > 0) {
        $result .= $totalDays . ' days';
    }

    if ($remainingHours > 0) {
        // add a separator if both days and hours are present
        if ($totalDays > 0) {
            $result .= ' and ';
        }
        $result .= $remainingHours . ' hours';
    }

    return $result;
}


?>