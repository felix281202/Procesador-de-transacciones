<?php 

require_once 'IHandler.php';

class JsonFileHandler implements IHandler
{
    private $directory;
    private $name;

    function __construct($directory, $name)
    {
        $this->directory = $directory;
        $this->name = $name;
    }

    function MakeDirectory()
    {

        if (!file_exists($this->directory)) {

            mkdir($this->directory, 0777, true);

        }
    }

    function ReadList()
    {
        $this->MakeDirectory();
        $path = $this->directory . '/' . $this->name . '.json';

        if(file_exists($path)) {

            $file = fopen($path, 'r');
            $fileDecode = fread($file, filesize($path));
            fclose($file);

            return json_decode($fileDecode);
        } else {

            return false;
        }
    }

    function WriteList($entity)
    {
        $this->MakeDirectory();
        $path = $this->directory . '/' . $this->name . '.json';

        $dataCode = json_encode($entity);

        $file = fopen($path,'w+');
        fwrite($file, $dataCode);
        fclose($file);
    }

}


?>
