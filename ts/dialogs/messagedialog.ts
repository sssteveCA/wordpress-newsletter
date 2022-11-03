
import { Modal } from "bootstrap";
import { BsDialogData } from "../types/types";


export default class MessageDialog{
    private _title: string;
    private _message: string;
    private _btOkText: string;
    private _html: string;
    private _instance: Modal;
    private _divDialog: HTMLDivElement;
    private _btOk: HTMLButtonElement;
    private _errno: number = 0;
    private _error: string|null;

    constructor(data: BsDialogData){
        this.assignValues(data);
        this.setDialogHtml();
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

    private assignValues(data: BsDialogData): void{
        this._title = data.title;
        this._message = data.message;
        if(data.btOkText) this._btOkText = data.btOkText;
        else this._btOkText = "OK";

    }

    private setDialogHtml(): void{
        this._html = `
<div id="nl_messagedialog" class="modal" tabindex="-1">
    <div class="modal-dialog">
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


}