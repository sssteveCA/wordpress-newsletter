import { NlFormDataSettings, NlFormDataSettingsInputLangs, NlFormDataSettingsInputPagesEnabled, NlFormDataSettingsInputSocial } from "../types/types"

export default class FormDataSettingsHtml{

    private _form: HTMLFormElement;
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

    constructor(data: NlFormDataSettings){
        this.assignValues(data);
        this.checkboxLangsChange();
    }

    private assignValues(data: NlFormDataSettings){
        this._form = data.form;
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
     * When at least one language checkbox value change
     */
    private checkboxLangsChange(): void{
        const cbs_lang: NodeListOf<HTMLInputElement> = this._container_langs.querySelectorAll('input[type="checkbox"]') as NodeListOf<HTMLInputElement>;
        const cbs_pages_enaled: NodeListOf<HTMLInputElement> = this._container_pages_enabled.querySelectorAll('input[type="checkbox"]') as NodeListOf<HTMLInputElement>;
        cbs_lang.forEach(cb_lang => {
            cb_lang.addEventListener('change',()=>{
                const cbs_lang_enabled: NodeListOf<HTMLInputElement> = this._container_langs.querySelectorAll('input[type="checkbox"]:checked') as NodeListOf<HTMLInputElement>;
                if(cbs_lang_enabled.length > 0){
                    cbs_pages_enaled.forEach(cb_page_enable => cb_page_enable.disabled = false)
                }//if(lang_checkboxes.length > 0){
                else{
                    cbs_pages_enaled.forEach(cb_page_enable => cb_page_enable.disabled = true)
                }
            })
        })
        
    }
}