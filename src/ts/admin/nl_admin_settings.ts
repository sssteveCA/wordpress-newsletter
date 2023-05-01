import FormDataSettingsHtml from "../html/formdatasettingshtml";
import { NlFormDataSettings } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    const fds_data: NlFormDataSettings = {
        container_pages_enabled: document.getElementById('nl_container_pages_enabled') as HTMLDivElement,
        cb_pages_enabled: {
            contacts_pages: document.getElementById('nl_cb_contacts_pages') as HTMLInputElement,
            privacy_policy_pages: document.getElementById('nl_cb_privacy_policy') as HTMLInputElement
        },
        container_langs: document.getElementById('nl_container_langs') as HTMLDivElement,
        cb_langs: {
            lang_it: document.getElementById('nl_cb_lang_it') as HTMLInputElement,
            lang_es: document.getElementById('nl_cb_lang_es') as HTMLInputElement,
            lang_en: document.getElementById('nl_cb_lang_en') as HTMLInputElement,
        },
        cb_social: {
            facebook: document.getElementById('nl_cb_facebook') as HTMLInputElement,
            instagram: document.getElementById('nl_cb_instagram') as HTMLInputElement,
            youtube: document.getElementById('nl_cb_youtube') as HTMLInputElement,
        },
        row_social_links: document.getElementById('nl_row_social_links') as HTMLDivElement,
        input_social_links: {
            facebook: document.getElementById('nl_input_facebook') as HTMLInputElement,
            instagram: document.getElementById('nl_input_instagram') as HTMLInputElement,
            youtube: document.getElementById('nl_input_youtube') as HTMLInputElement,
        },
        container_contacts_pages: document.getElementById('nl_container_contacts_pages') as HTMLDivElement,
        input_contacts_pages: {
            lang_it: document.getElementById('nl_page_contacts_it') as HTMLInputElement,
            lang_es: document.getElementById('nl_page_contacts_es') as HTMLInputElement,
            lang_en: document.getElementById('nl_page_contacts_en') as HTMLInputElement,
        },
        container_privacy_pages: document.getElementById('nl_container_privacy_pages') as HTMLInputElement,
        input_privacy_policy_pages: {
            lang_it: document.getElementById('nl_page_privacy_policy_it') as HTMLInputElement,
            lang_es: document.getElementById('nl_page_privacy_policy_es') as HTMLInputElement,
            lang_en: document.getElementById('nl_page_privacy_policy_en') as HTMLInputElement,
        },
        buttons: {
            primary: document.getElementById('nl_primary_button') as HTMLButtonElement
        }
    }
    const fds: FormDataSettingsHtml = new FormDataSettingsHtml(fds_data)
    fds.onFormSubmit((data) => {
        console.log(data);
    });
});