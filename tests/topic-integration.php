<?php

$sampleTopic = within("calculus",
    describe("addition",
        it("adds two numbers", function() { return
            1 + 1 == 3;
        }),
        it("is difficult", function() { return
            false;
        }),
        it("adds three numbers", function() { return
            1 + 1 + 1 == 3;
        })
    ),
    describe("subtraction",
        it("looks strange", function() { return
            false;
        }),
        it("subtracts two numbers", function() { return
            3 - 2 == 1;
        })
    )
);

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