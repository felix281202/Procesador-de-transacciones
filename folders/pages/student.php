<?php 

class Student {
    
    public $id;
    public $name;
    public $lastName;
    public $carrera;
    public $status;
    public $profilePhoto;

    private $logic;

    public function __construct()
    {
        $this->logic = new Logic();
    }

    public function InicializeData($id, $name, $lastName, $carrera, $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->carrera = $carrera;
        $this->status = $status;
    }

    public function set($data) {
        foreach($data as $key => $value) $this->{$key} = $value;
    }
}


?>