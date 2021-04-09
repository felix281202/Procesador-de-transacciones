<?php 

require_once 'IHandler.php';

class logFileHandler implements IHandler
{
    private $directory;
    private $name;

    function __construct($directory ='data', $name = 'log')
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
        $path = $this->directory . '/' . $this->name . '.txt';

        if(file_exists($path)) {

            $file = fopen($path, 'r');
            $fileDecode = fread($file, filesize($path));
            fclose($file);

            return $fileDecode;
        } else {

            return false;
        }
    }

    function WriteList($entity)
    {
        $this->MakeDirectory();
        $path = $this->directory . '/' . $this->name . '.txt';

        $file = fopen($path,'w+');


        fwrite($file,$entity);
        

        fclose($file);
    }

}


?>
