<?php

namespace Newsletter\Classes\Settings;

/**
 * This class check verify the provided user settings data and eventually correct them
 */
class SettingsCheck{

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
        $this->filterInputArray($data);
    }

    public function getLangStatus(){ return $this->lang_status; }
    public function getIncludedPagesStatus(){ return $this->included_pages_status; }
    public function getSocialsStatus(){ return $this->socials_status; }
    public function getSocialPages(){ return $this->social_pages; }
    public function getContactPages(){ return $this->contact_pages; }
    public function getPrivacyPolicyPages(){ return $this->privacy_policy_pages; }


    /**
     * Keep only the correct items in the array
     */
    private function filterInputArray(array $data){
        $this->filterIncludedPagesArray($data['included_page_status']);
        $this->filterLanguageArrays($data['lang_status'],$data['contact_pages'],$data['privacy_policy_pages']);
        $this->filterSocialArrays($data['socials_status'],$data['social_pages']);
    }

    /**
     * Add only the included page status valid keys and values to the respective properties
     */
    private function filterIncludedPagesArray(array $included_pages_status){
        $this->included_pages_status = array_filter($included_pages_status,function($value,$key){
            return (in_array($key,SettingsCheck::$included_pages_key_allowed) && in_array($value,[false,true]));
        },ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Add only the language valid keys and values to the respective properties
     */
    private function filterLanguageArrays(array $lang_status, array $contact_pages, array $privacy_policy_pages){
        $this->lang_status = array_filter($lang_status, function($value,$key){
            return (in_array($key,SettingsCheck::$language_key_allowed) && in_array($value,[false,true]));
        },ARRAY_FILTER_USE_BOTH);
        $this->contact_pages = array_filter($contact_pages, function($key){
            return in_array($key,SettingsCheck::$language_key_allowed);
        },ARRAY_FILTER_USE_KEY);
        $this->privacy_policy_pages = array_filter($privacy_policy_pages,function($key){
            return in_array($key,SettingsCheck::$language_key_allowed);
        },ARRAY_FILTER_USE_KEY);
    }

    /**
     * Add only the social valid keys and values to the respective properties
     */
    private function filterSocialArrays(array $socials_status, array $social_pages){
        $this->socials_status = array_filter($socials_status,function($value,$key){
            return (in_array($key,SettingsCheck::$socials_key_allowed) && in_array($value,[false,true]));
        },ARRAY_FILTER_USE_BOTH);
        $this->social_pages = array_filter($social_pages,function($key){
            return (in_array($key,SettingsCheck::$socials_key_allowed));
        },ARRAY_FILTER_USE_KEY);
    }


}

?>