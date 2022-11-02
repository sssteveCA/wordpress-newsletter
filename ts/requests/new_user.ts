import { NlFormData } from "../types/types";

export class NewUser{
    private _name: string|null;
    private _surname: string|null;
    private _email: string;
    private _cb_privacy: string;
    private _cb_terms: string;
    private _lang: string;

    constructor(data: NlFormData){

    }

    get name(){ return this._name; }
    get surname(){ return this._surname; }
    get email(){ return this._email; }
    get cb_privacy(){ return this._cb_privacy; }
    get cb_terms(){ return this._cb_terms; }
    get lang(){ return this._lang; }

}