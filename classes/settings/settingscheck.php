<?php

namespace Newsletter\Classes\Settings;
use Newsletter\Traits\ErrorTrait;

/**
 * This class check verify the provided user settings data and eventually correct them
 */
class SettingsCheck{
    use ErrorTrait;

    /**
     * Keys allowed for included_pages_status property
     */
    private static array $included_pages_key_allowed = ["contact_pages","privacy_policy_pages"];

    /**
     * Keys allowed for lang_status, contact_pages and privacy_policy_pages properties
     */
    private static array $language_key_allowed = ["en","es","it"];

    /**
     * Keys allowed for socials_status and social_pages properties
     */
    private static array $socials_key_allowed = ["facebook","instagram","youtube"];

    /**
     * The languages of the available pages
     */
    private array $lang_status = [];

    /**
     * The inclusion status of the site pages attachable to the newsletter body
     */
    private array $included_pages_status = [];

    /**
     * The social pages link to insert in the newsletter
     */
    private array $socials_status = [];

    /**
     * The social page links to be included in the newsletter
     */
    private array $social_pages = [];

    /**
     * The contact page links in the declared languages
     */
    private array $contact_pages = [];

    /**
     * The privacy policy pages links in the declared languages
     */
    private array $privacy_policy_pages = [];

    public function __construct(array $data){

    }

    public function getLangStatus(){ return $this->lang_status; }
    public function getIncludedPagesStatus(){ return $this->included_pages_status; }
    public function getSocialsStatus(){ return $this->socials_status; }
    public function getSocialPages(){ return $this->social_pages; }
    public function getContactPages(){ return $this->contact_pages; }
    public function getPrivacyPolicyPages(){ return $this->privacy_policy_pages; }

    /**
     * Add only the included page status valid keys and values 
     */
    private function filterIncludedPagesArray(array $included_pages_status){
        foreach($included_pages_status as $key => $value){
            if(in_array($key,SettingsCheck::$included_pages_key_allowed)){
                if(in_array($value,[false,true]))
                    $this->included_pages_status[] = [$key,$value];
            }
        }
    }


}

?>