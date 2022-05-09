<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    /**
     * Set DynamicExpress API username
     */
    'user' => env('DYNAMICEXPRESS_API_USER'),

    /**
     * Set DynamicExpress API password
     */
    'pass' => env('DYNAMICEXPRESS_API_PASS'),

    /**
     * DynamicExpress WSDL
     */
    'wsdl' => rtrim(env('DYNAMICEXPRESS_API_WSDL', 'https://system.dynamicexpress.eu/schema.wsdl'), '/'),
];
