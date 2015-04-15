<?php

class stats {

    public static function calculateMode($resultValues){
        $values = array_count_values($resultValues);
        return array_search(max($values), $values);
    }

    public static function calculateMean($resultValues){
        return array_sum($resultValues) / count($resultValues);
    }

    public static function calculateMedian($resultValues){
        rsort($resultValues);
        $middle = floor(count($resultValues) / 2);
        return $resultValues[intval($middle)-1];
    }

    public static function calculateTrimmedMean($resultValues, $trimmedPercent=TRIM_PERCENT){
        rsort($resultValues);;
        $arrayLength = count($resultValues);
        $trimLength = floor($arrayLength * $trimmedPercent/100);
        $slicedResultValues = array_slice($resultValues, $trimLength, $arrayLength-($trimLength*2));
        return stats::calculateMean($slicedResultValues);
    }

    public static function calculateRange($resultValues){
        return max($resultValues)-min($resultValues);
    }
} 