import { Constants } from "../namespaces/constants";
import { NlFormDataAdd } from "../types/types";

export class AddUserAdmin{
    private _name: string;
    private _surname: string;
    private _email: string;
    private _lang_code: string;
    private _errno: number = 0;
    private _error: string|null = null;

    private static NEWUSER_URL:string = Constants.PLUGIN_DIR+"/scripts/subscribe/admin_new_user.php";

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
}