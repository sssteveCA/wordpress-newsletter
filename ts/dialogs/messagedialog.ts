
import { BsMdDialogData } from "../types/types.js";


export default class MessageDialog{
    private _title: string;
    private _message: string;
    private _btOkText: string;
    private _html: string;
    private _instance: bootstrap.Modal;
    private _divDialog: HTMLDivElement;
    private _btOk: HTMLButtonElement;
    private _errno: number = 0;
    private _error: string|null;

    constructor(data: BsMdDialogData){
        this.assignValues(data);
        this.setDialogHtml();
        this.showDialog();
    }

    get title(){return this._title;} 
    get message(){return this._message;} 
    get btOkText(){return this._btOkText;} 
    get html(){return this._html;} 
    get instance(){return this._instance;} 
    get divDialog(){return this._divDialog;} 
    get btOk(){return this._btOk;} 
    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

    private assignValues(data: BsMdDialogData): void{
        this._title = data.title;
        this._message = data.message;
        if(data.btOkText) this._btOkText = data.btOkText;
        else this._btOkText = "OK";

    }

    private setDialogHtml(): void{
        this._html = `
<div id="nl_messagedialog" class="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">${this._title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="nl_messagedialog" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>${this._message}</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="nl_md_ok" class="btn btn-secondary" data-bs-dismiss="modal">${this._btOkText}</button>
            </div>
        </div>
    </div>
</div>       
        `;
    }

    private showDialog(): void{
        this._divDialog = document.createElement('div');
        this._divDialog.setAttribute('id','nl_div_message_dialog');
        this._divDialog.innerHTML = this._html;
        document.body.appendChild(this._divDialog);
        let modalDiv: HTMLDivElement = document.getElementById('nl_messagedialog') as HTMLDivElement;
        this._instance = new bootstrap.Modal(modalDiv,{
            backdrop: "static", focus: true, keyboard: false
        });
        this._instance.show();
        this._btOk = document.getElementById('nl_md_ok') as HTMLButtonElement;
    }
}