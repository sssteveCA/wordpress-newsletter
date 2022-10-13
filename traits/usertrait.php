<?php

namespace Newsletter\Traits;

use Newsletter\Classes\Database\Models\UserErrors as Ue;

trait UserTrait{

    /**
     * Generate a code for account verification and unsubscribe
     */
    private function codeGen(): string{
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
        if(isset($this->email, $this->lang, $this->verCode, $this->subscDate)){
            $classname = __CLASS__;
            $insert_array = [
                "values" => [
                    $classname::$fields['email'] => $this->email,
                    $classname::$fields['lang'] => $this->lang,
                    $classname::$fields['verCode'] => $this->verCode,
                    $classname::$fields['subscCode'] => $this->subscDate
                ],
                "format" => ["%s","%s","%s","%s"]
            ];
            if(isset($this->firstName, $this->lastName)){
                $insert_array["values"][$classname::$fields['firstName']] = $this->firstName;
                $insert_array["values"][$classname::$fields['lastName']] = $this->lastName;
                array_push($insert_array["format"],"%s","%s");
            }//if(isset($this->firstName, $this->lastName)){
            return $insert_array;
        }//if(isset($this->email, $this->lang, $this->verCode, $this->subscDate)){
        else $this->errno = Ue::ERR_MISSING_DATA;
        return null;
    }
}
?>