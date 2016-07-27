<?php

namespace Tests\AppBundle;

use AppBundle\Converter;
use PHPUnit\Framework\TestCase;
use SplFileObject;


class ConverterTests extends TestCase
{
    public function testConvertSimple()
    {
        $expectedSQL = [
            "INSERT INTO 'questionnaire' VALUES (1, 'Test Form', 1);",
            "INSERT INTO 'question' VALUES (1, 1, 'Test Question', 'Test Question', 0, 0, 1);",
            "INSERT INTO 'choice' VALUES (1, 1, 'Ans 1');",
            "INSERT INTO 'choice' VALUES (2, 1, 'Ans 2');",
            "INSERT INTO 'choice' VALUES (3, 1, 'Ans 3');",
        ];

        $data =
            [

                'Test Form' => [
                    'order' => 1,
                    'questions' => [
                        [
                            'Question' => 'Test Question',
                            'Type' => '1',
                            'Multiple Choice' => '0',
                            'Answers' => [
                                'Ans 1',
                                'Ans 2',
                                'Ans 3',
                            ]
                        ]
                    ]
                ]
            ];

        $converter = new Converter();
        $sql = $converter->convert($data);

        $this->assertEquals($expectedSQL, $sql);
    }

    public function testConvert2Forms()
    {
        $expectedSQL = [
            "INSERT INTO 'questionnaire' VALUES (1, 'Test Form', 1);",
            "INSERT INTO 'question' VALUES (1, 1, 'Test Question', 'Test Question', 0, 0, 1);",
            "INSERT INTO 'choice' VALUES (1, 1, 'Ans 1');",
            "INSERT INTO 'choice' VALUES (2, 1, 'Ans 2');",
            "INSERT INTO 'choice' VALUES (3, 1, 'Ans 3');",
            "INSERT INTO 'questionnaire' VALUES (2, 'Test Form 2', 2);",
            "INSERT INTO 'question' VALUES (2, 2, 'Test Question 2', 'Test Question 2', 0, 0, 1);",
            "INSERT INTO 'choice' VALUES (4, 2, 'Ans 1 - 2');",
            "INSERT INTO 'choice' VALUES (5, 2, 'Ans 2 - 2');",
            "INSERT INTO 'choice' VALUES (6, 2, 'Ans 3 - 2');",
        ];

        $data =
            [

                'Test Form' => [
                    'order' => 1,
                    'questions' => [
                        [
                            'Question' => 'Test Question',
                            'Type' => '1',
                            'Multiple Choice' => '0',
                            'Answers' => [
                                'Ans 1',
                                'Ans 2',
                                'Ans 3',
                            ]
                        ]
                    ]
                ],

                'Test Form 2' => [
                    'order' => 2,
                    'questions' => [
                        [
                            'Question' => 'Test Question 2',
                            'Type' => '1',
                            'Multiple Choice' => '0',
                            'Answers' => [
                                'Ans 1 - 2',
                                'Ans 2 - 2',
                                'Ans 3 - 2',
                            ]
                        ]
                    ]
                ]

            ];

        $converter = new Converter();
        $sql = $converter->convert($data);

        $this->assertEquals($expectedSQL, $sql);
    }

    public function testConvert2Questions()
    {
        $expectedSQL = [
            "INSERT INTO 'questionnaire' VALUES (1, 'Test Form', 1);",
            "INSERT INTO 'question' VALUES (1, 1, 'Test Question', 'Test Question', 0, 0, 1);",
            "INSERT INTO 'choice' VALUES (1, 1, 'Ans 1');",
            "INSERT INTO 'choice' VALUES (2, 1, 'Ans 2');",
            "INSERT INTO 'choice' VALUES (3, 1, 'Ans 3');",
            "INSERT INTO 'question' VALUES (2, 1, 'Test Question 2', 'Test Question 2', 1, 0, 1);",
            "INSERT INTO 'choice' VALUES (4, 2, 'Ans 1 - 2');",
            "INSERT INTO 'choice' VALUES (5, 2, 'Ans 2 - 2');",
            "INSERT INTO 'choice' VALUES (6, 2, 'Ans 3 - 2');",
        ];

        $data =
            [

                'Test Form' => [
                    'order' => 1,
                    'questions' => [
                        [
                            'Question' => 'Test Question',
                            'Type' => '1',
                            'Multiple Choice' => '0',
                            'Answers' => [
                                'Ans 1',
                                'Ans 2',
                                'Ans 3',
                            ]
                        ],
                        [
                            'Question' => 'Test Question 2',
                            'Type' => '1',
                            'Multiple Choice' => '0',
                            'Answers' => [
                                'Ans 1 - 2',
                                'Ans 2 - 2',
                                'Ans 3 - 2',
                            ]
                        ]
                    ]
                ]

            ];

        $converter = new Converter();
        $sql = $converter->convert($data);

        $this->assertEquals($expectedSQL, $sql);
    }

