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
                "link" => "Per completare l'iscrizione alla newsletter fare click a <a href=\"{$link}\">questo link</a>",
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
     * Messages to add at Mail HTML template
     */
    public static function mailTemplateMessages(string $lang, array $params): array{
        $homeUrl = Properties::homeUrl();
        $privacyUrl = Properties::privacyUrl($lang);
        $contactsUrl = Properties::contactsUrl($lang);
        $unsubscribeUrl = Properties::unsubscribeUrl();
        $unsubscribeFullUrl = $unsubscribeUrl."?lang={$lang}&unsubscCode=".$params['unsubscribe_code'];
        if($lang == Langs::$langs["it"]){
            return [
                0 => 'Siamo presenti anche su questi social network',
                1 => '<div>Ricevi questa comunicazione perché ti sei iscritto/a al servizio di newsletter di <a href="'.$homeUrl.'">La filosofia di Bianca</a> con l\'indirizzo e-mail <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                2 => '<div style="margin-top: 10px;">Puoi consultare <a href="'.$privacyUrl.'" target="_blank" title="Privacy">qui</a> la nostra informativa sulla privacy.<br>Per ulteriori informazioni sui tuoi dati personali, contattaci a questo <a href="'.$contactsUrl.'" target="_blank" title="Contattaci">link</a></div>',
                3 => 'Puoi cancellare l\'iscrizione facendo <a href="'.$unsubscribeFullUrl.'" title="Cancella iscrizione" target="_blank">click qui</a>'
            ];
        }
        else if($lang == Langs::$langs["es"]){
            return [
                0 => 'También estamos presentes en estas redes sociales',
                1 => '<div>Recibe esta comunicación porque se ha suscrito al servicio de newsletter de <a href="'.$homeUrl.'">La filosofia di Bianca</a> con con la dirección de correo electrónico <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                2 => '<div style="margin-top: 10px;">Puede consultar nuestra política de privacidad <a href="'.$privacyUrl.'" target="_blank" title="Privacidad">aquí</a>.<br> Para obtener más información sobre sus datos personales, contáctenos en este <a href="'.$contactsUrl.'" target="_blank" title="Contáctenos">enlace</a></div>',
                3 => 'Puede darse de baja haciendo <a href="'.$unsubscribeFullUrl.'" title="Darse de baja" target="_blank">clic aquí</a>'
            ];
        }
        else{
            return [
                0 => 'We are also present on these social networks',
                1 => '<div>You receive this communication because you have subscribed to the <a href="'.$homeUrl.'">La filosofia di Bianca</a>\'s newsletter service with the email address <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                2 => '<div style="margin-top: 10px;">You can consult our privacy policy <a href="'.$privacyUrl.'" target="_blank" title="Privacy">here</a>.<br> For more information on your personal data, contact us at this <a href="'.$contactsUrl.'" target="_blank" title="Contact us">link</a></div>',
                3 => 'You can unsubscribe by <a href="'.$unsubscribeFullUrl.'" title="Unsubscribe" target="_blank">clicking here</a>'
            ];
        }
    }

}
?>