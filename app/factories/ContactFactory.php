<?php

namespace Factories;

use Helpers\ContactHelper;
use Models\Contact;
use Validators\FormValidator;

class ContactFactory implements FactoryInterface
{
    /**
     * Store Contact Information
     * @param $req
     * @return mixed
     */
    public static function create($req)
    {
        $data = $req->bodyToArray();

        $validations = (new FormValidator(
            $data,
            [
                "firstname" => "required",
                "emails" => "email"
            ]
        ))->validate();

        if (isset($validations["data"])) {
            return $validations;
        }

        $contact = Contact::create($data);

        ContactHelper::storeEmailsAndPhones($contact, $data);

        $contact->load('emails', 'phones');

        return [
            "status" => "Ok",
            "message" => "Contact was created",
            "code" => 200,
            "data" => $contact
        ];
    }

    /**
     * Get all contacts
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Contact[]
     */
    public static function all()
    {
        return Contact::with(["emails", "phones"])->get();
    }

    /**
     * Get Contact by ID
     * @param $request
     * @return array
     */
    public static function get($request)
    {
        $contactId = $request->param('id');

        $validations = (new FormValidator(
            ['id' => $contactId], ["id" => "integer"]
        ))->validate();

        if (isset($validations["data"])) {
            return $validations;
        }

        $contact = Contact::find($contactId);

        if (!$contact) {
            return [
                "status" => "Error",
                "message" => "Contact not found",
                "code" => 404,
                "data" => []
            ];
        }

        return [
            "status" => "Ok",
            "message" => "Contact found",
            "code" => 200,
            "data" => $contact
        ];

    }

    /**
     * Delete Contact by ID
     * @param $request
     * @return array
     */
    public static function delete($request)
    {
        $contactId = $request->param('id');

        $validations = (new FormValidator(
            ['id' => $contactId], ["id" => "integer"]
        ))->validate();

        if (isset($validations["messages"])) {
            return $validations;
        }

        $contact = Contact::find($contactId);

        if (!$contact) {
            return [
                "status" => "Error",
                "message" => "Contact not found",
                "code" => 404,
                "data" => []
            ];
        }

        return [
            "status" => "Ok",
            "message" => "Contact was deleted",
            "code" => 200,
            "data" => $contact->delete()
        ];

    }

    /**
     * Update an existing contact
     * @param $request
     * @return array
     */
    public static function update($request)
    {
        $data = array_merge($request->bodyToArray(), $request->params());

        $validations = (new FormValidator(
            $data, ["id" => "integer", "firstname" => "required", "emails" => "email"]
        ))->validate();

        if (isset($validations["data"])) {
            return $validations;
        }

        $contact = Contact::find($data["id"]);

        if (!$contact) {
            return [
                "status" => "Error",
                "message" => "Contact not found",
                "code" => 404,
                "data" => []
            ];
        }

        $contact->fill($data);
        $contact->save();

        $contact->emails()->delete();
        $contact->phones()->delete();

        ContactHelper::storeEmailsAndPhones($contact, $data);

        $contact->load('emails', 'phones');

        return [
            "status" => "Ok",
            "message" => "Contact was updated",
            "code" => 200,
            "data" => $contact
        ];
    }
}