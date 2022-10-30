import {NlFormData} from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    let form: HTMLFormElement = document.getElementById("nl_form") as HTMLFormElement;
    if(form){
        form.addEventListener('submit', (e)=>{
            e.preventDefault();
            const data: NlFormData = {
                email: document.getElementById('nl_email')?.getAttribute('value') as string,
                cb_privacy: document.getElementById('nl_check_pc')?.getAttribute('value') as string,
                cb_terms: document.getElementById('nl_check_terms')?.getAttribute('value') as string,
                lang: document.getElementById('nl_lang')?.getAttribute('value') as string
            };
        });
    }//if(form){
});