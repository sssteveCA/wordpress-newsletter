import { GetSubscribersHtml, GetSubscribersHtmlInterface } from "../html/getsubscribershtml.js";
import GetSubscribers from "../requests/get_subscribers.js";
import { NlFormDataSend } from "../types/types.js";

window.addEventListener('DOMContentLoaded',()=>{
    let gs: GetSubscribers = new GetSubscribers();
    gs.getSubscribers().then(res => {
        console.log(gs.subscribers);
        let gsh_data: GetSubscribersHtmlInterface = {
            containerId: 'nl_send_content', subscribers: gs.subscribers
        };
        let gsh: GetSubscribersHtml = new GetSubscribersHtml(gsh_data);
        emailSelection();
    });
    let form: HTMLFormElement = document.getElementById('nl_form_send') as HTMLFormElement;
    let cb_all: HTMLInputElement = document.getElementById('nl_check_all') as HTMLInputElement;
    let cb_all_it: HTMLInputElement = document.getElementById('nl_check_all_it') as HTMLInputElement;
    let cb_all_es: HTMLInputElement = document.getElementById('nl_check_all_es') as HTMLInputElement;
    let cb_all_en: HTMLInputElement = document.getElementById('nl_check_all_en') as HTMLInputElement;
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        const data: NlFormDataSend = {
            subject: document.getElementById('nl_subject')?.getAttribute('value') as string,
            message: document.getElementById('nl_msg_text')?.getAttribute('value') as string,
            emails: []
        };
    });//form.addEventListener('submit',(e)=>{
    cb_all.addEventListener('change',()=>{});
    cb_all_it.addEventListener('change',()=>{});
    cb_all_es.addEventListener('change',()=>{});
    cb_all_en.addEventListener('change',()=>{});

});

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
        if(fired.checked){

        }
        else{

        }
    });
    check_all_el_it.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        if(fired.checked){

        }
        else{
            
        }

    });
    check_all_el_es.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        if(fired.checked){

        }
        else{
            
        }
    });
    check_all_el_en.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        if(fired.checked){

        }
        else{
            
        }
    });
}