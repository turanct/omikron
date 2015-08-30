<?php

function bad()
{
    throw new Exception('Something');
}

$sampleTopic = within("foo",
    describe("bar",
        it("throws an exception", function() { return
            expect(bad(), toBe('good'));
        })
    )
);

return within("omikron",
    describe("assertion",
        it("catches exceptions in callable", function() use ($sampleTopic) {
            try {
                $renderedOutput = renderOutput(testResults([$sampleTopic]));
            } catch (Exception $e) {
                $renderedOutput = '';
            }

            $outputContainsError =
                strpos($renderedOutput, 'FAILED') !== false
                && strpos($renderedOutput, 'Exception: Something in') !== false
                && strpos($renderedOutput, 'Call stack:') !== false;

            return expect($outputContainsError, toBeTrue());
        })
    )
);
