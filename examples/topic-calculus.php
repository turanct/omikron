<?php return

within("calculus",
    describe("addition",
        it("adds two numbers", function() { return
            expect(1 + 1, toBe(3));
        }),
        it("is difficult", function() { return
            expect(3 + 3, toBe(33));
        }),
        it("adds three numbers", function() { return
            expect(1 + 1 + 1, toBe(3));
        })
    ),
    describe("subtraction",
        it("looks strange", function() { return
            expect(true, toBeFalse());
        }),
        it("subtracts two numbers", function() { return
            expect(3 - 2, notToBe(5));
        })
    )
);
