<?php

function within($topic, ...$features)
{
    return function($message = 'getFailedAssertions') use ($topic, $features) {
        if ($message === 'getName') {
            return $topic;
        } elseif ($message === 'getFailedAssertions') {
            return array_reduce(
                $features,
                function($failedAssertions, $feature) {
                    return array_merge(
                        $failedAssertions,
                        array_map(
                            function($assertion) use ($feature) {
                                return array($assertion, $feature);
                            },
                            $feature('getFailedAssertions')
                        )
                    );
                },
                array()
            );
        } elseif ($message === 'numberOfFeatures') {
            return count($features);
        } elseif ($message === 'numberOfAssertions') {
            return array_reduce(
                $features,
                function($number, $feature) {
                    return $number + $feature('numberOfAssertions');
                },
                0
            );
        } else {
            throw new InvalidArgumentException('Invalid argument ' . $message);
        }
    };
}

function describe($feature, ...$assertions)
{
    return function($message = 'getFailedAssertions') use ($feature, $assertions) {
        if ($message === 'getName') {
            return $feature;
        } elseif ($message === 'getFailedAssertions') {
            return array_filter(
                $assertions,
                function($assertion) {
                    return !$assertion('assert');
                }
            );
        } elseif ($message === 'numberOfAssertions') {
            return count($assertions);
        } else {
            throw new InvalidArgumentException('Invalid argument ' . $message);
        }
    };
}

function it($doesThis, callable $correctly)
{
    return function($message = 'assert') use ($doesThis, $correctly) {
        if ($message === 'assert') {
            return (bool) $correctly();
        } elseif ($message === 'getDescription') {
            return (string) $doesThis;
        } else {
            throw new InvalidArgumentException('Invalid argument ' . $message);
        }
    };
}

function testResults(array $topics)
{
    return function($message = '') use ($topics) {
        if ($message === 'numberOfTopics') {
            return count(array_unique(array_map(
                function($topic) { return $topic('getName'); },
                $topics
            )));
        } elseif ($message === 'numberOfFeatures') {
            return array_reduce(
                $topics,
                function($number, $topic) {
                    return $number + $topic('numberOfFeatures');
                },
                0
            );
        } elseif ($message === 'numberOfAssertions') {
            return array_reduce(
                $topics,
                function($number, $topic) {
                    return $number + $topic('numberOfAssertions');
                },
                0
            );
        } elseif ($message === 'failedAssertions') {
            return array_reduce(
                $topics,
                function($failedAssertions, $topic) {
                    $assertions = $topic('getFailedAssertions');

                    $assertions = array_map(
                        function($assertion) use ($topic) {
                            $assertion[] = $topic;

                            return $assertion;
                        },
                        $assertions
                    );

                    return array_merge($failedAssertions, $assertions);
                },
                array()
            );
        } else {
            throw new InvalidArgumentException('Invalid argument ' . $message);
        }
    };
}
