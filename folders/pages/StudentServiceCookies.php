<?php

class StudentServiceCookie implements IServiceBasic
{

    private $logic;
    private $cookieName;

    public function __construct()
    {
        $this->logic = new Logic();
        $this->cookieName = 'student';
    }

    public function GetList()
    {
        $listadoStudent = array();

        if (isset($_COOKIE[$this->cookieName])) {

            $listadoStudent = json_decode($_COOKIE[$this->cookieName], false);
        } else {
            setcookie($this->cookieName, json_encode($listadoStudent), $this->logic->GetCookieTime(), "/");
        }

        return $listadoStudent;
    }

    public function GetById($id)
    {
        $listadoStudent = $this->GetList();
        $elementDecode = $this->logic->getElementList($listadoStudent, 'id', $id)[0];
        $student = new Student();
        $student->set($elementDecode);
        return $student;
    }

    public function Add($entity)
    {
        $listadoStudent = $this->GetList();
        $studentID = 1;

        if (!empty($listadoStudent)) {
            $lastStudent = $this->logic->lastID($listadoStudent);
            $studentID = $lastStudent->id + 1;
        }
        $entity->id = $studentID;
        $entity->profilePhoto = "";

        if (isset($_FILES['profilePhoto'])) {

            $photoFile = $_FILES['profilePhoto'];

            if ($photoFile['error'] == 4) {

                $entity->profilePhoto = "";

            } else {

                $typeReplace = str_replace("image/", "", $_FILES['profilePhoto']['type']);
                $type = $photoFile['type'];
                $size = $photoFile['size'];
                $name = $studentID . '.' . $typeReplace;
                $timeFile = $photoFile['tmp_name'];

                $sucess = $this->logic->uploadImage('../../folders/pages/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity->profilePhoto = $name;
                }
            }
        }

        array_push($listadoStudent, $entity);

        setcookie($this->cookieName, json_encode($listadoStudent), $this->logic->GetCookieTime(), "/");
    }

    public function Edit($id, $entity)
    {
        $element = $this->GetById($id);
        $listadoStudent = $this->GetList();
        $elementIndex = $this->logic->getIndex($listadoStudent, 'id', $id);

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

                $sucess = $this->logic->uploadImage('../../folders/pages/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity->profilePhoto = $name;
                }
            }
        }

        $listadoStudent[$elementIndex] = $entity;

        setcookie($this->cookieName, json_encode($listadoStudent), $this->logic->GetCookieTime(), "/");
    }

    public function Delete($id)
    {
        $listadoStudent = $this->GetList();
        $elementIndex = $this->logic->getIndex($listadoStudent, 'id', $id);
        unset($listadoStudent[$elementIndex]);

        $listadoStudent = array_values($listadoStudent);
        setcookie($this->cookieName, json_encode($listadoStudent), $this->logic->GetCookieTime(), "/");
    }
}
