<?php 

require_once 'IHandler.php';

class CSVFileHandler implements IHandler
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
        $path = $this->directory . '/' . $this->name . '.csv';

        if(file_exists($path)) {

            $file = fopen($path, 'r');
            $listComplete = array();
            while(($fileDecode = fgetcsv($file,1000,',')) == true) {
                array_push($listComplete, $fileDecode);
            }
            fclose($file);

            return $listComplete;
        } else {

            return false;
        }
    }

    function WriteList($entity)
    {
        $this->MakeDirectory();
        $path = $this->directory . '/' . $this->name . '.csv';

        $file = fopen($path,'w+');

        foreach($entity as $array) {
            fputcsv($file, $array);
        }
        
        fclose($file);
    }

}
