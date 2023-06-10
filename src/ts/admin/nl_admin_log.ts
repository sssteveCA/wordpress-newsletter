import GetNewsletterLogHtml from "../html/getnewsletterloghtml";
import { Constants } from "../namespaces/constants";
import DeleteNewsletterLog from "../requests/delete_newsletter_log";
import GetNewsletterLog from "../requests/get_newsletter_log"
import { NlGetNewsletterLogHtml } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    const table_container: HTMLDivElement = document.getElementById('nl_table_container') as HTMLDivElement
    const log_delete_response: HTMLDivElement = document.getElementById('nl_log_delete_response') as HTMLDivElement
    const spinner: HTMLDivElement = document.getElementById('nl_delete_log_spinner') as HTMLDivElement
    const bt_log_delete: HTMLButtonElement = document.getElementById('nl_log_bt_delete') as HTMLButtonElement
    const gnl: GetNewsletterLog = new GetNewsletterLog();
    gnl.getNewsletterLog().then(obj => {
        const nlh_data: NlGetNewsletterLogHtml = {
            response: obj, table_container: table_container
        }
        const nlh: GetNewsletterLogHtml = new GetNewsletterLogHtml(nlh_data)
    })
    bt_log_delete.addEventListener('click',()=>{
        log_delete_response.innerHTML = ''
        spinner.classList.remove('invisible')
        const dnl: DeleteNewsletterLog = new DeleteNewsletterLog()
        dnl.deleteNewsletterLog().then(obj => {
            spinner.classList.add('invisible')
            if(obj[Constants.KEY_DONE]){
                log_delete_response.style.color = 'green'
                table_container.innerHTML = ''
            } 
            else log_delete_response.style.color = 'red'
            log_delete_response.innerHTML = obj[Constants.KEY_MESSAGE]
        })
    })
})