<?php

namespace App\Usecase\Statistics;

//use App\T_Student;
use App\Usecase\Exceptions\ConfidenceLevelException;

/**
 * Class StatisticTest
 * @package App\Usecase\Statistics
 */
class StatisticTest {
    /**
     * @param string $alpha
     * @param int $dof
     * @return float
     * @throws ConfidenceLevelException
     */
    public static function TStudent(string $alpha, int $dof): float{
        //$max = T_Student::find(999);
        $db=$GLOBALS['dbg'];
        $max=$db->get_row("SELECT * FROM t_student WHERE dof=999");
        
        /*$high = T_Student::orderBy("dof", "desc")
                ->where("dof", "<", $dof)
                ->first();
        $low = T_Student::orderBy("dof", "asc")
                ->where("dof", ">", $dof)
                ->first();
        //*/
        $high=$db->get_row("SELECT * FROM t_student WHERE dof<$dof ORDER BY dof DESC");
        $low=$db->get_row("SELECT * FROM t_student WHERE dof>$dof ORDER BY dof ASC");

        switch ($alpha) {
            case "0.4":
                if ($dof > 120){
                    $result = $max->_0_4;
                } else {
                    $index1 = $low->dof;
                    $val1 = $low->_0_4;
                    $index2 = $high->dof;
                    $val2 = $high->_0_4;

                    $result = $val1 + ($val2 - $val1)*($dof - $index2)/($index1 - $index2);

                }
                break;
            case "0.35":
                if ($dof > 120){
                    $result = $max->_0_35;
                } else {
                    $index1 = $low->dof;
                    $val1 = $low->_0_35;
                    $index2 = $high->dof;
                    $val2 = $high->_0_35;

                    $result = $val1 + ($val2 - $val1)*($dof - $index2)/($index1 - $index2);

                }
                break;
            case "0.05":
                if ($dof > 120){
                    $result = $max->_0_05;
                } else {
                    $index1 = $low->dof;
                    $val1 = $low->_0_05;
                    $index2 = $high->dof;
                    $val2 = $high->_0_05;

                    $result = $val1 + ($val2 - $val1)*($dof - $index2)/($index1 - $index2);

                }
                break;
            default:
                throw new ConfidenceLevelException("Index not found for confidence level " . $alpha . ". Use other values instead.");
        }
        return $result;
    }
}
