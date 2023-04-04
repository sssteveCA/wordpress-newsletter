import { Constants } from "../namespaces/constants";
import { UnsubscribeUser } from "../requests/unsubscribe_user";
import { NlUnsubscribeUserData } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    let form = document.getElementById('fUnsubscribe') as HTMLFormElement;
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        const data: NlUnsubscribeUserData = {
            lang: '',
            unsubscribe_code: ''
        }
        const unsubscribe_user: UnsubscribeUser = new UnsubscribeUser(data);
        unsubscribe_user.unsubscribe().then(obj => {
            if(obj[Constants.KEY_DONE] == true){

            }
            else{
                
            }
        })
    })
})