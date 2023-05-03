import { NlFormDataSettingsInputLangs, NlFormDataSettingsInputPagesEnabled, NlFormDataSettingsInputSocial, NlFormDataSettingsSet, NlSettingsData } from "../types/types";

export default class FormDataSettingsSetHtml{
    private _data: NlSettingsData;
    private _container_langs: HTMLDivElement;
    private _cb_langs: NlFormDataSettingsInputLangs;
    private _container_pages_enabled: HTMLDivElement;
    private _cb_pages_enabled: NlFormDataSettingsInputPagesEnabled;
    private _cb_social: NlFormDataSettingsInputSocial;
    private _row_social_links: HTMLDivElement;
    private _input_social_links: NlFormDataSettingsInputSocial;
    private _container_contacts_pages: HTMLDivElement;
    private _input_contacts_pages: NlFormDataSettingsInputLangs;
    private _container_privacy_pages: HTMLDivElement;
    private _input_privacy_policy_pages: NlFormDataSettingsInputLangs;

    constructor(data: NlFormDataSettingsSet){
        this.assignValues(data);
    }

    get data(){return this._data;}

    set data(data: NlSettingsData){ this._data = data; }

    private assignValues(data: NlFormDataSettingsSet): void{
        this._data = data.data;
        this._container_langs = data.container_langs;
        this._cb_langs = data.cb_langs;
        this._container_pages_enabled = data.container_pages_enabled;
        this._cb_pages_enabled = data.cb_pages_enabled;
        this._cb_social = data.cb_social;
        this._row_social_links = data.row_social_links;
        this._input_social_links = data.input_social_links;
        this._container_contacts_pages = data.container_contacts_pages;
        this._input_contacts_pages = data.input_contacts_pages;
        this._container_privacy_pages = data.container_privacy_pages;
        this._input_privacy_policy_pages = data.input_privacy_policy_pages;
    }

    /**
     * Set the settings form values using the settings data obtained
     */
    public setSettingsForm(): void{
        this.setLangCheckboxes();
        this.setPageEnabledCheckboxes();
        this.setSocialCheckboxes();
        this.setSocialProfileURLs();
        this.setContactPageURLs();
        this.setPrivacyPolicyPageURLs();
    }

    /**
     * Set the language checkbox state
     */
    private setLangCheckboxes(): void{
        this._cb_langs.lang_it.checked = (this._data.lang_status.it) ? true : false;
        this._cb_langs.lang_es.checked = (this._data.lang_status.es) ? true : false;
        this._cb_langs.lang_en.checked = (this._data.lang_status.en) ? true : false;
    }

    /**
     * Set the page enabled checkbox state
     */
    private setPageEnabledCheckboxes(): void{
        this._cb_pages_enabled.contacts_pages.checked = (this._data.included_pages_status.contacts_pages) ? true : false;
        this._cb_pages_enabled.privacy_policy_pages.checked = (this._data.included_pages_status.privacy_policy_pages) ? true : false;
    }

    /**
     * Set the social checkboxes state
     */
    private setSocialCheckboxes(): void{
        this._cb_social.facebook.checked = (this._data.socials_status.facebook) ? true : false;
        this._cb_social.instagram.checked = (this._data.socials_status.instagram) ? true : false;
        this._cb_social.youtube.checked = (this._data.socials_status.youtube) ? true : false;
    }

    /**
     * Set the social profile URLs input tag values
     */
    private setSocialProfileURLs(): void{
        this._input_social_links.facebook.value = (this._data.social_pages.facebook) ? this._data.social_pages.facebook as string : "";
        this._input_social_links.instagram.value = (this._data.social_pages.instagram) ? this._data.social_pages.instagram as string : "";
        this._input_social_links.youtube.value = (this._data.social_pages.youtube) ? this._data.social_pages.youtube as string : "";
    }

    /**
     * Set the contact page URLs input tag values
     */
    private setContactPageURLs(): void{
        this._input_contacts_pages.lang_it.value = (this._data.contact_pages.it) ? this._data.contact_pages.it as string : "";
        this._input_contacts_pages.lang_es.value = (this._data.contact_pages.es) ? this._data.contact_pages.es as string : "";
        this._input_contacts_pages.lang_en.value = (this._data.contact_pages.en) ? this._data.contact_pages.en as string : "";
    }

    /**
     * Set the privacy policy URLs input tag values
     */
    private setPrivacyPolicyPageURLs(): void{
        this._input_privacy_policy_pages.lang_it.value = (this._data.privacy_policy_pages.it) ? this._data.privacy_policy_pages.it as string : "";
        this._input_privacy_policy_pages.lang_es.value = (this._data.privacy_policy_pages.es) ? this._data.privacy_policy_pages.es as string : "";
        this._input_privacy_policy_pages.lang_en.value = (this._data.privacy_policy_pages.en) ? this._data.privacy_policy_pages.en as string : "";
    }


}