import { checkedEmailsList, emailSelection } from "../general/admincommon.js";
import { GetSubscribersHtml, GetSubscribersHtmlInterface } from "../html/getsubscribershtml.js";
import GetSubscribers from "../requests/get_subscribers.js";
import SendEmail from "../requests/send_email.js";
import { NlFormDataSend } from "../types/types.js";

window.addEventListener('DOMContentLoaded',()=>{
    let form: HTMLFormElement = document.getElementById('nl_form_send') as HTMLFormElement;
    let send_spinner: HTMLDivElement = document.getElementById('send_spinner') as HTMLDivElement;
    let email_send_response: HTMLDivElement = document.getElementById('email_send_response') as HTMLDivElement;
    let gs: GetSubscribers = new GetSubscribers();
    gs.getSubscribers().then(res => {
        //console.log(gs.subscribers);
        let gsh_data: GetSubscribersHtmlInterface = {
            containerId: 'nl_send_content', subscribers: gs.subscribers
        };
        let gsh: GetSubscribersHtml = new GetSubscribersHtml(gsh_data);
        emailSelection('nl_send_content');
    });
    
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        email_send_response.innerHTML = "";
        let emails: string[] = checkedEmailsList('nl_send_content');
        if(emails.length > 0){
            const data: NlFormDataSend = {
                subject: (<HTMLTextAreaElement>document.getElementById('nl_subject')).value as string,
                message: (<HTMLInputElement>document.getElementById('nl_msg_text')).value as string,
                emails: emails
            };
            /* console.log("NlFormDataSend => ");
            console.log(data); */
            send_spinner.classList.remove("invisible");
            let se: SendEmail = new SendEmail(data);
            se.sendEmail().then(obj => {
                send_spinner.classList.add("invisible");
                if(obj["done"] == true) email_send_response.style.color = 'green';
                else email_send_response.style.color = 'red';
                email_send_response.innerHTML = obj["msg"];
            });
        }//if(emails.length > 0){ 
        else{
            email_send_response.style.color = 'red';
            email_send_response.innerHTML = "Seleziona almeno un indirizzo email";
        }
    });//form.addEventListener('submit',(e)=>{
});