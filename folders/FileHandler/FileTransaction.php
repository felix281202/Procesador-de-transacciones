<?php

require_once 'SerializeFileHandler.php';
require_once 'CSVFileHandler.php';

class FileTransaction implements IServiceBasic
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
        $this->fileHandler = new JsonFileHandler($this->directory, $this->name);
    }

    public function GetList()
    {
        $listadoTransaction = $this->fileHandler->ReadList();
        $transactionList = array();

        if ($listadoTransaction == false) {
            $this->fileHandler->WriteList($transactionList);
        } else {

            foreach ($listadoTransaction as $list) {

                $transaction = new transactionObject();
                $transaction->set($list);
                array_push($transactionList, $transaction);
            }
        }
        return $transactionList;
    }

    public function GetById($id)
    {
        $listadoTransaction = $this->GetList();
        $elementDecode = $this->logic->getElementList($listadoTransaction, 'id', $id)[0];
        $transaction = new transactionObject();
        $transaction->set($elementDecode);
        return $transaction;
    }

    public function Add($entity)
    {
        $listadoTransaction = $this->GetList();
        $transactionID = 1;

        if (!empty($listadoTransaction)) {
            $lastTransaction = $this->logic->lastID($listadoTransaction);
            $transactionID = $lastTransaction->id + 1;
        }
        $entity->id = $transactionID;
        $entity->profilePhoto = "";

        if (isset($_FILES['profilePhoto'])) {

            $photoFile = $_FILES['profilePhoto'];

            if ($photoFile['error'] == 4) {

                $entity->profilePhoto = "";
            } else {

                $typeReplace = str_replace("image/", "", $_FILES['profilePhoto']['type']);
                $type = $photoFile['type'];
                $size = $photoFile['size'];
                $name = $transactionID . '.' . $typeReplace;
                $timeFile = $photoFile['tmp_name'];

                $sucess = $this->logic->uploadImage('../FileHandler/images/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity->profilePhoto = $name;
                }
            }
        }

        array_push($listadoTransaction, $entity);

        $this->fileHandler->WriteList($listadoTransaction);
    }

    public function Edit($id, $entity)
    {
        $element = $this->GetById($id);
        $$listadoTransaction = $this->GetList();
        $elementIndex = $this->logic->getIndex($listadoTransaction, 'id', $id);

        if (isset($_FILES['profilePhoto'])) {

            $photoFile = $_FILES['profilePhoto'];

            if ($photoFile['error'] == 4) {

                $entity->profilePhoto = $element->profilePhoto;
            } else {

                $typeReplace = str_replace("image/", "", $_FILES['profilePhoto']['type']);
                $type = $photoFile['type'];
                $size = $photoFile['size'];
                $name = $id . '.' . $typeReplace;
                $timeFile = $photoFile['tmp_name'];

                $sucess = $this->logic->uploadImage('../FileHandler/images/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity->profilePhoto = $name;
                }
            }
        }

        $listadoTransaction[$elementIndex] = $entity;

        $this->fileHandler->WriteList($listadoTransaction);
    }

    public function Delete($id)
    {
        $listadoTransaction = $this->GetList();
        $elementIndex = $this->logic->getIndex($listadoTransaction, 'id', $id);
        unset($listadoTransaction[$elementIndex]);

        $listadoTransaction = array_values($listadoTransaction);
        $this->fileHandler->WriteList($listadoTransaction);
    }
}
