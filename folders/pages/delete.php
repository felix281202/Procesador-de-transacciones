<?php 

require_once '..\..\folders\layouts\layouts.php';
require_once '..\..\folders\business\logic.php';
require_once 'student.php';
require_once '..\..\folders\service\IServiceBasic.php';
require_once 'StudentServiceCookies.php';
require_once '..\FileHandler\JsonFileHandler.php';
require_once '..\FileHandler\FileTransaction.php';
require_once '../FileHandler/IHandler.php';
require_once '../FileHandler/transactionObjetc.php';
require_once '../FileHandler/CSVFileTransaction.php';
require_once '../FileHandler/logFileHandler.php';

$serviceStudent = new CSVFileTransaction("..\FileHandler\data");
$logic = new Logic();
$log = new logFileHandler("../FileHandler/data");

$isContainId = isset($_GET['id']);

if($isContainId) {

    $studentID = $_GET['id'];

    $logList = $log->ReadList();

    $list = $serviceStudent->GetList();

    $time = date('d-m-Y H:i:s');

    $newLog = 'Se hizo una eliminación en la fecha ' . $time . ', la transacción eliminada tenía la ID: ' . $studentID . PHP_EOL;

    if ($logList !== FALSE) {

        $logList .= $newLog;

        $log->WriteList($logList);
    } else {
        $log->WriteList($newLog);
    }
    $serviceStudent->Delete($studentID);

}

header("location: ../../index.php");
exit();

?>