<?php
// Polyfill para funciones ctype faltantes en iPage
// Incluir ANTES de cargar Laravel

if (!extension_loaded('ctype')) {
    // Implementar funciones ctype básicas que Laravel necesita
    
    if (!function_exists('ctype_alnum')) {
        function ctype_alnum($text) {
            return preg_match('/^[a-zA-Z0-9]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_alpha')) {
        function ctype_alpha($text) {
            return preg_match('/^[a-zA-Z]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_digit')) {
        function ctype_digit($text) {
            return preg_match('/^[0-9]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_lower')) {
        function ctype_lower($text) {
            return preg_match('/^[a-z]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_upper')) {
        function ctype_upper($text) {
            return preg_match('/^[A-Z]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_space')) {
        function ctype_space($text) {
            return preg_match('/^[\s]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_xdigit')) {
        function ctype_xdigit($text) {
            return preg_match('/^[a-fA-F0-9]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_print')) {
        function ctype_print($text) {
            return preg_match('/^[ -~]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_punct')) {
        function ctype_punct($text) {
            return preg_match('/^[!-\/:-@\[-`{-~]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_cntrl')) {
        function ctype_cntrl($text) {
            return preg_match('/^[\x00-\x1F\x7F]+$/', $text) ? true : false;
        }
    }
    
    if (!function_exists('ctype_graph')) {
        function ctype_graph($text) {
            return preg_match('/^[!-~]+$/', $text) ? true : false;
        }
    }
}
?>
