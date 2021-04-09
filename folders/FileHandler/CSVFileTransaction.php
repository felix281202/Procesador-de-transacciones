<?php

require_once 'SerializeFileHandler.php';
require_once 'CSVFileHandler.php';

class CSVFileTransaction implements IServiceBasic
{

    private $logic;
    private $fileHandler;
    private $name;
    private $directory;

    public function __construct($directory = 'data')
    {
        $this->logic = new Logic();
        $this->directory = $directory;
        $this->name = 'Transacciones';
        $this->fileHandler = new CSVFileHandler($this->directory, $this->name);
    }

    public function GetList()
    {
        $listadoTransaction = $this->fileHandler->ReadList();
        $transactionList = array();

        if ($listadoTransaction == false) {
            $this->fileHandler->WriteList($transactionList);
        } else {

            $transactionList = $listadoTransaction;
        }
        return $transactionList;
    }

    public function GetById($id)
    {
        $listadoTransaction = $this->GetList();
        $elementDecode = $this->logic->getElementListCSV($listadoTransaction, '0', $id)[0];
        return $elementDecode;
    }

    public function Add($entity)
    {
        $listadoTransaction = $this->GetList();
        $transactionID = 1;

        $entity["5"] = "";

        if (isset($_FILES['profilePhoto'])) {

            $photoFile = $_FILES['profilePhoto'];

            if ($photoFile['error'] == 4) {

                $entity["5"] = "";
            } else {

                $typeReplace = str_replace("image/", "", $_FILES['profilePhoto']['type']);
                $type = $photoFile['type'];
                $size = $photoFile['size'];
                $name = $transactionID . '.' . $typeReplace;
                $timeFile = $photoFile['tmp_name'];

                $sucess = $this->logic->uploadImage('../FileHandler/images/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity["5"] = $name;
                }
            }
        }

        if (!empty($listadoTransaction)) {
            $lastTransaction = $this->logic->lastID($listadoTransaction);
            $transactionID = $lastTransaction["0"][0] + 1;
        }
        $entity["0"] = $transactionID;

        array_push($listadoTransaction, $entity);

        $this->fileHandler->WriteList($listadoTransaction);
    }

    public function Edit($id, $entity)
    {
        $element = $this->GetById($id);
        $$listadoTransaction = $this->GetList();
        $elementIndex = $this->logic->getIndexCSV($listadoTransaction, '0', $id);

        if (isset($_FILES['profilePhoto'])) {

            $photoFile = $_FILES['profilePhoto'];

            if ($photoFile['error'] == 4) {

                $entity["0"] = $element["5"];
            } else {

                $typeReplace = str_replace("image/", "", $_FILES['profilePhoto']['type']);
                $type = $photoFile['type'];
                $size = $photoFile['size'];
                $name = $id . '.' . $typeReplace;
                $timeFile = $photoFile['tmp_name'];

                $sucess = $this->logic->uploadImage('../FileHandler/images/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity["5"] = $name;
                }
            }
        }
        

        $listadoTransaction[$elementIndex] = $entity;
        $listadoTransaction[$elementIndex]['0'] = $id;

        $this->fileHandler->WriteList($listadoTransaction);
    }

    public function Delete($id)
    {
        $listadoTransaction = $this->GetList();
        $elementIndex = $this->logic->getIndexCSV($listadoTransaction, '0', $id);
        unset($listadoTransaction[$elementIndex]);

        $listadoTransaction = array_values($listadoTransaction);
        $this->fileHandler->WriteList($listadoTransaction);
    }
}
