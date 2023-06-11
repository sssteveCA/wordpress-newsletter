<?php

namespace Newsletter\Classes\Log;

use Newsletter\Traits\ErrorTrait;
use Newsletter\Classes\Log\NewsletterLogManagerErrors as Nlme;
use Newsletter\Classes\Models\NewsletterLogInfo;

interface NewsletterLogManagerErrors{
    const ERR_INVALID_FILE = 1;
    const ERR_READ_FILE = 2;
    const ERR_DELETE_FILE = 3;
    const ERR_WRITE_FILE = 4;

    const ERR_INVALID_FILE_MSG = "Il percorso indicato non contiene un file valido";
    const ERR_READ_FILE_MSG = "Impossibile leggere il file";
    const ERR_DELETE_FILE_MSG = "Impossibile cancellare il file";
    const ERR_WRITE_FILE_MSG = "Impossibile scrivere sul file";
}

/**
 * Class to retrieve the newsletter log info file
 */
class NewsletterLogManager implements Nlme{

    use ErrorTrait;

    private array $loginfo = [];
    private int $filesize = 0;
    private string $file_path;

    public function __construct(string $file_path){
        $this->file_path = $file_path;
        $this->readFile();
    }

    public function getLogInfo(){ return $this->loginfo; }
    public function getFileSize(){ return $this->filesize; }
    public function getError(){
        switch($this->errno){
            case Nlme::ERR_INVALID_FILE:
                $this->error = Nlme::ERR_INVALID_FILE_MSG;
                break;
            case Nlme::ERR_READ_FILE:
                $this->error = Nlme::ERR_READ_FILE_MSG;
                break;
            case Nlme::ERR_DELETE_FILE:
                $this->error = Nlme::ERR_DELETE_FILE_MSG;
                break;
            case Nlme::ERR_WRITE_FILE:
                $this->error = Nlme::ERR_WRITE_FILE_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }

    /**
     * Delete the newsletter log file
     * @return bool
     */
    public function deleteFile(): bool{
        $this->errno = 0;
        if(file_exists($this->file_path) && is_file($this->file_path)){
            $delete = unlink($this->file_path);
            if($delete) return true;
            $this->errno = Nlme::ERR_DELETE_FILE;
            return false;
        }//if(file_exists($this->file_path) && is_file($this->file_path)){
        $this->errno = Nlme::ERR_INVALID_FILE;
        return false;
    }

    /**
     * Return the log info objects array as associative array
     * @return array
     */
    public function getLogInfoAssociative(): array{
        $log_info_array = [];
        foreach($this->loginfo as $item){
            $log_info_array[] = [
                'subject' => $item->getSubject(), 'recipient' => $item->getRecipient(), 'date' => $item->getDate()
            ];
        }//foreach($this->getLogInfo() as $item){
        return $log_info_array;
    }

    /**
     * Fetch the newsletter log information from the file
     * @return  bool
     */
    public function readFile(): bool{
        $this->errno = 0;
        if(file_exists($this->file_path) && is_file($this->file_path)){
            $handle = fopen($this->file_path,'r');
            if($handle !== false){
                $this->filesize = filesize($this->file_path);
                if($this->filesize > 0){
                    $regex = '/SUBJECT:\s*"([a-z0-9\s]+)"\s*RECIPIENT:\s*"([a-z0-9\s\.@]+)"\s*DATE:\s*"([0-9\s:\-]+)"/i';
                    while($file_line = fgets($handle)){
                        if(preg_match($regex,$file_line,$matches)){
                            $nli = new NewsletterLogInfo($matches[1],$matches[2],$matches[3]);
                            $this->loginfo[] = $nli;
                        } 
                    }//while(($file_line = fgets($handle) !== false)){
                    fclose($handle);
                }//if($this->filesize > 0){
                return true;
            }//if($handle !== false){
            $this->errno = Nlme::ERR_READ_FILE;
            return false;
        }//if(file_exists($this->file_path) && is_file($this->file_path)){
        $this->errno = Nlme::ERR_INVALID_FILE;
        return false;
    }

    /**
     * Write the log information on a file
     * @param array $loginfo
     * @return bool
     */
    public function writeFile(array $loginfo): bool{
        $this->errno = 0;
        $handle = fopen($this->file_path,'a');
        if($handle !== false){
            $content = array_reduce($loginfo,function($carry,$item){
                if($item instanceof NewsletterLogInfo){
                    $carry .= sprintf("SUBJECT: %s RECIPIENT: %s DATE: %s\r\n",$item->getSubject(),$item->getRecipient(),$item->getDate());
                    return $carry;
                }
                return $carry;
            },'');
            $writed = fwrite($handle,$content);
            fclose($handle);
            if($writed !== false) return true;
            $this->errno = Nlme::ERR_WRITE_FILE;
            return false;
        }//if($handle !== false){
        $this->errno = Nlme::ERR_WRITE_FILE;
        return false;
    }
}
?>