import { NlFormDataSettings, NlFormDataSettingsButtons, NlFormDataSettingsInputLangs, NlFormDataSettingsInputPagesEnabled, NlFormDataSettingsInputSocial, NlSettingsData } from "../types/types"

export default class FormDataSettingsHtml{

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
    private _buttons: NlFormDataSettingsButtons;

    constructor(data: NlFormDataSettings){
        this.assignValues(data);
        this.checkboxLangsChange();
        this.checkboxSocialChange();
        this.checkboxContactsPagesChange();
        this.checkboxCookiePolicyPagesChange();
        this.checkboxPrivacyPolicyPagesChange();
    }

    get container_langs(){ return this._container_langs; }
    get cb_langs(){ return this._cb_langs; }
    get container_pages_enabled(){ return this._container_pages_enabled; }
    get cb_pages_enabled(){ return this._cb_pages_enabled; }
    get cb_social(){ return this._cb_social; }
    get row_social_links(){ return this._row_social_links; }
    get input_social_links(){ return this._input_social_links; }
    get container_contacts_pages(){ return this._container_contacts_pages; }
    get container_cookie_pages(){ return this._container_cookie_pages; }
    get input_cookie_policy_pages(){ return this._input_cookie_policy_pages; }
    get input_contacts_pages(){ return this._input_contacts_pages; }
    get container_privacy_pages(){return this._container_contacts_pages; }
    get input_privacy_policy_pages(){ return this._input_privacy_policy_pages; }
    get container_terms_pages(){ return this._container_terms_pages; }
    get input_terms_pages(){ return this._input_terms_pages; }
    get buttons(){ return this._buttons };

    private assignValues(data: NlFormDataSettings){
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
        this._buttons = data.buttons;
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
     * When the cookie policy pages enabled checkbox value change 
     */
    private checkboxCookiePolicyPagesChange(): void{
        this._cb_pages_enabled.cookie_policy_pages.addEventListener('change',()=>{
            if(this._cb_pages_enabled.cookie_policy_pages.checked){
                if(this._cb_langs.lang_it.checked) this._input_cookie_policy_pages.lang_it.disabled = false;
                else this._input_cookie_policy_pages.lang_it.disabled = true;
                if(this._cb_langs.lang_es.checked) this._input_cookie_policy_pages.lang_es.disabled = false;
                else this._input_cookie_policy_pages.lang_es.disabled = true;
                if(this._cb_langs.lang_en.checked) this._input_cookie_policy_pages.lang_en.disabled = false;
                else this._input_cookie_policy_pages.lang_en.disabled = true;
            }
            else{
                const input_cookie_policy_pages: NodeListOf<HTMLInputElement> = this._container_cookie_pages.querySelectorAll('input[type="text"]') as NodeListOf<HTMLInputElement>;
                input_cookie_policy_pages.forEach(input_cookie_policy_page => input_cookie_policy_page.disabled = true)
            }
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
    public onFormSubmit(callback: (data: NlSettingsData) => void): void{
        this._buttons.primary.addEventListener('click',()=>{

            const form_data: NlSettingsData = {
                lang_status: {
                    en: this._cb_langs.lang_en.checked,
                    es: this._cb_langs.lang_es.checked,
                    it: this._cb_langs.lang_it.checked
                },
                included_pages_status: {
                    contacts_pages: this._cb_pages_enabled.contacts_pages.checked,
                    privacy_policy_pages: this._cb_pages_enabled.privacy_policy_pages.checked
                },
                socials_status: {
                    facebook: this._cb_social.facebook.checked,
                    instagram: this._cb_social.instagram.checked,
                    youtube: this._cb_social.youtube.checked
                },
                social_pages: {
                    facebook: this._input_social_links.facebook.value,
                    instagram: this._input_social_links.instagram.value,
                    youtube: this._input_social_links.youtube.value
                },
                contact_pages: {
                    en: this._input_contacts_pages.lang_en.value,
                    es: this._input_contacts_pages.lang_es.value,
                    it: this._input_contacts_pages.lang_it.value
                },
                cookie_policy_pages: {
                    en: this._input_cookie_policy_pages.lang_en.value,
                    es: this._input_cookie_policy_pages.lang_es.value,
                    it: this._input_cookie_policy_pages.lang_it.value,
                },
                privacy_policy_pages: {
                    en: this._input_privacy_policy_pages.lang_en.value,
                    es: this._input_privacy_policy_pages.lang_es.value,
                    it: this._input_privacy_policy_pages.lang_it.value
                },
                terms_pages: {
                    en: this._input_terms_pages.lang_en.value,
                    es: this._input_terms_pages.lang_es.value,
                    it: this._input_terms_pages.lang_it.value,
                }
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