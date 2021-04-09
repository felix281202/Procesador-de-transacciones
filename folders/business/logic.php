<?php

class Logic
{

    public function lastID($array)
    {
        $countId = count($array);
        $lastId = $array[$countId - 1][0];
        return $lastId;
    }

    public function getElementList($array, $place, $value)
    {
        $filter = [];

        foreach ($array as $comp) {
            if ($comp->$place == $value) {
                array_push($filter, $comp);
            }
        }
        return $filter;
    }

    public function getElementListCSV($array, $place, $value)
    {
        $filter = [];

        for($f = 0; $f<count($array); $f++) {
            if($array[$f][$place] == $value) {
                array_push($filter, $array[$f]);
            }
        }
        return $filter;
    }

    public function getCookieTime() {

        return time() + 60*60*24*30;
    }

    public function getIndex($array, $place, $value)
    {

        $loc = 0;

        foreach ($array as $key => $item) {
            if ($item->$place == $value) {
                $loc = $key;
            }
        }
        return $loc;
    }

    public function getIndexCSV($array, $place, $value)
    {

        $loc = 0;

        for($f = 0; $f<count($array); $f++) {
            if($array[$f][$place] == $value) {
                $loc = $f;
            }
        }
        return $loc;
    }


    public function uploadImage($directory, $name, $timeFile, $type, $size) {

        $isSucess = false;
        if( ($type == "image/gif") 
        || ($type == "image/jpeg") 
        || ($type == "image/png") 
        || ($type == "image/jpg") 
        || ($type == "image/JPG") 
        || ($type == "image/pjpeg") && ($size < 1000000) ) {


            if(!file_exists($directory)) {

                mkdir($directory,0777,true);

                if(file_exists($directory)) {

                    $this->uploadFile($directory.$name, $timeFile);
                    $isSucess = true;
                }
            } else {

                $this->uploadFile($directory.$name, $timeFile);
                $isSucess = true;
            }

        } else {

            $isSucess = false;
        }

        return $isSucess;

    }

    private function uploadFile($name, $timeFile) {

        if(file_exists($name)) {

            unlink($name);
        }

        move_uploaded_file($timeFile,$name);

    }
}

?>
