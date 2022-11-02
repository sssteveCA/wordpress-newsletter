import { NlFormData } from "../types/types";

export class NewUser{
    private _name: string|null;
    private _surname: string|null;
    private _email: string;
    private _cb_privacy: string;
    private _cb_terms: string;
    private _lang: string;

    constructor(data: NlFormData){
        this.assignValues(data);
    }

    get name(){ return this._name; }
    get surname(){ return this._surname; }
    get email(){ return this._email; }
    get cb_privacy(){ return this._cb_privacy; }
    get cb_terms(){ return this._cb_terms; }
    get lang(){ return this._lang; }

    private assignValues(data: NlFormData): void{
        if(data.name) this._name = data.name;
        if(data.surname) this._surname = data.surname;
        this._email = data.email;
        this._cb_privacy = data.cb_privacy;
        this._cb_terms = data.cb_terms;
        this._lang = data.lang;
    }

}