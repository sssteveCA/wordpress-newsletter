import { NewUser } from "../requests/new_user.js";
import {NlFormData} from "../types/types.js";

window.addEventListener('DOMContentLoaded',()=>{
    console.log("nl_wp load");
    let form: HTMLFormElement = document.getElementById("nl_form") as HTMLFormElement;
    if(form){
        form.addEventListener('submit', (e)=>{
            e.preventDefault();
            const data: NlFormData = {
                name: (<HTMLInputElement>document.getElementById('nl_name')).value as string,
                surname: (<HTMLInputElement>document.getElementById('nl_surname')).value as string,
                email: (<HTMLInputElement>document.getElementById('nl_email')).value as string,
                cb_privacy: (<HTMLInputElement>document.getElementById('nl_cb_privacy')).value as string,
                cb_terms: (<HTMLInputElement>document.getElementById('nl_cb_terms')).value as string,
                lang: (<HTMLInputElement>document.getElementById('nl_lang')).value as string
            };
            let spinner: HTMLElement = document.getElementById('nl_spinner') as HTMLElement;
            spinner.classList.remove('invisible');
            console.log("nl_wp.ts NlFormData => ");
            console.log(data);
            let newUser: NewUser = new NewUser(data);
            newUser.newUser().then(res => {
                spinner.classList.add('invisible');
            });
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