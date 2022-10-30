import { NlFormDataAdd } from "../types/types";

window.addEventListener('DOMContentLoaded', ()=>{
    let form: HTMLFormElement = document.getElementById('nl_form_add') as HTMLFormElement;
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        const data: NlFormDataAdd = {
            email: document.getElementById('nl_email')?.getAttribute('value') as string,
            lang_code: document.getElementById('nl_lang_code')?.getAttribute('value') as string,
            unsubcribe_code: document.getElementById('nl_unsubscribe_code')?.getAttribute('value') as string
        };
    });//form.addEventListener('submit',(e)=>{
});