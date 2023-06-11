import { messageDialog } from "../general/functions";
import { Constants } from "../namespaces/constants";
import { NewUser } from "../requests/new_user";
import {BsMdDialogData, NlFormData, NlFormDataElements} from "../types/types";

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
                lang: formEls.lang.value as string
            };
            if(formEls.cb_privacy)data.cb_privacy = formEls.cb_privacy.value
            if(formEls.cb_terms)data.cb_terms = formEls.cb_terms.value
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
                    if(formEls.cb_privacy && formEls.cb_terms){
                        formEls.cb_privacy.checked = false; 
                        formEls.cb_terms.checked = false;
                    }
                }//if(res[Constants.KEY_DONE] == true){
            });
        });
        if(formEls.cb_privacy || formEls.cb_terms) checkboxEvents(formEls);
        else formEls.bt_submit.disabled = false;
    }//if(form){  
});

/**
 * Create an object that contains the Signup form HTML element references
 * @returns 
 */
function htmlFormElements(): NlFormDataElements{
    const formElements: NlFormDataElements = {
        name: document.getElementById('nl_name') as HTMLInputElement,
        surname: document.getElementById('nl_surname') as HTMLInputElement,
        email: document.getElementById('nl_email') as HTMLInputElement,
        lang: document.getElementById('nl_lang') as HTMLInputElement,
        bt_submit: document.getElementById('nl_submit') as HTMLButtonElement 
    }
    const cb_privacy = document.getElementById('nl_cb_privacy');
    const cb_terms = document.getElementById('nl_cb_terms');
    if(cb_privacy) formElements.cb_privacy = cb_privacy as HTMLInputElement;
    if(cb_terms) formElements.cb_terms = cb_terms as HTMLInputElement;
    return formElements;
}

/**
 * Set the events for checkboxes and the behavior of the submit button
 * @param formEls 
 */
function checkboxEvents(formEls: NlFormDataElements): void{
    if(formEls.bt_submit){
        if(formEls.cb_privacy){
            formEls.cb_privacy.addEventListener('change',()=>{
                if(formEls.cb_privacy?.checked){
                    if(!formEls.cb_terms || (formEls.cb_terms && formEls.cb_terms.checked)) formEls.bt_submit.disabled = false
                    else formEls.bt_submit.disabled = true
                }//if(formEls.cb_privacy?.checked){
                else formEls.bt_submit.disabled = true
            });
        }//if(formEls.cb_privacy){
        if(formEls.cb_terms){
            formEls.cb_terms.addEventListener('change',()=>{
                if(formEls.cb_terms?.checked){
                    if(!formEls.cb_privacy || (formEls.cb_privacy && formEls.cb_privacy.checked)) formEls.bt_submit.disabled = false
                else formEls.bt_submit.disabled = true
                }//if(formEls.cb_terms?.checked){  
                else formEls.bt_submit.disabled = true
            })
        }//if(formEls.cb_terms){
        if(!(formEls.cb_privacy && formEls.cb_terms)) formEls.bt_submit.disabled = false
        formEls.bt_submit.disabled = true
    }//if(formEls.bt_submit){
}
