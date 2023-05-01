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
        this.checkboxSocialChange();
        this.checkboxContactsPagesChange();
        this.checkboxPrivacyPolicyPagesChange();
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
     * When the contacts pages enabled checkbox value change 
     */
    private checkboxContactsPagesChange(): void{
        this._cb_pages_enabled.contacts_pages.addEventListener('change',()=>{
            if(this._cb_pages_enabled.contacts_pages.checked){
                if(this._cb_langs.lang_it.checked) this._input_contacts_pages.lang_it.disabled = false;
                else this._input_contacts_pages.lang_it.disabled = true;
                if(this._cb_langs.lang_es.checked) this._input_contacts_pages.lang_es.disabled = false;
                else this._input_contacts_pages.lang_es.disabled = true;
                if(this._cb_langs.lang_en.checked) this._input_contacts_pages.lang_en.disabled = false;
                else this._input_contacts_pages.lang_en.disabled = true;
            }
            else{
                const input_contacts_pages: NodeListOf<HTMLInputElement> = this._container_contacts_pages.querySelectorAll('input[type="text"]') as NodeListOf<HTMLInputElement>;
                input_contacts_pages.forEach(input_contacts_page => input_contacts_page.disabled = true)
            }
        })
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
                this.triggerOnCbLangChange();
            })
        })
        
    }

    /**
     * When the privacy policy pages enabled checkbox value change 
     */
    private checkboxPrivacyPolicyPagesChange(): void{
        this._cb_pages_enabled.privacy_policy_pages.addEventListener('change',()=>{
            if(this._cb_pages_enabled.privacy_policy_pages.checked){
                if(this._cb_langs.lang_it.checked) this._input_privacy_policy_pages.lang_it.disabled = false;
                else this._input_privacy_policy_pages.lang_it.disabled = true;
                if(this._cb_langs.lang_es.checked) this._input_privacy_policy_pages.lang_es.disabled = false;
                else this._input_privacy_policy_pages.lang_es.disabled = true;
                if(this._cb_langs.lang_en.checked) this._input_privacy_policy_pages.lang_en.disabled = false;
                else this._input_privacy_policy_pages.lang_en.disabled = true;
            }
            else{
                const input_privacy_policy_pages: NodeListOf<HTMLInputElement> = this._container_privacy_pages.querySelectorAll('input[type="text"]') as NodeListOf<HTMLInputElement>;
                input_privacy_policy_pages.forEach(input_privacy_policy_page => input_privacy_policy_page.disabled = true)
            }
        })
    }

    /**
     * When a social checkbox item value change
     */
    private checkboxSocialChange(): void{
        this._cb_social.facebook.addEventListener('change',()=>{
            if(this._cb_social.facebook.checked)this._input_social_links.facebook.disabled = false;
            else this._input_social_links.facebook.disabled = true;
        })
        this._cb_social.instagram.addEventListener('change',()=>{
            if(this._cb_social.instagram.checked) this._input_social_links.instagram.disabled = false;
            else this._input_social_links.instagram.disabled = true;
        })
        this._cb_social.youtube.addEventListener('change',()=>{
            if(this._cb_social.youtube.checked) this._input_social_links.youtube.disabled = false;
            else this._input_social_links.youtube.disabled = true;
        })

    }

    /**
     * When the user submit the form
     * @param callback the function to invoke when the user submit the form
     */
    public onFormSubmit(callback: (data: object) => void): void{
        this._form.addEventListener('submit',(e)=>{
            e.preventDefault();
            let form_data: object = {
                facebook_page: '',
                instagram_page: '',
                youtube_page: '',
                contacts_page_it: '',
                contacts_page_es: '',
                contacts_page_en: '',
                privacy_policy_page_it: '',
                privacy_policy_page_es: '',
                privacy_policy_page_en: '',
            }
            callback(form_data)
        })
    }

    /**
     * When a language checkbox value change, trigger change event for pages enabled checkbox
     */
    private triggerOnCbLangChange(): void{
        const change_event: Event = new Event('change');
        this._cb_pages_enabled.contacts_pages.dispatchEvent(change_event);
        this._cb_pages_enabled.privacy_policy_pages.dispatchEvent(change_event);
    }
}