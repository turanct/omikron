<?php

return within('omikron',
    describe('"within"',
        it('has a name', function() {
            $topic = within('name', @_);

            return $topic('getName') == 'name';
        }),

        it('counts its features', function() {
            $topic1 = within(@_, @feature1, @feature2, @feature3);
            $topic2 = within(@_, @feature1);

            return
                $topic1('numberOfFeatures') == 3
                && $topic2('numberOfFeatures') == 1
            ;
        }),

        it('counts the assertions inside its features', function() {
            $feature1 = describe(@_, @assertion1, @assertion2, @assertion3);
            $feature2 = describe(@_, @assertion1);
            $topic1 = within(@_, $feature1, $feature2);
            $topic2 = within(@_, $feature1);

            return
                $topic1('numberOfAssertions') == 4
                && $topic2('numberOfAssertions') == 3
            ;
        }),

        it('returns a list of failed assertions', function() {
            $feature1 = describe(@_,
                it('fails1', function() { return false; }),
                it('fails2', function() { return false; }),
                it('succeeds', function() { return true; })
            );
            $feature2 = describe(@_,
                it('fails3', function() { return false; })
            );
            $topic = within(@_, $feature1, $feature2);

            $failedAssertions = $topic('getFailedAssertions');

            return
                count($failedAssertions) == 3
                && $failedAssertions[0][0]('getDescription') == 'fails1'
                && $failedAssertions[1][0]('getDescription') == 'fails2'
                && $failedAssertions[2][0]('getDescription') == 'fails3'
            ;
        })
    )
);
