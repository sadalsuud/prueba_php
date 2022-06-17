<?php 

function toObject($arr)
{
    return htmlspecialchars(json_encode($arr, true), ENT_QUOTES);
}