<?php

namespace Gdinko\DynamicExpress;

use SoapClient;

class DynamicExpress
{
    /**
     * DynamicExpress API username
     */
    protected $user;

    /**
     * DynamicExpress API password
     */
    protected $pass;

    /**
     * SOAP Client
     */
    protected $client;

    public function __construct()
    {
        $this->user = config('dynamicexpress.user');

        $this->pass = config('dynamicexpress.pass');

        $this->client = new SoapClient(
            config('dynamicexpress.wsdl')
        );
    }

    /**
     * setAccount
     *
     * @param  string $user
     * @param  string $pass
     * @return void
     */
    public function setAccount($user, $pass)
    {
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * getAccount
     *
     * @return object
     */
    public function getAccount(): object
    {
        return (object) [
            'user' => $this->user,
            'pass' => $this->pass,
        ];
    }

    /**
     * Call SOAP Methods
     *
     * @param  string $name
     * @param  array $arguments
     */
    public function __call(string $name, array $arguments)
    {
        array_unshift(
            $arguments,
            $this->getAccount()
        );

        return call_user_func_array(
            [$this->client, $name],
            $arguments
        );
    }
}
