import { checkedEmailsList, emailSelection } from "../general/admincommon";
import { GetSubscribersHtml, GetSubscribersHtmlInterface } from "../html/getsubscribershtml";
import { Constants } from "../namespaces/constants";
import DeleteUsers from "../requests/delete_users";
import GetSubscribers from "../requests/get_subscribers";
import { NlFormDataDelete } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    const form: HTMLFormElement = document.getElementById('nl_form_del') as HTMLFormElement;
    const delete_spinner: HTMLDivElement = document.getElementById('nl_delete_spinner') as HTMLDivElement;
    const delete_users_response: HTMLDivElement = document.getElementById('nl_delete_users_response') as HTMLDivElement;
    loadEmailAddresses();
    form.addEventListener('submit', (e)=>{
        e.preventDefault();
        delete_users_response.innerHTML = "";
        const emails: string[] = checkedEmailsList('nl_del_content_email');
        if(emails.length > 0){
            const data: NlFormDataDelete = {
                emails: emails
            };
            const du: DeleteUsers = new DeleteUsers(data);
            delete_spinner.classList.remove("invisible");
            du.deleteUsers().then(obj => {
                delete_spinner.classList.add("invisible");
                if(obj[Constants.KEY_DONE] == true){
                    loadEmailAddresses();
                   delete_users_response.style.color = 'green'; 
                }
                else delete_users_response.style.color = 'red';
                delete_users_response.innerHTML = obj["msg"];
            });
        }//if(emails.length > 0){
        else{
            delete_users_response.style.color = 'red';
            delete_users_response.innerHTML = "Seleziona almeno un indirizzo email";
        }
    });//form.addEventListener('submit', (e)=>{
});

/**
 * Execute the request to get the newsletter subscribers and print them
 */
function loadEmailAddresses(): void{
    const gs: GetSubscribers = new GetSubscribers();
    gs.getSubscribers().then(res => {
        //console.log(res);
        const gsh_data: GetSubscribersHtmlInterface = {
            containerId: 'nl_del_content_email', subscribers: gs.subscribers
        };
        const gsh: GetSubscribersHtml = new GetSubscribersHtml(gsh_data);
        emailSelection('nl_del_content_email');
    });
}