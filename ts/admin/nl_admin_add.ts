import { AddUserAdmin } from "../requests/add_user_admin";
import { NlFormDataAdd } from "../types/types";

window.addEventListener('DOMContentLoaded', ()=>{
    let form: HTMLFormElement = document.getElementById('nl_form_add') as HTMLFormElement;
    let add_spinner: HTMLDivElement = document.getElementById('nl_add_spinner') as HTMLDivElement;
    let add_user_response: HTMLDivElement = document.getElementById('nl_add_user_response') as HTMLDivElement;
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        const data: NlFormDataAdd = {
            name: document.getElementById('nl_name')?.getAttribute('value') as string,
            surname: document.getElementById('nl_surname')?.getAttribute('value') as string,
            email: document.getElementById('nl_email')?.getAttribute('value') as string,
            lang_code: document.getElementById('nl_lang_code')?.getAttribute('value') as string,
        };
        let addUser: AddUserAdmin = new AddUserAdmin(data);
        add_spinner.classList.remove("invisible");
        addUser.addUser().then(obj => {
            add_spinner.classList.add("invisible");
            if(obj["done"] == true) add_user_response.style.color = 'green';
            else add_user_response.style.color = 'red';
            add_user_response.innerHTML = obj["msg"];
        });
    });//form.addEventListener('submit',(e)=>{
});