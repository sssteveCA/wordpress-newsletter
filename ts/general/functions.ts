import MessageDialog from "../dialogs/messagedialog.js";
import { BsMdDialogData } from "../types/types.js";

export function messageDialog(md_data: BsMdDialogData): void{
    let md: MessageDialog = new MessageDialog(md_data);
    md.btOk.addEventListener('click',()=>{
        md.instance.dispose();
        md.divDialog.remove();
        document.body.style.overflow = 'auto';
    });
}