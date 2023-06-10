import GetNewsletterLogHtml from "../html/getnewsletterloghtml";
import { Constants } from "../namespaces/constants";
import GetNewsletterLog from "../requests/get_newsletter_log"
import { NlGetNewsletterLogHtml } from "../types/types";

window.addEventListener('DOMContentLoaded',()=>{
    const table_container: HTMLDivElement = document.getElementById('nl_table_container') as HTMLDivElement
    const gnl: GetNewsletterLog = new GetNewsletterLog();
    gnl.getNewsletterLog().then(obj => {
        if(obj[Constants.KEY_DONE]){
            const nlh_data: NlGetNewsletterLogHtml = {
                log_info: obj['loginfo'], table_container: table_container
            }
            const nlh: GetNewsletterLogHtml = new GetNewsletterLogHtml(nlh_data)
        }
    })
})