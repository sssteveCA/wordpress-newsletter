import { NlGetNewsletterLogHtml, NlLogItem } from "../types/types";

export default class GetNewsletterLogHtml{

    private _table_container: HTMLDivElement;
    private _loginfo: NlLogItem[] = [];
    private _errno: number = 0;
    private _error: string|null = null;

    constructor(data: NlGetNewsletterLogHtml){
        this._loginfo = data.log_info;
        this._table_container = data.table_container;
    }

    get loginfo(){ return this._loginfo; }
    get errno(){ return this._errno; }
    get error(){ return this._error; }



}