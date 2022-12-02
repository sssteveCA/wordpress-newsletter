import { NlFormData } from "../types/types.js";
import { Constants } from "../namespaces/constants.js";
import { clientPost } from "../config/axios_instances.js";
import axios from "../../node_modules/axios/index.js";

export class NewUser{
    private _name: string|null;
    private _surname: string|null;
    private _email: string;
    private _cb_privacy: string;
    private _cb_terms: string;
    private _lang: string;
    private _errno: number = 0;
    private _error: string|null = null;

    private static NEWUSER_URL:string = Constants.HOME_URL+Constants.PLUGIN_DIR+"/scripts/subscribe/new_user.php";

    public static ERR_FETCH: number = 1;
    public static ERR_INVALID_DATA: number = 2;

    private static ERR_FETCH_MSG:string = "Errore durante l'esecuzione della richiesta. Se il problema persiste contattare l'amministratore del sito";
    private static ERR_INVALID_DATA_MSG:string = "Inserisci i dati richiesti e accetta le condizioni per continuare";

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
            case NewUser.ERR_INVALID_DATA:
                this._error = NewUser.ERR_INVALID_DATA_MSG;
                break;
            default:
                this._error = null;
                break;
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
        if(this.validate()){
            try{
                await this.newUserPromise().then(res => {
                    //console.log(res);
                    let rJson: object = JSON.parse(res);
                    response = { done: rJson['done'], msg: rJson['msg'] }
                }).catch(err => {
                    throw err;
                });
            }catch(e){
                console.warn(e);
                if(e instanceof axios.AxiosError){
                    const stringError: string = e.response?.data;
                    response = JSON.parse(stringError);
                }
                else{
                  this._errno = NewUser.ERR_FETCH;
                    response = { done: false, msg: this.error };  
                }
            }
        }//if(this.validate()){
        else{
            this._errno = NewUser.ERR_INVALID_DATA;
            response = { done: false, msg: this.error };
        }
        return response;
    }

    private async newUserPromise(): Promise<string>{
        return await new Promise<string>((resolve,reject)=>{
            let postData: NlFormData = {
                name: this._name as string, surname: this._surname as string, email: this._email, cb_privacy: this._cb_privacy, 
                cb_terms: this._cb_terms, lang: this._lang
            };
            /* console.log("new_user.ts newUserPromise postData => ");
            console.log(postData); */
            clientPost.post(NewUser.NEWUSER_URL,postData).then(res => {
                resolve(res.data);
            }).catch(err => {
                reject(err);
            })
        });
    }

    private validate(): boolean{
        if(this._email == '') return false;
        if(this._cb_privacy != '1') return false;
        if(this._cb_terms != '1') return false;
        return true;
    }

}