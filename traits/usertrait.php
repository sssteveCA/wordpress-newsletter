<?php

namespace Newsletter\Traits;

use Newsletter\Classes\Database\Models\UserErrors as Ue;
use Newsletter\Interfaces\Constants as C;

trait UserTrait{

    /**
     * Generate a code for account verification and unsubscribe
     */
    public function codeGen(): string{
        $characters = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789";
        $time = str_replace('.','a', microtime());
        $time = str_replace(' ', 'b', $time);
        $times = 100 - strlen($time);
        $code = "";
        $cLenght = strlen($characters);
        for($i = 0; $i < $times; $i++){
            $n = mt_rand(0, $cLenght - 1);
            $code .= $characters[$n];
        }
        return $time.$code;
    }

    /**
     * Set the array to insert new user in database
     */
    private function insertUserArray(): array|null{
        $this->errno = 0;
        $this->verCode = $this->codeGen();
        $this->subscDate = date("Y-m-d H:i:s");
        if(isset($this->email, $this->lang, $this->verCode, $this->subscDate)){
            $classname = __CLASS__;
            $insert_array = [
                "values" => [
                    $classname::$fields['email'] => $this->email,
                    $classname::$fields['lang'] => $this->lang,
                    $classname::$fields['verCode'] => $this->verCode,
                    $classname::$fields['subscDate'] => $this->subscDate
                ],
                "format" => ["%s","%s","%s","%s"]
            ];
            if(isset($this->firstName, $this->lastName)){
                $insert_array["values"][$classname::$fields['firstName']] = $this->firstName;
                $insert_array["values"][$classname::$fields['lastName']] = $this->lastName;
                array_push($insert_array["format"],"%s","%s");
            }//if(isset($this->firstName, $this->lastName)){
                file_put_contents("log.txt","UserTrait insertUserArray insert_array => ".var_export($insert_array,true)."\r\n",FILE_APPEND);
            return $insert_array;
        }//if(isset($this->email, $this->lang, $this->verCode, $this->subscDate)){
        else $this->errno = Ue::ERR_MISSING_DATA;
        return null;
    }
}
?>