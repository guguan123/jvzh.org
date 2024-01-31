<?php

class TaskTemplate
{
    public function __construct(array $data = [])
    {
        $this->sets($data);
    }

    public function sets($attr, $value = null)
    {
        foreach (is_array($attr) ? $attr : [$attr => $value] as $key => $val) {
            $this->$key = $val;
        }
        return $this;
    }

    public function gets(): array
    {
        return get_object_vars($this);
    }

    protected $host = 'mail.jvzh.cn';
    protected $port = '25';
    protected $smtpDebug = false;
    protected $nickname = 'admin@jvzh.cn';
    protected $username = '续梦网';
    protected $password = 'Al3475272270';
    protected $isHTML = true;
    protected $charSet = 'utf-8';
    protected $subject = '';
    protected $address = [];
    protected $body = '';
    protected $params = [];


    public function setHost(string $host)
    {
        return $this->sets('host', $host);
    }

    public function setPort(string $port)
    {
        return $this->sets('port', $port);
    }

    public function setSmtpDebug(bool $smtpDebug)
    {
        return $this->sets('smtpDebug', $smtpDebug);
    }


    public function setNickname(string $nickname)
    {
        return $this->sets('nickname', $nickname);
    }

    public function setUsername(string $username)
    {
        return $this->sets('username', $username);
    }

    public function setPassword(string $password)
    {
        return $this->sets('password', $password);
    }

    public function setIsHTML(bool $isHTML)
    {
        return $this->sets('isHTML', $isHTML);
    }

    public function setCharSet(string $charSet)
    {
        return $this->sets('charSet', $charSet);
    }

    public function setSubject(string $subject)
    {
        return $this->sets('subject', $subject);
    }

    public function setAddress(array $address)
    {
        return $this->sets('address', $address);
    }

    public function setBody(string $body)
    {
        return $this->sets('body', $body);
    }

    public function setParams(array $params)
    {
        return $this->sets('params', $params);
    }

    /**
     * @return bool
     */
    public function isSmtpDebug(): bool
    {
        return $this->smtpDebug;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @return bool
     */
    public function isHTML(): bool
    {
        return $this->isHTML;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function getAddress(): array
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCharSet(): string
    {
        return $this->charSet;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}