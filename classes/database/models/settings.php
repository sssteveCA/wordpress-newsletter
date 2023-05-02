<?php

namespace Newsletter\Classes\Database\Models;
use Newsletter\Classes\Database\Models;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SqlTrait;

class Settings extends Models{

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
     * Get all the newsletter settings
     */
    public function getSettings(): bool{
        $this->errno = 0;
        //Select all table rows 
        $results = parent::get('',[]);
        if($this->errno == 0){
            $this->lang_status = (isset($results['lang_status'])) ? $results['lang_status'] : [];
            $this->included_pages_status = (isset($results['included_pages_status'])) ? $results['included_pages_status'] : [];
            $this->socials_status = (isset($results['socials_status'])) ? $results['socials_status'] : [];
            $this->social_pages = (isset($results['social_pages'])) ? $results['social_pages'] : [];
            $this->contact_pages = (isset($results['contact_pages'])) ? $results['contact_pages'] : [];
            $this->privacy_policy_pages = (isset($results['lang_status'])) ? $results['lang_status'] : [];
            return true;
        }//if($this->errno == 0){
        return false;
    }


}

?>