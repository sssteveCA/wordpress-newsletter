import { messageDialog } from "../general/functions.js";
import { Constants } from "../namespaces/constants.js";
import { NewUser } from "../requests/new_user.js";
import {BsMdDialogData, NlFormData, NlFormDataElements} from "../types/types.js";

window.addEventListener('DOMContentLoaded',()=>{
    const form: HTMLFormElement = document.getElementById("nl_form") as HTMLFormElement;
    const formEls: NlFormDataElements = htmlFormElements();
    if(form){
        form.addEventListener('submit', (e)=>{
            e.preventDefault();
            const data: NlFormData = {
                name: formEls.name.value as string,
                surname: formEls.surname.value as string,
                email: formEls.email.value as string,
                cb_privacy: formEls.cb_privacy.value as string,
                cb_terms: formEls.cb_terms.value as string,
                lang: formEls.lang.value as string
            };
            const spinner: HTMLElement = document.getElementById('nl_spinner') as HTMLElement;
            spinner.classList.remove('invisible');
            /* console.log("nl_wp.ts NlFormData => ");
            console.log(data); */
            const newUser: NewUser = new NewUser(data);
            newUser.newUser().then(res => {
                spinner.classList.add('invisible');
                const md_data: BsMdDialogData = {
                    title: 'Iscrizione newsletter', message: res[Constants.KEY_MESSAGE]
                };
                messageDialog(md_data);
                if(res[Constants.KEY_DONE] == true){
                    formEls.name.value = ""; formEls.surname.value = ""; formEls.email.value = "";
                    formEls.cb_privacy.checked = false; formEls.cb_terms.checked = false;
                }//if(res[Constants.KEY_DONE] == true){
            });
        });
    }//if(form){
    if(formEls.cb_privacy && formEls.cb_terms && formEls.bt_submit){
        formEls.cb_privacy.addEventListener('change',()=>{
            if(formEls.cb_privacy.checked && formEls.cb_terms.checked) formEls.bt_submit.disabled = false;
            else formEls.bt_submit.disabled = true;
        });
        formEls.cb_terms.addEventListener('change',()=>{
            if(formEls.cb_privacy.checked && formEls.cb_terms.checked) formEls.bt_submit.disabled = false;
            else formEls.bt_submit.disabled = true;
        });
    }//if(cbPrivacyEl && cbTermsEl && btSubmit){
});

/**
 * Create an object that contains the Signup form HTML element references
 * @returns 
 */
function htmlFormElements(): NlFormDataElements{
    return {
        name: document.getElementById('nl_name') as HTMLInputElement,
        surname: document.getElementById('nl_surname') as HTMLInputElement,
        email: document.getElementById('nl_email') as HTMLInputElement,
        cb_privacy: document.getElementById('nl_cb_privacy') as HTMLInputElement,
        cb_terms: document.getElementById('nl_cb_terms') as HTMLInputElement,
        lang: document.getElementById('nl_lang') as HTMLInputElement,
        bt_submit: document.getElementById('nl_submit') as HTMLButtonElement
    };
}
