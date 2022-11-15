import { Constants } from "../namespaces/constants";
import { NlFormDataDelete } from "../types/types";

export default class DeleteUsers{
    private _emails: string[];
    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Errore durante l'invio della mail";

    private static FETCH_URL: string = Constants.HOME_URL+Constants.PLUGIN_DIR+"/scripts/subscribe/delete_user.php";

    constructor(data: NlFormDataDelete){
        this._emails = data.emails;
    }

    get emails(){ return this._emails; }
    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            case DeleteUsers.ERR_FETCH:
                this._error = DeleteUsers.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }
}