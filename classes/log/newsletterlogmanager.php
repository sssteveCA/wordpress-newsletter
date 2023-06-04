<?php

namespace Newsletter\Classes\Log;

use Newsletter\Traits\ErrorTrait;
use Newsletter\Classes\Log\NewsletterLogManagerErrors as Nlme;
use Newsletter\Classes\Models\NewsletterLogInfo;

interface NewsletterLogManagerErrors{
    const ERR_INVALID_FILE = 1;
    const ERR_READ_FILE = 2;

    const ERR_INVALID_FILE_MSG = "Il percorso indicato non contiene un file valido";
    const ERR_READ_FILE_MSG = "Impossibile leggere il file";
}

/**
 * Class to retrieve the newsletter log info file
 */
class NewsletterLogManager implements Nlme{

    use ErrorTrait;

    private array $loginfo = [];
    private string $file_path;

    public function __construct(string $file_path){
        $this->file_path = $file_path;
        $this->readFile();
    }

    public function getLogInfo(){ return $this->loginfo; }
    public function getError(){
        switch($this->errno){
            case Nlme::ERR_INVALID_FILE:
                $this->error = Nlme::ERR_INVALID_FILE_MSG;
                break;
            case Nlme::ERR_READ_FILE:
                $this->error = Nlme::ERR_READ_FILE_MSG;
                break;
            default:
                $this->error = null;
        }
        return $this->error;
    }

    /**
     * Fetch the newsletter log information from the file
     */
    private function readFile(){
        if(file_exists($this->file_path) && is_file($this->file_path)){
            $handle = fopen($this->file_path,'r');
            if($handle !== false){
                while($log_item = fscanf($handle,"SUBJECT: %s RECIPIENT: %s DATE: %s")){
                    list($subject,$recipient,$date) = $log_item;
                    $nli = new NewsletterLogInfo($subject,$recipient,$date);
                    $this->loginfo[] = $nli;
                }
                fclose($handle);
            }
            else $this->errno = Nlme::ERR_READ_FILE;
        }//if(file_exists($this->file_path) && is_file($this->file_path)){
        else $this->errno = Nlme::ERR_INVALID_FILE;    
        
        
    }
}
?>