    public function testConvert()
    {
        $expectedSQL = [
            "INSERT INTO 'questionnaire' VALUES (1, 'Test Form', 1);",
            "INSERT INTO 'question' VALUES (1, 1, 'Test Question', 'Test Question', 0, 0, 1);",
            "INSERT INTO 'choice' VALUES (1, 1, 'Ans 1');",
            "INSERT INTO 'choice' VALUES (2, 1, 'Ans 2');",
            "INSERT INTO 'choice' VALUES (3, 1, 'Ans 3');",
            "INSERT INTO 'question' VALUES (2, 1, 'Test Question 2', 'Test Question 2', 1, 0, 1);",
            "INSERT INTO 'choice' VALUES (4, 2, 'Ans 1 - 2');",
            "INSERT INTO 'choice' VALUES (5, 2, 'Ans 2 - 2');",
            "INSERT INTO 'choice' VALUES (6, 2, 'Ans 3 - 2');",
            "INSERT INTO 'questionnaire' VALUES (2, 'Test Form 2', 2);",
            "INSERT INTO 'question' VALUES (3, 2, 'Test Question 3', 'Test Question 3', 0, 0, 1);",
            "INSERT INTO 'choice' VALUES (7, 3, 'Ans 1');",
            "INSERT INTO 'choice' VALUES (8, 3, 'Ans 2');",
            "INSERT INTO 'choice' VALUES (9, 3, 'Ans 3');",
        ];

        $data =
            [

                'Test Form' => [
                    'order' => 1,
                    'questions' => [
                        [
                            'Question' => 'Test Question',
                            'Type' => '1',
                            'Multiple Choice' => '0',
                            'Answers' => [
                                'Ans 1',
                                'Ans 2',
                                'Ans 3',
                            ]
                        ],
                        [
                            'Question' => 'Test Question 2',
                            'Type' => '1',
                            'Multiple Choice' => '0',
                            'Answers' => [
                                'Ans 1 - 2',
                                'Ans 2 - 2',
                                'Ans 3 - 2',
                            ]
                        ]
                    ]
                ],

                'Test Form 2' => [
                    'order' => 2,
                    'questions' => [
                        [
                            'Question' => 'Test Question 3',
                            'Type' => '1',
                            'Multiple Choice' => '0',
                            'Answers' => [
                                'Ans 1',
                                'Ans 2',
                                'Ans 3',
                            ]
                        ]
                    ]
                ]
            ];

        $converter = new Converter();
        $sql = $converter->convert($data);

        $this->assertEquals($expectedSQL, $sql);
    }

    public function testConvertFromFile() {

        $expectedSQL = [
            "INSERT INTO 'questionnaire' VALUES (1, 'Test Form', 1);",
            "INSERT INTO 'question' VALUES (1, 1, 'Test Question', 'Test Question', 0, 0, 1);",
            "INSERT INTO 'choice' VALUES (1, 1, 'Ans 1');",
            "INSERT INTO 'choice' VALUES (2, 1, 'Ans 2');",
            "INSERT INTO 'choice' VALUES (3, 1, 'Ans 3');",
            "INSERT INTO 'question' VALUES (2, 1, 'Test Question 2', 'Test Question 2', 1, 0, 1);",
            "INSERT INTO 'choice' VALUES (4, 2, 'Ans 1 - 2');",
            "INSERT INTO 'choice' VALUES (5, 2, 'Ans 2 - 2');",
            "INSERT INTO 'choice' VALUES (6, 2, 'Ans 3 - 2');",
            "INSERT INTO 'questionnaire' VALUES (2, 'Test Form 2', 2);",
            "INSERT INTO 'question' VALUES (3, 2, 'Test Question 3', 'Test Question 3', 0, 0, 1);",
            "INSERT INTO 'choice' VALUES (7, 3, 'Ans 1');",
            "INSERT INTO 'choice' VALUES (8, 3, 'Ans 2');",
            "INSERT INTO 'choice' VALUES (9, 3, 'Ans 3');",
        ];

        $fileName = realpath('data/sample.csv');
        $converter = new Converter();
        $file = new SplFileObject($fileName);

        $sql = $converter->convertFromFile($file);

        $this->assertEquals($expectedSQL, $sql);
    }
}
