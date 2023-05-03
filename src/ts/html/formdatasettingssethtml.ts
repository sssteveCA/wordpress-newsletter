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

    public setSettingsForm(): void{
        if(this._data){

        }//if(this._data){
    }

    /**
     * Change the language checkbox values
     */
    private setLangCheckboxes(): void{
        this._cb_langs.lang_it.checked = (this._data.lang_status.it) ? true : false;
        this._cb_langs.lang_es.checked = (this._data.lang_status.es) ? true : false;
        this._cb_langs.lang_en.checked = (this._data.lang_status.en) ? true : false;
    }
}