<?php 

interface IHandler {

    function MakeDirectory();
    function ReadList();
    function WriteList($entity);
}

?>