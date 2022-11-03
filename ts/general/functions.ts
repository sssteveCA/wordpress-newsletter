import MessageDialog from "../dialogs/messagedialog";
import { BsMdDialogData } from "../types/types";

export function messageDialog(md_data: BsMdDialogData): void{
    let md: MessageDialog = new MessageDialog(md_data);
    md.btOk.addEventListener('click',()=>{
        md.instance.dispose();
        md.divDialog.remove();
        document.body.style.overflow = 'auto';
    });
}