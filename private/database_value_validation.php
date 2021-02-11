<?php 

//check if value is empyt, returns true if value is not set (!isset) OR if the trimmed value is empty ('')
function is_blank($value){
    return !isset($value) || trim($value) === '';
}

//the opposite of function is_blank
function has_presence($value){
    return !is_blank($value);

}

function length_greater_than($value, $min){
    $length = strlen($value);
    return $length > $min; // returns true if length is greater than minimum
}

function length_less_than($value, $max){
    $length = strlen($value);
    return $length <  $max; // returns true if length is greater than maximum
}

function equal_length($value, $exact){
    $length = strlen($value);
    return $length == $exact; // returns true if length is equal to 'exact'
}

function has_length($value, $options){
    if(isset($options['min']) && !length_greater_than($value, $options['min'] -1)) {
        return false; 
    } elseif (isset($options['max']) && !length_less_than($value, $options['max'] -1)) {
        return false;
    } else {
        return true;
    }

}

function includes_value($needle, $haystack){
    return in_array($needle, $haystack); //returns true if needle is found in haystack
}

function excludes_value($needle, $haystack){
    return !in_array($needle, $haystack); //returns true if needle is found in haystack
}

function has_string($value, $string){
    return strpos($value, $string) !== false;
}

function has_valid_email_format($value){
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
}

?>