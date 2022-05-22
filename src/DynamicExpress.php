<?php

namespace Gdinko\DynamicExpress;

use Gdinko\DynamicExpress\Exceptions\DynamicExpressException;
use \SoapClient;
use Illuminate\Support\Str;

class DynamicExpress
{
    public const SIGNATURE = 'CARRIER_DYNAMICEXPRESS';

    /**
     * DynamicExpress API username
     */
    protected $user;

    /**
     * DynamicExpress API password
     */
    protected $pass;

    /**
     * DynamicExpress API Account Store
     *
     * @var array
     */
    protected $accountStore = [];

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
     * setClient
     *
     * @param  \SoapClient $client
     * @return void
     */
    public function setClient(SoapClient $client)
    {
        $this->client = $client;
    }

    /**
     * getClient
     *
     * @return object
     */
    public function getClient(): object
    {
        return $this->client;
    }

    /**
     * setAccount
     *
     * @param  string $user
     * @param  string $pass
     * @return void
     */
    public function setAccount(string $user, string $pass)
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
     * getUserName
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user;
    }

    /**
     * getPassword
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->pass;
    }

    /**
     * getSignature
     *
     * @return string
     */
    public function getSignature(): string
    {
        return self::SIGNATURE;
    }

    /**
     * addAccountToStore
     *
     * @param  string $user
     * @param  string $pass
     * @return void
     */
    public function addAccountToStore(string $user, string $pass)
    {
        $this->accountStore[Str::slug($user)] = [
            'user' => $user,
            'pass' => $pass,
        ];
    }

    /**
     * getAccountFromStore
     *
     * @param  string $user
     * @return array
     */
    public function getAccountFromStore(string $user): array
    {
        $key = Str::slug($user);

        if (isset($this->accountStore[$key])) {
            return $this->accountStore[$key];
        }

        throw new DynamicExpressException('Missing Account in Account Store');
    }

    /**
     * setAccountFromStore
     *
     * @param  string $account
     * @return void
     */
    public function setAccountFromStore(string $account)
    {
        $accountFromStore = $this->getAccountFromStore($account);

        $this->setAccount(
            $accountFromStore['user'],
            $accountFromStore['pass']
        );
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
