
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


}