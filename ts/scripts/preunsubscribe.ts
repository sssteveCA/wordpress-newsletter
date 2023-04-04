import { Constants } from "../namespaces/constants";
import { UnsubscribeUser } from "../requests/unsubscribe_user";
import { NlUnsubscribeUserData } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    let uu_response_div = document.getElementById('nl_unsubscribe_user_response') as HTMLDivElement;
    let form = document.getElementById('fUnsubscribe') as HTMLFormElement;
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        const data: NlUnsubscribeUserData = {
            lang: (<HTMLInputElement>document.querySelector('input[name=lang]')).value,
            unsubscribe_code: (<HTMLInputElement>document.querySelector('input[name=unsubsc_code]')).value
        }
        const unsubscribe_user: UnsubscribeUser = new UnsubscribeUser(data);
        unsubscribe_user.unsubscribe().then(obj => {
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