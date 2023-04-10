import { Constants } from "../namespaces/constants.js";
import { AddUserAdmin } from "../requests/add_user_admin.js";
import { NlFormDataAdd } from "../types/types";

window.addEventListener('DOMContentLoaded', ()=>{
    const form: HTMLFormElement = document.getElementById('nl_form_add') as HTMLFormElement;
    const add_spinner: HTMLDivElement = document.getElementById('nl_add_spinner') as HTMLDivElement;
    const add_user_response: HTMLDivElement = document.getElementById('nl_add_user_response') as HTMLDivElement;
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        add_user_response.innerHTML = "";
        const data: NlFormDataAdd = {
            name: (<HTMLInputElement>document.getElementById('nl_name')).value as string,
            surname: (<HTMLInputElement>document.getElementById('nl_surname')).value as string,
            email: (<HTMLInputElement>document.getElementById('nl_email')).value as string,
            lang_code: (<HTMLSelectElement>document.getElementById('nl_lang_code')).value as string,
        };
        const addUser: AddUserAdmin = new AddUserAdmin(data);
        add_spinner.classList.remove("invisible");
        addUser.addUser().then(obj => {
            add_spinner.classList.add("invisible");
            if(obj[Constants.KEY_DONE] == true) add_user_response.style.color = 'green';
            else add_user_response.style.color = 'red';
            add_user_response.innerHTML = obj[Constants.KEY_MESSAGE];
        });
    });//form.addEventListener('submit',(e)=>{
});