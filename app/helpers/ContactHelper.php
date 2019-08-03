<?php

namespace Helpers;

use Models\ContactEmail;
use Models\ContactPhone;

class ContactHelper
{
    /**
     * Function to store emails and phones numbers for a given contact
     * @param $contact
     * @param $data
     */
    public static function storeEmailsAndPhones($contact, $data)
    {
        foreach ($data["emails"] as $email) {
            $contact->emails()->save(new ContactEmail(["email" => $email]));
        }

        foreach ($data["phones"] as $phone) {
            $contact->phones()->save(new ContactPhone(["phone" => $phone]));
        }
    }
}