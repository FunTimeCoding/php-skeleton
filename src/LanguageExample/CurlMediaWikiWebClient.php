<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample;

use DOMDocument;
use DOMXPath;
use Exception;

class CurlMediaWikiWebClient implements MediaWikiWebClient
{
    private $username = '';
    private $password = '';
    private $url;
    private $cookieJar = '/tmp/php-cookie-jar';

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
        $url = $this->url . '?' . http_build_query($this->getLoginUrlQueryData());
        $body = $this->makeCurlGetRequestAndWriteCookies($url);
        $xpath = $this->createDomXpathForBody($body);
        $token = $this->searchTokenInDomXpath($xpath);

        $formData = $this->createFormDataWithToken($token);
        $body = $this->makeCurlPostRequest($url, $formData);
        $xpath = $this->createDomXpathForBody($body);

        if (1 != $xpath->query('//li[@id="pt-logout"]')->length) {
            throw new Exception('Login failed.');
        }
    }

    /**
     * @param string $url
     * @return string
     */
    private function makeCurlGetRequestAndWriteCookies($url)
    {
        $request = $this->createCurlRequest($url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_COOKIEJAR, $this->cookieJar);
        $body = $this->executeCurlRequest($request);

        return $body;
    }

    /**
     * @return array
     */
    private function getLoginUrlQueryData()
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
        $body = $this->makeCurlGetRequestAndReadCookies($this->url . '/' . $page);
        $xpath = $this->createDomXpathForBody($body);

        return $content = $this->searchContentInDomXpath($xpath);
    }

    /**
     * @param string $url
     * @return resource
     */
    private function createCurlRequest($url)
    {
        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $url);

        return $request;
    }

    /**
     * @param resource $request
     * @return string
     */
    private function executeCurlRequest($request)
    {
        $body = curl_exec($request);
        curl_close($request);

        return (string)$body;
    }

    /**
     * @param string $url
     * @param array $formData
     * @return string
     */
    private function makeCurlPostRequest($url, array $formData)
    {
        $request = $this->createCurlRequest($url);
        curl_setopt($request, CURLOPT_POST, count($formData));
        curl_setopt($request, CURLOPT_POSTFIELDS, http_build_query($formData));
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_COOKIEJAR, $this->cookieJar);
        curl_setopt($request, CURLOPT_COOKIEFILE, $this->cookieJar);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, 1);
        $body = $this->executeCurlRequest($request);

        return $body;
    }

    /**
     * @param string $url
     * @return string
     */
    private function makeCurlGetRequestAndReadCookies($url)
    {
        $request = $this->createCurlRequest($url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_COOKIEFILE, $this->cookieJar);
        $body = $this->executeCurlRequest($request);

        return $body;
    }
}
