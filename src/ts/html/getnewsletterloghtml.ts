import { NlGetNewsletterLogHtml, NlLogItem } from "../types/types";

export default class GetNewsletterLogHtml{

    private _table_container: HTMLDivElement;
    private _loginfo: NlLogItem[] = [];
    private _errno: number = 0;
    private _error: string|null = null;

    constructor(data: NlGetNewsletterLogHtml){
        this._loginfo = data.log_info;
        this._table_container = data.table_container;
        this.setHtml();
    }

    get loginfo(){ return this._loginfo; }
    get errno(){ return this._errno; }
    get error(){ return this._error; }

    private setHtml(): void{
        let html: string = `
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">OGGETTO</th>
            <th scope="col">DESTINATARIO</th>
            <th scope="col">DATA</th>
        </tr>
    </thead>
    <tbody>
        `;
        html += this._loginfo.reduce((accumulator,currentValue) => {
            return `${accumulator}
        <tr>
            <td>${currentValue.subject}</td><td>${currentValue.recipient}</td><td>${currentValue.date}</td>
        </tr>     
            `;
        },'')
        html += `
    </tbody>
</table>
        `;
        this._table_container.innerHTML = html;
    }



}