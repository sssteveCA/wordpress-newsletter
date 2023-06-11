import { Constants } from "../namespaces/constants";
import { NlGetNewsletterLogHtml, NlLogItem } from "../types/types";

export default class GetNewsletterLogHtml{

    private _table_container: HTMLDivElement;
    private _loginfo: NlLogItem[] = [];
    private _response: object;
    private _errno: number = 0;
    private _error: string|null = null;

    constructor(data: NlGetNewsletterLogHtml){
        this._response = data.response;
        this._table_container = data.table_container;
        if(this._response[Constants.KEY_DONE]) this.setHtml();
        else this.setMessage();
    }

    get loginfo(){ return this._loginfo; }
    get errno(){ return this._errno; }
    get error(){ return this._error; }

    /**
     * Create a table when the response is successful
     */
    private setHtml(): void{
        this._loginfo = this._response['loginfo']
        let html: string = `
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">OGGETTO</th>
            <th scope="col">DESTINATARIO</th>
            <th scope="col">DATA</th>
            <th scope="col">INVIATA</th>
        </tr>
    </thead>
    <tbody>
        `;
        html += this._loginfo.reduce((accumulator,currentValue) => {
            const sended: string = currentValue.sended ? 'SÌ' : 'NO'
            return `${accumulator}
        <tr>
            <td>${currentValue.subject}</td><td>${currentValue.recipient}</td><td>${currentValue.date}</td><td>${sended}</td>
        </tr>     
            `;
        },'')
        html += `
    </tbody>
</table>
        `;
        this._table_container.innerHTML = html;
    }

    /**
     * Create a table when the response is successful
     */
    private setMessage(): void{
        const div = document.createElement('div')
        div.classList.add('col-12','text-center','fw-bold','fs-4','mt-3','ms-2')
        div.style.color = 'red'
        div.innerHTML = this._response[Constants.KEY_MESSAGE]
        this._table_container.appendChild(div)
    }



}