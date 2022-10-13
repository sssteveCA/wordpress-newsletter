<?php

namespace Newsletter\Traits;

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
}
?>