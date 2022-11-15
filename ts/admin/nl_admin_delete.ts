import { checkedEmailsList, emailSelection } from "../general/admincommon.js";
import { GetSubscribersHtml, GetSubscribersHtmlInterface } from "../html/getsubscribershtml.js";
import GetSubscribers from "../requests/get_subscribers.js";
import { NlFormDataDelete } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    let form: HTMLFormElement = document.getElementById('nl_form_add') as HTMLFormElement;
    let gs: GetSubscribers = new GetSubscribers();
    gs.getSubscribers().then(res => {
        console.log(res);
        let gsh_data: GetSubscribersHtmlInterface = {
            containerId: 'nl_del_content_email', subscribers: gs.subscribers
        };
        let gsh: GetSubscribersHtml = new GetSubscribersHtml(gsh_data);
        emailSelection('nl_del_content_email');
    });
    form.addEventListener('submit', (e)=>{
        e.preventDefault();
        let emails: string[] = checkedEmailsList('nl_del_content_email');
        if(emails.length > 0){
            const data: NlFormDataDelete = {
                emails: emails
            };
        }//if(emails.length > 0){
    });//form.addEventListener('submit', (e)=>{
});