checkExamScores.php

input json:

{
    studentExamId: int
}

output json:

{
    result: true/false,
    answers: [
        {   ...
            correct: true/false,
            score: double,
            testCases: [
                {
                    inputs: [ int, int, ..., int ],
                    output: string,
                    expectedResult: string
                },
                ...
            ]
        },
        ...
    ]
}