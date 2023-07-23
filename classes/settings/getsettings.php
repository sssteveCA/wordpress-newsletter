<?php

namespace Newsletter\Classes\Settings;
use Newsletter\Traits\ErrorTrait;
use WP_Error;
use Newsletter\Classes\Settings\GetSettingsErrors as Gse;

interface GetSettingsErrors{
    const ERR_FETCH_URL = 1;
    const ERR_FETCH_URL_MSG = "Errore durante l'esecuzione della richiesta";
}

/**
 * This class fetch the settings from the DB and returns the proper HTML
 */
class GetSettings implements Gse{

    use ErrorTrait;

    private string $html = '';

    private const FETCH_URL = '/wp-content/plugins/newsletter/scripts/browser/settings/getsettings.php';

    public function __construct(){
        $response = $this->request();
    }

    private function request(): array{
        $response = wp_remote_get(self::FETCH_URL);
        if(!$response instanceof WP_Error){
            $body = wp_remote_retrieve_body($response);
            if($body != ''){
                $bodyArr = json_decode($body,true);
                return $bodyArr;
            }
            else $this->errno = Gse::ERR_FETCH_URL;
        }//if(!$response instanceof WP_Error){
        else $this->errno = Gse::ERR_FETCH_URL;
        return [];
    }

    public function getHtml(){ return $this->html; }

    public function getError(){
        switch($this->errno){
            case Gse::ERR_FETCH_URL:
                $this->error = Gse::ERR_FETCH_URL_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }
}

?>