import axios from "axios";
import { clientPut } from "../config/axios_instances";
import { Constants } from "../namespaces/constants";
import { NlLanguages, NlPages, NlSettingsData, NlSocials } from "../types/types";

export default class UpdateSettings{

    /**
     * The languages of the available pages
     */
    private _lang_status: NlLanguages;

    /**
     * The inclusion status of the site pages attachable to the newsletter body
     */
    private _included_pages_status: NlPages;

    /**
     * The social pages link to insert in the newsletter
     */
    private _socials_status: NlSocials;

    /**
     * The social page links to be included in the newsletter
     */
    private _social_pages: NlSocials;

    /**
     * The contact page links in the declared languages
     */
    private _contact_pages: NlLanguages;

    /**
     * The privacy policy pages links in the declared languages
     */
    private _privacy_policy_pages: NlLanguages

    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Errore durante l'esecuzione della richiesta";

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/settings/updatesettings.php";

    constructor(data: NlSettingsData){
        this.assignValues(data);
    }

    get lang_status(){ return this._lang_status};
    get included_pages_status(){ return this._included_pages_status};
    get socials_status(){ return this._socials_status};
    get social_pages(){ return this._social_pages};
    get contact_pages(){ return this._contact_pages};
    get privacy_policy_pages(){ return this._privacy_policy_pages};
    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            case UpdateSettings.ERR_FETCH:
                this._error = UpdateSettings.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

    private assignValues(data: NlSettingsData): void{
        this._lang_status = data.lang_status;
        this._included_pages_status = data.included_pages_status;
        this._socials_status = data.socials_status;
        this._social_pages = data.social_pages;
        this._contact_pages = data.contact_pages;
        this._privacy_policy_pages = data.privacy_policy_pages;
    }

    public async updateSettings(): Promise<object>{
        let response: object = {}
        this._errno = 0;
        try{
            await this.updateSettingsPromise().then(res =>{
                console.log(res)
                response = JSON.parse(res)
            }).catch(err => {
                throw err;
            })
        }catch(e){
            if(e instanceof axios.AxiosError){
                const stringError: string = e.response?.data;
                response = JSON.parse(stringError);
            }
            else{
                this._errno = UpdateSettings.ERR_FETCH;
                response = {done: false, msg: this.error}
            }
        }
        return response;
    }

    private async updateSettingsPromise(): Promise<string>{
        let promise: string = await new Promise<string>((resolve,reject)=>{
            clientPut.put(UpdateSettings.FETCH_URL,{
                data: {
                    lang_status: this._lang_status,
                    included_pages_status: this._included_pages_status,
                    socials_status: this._socials_status,
                    social_pages: this._social_pages,
                    contact_pages: this._contact_pages,
                    privacy_policy_pages: this._privacy_policy_pages,
                }
            }).then(res => resolve(res.data)).catch(err => reject(err))
        })
        return promise;
    }

}