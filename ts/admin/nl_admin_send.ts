import { NlFormDataSend } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    let form: HTMLFormElement = document.getElementById('nl_form_send') as HTMLFormElement;
    let cb_all: HTMLInputElement = document.getElementById('nl_check_all') as HTMLInputElement;
    let cb_all_it: HTMLInputElement = document.getElementById('nl_check_all_it') as HTMLInputElement;
    let cb_all_es: HTMLInputElement = document.getElementById('nl_check_all_es') as HTMLInputElement;
    let cb_all_en: HTMLInputElement = document.getElementById('nl_check_all_en') as HTMLInputElement;
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        const data: NlFormDataSend = {
            subject: document.getElementById('nl_subject')?.getAttribute('value') as string,
            message: document.getElementById('nl_msg_text')?.getAttribute('value') as string,
            emails: []
        };
    });//form.addEventListener('submit',(e)=>{
    cb_all.addEventListener('change',()=>{});
    cb_all_it.addEventListener('change',()=>{});
    cb_all_es.addEventListener('change',()=>{});
    cb_all_en.addEventListener('change',()=>{});

});