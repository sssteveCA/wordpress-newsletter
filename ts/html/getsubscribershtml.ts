import { GetSubscriber } from "../types/types";

export interface GetSubscribersHtmlInterface{
    subscribers: GetSubscriber[];
}

/**
 * Print the HTML table with the obtained subscribers list
 */
export class GetSubscribersHtml{

    private _subscribers: GetSubscriber[];
    private _table: string = "";

    constructor(data: GetSubscribersHtmlInterface){
        this._subscribers = data.subscribers;
    }

    get subscribers(){return this._subscribers;}
    get table(){return this._table;}

}