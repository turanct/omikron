<?php

return within('omikron',
    describe('"describe"',
        it('has a name', function() {
            $feature = describe('name', @_);

            return $feature('getName') == 'name';
        }),

        it('counts its assertions', function() {
            $feature1 = describe(@_, @assertion1, @assertion2, @assertion3);
            $feature2 = describe(@_, @assertion1);

            return
                $feature1('numberOfAssertions') == 3
                && $feature2('numberOfAssertions') == 1
            ;
        }),

        it('returns a list of failed assertions', function() {
            $feature = describe(@_,
                it('fails1', function() { return false; }),
                it('fails2', function() { return false; }),
                it('succeeds', function() { return true; })
            );

            $failedAssertions = $feature('getFailedAssertions');

            return
                count($failedAssertions) == 2
                && $failedAssertions[0]('getDescription') == 'fails1'
                && $failedAssertions[1]('getDescription') == 'fails2'
            ;
        })
    )
);
