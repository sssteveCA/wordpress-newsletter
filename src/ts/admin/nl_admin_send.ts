import { checkedEmailsList, emailSelection } from "../general/admincommon";
import { GetSubscribersHtml, GetSubscribersHtmlInterface } from "../html/getsubscribershtml";
import { Constants } from "../namespaces/constants";
import GetSubscribers from "../requests/get_subscribers";
import SendEmail from "../requests/send_email";
import { NlFormDataSend } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    const form: HTMLFormElement = document.getElementById('nl_form_send') as HTMLFormElement;
    const send_spinner: HTMLDivElement = document.getElementById('nl_send_spinner') as HTMLDivElement;
    const email_send_response: HTMLDivElement = document.getElementById('nl_email_send_response') as HTMLDivElement;
    const gs: GetSubscribers = new GetSubscribers();
    gs.getSubscribers().then(res => {
        //console.log(gs.subscribers);
        const gsh_data: GetSubscribersHtmlInterface = {
            containerId: 'nl_send_content', subscribers: gs.subscribers
        };
        const gsh: GetSubscribersHtml = new GetSubscribersHtml(gsh_data);
        emailSelection('nl_send_content');
    });
    
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        email_send_response.innerHTML = "";
        const emails: string[] = checkedEmailsList('nl_send_content');
        if(emails.length > 0){
            const data: NlFormDataSend = {
                subject: (<HTMLTextAreaElement>document.getElementById('nl_subject')).value as string,
                message: (<HTMLInputElement>document.getElementById('nl_msg_text')).value as string,
                emails: emails
            };
            /* console.log("NlFormDataSend => ");
            console.log(data); */
            send_spinner.classList.remove("invisible");
            const se: SendEmail = new SendEmail(data);
            se.sendEmail().then(obj => {
                send_spinner.classList.add("invisible");
                if(obj[Constants.KEY_DONE] == true) email_send_response.style.color = 'green';
                else email_send_response.style.color = 'red';
                email_send_response.innerHTML = obj[Constants.KEY_MESSAGE];
            });
        }//if(emails.length > 0){ 
        else{
            email_send_response.style.color = 'red';
            email_send_response.innerHTML = "Seleziona almeno un indirizzo email";
        }
    });//form.addEventListener('submit',(e)=>{
});