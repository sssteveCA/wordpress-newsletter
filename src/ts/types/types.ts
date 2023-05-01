
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

export type NlFormDataSettings = {
    form: HTMLFormElement,
    container_pages_enabled: HTMLDivElement,
    cb_pages_enabled: {
        contacts_pages: HTMLInputElement,
        privacy_policy_pages: HTMLInputElement,
    },
    container_langs: HTMLDivElement,
    cb_langs: {
        lang_it: HTMLInputElement,
        lang_es: HTMLInputElement,
        lang_en: HTMLInputElement,
    },
    cb_social: {
        facebook: HTMLInputElement,
        instagram: HTMLInputElement,
        youtube: HTMLInputElement,
    },
    row_social_links: HTMLDivElement,
    input_social_links: {
        facebook: HTMLInputElement,
        instagram: HTMLInputElement,
        youtube: HTMLInputElement, 
    },
    container_contacts_pages: HTMLDivElement,
    input_contacts_pages: {
        lang_it: HTMLInputElement,
        lang_es: HTMLInputElement,
        lang_en: HTMLInputElement,
    },
    container_privacy_pages: HTMLDivElement,
    input_privacy_policy_pages: {
        lang_it: HTMLInputElement,
        lang_es: HTMLInputElement,
        lang_en: HTMLInputElement,
    }
}

export type NlUnsubscribeUserData = {
    lang?: string;
    unsubscribe_code: string;
}