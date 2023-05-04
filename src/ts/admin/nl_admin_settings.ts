import FormDataSettingsHtml from "../html/formdatasettingshtml";
import FormDataSettingsSetHtml from "../html/formdatasettingssethtml";
import { Constants } from "../namespaces/constants";
import GetSettings from "../requests/get_settings";
import UpdateSettings from "../requests/update_settings";
import { NlFormDataSettings, NlFormDataSettingsSet, NlSettingsData } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    const response_div: HTMLDivElement = document.getElementById('nl_update_settings_response') as HTMLDivElement
    const spinner: HTMLDivElement = document.getElementById('nl_spinner') as HTMLDivElement
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
        response_div.innerHTML = ""
        const us: UpdateSettings = new UpdateSettings(data)
        spinner.classList.toggle('invisible')
        us.updateSettings().then(obj => {
            spinner.classList.toggle('invisible')
            if(obj[Constants.KEY_DONE])
                response_div.style.color = 'green'
            else
                response_div.style.color = 'red'
            response_div.innerHTML = obj[Constants.KEY_MESSAGE]
                
        })
    });
    const gs: GetSettings = new GetSettings();
    gs.getSettings().then(obj => {
        if(obj[Constants.KEY_DONE]){
            const fds_set_data: NlFormDataSettingsSet = {
                data: obj[Constants.KEY_DATA],
                container_pages_enabled: fds.container_pages_enabled,
                cb_pages_enabled: fds.cb_pages_enabled,
                container_langs: fds.container_langs,
                cb_langs: fds.cb_langs,
                cb_social: fds.cb_social,
                row_social_links: fds.row_social_links,
                input_social_links: fds.input_social_links,
                container_contacts_pages: fds.container_contacts_pages,
                input_contacts_pages: fds.input_contacts_pages,
                container_privacy_pages: fds.container_privacy_pages,
                input_privacy_policy_pages: fds.input_privacy_policy_pages,
            }
            const fds_set: FormDataSettingsSetHtml = new FormDataSettingsSetHtml(fds_set_data)
            fds_set.setSettingsForm();
        }//if(obj[Constants.KEY_DONE]){
    })
});