<?php

namespace Newsletter\Classes\Database\Models;
use Newsletter\Classes\Database\Models;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SettingsTrait;
use Newsletter\Traits\SqlTrait;

class Settings extends Models{

    use SettingsTrait;

    /**
     * The languages of the available pages
     */
    private array $lang_status;

    /**
     * The inclusion status of the site pages attachable to the newsletter body
     */
    private array $included_pages_status;

    /**
     * The social pages link to insert in the newsletter
     */
    private array $socials_status;

    /**
     * The social page links to be included in the newsletter
     */
    private array $social_pages;

    /**
     * The contact page links in the declared languages
     */
    private array $contact_pages;

    /**
     * The privacy policy page links in the declared languages
     */
    private array $privacy_policy_pages;

    public function __construct(array $data){
        parent::__construct($data);
        $this->assignValues($data);
    }

    public function getLangStatus(){ return $this->lang_status; }
    public function getIncludedPagesStatus(){return $this->included_pages_status; }
    public function getSocialsStatus(){ return $this->socials_status; }
    public function getSocialPages(){ return $this->social_pages; }
    public function getContactPages(){ return $this->contact_pages; }
    public function getPrivacyPolicyPages(){ return $this->privacy_policy_pages; }

    public function getError(){
        if($this->errno < parent::MAX_MODELS){
            return parent::getError();
        }
        else{
            switch($this->errno){
                default:
                    $this->error = null;
                    break;
            }
        }
        return $this->error;
    }

    private function assignValues(array $data){
        $this->lang_status = isset($data['lang_status']) ? $data['lang_status'] : [];
        $this->included_pages_status = isset($data['included_pages_status']) ? $data['included_pages_status'] : [];
        $this->socials_status = isset($data['socials_status']) ? $data['socials_status'] : [];
        $this->social_pages = isset($data['social_pages']) ? $data['social_pages'] : [];
        $this->contact_pages = isset($data['contact_pages']) ? $data['contact_pages'] : [];
        $this->privacy_policy_pages = isset($data['privacy_policy_pages']) ? $data['privacy_policy_pages'] : [];
    }

    /**
     * Get all the newsletter settings rows
     */
    public function getSettings(): bool{
        $this->errno = 0;
        //Select all table rows 
        $results = parent::get('',[]);
        if($this->errno == 0){
            $this->lang_status = isset($results[0]['setting_value']) ? json_decode($results[0]['setting_value'],true) : [];
            $this->included_pages_status = isset($results[1]['setting_value']) ? json_decode($results[1]['setting_value'],true) : [];
            $this->socials_status = isset($results[2]['setting_value']) ? json_decode($results[2]['setting_value'],true) : [];
            $this->social_pages = isset($results[3]['setting_value']) ? json_decode($results[3]['setting_value'],true) : [];
            $this->contact_pages = isset($results[4]['setting_value']) ? json_decode($results[4]['setting_value'],true) : [];
            $this->privacy_policy_pages = isset($results[5]['setting_value']) ? json_decode($results[5]['setting_value'],true) : [];
            return true;
        }//if($this->errno == 0){
        return false;
    }

    /**
     * Insert all the newsletter settings rows
     */
    public function insertSettings(): bool{
        $this->errno = 0;
        $insert_query = $this->setInsertQuery();
        parent::insert($insert_query['sql'],$insert_query['values']);
        if($this->errno == 0) return true;
        return false;
    }

    /**
     * Update all the newsletter settings rows
     */
    public function updateSettings(): bool{
        $this->errno = 0;
        parent::update(['setting_value' => json_encode($this->lang_status,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)],['setting_name' => 'lang_status'],["%s"]);
        parent::update(['setting_value' => json_encode($this->included_pages_status,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)],['setting_name' => 'included_pages_status'],["%s"]);
        parent::update(['setting_value' => json_encode($this->socials_status,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)],['setting_name' => 'socials_status'],["%s"]);
        parent::update(['setting_value' => json_encode($this->social_pages,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)],['setting_name' => 'social_pages'],["%s"]);
        parent::update(['setting_value' => json_encode($this->contact_pages,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)],['setting_name' => 'contact_pages'],["%s"]);
        parent::update(['setting_value' => json_encode($this->privacy_policy_pages,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)],['setting_name' => 'privacy_policy_pages'],["%s"]);
        return true;
    }


}

?>