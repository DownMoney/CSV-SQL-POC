<?php

namespace AppBundle;


class Converter
{
    private $formCounter = 0;
    private $questionCounter = 0;
    private $choiceCounter = 0;

    public function convert($data) {
        $sql = [];

        foreach ($data as $form) {
            $formName = $form[0];
            $questions = $form[1];

            $sql = array_merge($sql, $this->convertForm($formName, $questions));
        }

        return $sql;
    }

    private function convertForm($form, $questions) {
        $this->formCounter++;

        $sql = ["INSERT INTO 'questionnaire' VALUES ($this->formCounter, '$form', $this->formCounter);"];

        $sql = array_merge($sql, $this->convertQuestions($this->formCounter, $questions));

        return $sql;
    }

    private function convertQuestions($formID, $questions) {
        $sql = [];

        for ($i = 0; $i < count($questions); $i++)
        {
            $sql = array_merge($sql, $this->convertQuestion($formID, $questions[$i], $i));
        }

        return $sql;
    }

    private function convertQuestion($formID, $question, $questionOrder) {
        $questionText = $question['Question'];
        $type = $question['Type'];
        $multiple = $question['Multiple Choice'];

        $this->questionCounter++;

        $sql = ["INSERT INTO 'question' VALUES ($this->questionCounter, $formID, '$questionText', '$questionText', $questionOrder, $multiple, $type);"];

        $choices = $question['Answers'];

        foreach ($choices as $choice) {
            $sql []= $this->convertChoice($this->questionCounter, $choice);
        }

        return $sql;
    }

    private function convertChoice($questionID, $choice) {
        $this->choiceCounter++;

        return "INSERT INTO 'choice' VALUES ($this->choiceCounter, $questionID, '$choice');";
    }
}