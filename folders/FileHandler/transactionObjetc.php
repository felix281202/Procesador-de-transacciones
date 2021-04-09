<?php 

class TransactionObject {
    
    public $id;
    public $fechaHora;
    public $monto;
    public $descripcion;
    public $tipo;
    public $profilePhoto;

    private $logic;

    public function __construct()
    {
        $this->logic = new Logic();
    }

    public function InicializeData($id, $fechaHora, $monto, $descripcion, $tipo, $profilePhoto)
    {
        $this->id = $id;
        $this->fechaHora = $fechaHora;
        $this->monto = $monto;
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
        $this->profilePhoto = $profilePhoto;
    }

    public function set($data) {
        foreach($data as $key => $value) $this->{$key} = $value;
    }
}


?>