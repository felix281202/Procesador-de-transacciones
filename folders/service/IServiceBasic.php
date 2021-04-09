<?php 

interface IServiceBasic {

    public function GetList();
    public function GetById($id);
    public function Add($entity);
    public function Edit($id, $entity);
    public function Delete($id);
}

?>