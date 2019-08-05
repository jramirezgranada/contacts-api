<?php

namespace App\Controllers;

use App\Factories\ContactFactory;

class ContactController extends Controller
{
    public function __construct($request, $response)
    {
        print_r($request->headers());
        die;
        $this->checkAuthToken($request, $response);
    }

    /**
     * Get all contacts wit its emails and phone numbers
     * @param $request
     * @param $response
     * @return mixed
     */
    public function index($request, $response)
    {
        return $response->json(ContactFactory::all());
    }

    /**
     * Store Contact Information
     * @param $request
     * @param $response
     * @param $service
     * @return mixed
     */
    public function store($request, $response, $service)
    {
        return $response->json(ContactFactory::create($request));
    }

    /**
     * Get a specific contact by id
     * @param $request
     * @param $response
     * @return mixed
     */
    public function get($request, $response)
    {
        return $response->json(ContactFactory::get($request));
    }

    /**
     * Delete a specific contact
     * @param $request
     * @param $response
     * @return mixed
     */
    public function delete($request, $response)
    {
        return $response->json(ContactFactory::delete($request));
    }

    /**
     * Update a specific contact
     * @param $request
     * @param $response
     * @return mixed
     */
    public function update($request, $response)
    {
        return $response->json(ContactFactory::update($request));
    }
}