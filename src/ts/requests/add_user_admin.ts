import axios from 'axios';
import { clientPost } from "../config/axios_instances";
import { Constants } from "../namespaces/constants";
import { NlFormDataAdd } from "../types/types";

export class AddUserAdmin{
    private _name: string;
    private _surname: string;
    private _email: string;
    private _lang_code: string;
    private _errno: number = 0;
    private _error: string|null = null;

    private static ADDUSER_URL:string = Constants.PLUGIN_DIR+"/scripts/browser/subscribe/admin_new_user.php";

    public static ERR_FETCH: number = 1;
    private static ERR_FETCH_MSG:string = "Errore durante l'esecuzione della richiesta.";

    constructor(data: NlFormDataAdd){
        this.assignValues(data);
    }

    get name(){return this._name;}
    get surname(){return this._surname;}
    get email(){return this._email;}
    get lang_code(){return this._lang_code;}
    get errno(){ return this._errno; }
    get error(){
        switch(this._errno){
            case AddUserAdmin.ERR_FETCH:
                this._error = AddUserAdmin.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

    private assignValues(data: NlFormDataAdd): void{
        if(data.name) this._name = data.name;
        if(data.surname) this._surname = data.surname;
        this._email = data.email;
        this._lang_code = data.lang_code;
    }

    public async addUser(): Promise<object>{
        this._errno = 0;
        let response: object = {};
        try{
            await this.addUserPromise().then(res => {
                //console.log(res);
                response = JSON.parse(res);
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
                this._errno = AddUserAdmin.ERR_FETCH;
                response = { done: false, msg: this.error }
            } 
        }
        return response;
    }

    private async addUserPromise(): Promise<string>{
        return await new Promise<string>((resolve, reject)=>{
            let postData: NlFormDataAdd = {
                name: this._name, surname: this._surname, email: this._email, lang_code: this._lang_code
            };
            clientPost.post(AddUserAdmin.ADDUSER_URL, postData).then(res =>{
                resolve(res.data);
            }).catch(err => {
                reject(err);
            })
        });
    }
}