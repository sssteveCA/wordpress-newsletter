import { GetSubscribersHtml, GetSubscribersHtmlInterface } from "../html/getsubscribershtml.js";
import GetSubscribers from "../requests/get_subscribers.js";
import SendEmail from "../requests/send_email.js";
import { NlFormDataSend } from "../types/types.js";

window.addEventListener('DOMContentLoaded',()=>{
    let form: HTMLFormElement = document.getElementById('nl_form_send') as HTMLFormElement;
    let cb_all: HTMLInputElement = document.getElementById('nl_check_all') as HTMLInputElement;
    let cb_all_it: HTMLInputElement = document.getElementById('nl_check_all_it') as HTMLInputElement;
    let cb_all_es: HTMLInputElement = document.getElementById('nl_check_all_es') as HTMLInputElement;
    let cb_all_en: HTMLInputElement = document.getElementById('nl_check_all_en') as HTMLInputElement;
    let send_spinner: HTMLDivElement = document.getElementById('send_spinner') as HTMLDivElement;
    let gs: GetSubscribers = new GetSubscribers();
    gs.getSubscribers().then(res => {
        console.log(gs.subscribers);
        let gsh_data: GetSubscribersHtmlInterface = {
            containerId: 'nl_send_content', subscribers: gs.subscribers
        };
        let gsh: GetSubscribersHtml = new GetSubscribersHtml(gsh_data);
        emailSelection();
    });
    
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        let emails: string[] = checkedEmailsList();
        if(emails.length > 0){
            const data: NlFormDataSend = {
                subject: document.getElementById('nl_subject')?.getAttribute('value') as string,
                message: document.getElementById('nl_msg_text')?.getAttribute('value') as string,
                emails: emails
            };
            send_spinner.classList.remove("invisible");
            let se: SendEmail = new SendEmail(data);
            se.sendEmail().then(res => {
                send_spinner.classList.add("invisible");
            });
        }//if(emails.length > 0){ 
    });//form.addEventListener('submit',(e)=>{
    cb_all.addEventListener('change',()=>{});
    cb_all_it.addEventListener('change',()=>{});
    cb_all_es.addEventListener('change',()=>{});
    cb_all_en.addEventListener('change',()=>{});

});

/**
 * Get the emails that has checkbox checked 
 * @returns the checked emails list
 */
function checkedEmailsList(): string[]{
    let emails: string[] = [];
    let trTable = document.querySelectorAll('#nl_send_content table tbody tr');
    trTable.forEach(tr => {
        let tds = tr.querySelectorAll('td');
        let cb: HTMLInputElement = tr.querySelector('td:first-child input') as HTMLInputElement;
        if(cb.checked){
            let email: string = tds.item(1).innerText;
            emails.push(email);
        }
    });//trTable.forEach(tr => {
    console.log(emails);
    return emails;
}

/**
 * Select all the emails or emails of a particular language in subscriber list box
 */
function emailSelection(): void{
    let check_all_el: HTMLInputElement = document.getElementById('nl_check_all') as HTMLInputElement;
    let check_all_el_it: HTMLInputElement = document.getElementById('nl_check_all_it') as HTMLInputElement;
    let check_all_el_es: HTMLInputElement = document.getElementById('nl_check_all_es') as HTMLInputElement;
    let check_all_el_en: HTMLInputElement = document.getElementById('nl_check_all_en') as HTMLInputElement;
    check_all_el.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        selectEmails(fired.id,fired.checked);
    });
    check_all_el_it.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        selectEmails(fired.id,fired.checked);
    });
    check_all_el_es.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        selectEmails(fired.id,fired.checked);
    });
    check_all_el_en.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        selectEmails(fired.id,fired.checked);
    });
}

/**
 * Check checkbox in emails list box when a checkbox of email select group is checked
 */
function selectEmails(idSelected: string, checked: boolean): void{
    console.log(idSelected);
    console.log(checked);
    let checkgroup: string = "";
    if(idSelected == 'nl_check_all_it'){checkgroup = "it";}
    if(idSelected == 'nl_check_all_es'){checkgroup = "es";}
    if(idSelected == 'nl_check_all_en'){checkgroup = "en";}
    let trTable = document.querySelectorAll('#nl_send_content table tbody tr');
    trTable.forEach(tr => {
        let tds = tr.querySelectorAll('td');
        let cb: HTMLInputElement = tr.querySelector('td:first-child input') as HTMLInputElement;
        let tdLang: string = tds.item(2).innerText;
        console.log("checkgroup => "+checkgroup);
        console.log("tdLang => "+tdLang);
        if(checkgroup == ""){
            if(checked)cb.checked = true;
            else cb.checked = false;
        } 
        else{
            if(checkgroup == tdLang){
                if(checked)cb.checked = true;
                else cb.checked = false;
            }
        }//if(checkgroup == ""){
    });
}