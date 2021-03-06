<?php

use SebastianBergmann\Diff\Differ;

function expect($value, callable $predicate) {
    return $predicate($value);
}

function expectToThrow(callable $expression, $exception = null) {
    try {
        $expression();
    } catch (Exception $e) {
        if (
            ($exception !== null && $e instanceof $exception)
            || $exception === null
        ) {
            return true;
        }
    }

    return "Expected " . ($exception ?: 'Exception') . " to be thrown\n";
}

function expectNotToThrow(callable $expression) {
    try {
        $expression();
    } catch (Exception $e) {
        return "Unexpected exception was thrown: [" . get_class($e) . "] " . $e->getMessage() . "\n";
    }

    return true;
}

function diff($actual, $expected) {
    // workaround for bug in differ https://github.com/sebastianbergmann/diff/issues/25
    $actual = is_scalar($actual) ? (string) $actual : $actual;
    $expected = is_scalar($expected) ? (string) $expected : $expected;
    return PHP_EOL.
        (new Differ("--- Actual\n+++ Expected\n"))
            ->diff($actual, $expected);
}

function toBe($expected) {
    return function($actual) use($expected) {
        return $actual === $expected
            ? true
            : "Expected values to be equal, instead got:".diff($actual, $expected)
        ;
    };
}

function notToBe($expected) {
    return function($actual) use($expected) {
        return $actual !== $expected
            ? true
            : "Expected values not to be equal, instead got:".diff($actual, $expected)
        ;
    };
}

function toBeTrue() {
    return function($actual) {
        return $actual === true
            ? true
            : "Expected value to be true"
        ;
    };
}

function toBeFalse() {
    return function($actual) {
        return $actual === false
            ? true
            : "Expected value to be false"
        ;
    };
}
