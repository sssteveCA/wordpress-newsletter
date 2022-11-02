import { NlFormData } from "../types/types";
import axios from "../../node_modules/axios/index";
import { Constants } from "../namespaces/constants";
import { clientPost } from "../config/axios_instances";

export class NewUser{
    private _name: string|null;
    private _surname: string|null;
    private _email: string;
    private _cb_privacy: string;
    private _cb_terms: string;
    private _lang: string;
    private _errno: number = 0;
    private _error: string|null = null;

    private static NEWUSER_URL:string = Constants.PLUGIN_DIR+"/scripts/subscribe/new_user.php";

    public static ERR_FETCH: number = 1;
    private static ERR_FETCH_MSG:string = "Errore durante l'esecuzione della richiesta";


    constructor(data: NlFormData){
        this.assignValues(data);
    }

    get name(){ return this._name; }
    get surname(){ return this._surname; }
    get email(){ return this._email; }
    get cb_privacy(){ return this._cb_privacy; }
    get cb_terms(){ return this._cb_terms; }
    get lang(){ return this._lang; }
    get errno(){ return this._errno; }
    get error(){
        switch(this._errno){
            case NewUser.ERR_FETCH:
                this._error = NewUser.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
        }
        return this._error;
    }

    private assignValues(data: NlFormData): void{
        if(data.name) this._name = data.name;
        if(data.surname) this._surname = data.surname;
        this._email = data.email;
        this._cb_privacy = data.cb_privacy;
        this._cb_terms = data.cb_terms;
        this._lang = data.lang;
    }

    public async newUser(): Promise<object>{
        let response: object = {};
        this._errno = 0;
        try{
            await this.newUserPromise().then(res => {
                console.log(res);
            }).catch(err => {
                throw err;
            });
        }catch(e){
            this._errno = NewUser.ERR_FETCH;
        }
        return response;
    }

    private async newUserPromise(): Promise<string>{
        return await new Promise<string>((resolve,reject)=>{
            clientPost.post(NewUser.NEWUSER_URL,{
                name: this._name, surname: this._surname, email: this._email, cb_privacy: this._cb_privacy, 
                cb_terms: this._cb_terms, lang: this._lang
            }).then(res => {
                resolve(res.data);
            }).catch(err => {
                reject(err);
            })
        });
    }

}