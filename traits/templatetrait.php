<?php

namespace Newsletter\Traits;

use Newsletter\Classes\Properties;
use Newsletter\Enums\Langs;

/**
 * Messages used by Template class
 */
trait TemplateTrait{

   /**
     * Get the messages used in activation mail template in user language
     * @param string $lang the user language
     * @param array $params an array of values, used in the mail
     * @return array an array containing the message used in activation mail in the user language
     */
    public static  function activationMailMessages(string $lang, array $params):array {
        $code = $params['verCode'];
        $contactUrl = Properties::contactsUrl($lang);
        $link = $params['link'];
        $verifyUrl = $params['verifyUrl'];
        if($lang == Langs::$langs["it"]){
            return [
                "codeWithLink" => <<<HTML
O in alternativa fai click su <a href="{$verifyUrl}">questo link</a><br>
E incolla questo codice: {$code}
HTML,
                "link" => "Per completare l'iscrizione alla newsletter fai click a <a href=\"{$link}\">questo link</a>",
                "moreInfo" => "Per maggiori informazioni <a href=\"".$contactUrl."\">contattaci</a>",
                "title" => "Iscrizione Newsletter"
            ];
        }
        else if($lang == Langs::$langs["es"]){
            return [
                "codeWithLink" => <<<HTML
O, alternativamente, haga clic en <a href="{$verifyUrl}">este enlace</a><br>
Y pega este código: {$code}
HTML,
                "link" => "Para completar la suscripción al boletín, haga clic en <a href=\"{$link}\">este enlace</a>",
                "moreInfo" => "Para más información <a href=\"".$contactUrl."\">contáctenos</a>",
                "title" => "Suscripción al boletín informativo"
            ];
        }
        else{
            return [
                "codeWithLink" => <<<HTML
Or alternatively click on <a href="{$verifyUrl}">this link</a><br>
And paste this code: {$code}
HTML,
                "link" => "To complete the newsletter subscription click on <a href=\"{$link}\">this link</a>",
                "moreInfo" => "For more information <a href=\"".$contactUrl."\">contact us</a>",
                "title" => "Newsletter subscription"
            ];
        }
    }

