<?php

namespace Newsletter\Traits;

trait EmailManagerTrait{

    private function assignValues(array $data){
        $this->emailsList = $data['emails'];
        $this->emailAddress = $data['from'];
        $this->password = $data['password'];
        $this->subject = $data['subject'];
        $this->body = $data['body'];
    }
}
?>