<?php
function getLimitToReserve() {
    return "+1 week";
}
function getStartTime($date)
{
    return 8; // 8am
}

function getEndTime($date)
{
    return 19; // 7pm
}

function getTimeBlockChange()
{
    return "+1 hour"; // 1 hour
}
function getTimeTooLatePolicy() {
    return "-20 minutes";
}

function getMaxAllowedTimeBlocks()
{
    return 3;
}