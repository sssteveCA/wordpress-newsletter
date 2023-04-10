import { BsCdDialogData } from "../types/types";

declare const bootstrap: any;

export default class ConfirmDialog{
    private _title: string;
    private _message: string;
    private _btYesText: string;
    private _btNoText: string;
    private _html: string;
    private _instance: bootstrap.Modal;
    private _divDialog: HTMLDivElement;
    private _btYes: HTMLButtonElement;
    private _btNo: HTMLButtonElement;
    private _errno: number = 0;
    private _error: string|null;

    constructor(data: BsCdDialogData){
        this.assignValues(data);
        this.setDialogHtml();
        this.showDialog();
    }

    get title(){return this._title;} 
    get message(){return this._message;} 
    get btTYesText(){return this._btYesText;} 
    get btTNoText(){return this._btNoText;} 
    get html(){return this._html;} 
    get instance(){return this._instance;} 
    get divDialog(){return this._divDialog;} 
    get btYes(){return this._btYes;} 
    get btNo(){return this._btNo;} 
    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

    private assignValues(data: BsCdDialogData): void{
        this._title = data.title;
        this._message = data.message;
        if(data.btYesText) this._btYesText = data.btYesText;
        else this._btYesText = "SÌ";
        if(data.btNoText) this._btNoText = data.btNoText;
        else this._btNoText = "NO";
    }

    private setDialogHtml(): void{
        this._html = `
<div id="nl_confirmdialog" class="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">${this._title}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>${this._message}</p>
            </div>
            <div class="modal-footer">
              <button type="button" id="nl_cd_yes" class="btn btn-primary">${this._btYesText}</button>
              <button type="button" id="nl_cd_no" class="btn btn-secondary" data-bs-dismiss="modal">${this._btNoText}</button>
            </div>
        </div>
    </div>
</div>       
        `;
    }

    private showDialog(): void{
        this._divDialog = document.createElement('div');
        this._divDialog.setAttribute('id','nl_div_confirm_dialog');
        this._divDialog.innerHTML = this.html;
        document.body.appendChild(this._divDialog);
        let modalDiv: HTMLDivElement = document.getElementById('nl_confirmdialog') as HTMLDivElement;
        this._instance = new bootstrap.Modal(modalDiv,{
            backdrop: "static", focus: true, keyboard: false
        });
        this._instance.show();
        this._btYes = document.getElementById('nl_cd_yes') as HTMLButtonElement;
        this._btNo = document.getElementById('nl_cd_no') as HTMLButtonElement;
    }

}