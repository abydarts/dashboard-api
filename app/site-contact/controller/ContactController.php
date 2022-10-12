<?php
/**
 * ContactController
 * @package site-contact
 * @version 0.0.1
 */

namespace SiteContact\Controller;

use LibMailer\Library\Mailer;
use SiteContact\Meta\Contact as Meta;
use LibForm\Library\Form;
use Contact\Library\Contact;
use LibRecaptcha\Library\Validator;

class ContactController extends \Site\Controller
{

    public function contactAction() {
        $form = new Form('site-contact');

        $params = [
            'meta'    => Meta::single(),
            'form'    => $form,
            'error'   => null,
            'success' => null
        ];

        if(!is_null($fields = $form->validate())){
//            if(module_exists('lib-recaptcha')){
//                $token = $this->req->getPost('secure');
//                if(is_null(Validator::validate($token))){
//                    $params['error'] = 'Invalid Credentials';
//                    $this->res->render('contact/single', $params);
//                    return $this->res->send();
//                }
//            }

            if(!Contact::add((array)$fields)){
                $params['error'] = Contact::$last_error;
                $this->res->render('contact/single', $params);
                return $this->res->send();
            }

            $options = [
                'from' => [
                    'name' => $fields->fullname,
                    'email' => $fields->email,
                ],
                'to' => [
                    [
                        'name' => 'IFeL Sponsorship',
                        'email' => $this->setting->contact_email,
                    ]
                ],
                'subject' => "Request Sponsorship ".$fields->subject,
                'text' => $fields->content,
            ];
            if(!Mailer::send($options))
                die(Mailer::getError());

            $params['success'] = true;
        }

        $this->res->render('contact/single', $params);
        $this->res->send();
    }
}