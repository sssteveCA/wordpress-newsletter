import { NlFormDataSettingsInputLangs, NlFormDataSettingsInputPagesEnabled, NlFormDataSettingsInputSocial, NlFormDataSettingsSet, NlSettingsData } from "../types/types";

export default class FormDataSettingsSetHtml{
    //private _data: NlSettingsData;
    private _container_langs: HTMLDivElement;
    private _cb_langs: NlFormDataSettingsInputLangs;
    private _container_pages_enabled: HTMLDivElement;
    private _cb_pages_enabled: NlFormDataSettingsInputPagesEnabled;
    private _cb_social: NlFormDataSettingsInputSocial;
    private _row_social_links: HTMLDivElement;
    private _input_social_links: NlFormDataSettingsInputSocial;
    private _container_contacts_pages: HTMLDivElement;
    private _input_contacts_pages: NlFormDataSettingsInputLangs;
    private _container_cookie_pages: HTMLDivElement;
    private _input_cookie_policy_pages: NlFormDataSettingsInputLangs;
    private _container_privacy_pages: HTMLDivElement;
    private _input_privacy_policy_pages: NlFormDataSettingsInputLangs;
    private _container_terms_pages: HTMLDivElement;
    private _input_terms_pages: NlFormDataSettingsInputLangs;

    constructor(data: NlFormDataSettingsSet){
        this.assignValues(data);
    }

    private assignValues(data: NlFormDataSettingsSet): void{
        //this._data = data.data;
        this._container_langs = data.container_langs;
        this._cb_langs = data.cb_langs;
        this._container_pages_enabled = data.container_pages_enabled;
        this._cb_pages_enabled = data.cb_pages_enabled;
        this._cb_social = data.cb_social;
        this._row_social_links = data.row_social_links;
        this._input_social_links = data.input_social_links;
        this._container_contacts_pages = data.container_contacts_pages;
        this._input_contacts_pages = data.input_contacts_pages;
        this._container_cookie_pages = data.container_cookie_pages;
        this._input_cookie_policy_pages = data.input_cookie_policy_pages;
        this._container_privacy_pages = data.container_privacy_pages;
        this._input_privacy_policy_pages = data.input_privacy_policy_pages;
        this._container_terms_pages = data.container_terms_pages;
        this._input_terms_pages = data.input_terms_pages;
    }

    /**
     * Set the settings form values using the settings data obtained
     */
    public setSettingsForm(): void{
        this.setLangCheckboxes();
        this.setPageEnabledCheckboxes();
        this.setSocialCheckboxes();
    }

    /**
     * Set the language checkbox state
     */
    private setLangCheckboxes(): void{
        const change_event: Event = new Event('change');
        if(this._cb_langs.lang_it.checked)
            this._cb_langs.lang_it.dispatchEvent(change_event);
        if(this._cb_langs.lang_es.checked)
            this._cb_langs.lang_es.dispatchEvent(change_event);
        if(this._cb_langs.lang_en.checked)
            this._cb_langs.lang_en.dispatchEvent(change_event);
    }

    /**
     * Set the page enabled checkbox state
     */
    private setPageEnabledCheckboxes(): void{
        const change_event: Event = new Event('change');
        if(this._cb_pages_enabled.contacts_pages.checked)
            this._cb_pages_enabled.contacts_pages.dispatchEvent(change_event)
        if(this._cb_pages_enabled.cookie_policy_pages.checked)
            this._cb_pages_enabled.cookie_policy_pages.dispatchEvent(change_event)
        if(this._cb_pages_enabled.privacy_policy_pages.checked)
            this._cb_pages_enabled.privacy_policy_pages.dispatchEvent(change_event)
        if(this._cb_pages_enabled.terms_pages.checked)
            this._cb_pages_enabled.terms_pages.dispatchEvent(change_event)
        
    }

    /**
     * Set the social checkboxes state
     */
    private setSocialCheckboxes(): void{
        const change_event: Event = new Event('change');
        if(this._cb_social.facebook.checked)
            this._cb_social.facebook.dispatchEvent(change_event);
        if(this._cb_social.instagram.checked)
            this._cb_social.instagram.dispatchEvent(change_event);
        if(this._cb_social.youtube.checked)
            this._cb_social.youtube.dispatchEvent(change_event);
    }

}