    /**
     * Get the activation mail <title> tag content
     * @param string $lang the user language
     * @return  string the activation mail <title> tag content
     */
    public static function activationMailTitle(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Iscrizione Newsletter";
        }
        else if($lang == Langs::$langs["es"]){
            return "Suscripción al boletín informativo";
        }
        else{
            return "Newsletter subscription"; 
        }
    }

    /**
     * Get the messages used in the admin user add message
     * @param string $lang the user language
     * @param array $params an array of values used in this mail
     * @return array an array containing the messages used in add user admin mail in user language
     */
    public static function addUserAdminMessages(string $lang, array $params): array{
        $contactUrl = Properties::contactsUrl($lang);
        $homeUrl = Properties::homeUrl();
        $newsletterName = Properties::newsletterName();
        if($lang == Langs::$langs["it"]){
            return [
                "added" => "Sei stato aggiunto alla newsletter '{$newsletterName}'",
                "moreInfo" => "Se pensi che sia stato fatto per errore scrivi una mail sulla nostra <a href=\"{$contactUrl}\">pagina dei contatti</a>",
                "moreInfoMail" => "oppure puoi scrivere direttamente a <a href=\"{$params['from']}\">{$params['from']}</a>",
                "receive" => "Da questo momento riceverai periodicamente delle mail da questo sito <a href=\"{$homeUrl}\">{$homeUrl}</a>",
                "title" => "Nuovo iscritto alla newsletter '{$newsletterName}'"
            ];
        }
        else if($lang == Langs::$langs["es"]){
            return [
                "added" => "Has sido añadido al boletín '{$newsletterName}'",
                "moreInfo" => "Si cree que se hizo por error, escriba un correo electrónico en nuestra <a href=\"{$contactUrl}\">página de contacto</a>",
                "moreInfoMail" => "o puedes escribir directamente a <a href=\"{$params['from']}\">{$params['from']}</a>",
                "receive" => "A partir de ahora recibirás periódicamente correos electrónicos de este sitio <a href=\"{$homeUrl}\">{$homeUrl}</a>",
                "title" => "Nuevo suscriptor del boletín '{$newsletterName}'"
            ];
        }
        else{
            return [
                "added" => "You have been added to the newsletter '{$newsletterName}'",
                "moreInfo" => "f you think it was done by mistake write an email on our <a href=\"{$contactUrl}\">contact page</a>",
                "moreInfoMail" => "or you can write directly to <a href=\"{$params['from']}\">{$params['from']}</a>",
                "receive" => "From now on you will periodically receive emails from this site <a href=\"{$homeUrl}\">{$homeUrl}</a>",
                "title" => "New '{$newsletterName}' newsletter subscriber"
            ];
        }
    }

    /**
     * Get the messages used in the delete user notification message
     * @param string $lang the user language
     * @param array $params an array of values used in this mail
     * @return array an array containing the messages used in delete user mail in the user language
     */
    public static function deleteUserMessages(string $lang, array $params): array{
        $contactUrl = Properties::contactsUrl($lang);
        $newsletterName = Properties::newsletterName();
        if($lang == Langs::$langs["it"]){
            return [
                "moreInfo" => "Se pensi che sia stato fatto per errore scrivi una mail sulla nostra <a href=\"{$contactUrl}\">pagina dei contatti</a>",
                "moreInfoMail" => "oppure puoi scrivere direttamente a <a href=\"{$params['from']}\">{$params['from']}</a>",
                "removed" => "L'amministratore ti ha rimosso dalla newsletter '{$newsletterName}'.",
                "title" => "Cancellazione utente"
            ];
        }
        else if($lang == Langs::$langs["es"]){
            return [
                "moreInfo" => "Si cree que se hizo por error, escriba un correo electrónico en nuestra <a href=\"{$contactUrl}\">página de contacto</a>",
                "moreInfoMail" => "o puedes escribir directamente a <a href=\"{$params['from']}\">{$params['from']}</a>",
                "removed" => "El administrador te ha eliminado del boletín '{$newsletterName}'.",
                "title" => "Eliminación del usuario"
            ];
        }
        else{
            return [
                "moreInfo" => "If you think it was done by mistake write an email on our <a href=\"{$contactUrl}\">contact page</a>",
                "moreInfoMail" => "or you can write directly to <a href=\"{$params['from']}\">{$params['from']}</a>",
                "removed" => "The administrator has removed you from the '{$newsletterName}' newsletter.",
                "title" => "User deletion"
            ];
        }
    }

    /**
     * Messages to add at Mail HTML template
     * @param string $lang the user language
     * @param array $params array of values used to build these messages
     * @return array an array of message to use in mail Template in user language
     */
    public static function mailTemplateMessages(string $lang, array $params): array{
        $homeUrl = Properties::homeUrl();
        $privacyUrl = Properties::privacyUrl($lang);
        $contactsUrl = Properties::contactsUrl($lang);
        $unsubscribeUrl = Properties::unsubscribeUrl();
        $unsubscribeFullUrl = $unsubscribeUrl."?lang={$lang}&unsubscCode=".$params['unsubscribe_code'];
        if($lang == Langs::$langs["it"]){
            return [
                'socials_message' => 'Siamo presenti anche su questi social network',
                'subscriber_message' => '<div>Ricevi questa comunicazione perché ti sei iscritto/a al servizio di newsletter di <a href="'.$homeUrl.'">La filosofia di Bianca</a> con l\'indirizzo e-mail <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                'privacy_policy_page' => '<div style="margin-top: 10px;">Puoi consultare <a href="'.$privacyUrl.'" target="_blank" title="Privacy">qui</a> la nostra informativa sulla privacy.',
                'contacts_page' => 'Per ulteriori informazioni sui tuoi dati personali, contattaci a questo <a href="'.$contactsUrl.'" target="_blank" title="Contattaci">link</a></div>',
                'unsubscribe_message' => 'Puoi cancellare l\'iscrizione facendo <a href="'.$unsubscribeFullUrl.'" title="Cancella iscrizione" target="_blank">click qui</a>'
            ];
        }
        else if($lang == Langs::$langs["es"]){
            return [
                'socials_message' => 'También estamos presentes en estas redes sociales',
                'subscriber_message' => '<div>Recibe esta comunicación porque se ha suscrito al servicio de newsletter de <a href="'.$homeUrl.'">La filosofia di Bianca</a> con con la dirección de correo electrónico <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                'privacy_policy_page' => '<div style="margin-top: 10px;">Puede consultar nuestra política de privacidad <a href="'.$privacyUrl.'" target="_blank" title="Privacidad">aquí</a>.',
                'contacts_page' => 'Para obtener más información sobre sus datos personales, contáctenos en este <a href="'.$contactsUrl.'" target="_blank" title="Contáctenos">enlace</a></div>',
                'unsubscribe_message' => 'Puede darse de baja haciendo <a href="'.$unsubscribeFullUrl.'" title="Darse de baja" target="_blank">clic aquí</a>'
            ];
        }
        else{
            return [
                'socials_message' => 'We are also present on these social networks',
                'subscriber_message' => '<div>You receive this communication because you have subscribed to the <a href="'.$homeUrl.'">La filosofia di Bianca</a>\'s newsletter service with the email address <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                'privacy_policy_page' => '<div style="margin-top: 10px;">You can consult our privacy policy <a href="'.$privacyUrl.'" target="_blank" title="Privacy">here</a>.',
                'contacts_page' => 'For more information on your personal data, contact us at this <a href="'.$contactsUrl.'" target="_blank" title="Contact us">link</a></div>',
                'unsubscribe_message' => 'You can unsubscribe by <a href="'.$unsubscribeFullUrl.'" title="Unsubscribe" target="_blank">clicking here</a>'
            ];
        }
    }

}
?>