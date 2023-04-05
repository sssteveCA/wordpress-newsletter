
export type BsCdDialogData = {
    title: string;
    message: string;
    btYesText?: string;
    btNoText?: string;
}

export type BsMdDialogData = {
    title: string;
    message: string;
    btOkText?: string;
}

/**
 * Single subscriber getted from subscribers array (with getsubscribers.php)
 */
export type GetSubscriber = {
    email: string;
    lang: string;
}

export type NlFormData = {
    name?: string;
    surname?: string;
    email: string;
    cb_privacy: string;
    cb_terms: string;
    lang: string;
};

export type NlFormDataElements = {
    name: HTMLInputElement;
    surname: HTMLInputElement;
    email: HTMLInputElement;
    cb_privacy: HTMLInputElement;
    cb_terms: HTMLInputElement;
    lang: HTMLInputElement;
    bt_submit: HTMLButtonElement;
}

export type NlFormDataAdd = {
    name?: string;
    surname?: string;
    email: string;
    lang_code: string;
};

export type NlFormDataDelete = {
    emails: string[];
}

export type NlFormDataSend = {
    subject: string;
    message: string;
    emails: string[];
};

export type NlUnsubscribeUserData = {
    lang?: string;
    unsubscribe_code: string;
}