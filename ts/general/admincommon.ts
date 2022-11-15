
/**
 * Get the emails that has checkbox checked 
 * @returns the checked emails list
 */
 export function checkedEmailsList(idContainer: string): string[]{
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
export function emailSelection(idContainer: string): void{
    let check_all_el: HTMLInputElement = document.getElementById('nl_check_all') as HTMLInputElement;
    let check_all_el_it: HTMLInputElement = document.getElementById('nl_check_all_it') as HTMLInputElement;
    let check_all_el_es: HTMLInputElement = document.getElementById('nl_check_all_es') as HTMLInputElement;
    let check_all_el_en: HTMLInputElement = document.getElementById('nl_check_all_en') as HTMLInputElement;
    check_all_el.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        selectEmails(idContainer,fired.id,fired.checked);
    });
    check_all_el_it.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        selectEmails(idContainer,fired.id,fired.checked);
    });
    check_all_el_es.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        selectEmails(idContainer,fired.id,fired.checked);
    });
    check_all_el_en.addEventListener('change',(e)=>{
        let fired: HTMLInputElement = e.currentTarget as HTMLInputElement;
        selectEmails(idContainer,fired.id,fired.checked);
    });
}

/**
 * Check checkbox in emails list box when a checkbox of email select group is checked
 */
export function selectEmails(idContainer: string, idSelected: string, checked: boolean): void{
    console.log(idSelected);
    console.log(checked);
    let checkgroup: string = "";
    if(idSelected == 'nl_check_all_it'){checkgroup = "it";}
    if(idSelected == 'nl_check_all_es'){checkgroup = "es";}
    if(idSelected == 'nl_check_all_en'){checkgroup = "en";}
    let trTable = document.querySelectorAll(`#${idContainer} table tbody tr`);
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