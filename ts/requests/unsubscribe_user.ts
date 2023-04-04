import { NlUnsubscribeUserData } from "../types/types";
import { Languages } from "../enums/enums";
import { Constants } from "../namespaces/constants";
import { Messages } from "../namespaces/messages";

export class UnsubscribeUser{

    private _lang: string;
    private _unsubscribe_code: string;
    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = Messages.ERR_UNSUBSCRIBE_USER;

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/subscribe/delete_user.php";

    constructor(data: NlUnsubscribeUserData){
        if(data.lang)
            this._lang = data.lang;
        else
            this._lang = Languages.EN;
        this._unsubscribe_code = data.unsubscribe_code;
    }

    get lang(){ return this._lang}
    get unsubscribe_code(){ return this._unsubscribe_code}
    get errno(){ return this._errno; }
    get error(){
        switch(this._errno){
            case UnsubscribeUser.ERR_FETCH:
                this._error = UnsubscribeUser.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }
}