import { NlFormDataDelete } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    let form: HTMLFormElement = document.getElementById('nl_form_add') as HTMLFormElement;
    let cb_all: HTMLInputElement = document.getElementById('nl_check_all') as HTMLInputElement;
    let cb_all_it: HTMLInputElement = document.getElementById('nl_check_all_it') as HTMLInputElement;
    let cb_all_es: HTMLInputElement = document.getElementById('nl_check_all_es') as HTMLInputElement;
    let cb_all_en: HTMLInputElement = document.getElementById('nl_check_all_en') as HTMLInputElement;
    form.addEventListener('submit', (e)=>{
        e.preventDefault();
        const data: NlFormDataDelete = {
            emails: []
        };
    });//form.addEventListener('submit', (e)=>{
    cb_all.addEventListener('change',()=>{});
    cb_all_it.addEventListener('change',()=>{});
    cb_all_es.addEventListener('change',()=>{});
    cb_all_en.addEventListener('change',()=>{});
});