<?php

namespace Tests\AppBundle;

use AppBundle\Converter;
use PHPUnit\Framework\TestCase;


class DefaultControllerTest extends TestCase
{
    public function testConvert()
    {
        $expectedSQL = [
            "INSERT INTO 'questionnaire' VALUES (1, 'Test Form', 1);",
            "INSERT INTO 'question' VALUES (1, 1, 'Test Question', 'Test Question', 1, 0, 1)",
            "INSERT INTO 'choice' VALUES (1, 1, 'Ans 1')",
            "INSERT INTO 'choice' VALUES (2, 1, 'Ans 2')",
            "INSERT INTO 'choice' VALUES (3, 1, 'Ans 3')",
        ];

        $data =
            [
                [
                    'Test Form' => [
                        [
                            'Form' => 'Test Form',
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

        $sql = Converter::convert($data);

        $this->assertEquals($expectedSQL, $sql);
    }
}
