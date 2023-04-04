import { Constants } from "../namespaces/constants";
import { UnsubscribeUser } from "../requests/unsubscribe_user";
import { NlUnsubscribeUserData } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    const spinner = document.getElementById('nl_spinner') as HTMLDivElement;
    const uu_response_div = document.getElementById('nl_unsubscribe_user_response') as HTMLDivElement;
    const form = document.getElementById('fUnsubscribe') as HTMLFormElement;
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        const data: NlUnsubscribeUserData = {
            lang: (<HTMLInputElement>document.querySelector('input[name=lang]')).value,
            unsubscribe_code: (<HTMLInputElement>document.querySelector('input[name=unsubsc_code]')).value
        }
        spinner.classList.toggle('invisible');
        const unsubscribe_user: UnsubscribeUser = new UnsubscribeUser(data);
        unsubscribe_user.unsubscribe().then(obj => {
            spinner.classList.toggle('invisible');
            if(obj[Constants.KEY_DONE] == true){
                uu_response_div.style.color = 'green';
            }
            else{
                uu_response_div.style.color = 'red';
            }
            uu_response_div.innerHTML = obj[Constants.KEY_MESSAGE];
        })
    })
})