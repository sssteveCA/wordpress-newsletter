import GetNewsletterLog from "../requests/get_newsletter_log"

window.addEventListener('DOMContentLoaded',()=>{
    const table_container: HTMLDivElement = document.getElementById('nl_table_container') as HTMLDivElement
    const gnl: GetNewsletterLog = new GetNewsletterLog();
    gnl.getNewsletterLog();
})