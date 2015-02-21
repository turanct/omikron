<?php

$sampleTopic = include(__DIR__.'/../examples/topic-calculus.php');

$expectedOutput = <<<OUTPUT
topics: 1
features: 2
assertions: 5

FAILED: calculus: addition adds two numbers
FAILED: calculus: addition is difficult
FAILED: calculus: subtraction looks strange

OUTPUT;


return within("integration",
    describe("output from complete suite",
        it("renders everything we need to know", function() use($expectedOutput, $sampleTopic) {
            $renderedOutput = renderOutput(testResults([$sampleTopic]));
            return $renderedOutput === $expectedOutput;
        })
    )
);