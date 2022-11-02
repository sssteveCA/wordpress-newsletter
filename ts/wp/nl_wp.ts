import { NewUser } from "../requests/new_user";
import {NlFormData} from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    console.log("nl_wp load");
    let form: HTMLFormElement = document.getElementById("nl_form") as HTMLFormElement;
    if(form){
        form.addEventListener('submit', (e)=>{
            e.preventDefault();
            const data: NlFormData = {
                name: document.getElementById('name')?.getAttribute('value') as string,
                surname: document.getElementById('surname')?.getAttribute('value') as string,
                email: document.getElementById('nl_email')?.getAttribute('value') as string,
                cb_privacy: document.getElementById('nl_cb_privacy')?.getAttribute('value') as string,
                cb_terms: document.getElementById('nl_cb_terms')?.getAttribute('value') as string,
                lang: document.getElementById('nl_lang')?.getAttribute('value') as string
            };
            let newUser: NewUser = new NewUser(data);
            newUser.newUser();
        });
    }//if(form){
    let cbPrivacyEl: HTMLInputElement = document.getElementById('nl_cb_privacy') as HTMLInputElement;
    let cbTermsEl: HTMLInputElement = document.getElementById('nl_cb_terms') as HTMLInputElement;
    let btSubmit: HTMLButtonElement = document.getElementById('nl_submit') as HTMLButtonElement;
    if(cbPrivacyEl && cbTermsEl && btSubmit){
        cbPrivacyEl.addEventListener('change',()=>{
            if(cbPrivacyEl.checked && cbTermsEl.checked) btSubmit.disabled = false;
            else btSubmit.disabled = true;
        });
        cbTermsEl.addEventListener('change',()=>{
            if(cbPrivacyEl.checked && cbTermsEl.checked) btSubmit.disabled = false;
            else btSubmit.disabled = true;
        });
    }//if(cbPrivacyEl && cbTermsEl && btSubmit){
});