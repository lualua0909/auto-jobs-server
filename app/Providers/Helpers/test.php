<?php

if (!function_exists('greet')) {
    /**
     * Greeting a person
     *
     * @param  string $person Name
     * @return string
     */
    function greet($person = 'Admin')
    {
        return 'Hello ' . $person;
    }
}