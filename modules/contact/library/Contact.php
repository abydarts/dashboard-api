<?php
/**
 * Contact
 * @package contact
 * @version 0.0.1
 */

namespace Contact\Library;

use Contact\Model\Contact as _Contact;
use LibMailer\Library\Mailer;
use LibFormatter\Library\Formatter;

class Contact
{
    static $last_error;

    /**
     * Add new contact object
     * @param object $contact
     *  - fullname
     *  - email
     *  - subject
     *  - content
     */
    static function add(array $contact): ?object {
        $contact['ip'] = \Mim::$app->req->getIP();
        
        $id = _Contact::create($contact);
        if(!$id)
            return null;

        $contact = _Contact::getOne(['id'=>$id]);

        // send email to admin
        if(!\Mim::$app->setting->contact_admin_email)
            return $contact;

        $xcontact = Formatter::format('contact', clone $contact);

        $params = [
            'contact' => $xcontact,
            'next'    => ''
        ];

        $reply_route = \Mim::$app->config->contact->replyRoute ?? null;
        if($reply_route)
            $params['next'] = \Mim::$app->router->to($reply_route, (array)$contact);

        $mail = [
            'to' => [
                [
                    'name' => 'Administrator',
                    'email' => \Mim::$app->setting->contact_admin_email
                ]
            ],
            'subject' => 'New Contact From ' . $xcontact->fullname . ' : ' . $xcontact->subject,
            'text' => $xcontact->content->safe,
            'view' => [
                'path' => 'contact/admin',
                'params' => $params
            ]
        ];

        if(!Mailer::send($mail)){
            self::$last_error = Mailer::getError();
            return null;
        }

        return $contact;
    }

    /**
     * Add reply to a contact
     * @param object $contact
     * @param object $reply
     *  - user
     *  - reply
     */
    static function reply(object $contact, array $reply): ?object {
        $reply['replyed'] = date('Y-m-d H:i:s');

        if(!_Contact::set($reply, ['id'=>$contact->id]))
            return null;

        // send email to the contact
        $contact = _Contact::getOne(['id'=>$contact->id]);

        $xcontact = Formatter::format('contact', clone $contact);
        $params = [
            'contact' => $xcontact
        ];

        $mail = [
            'to' => [
                [
                    'name'  => $xcontact->fullname->safe,
                    'email' => $xcontact->email->safe
                ]
            ],
            'subject' => 'Re: ' . $xcontact->subject,
            'text' => $xcontact->reply->clean,
            'view' => [
                'path' => 'contact/user',
                'params' => $params
            ]
        ];

        if(!Mailer::send($mail)){
            self::$last_error = Mailer::getError();
            return null;
        }

        return $contact;
    }
}