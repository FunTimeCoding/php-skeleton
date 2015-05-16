<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample;

use DOMDocument;
use DOMXPath;
use HttpRequest;
use Exception;

class HttpRequestMediaWikiWebClient implements MediaWikiWebClient
{
    private $username = '';
    private $password = '';
    private $url;

    /**
     * @param string $domainName
     */
    public function __construct($domainName)
    {
        $this->url = 'http://' . $domainName . '/index.php';
    }

    /**
     * @throws Exception
     */
    public function login()
    {
        $request = new HttpRequest($this->url, HttpRequest::METH_GET);
        $request->enableCookies();
        $request->addQueryData($this->getLoginUrlQueryData());
        $request->send();
        $body = $request->getResponseBody();
        $xpath = $this->createDomXpathForBody($body);
        $token = $this->searchTokenInDomXpath($xpath);

        $request = new HttpRequest($this->url, HttpRequest::METH_POST);
        $request->addQueryData($this->getLoginUrlQueryData());
        $formData = $this->createFormDataWithToken($token);
        $request->addPostFields($formData);
        $response = $request->send();
        $location = $response->getHeader("Location");

        $request = new HttpRequest($location, HttpRequest::METH_GET);
        $request->send();
        $body = $request->getResponseBody();
        $xpath = $this->createDomXpathForBody($body);

        if (1 != $xpath->query('//li[@id="pt-logout"]')->length) {
            throw new Exception('Login failed.');
        }
    }

    /**
     * @internal
     * @return array
     */
    public function getLoginUrlQueryData()
    {
        return array(
            'title' => 'Special:UserLogin',
            'action' => 'submitlogin',
            'type' => 'login'
        );
    }

    /**
     * @param string $body
     * @return DOMXPath
     */
    private function createDomXpathForBody($body)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($body);
        libxml_clear_errors();
        return new DOMXPath($dom);
    }

    /**
     * @param string $token
     * @return array
     */
    private function createFormDataWithToken($token)
    {
        return array(
            'wpName' => $this->username,
            'wpPassword' => $this->password,
            'wpLoginAttempt' => 'Log in',
            'wpLoginToken' => $token,
            'wpRemember' => '1'
        );
    }

    /**
     * @param DOMXPath $xpath
     * @return string
     */
    private function searchTokenInDomXpath(DOMXPath $xpath)
    {
        return $xpath->query('//input[@name="wpLoginToken"]/@value')->item(0)->nodeValue;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param DOMXPath $xpath
     * @return string
     */
    private function searchContentInDomXpath(DOMXPath $xpath)
    {
        return trim($xpath->query('//div[@id="mw-content-text"]')->item(0)->nodeValue);
    }

    /**
     * @param string $page
     * @return string
     */
    public function getPage($page)
    {
        $request = new HttpRequest($this->url . '/' . $page, HttpRequest::METH_GET);
        $request->enableCookies();
        $request->send();
        $body = $request->getResponseBody();
        $xpath = $this->createDomXpathForBody($body);

        return $content = $this->searchContentInDomXpath($xpath);
    }
}
