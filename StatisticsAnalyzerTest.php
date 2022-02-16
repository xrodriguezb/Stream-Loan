<?php
//Statistics analyzer unit test cases


use PHPUnit\Framework\TestCase;
require_once ('StatisticsAnalyzer.php');
class StatisticsAnalyzerTest extends TestCase
{

    public function testByScore(){
        $stats=StatisticsAnalyzer::getInstance();
        $this->assertEquals(3,$stats->getCountOfUsersWithinScoreRange(20, 50));
        $this->assertEquals(1,$stats->getCountOfUsersWithinScoreRange(-40, 0));
        $this->assertEquals(4,$stats->getCountOfUsersWithinScoreRange(0, 80));
    }

    public function testByCondition(){
        $stats=StatisticsAnalyzer::getInstance();
        $this->assertEquals(1,$stats->getCountOfUsersByCondition('CA', 'w', false, false));
        $this->assertEquals(0,$stats->getCountOfUsersByCondition('CA', 'w', false, true));
        $this->assertEquals(1,$stats->getCountOfUsersByCondition('CA', 'w', true, true));
    }

}
