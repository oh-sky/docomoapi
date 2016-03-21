<?php
namespace OhSky\DocomoApi;

use CURLFile;
use finfo;

class DocomoApi
{
    const USER_AGENT = 'OhSky Docomo API Client';
    protected $curl         = null;
    protected $apiKey       = '';
    protected $clientId     = '';
    protected $clientSecret = '';

    public function __construct($apiKey = '', $clientId = '', $clientSecret = '')
    {
        $this->apiKey = $apiKey;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->init();
    }

    protected function init()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
        $this->curl = curl_init();
        curl_setopt_array($this->curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => self::USER_AGENT,
        ]);
    }

    /**
     * @param string $url endpoint of the api
     * @param array $data data for HTTP request body
     * @param array $header http request header
     * @param boolean $fileUpload
     * @return array
     */
    protected function post($url, $data = [], $headers = [], $fileUpload = false)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_POST => true,
            CURLOPT_URL => $this->createRequestUri($url),
            CURLOPT_HTTPHEADER => $headers,
        ]);
        if ($fileUpload) {
            curl_setopt($this->curl, CURLOPT_SAFE_UPLOAD, true);
        }
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($this->curl);
        $this->checkResponseStatus();
        return json_decode($res);
    }

    /**
     * POST with some files
     * @param string $url endpoint of the api
     * @param array $data data for HTTP request body
     * @param array $header http request header
     * @return array
     *
     * format for $data
     * [
     *   'upload_files' => [KEY => FILEPATH_TO_UPLOAD],
     *   'other_key' => 'value for other_key',
     * ]
     */
    protected function postMultipartFormData($url, $data = [], $headers = [])
    {
        if (isset($data['upload_files']) && is_array($data['upload_files'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $uploadFiles = $data['upload_files'];
            unset($data['upload_files']);
            foreach ($uploadFiles as $key => $path) {
                $file = new CURLFile($path);
                $file->setMimeType($finfo->file($path));
                $data[$key] = $file;
            }
        }
        return $this->post($url, $data, $headers, true);
    }

    private function createRequestUri($url)
    {
        return $url . "?" . http_build_query([
            'APIKEY' => $this->apiKey,
        ]);
    }

    private function checkResponseStatus()
    {
        $info = curl_getinfo($this->curl);
        if ($info['http_code'] >= 400) {
            throw new DocomoApiException("Response status: {$info['http_code']}");
        }
    }
}
