<?php
require_once 'ScoreDataIndexerInterface.php';

class StatisticsAnalyzer implements ScoreDataIndexerInterface
{

    private Generator $_generator;
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new StatisticsAnalyzer();
        }

        return self::$instance;
    }

    public function getCountOfUsersWithinScoreRange(int $rangeStart, int $rangeEnd): int
    {

        //if invalid params
        if ($rangeEnd < $rangeStart || !is_int($rangeStart) || !is_int($rangeEnd)) {
            return 0;
        }

        $count_of_users = 0;
        $this->setGenerator();

        while ($currentLine = $this->_generator->current()) {
            list($_name, $_gender, $_age, $_region, $_score) = str_getcsv($currentLine, ";");
            if ($_score >= $rangeStart && $_score <= $rangeEnd) {
                $count_of_users++;
            }
            $this->_generator->next();
        }

        unset($this->_generator);
        return $count_of_users;

    }

    private function setGenerator()
    {
        $this->_generator = $this->getLines();
        $this->_generator->next();
    }

    private function getLines(): Generator
    {
        try {

            $file = fopen(__DIR__ . '/dataset.csv', 'r');
            if (!$file) {
                throw new Exception("File not found");
            }

            while (!feof($file)) {
                yield trim(fgets($file));
            }

        } catch (Exception $e) {
            return $e->getTraceAsString();
        }


    }

    public function getCountOfUsersByCondition(string $region, string $gender, bool $hasLegalAge, bool $hasPositiveScore): int
    {
        if (empty($region) || empty($gender) || !is_bool($hasLegalAge) || !is_bool($hasPositiveScore)) {
            return 0;
        }

        $count_of_users = 0;
        $this->setGenerator();
        while ($currentLine = $this->_generator->current()) {
            list($_name, $_gender, $_age, $_region, $_score) = str_getcsv($currentLine, ";");
            if ($_region == $region && $_gender == $gender) {
                //if region and gender matches then evaluate age and score
                if ((($hasLegalAge && $_age >= 21) || (!$hasLegalAge && $_age < 21)) and (($hasPositiveScore && $_score >= 0) || (!$hasPositiveScore && $_score < 0))) {
                    $count_of_users++;
                }

            }
            $this->_generator->next();
        }
        unset($this->_generator);
        return $count_of_users;
    }
}