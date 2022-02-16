<?php

require_once ('StatisticsAnalyzer.php');

$statistics=StatisticsAnalyzer::getInstance();

//Direct statistics execution
//To visualize generated PHP Unit testing please execute StatisticsAnalyzerTest.php


echo $statistics->getCountOfUsersWithinScoreRange(20, 50)."\n"; // 3
echo $statistics->getCountOfUsersWithinScoreRange(-40,0)."\n"; //1
echo $statistics->getCountOfUsersWithinScoreRange(0,80)."\n"; // 4

echo $statistics->getCountOfUsersByCondition('CA', 'w', false, false)."\n"; // 1
echo $statistics->getCountOfUsersByCondition('CA', 'w', false, true)."\n"; // 0
echo $statistics->getCountOfUsersByCondition('CA', 'w', true, true)."\n"; // 1



