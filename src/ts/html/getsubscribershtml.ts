import { GetSubscriber } from "../types/types";

export interface GetSubscribersHtmlInterface{
    containerId: string;
    subscribers: GetSubscriber[];
}

/**
 * Print the HTML table with the obtained subscribers list
 */
export class GetSubscribersHtml{

    private _containerId: string;
    private _subscribers: GetSubscriber[];
    private _table: string = "";

    constructor(data: GetSubscribersHtmlInterface){
        this._containerId = data.containerId;
        this._subscribers = data.subscribers;
        this.setTable();
    }

    get containerId(){return this._containerId;}
    get subscribers(){return this._subscribers;}
    get table(){return this._table;}

    private attach(): void{
        let container: HTMLDivElement = document.getElementById(this._containerId) as HTMLDivElement;
        if(container){
            container.innerHTML = this._table;
        }
    }

    private setTable(): void{
        if(this._subscribers.length > 0){
            this._table += `
<table class="table table-striped">
    <thead>
        <th scope="col"></th>
        <th scope="col">EMAIL</th>
        <th scope="col">LINGUA</th>
    </thead>
    <tbody>
`;
            this._table += this.tableBody();
            this._table += `
    </tbody>
</table>
        `;
        }//if(this._subscribers.length > 0){
        else{
            this._table = `<p class="text-center fs-4 fw-bold">Nessun utente iscritto alla newsletter</p>`;
        }
        this.attach();
    }

    private tableBody(): string {
        let tbody: string = ``;
        this._subscribers.forEach(subscriber => {
            tbody += `
<tr>
    <td><input type="checkbox" class="form-check-input"></td>
    <td>${subscriber.email}</td>
    <td>${subscriber.lang}</td>
</tr>
            `;
        });
        return tbody;
    }




}