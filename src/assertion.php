<?php

function expect($value, $predicate) {
    return $predicate($value);
}

function toBe($expected) {
    return function($actual) use($expected) {
        return $actual === $expected
            ? true
            : "Expected ".print_r($actual, true)." to be ".print_r($expected, true);
    };
}

function notToBe($expected) {
    return function($actual) use($expected) {
        return $actual !== $expected
            ? true
            : "Expected ".print_r($actual, true)." not to be ".print_r($expected, true);
    };
}

function toBeTrue() {
    return function($actual) {
        return $actual === true
            ? true
            : "Expected ".print_r($actual, true)." to be true.";
    };
}

function toBeFalse() {
    return function($actual) {
        return $actual === false
            ? true
            : "Expected ".print_r($actual, true)." to be false.";
    };
}