<?php
namespace OhSky\DocomoApi;

use CURLFile;
use finfo;
use Curl\Curl;

class DocomoApi
{
    const USER_AGENT = 'OhSky Docomo API Client';
    /** @var Curl $curl */
    protected $curl         = null;
    /** @var string $apiKey */
    protected $apiKey       = '';
    /** @var string $clientId */
    protected $clientId     = '';
    /** @var string $clientSecret */
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
        if ($this->curl instanceof Curl) {
            $this->curl->close();
        }
        $this->curl = new Curl();
        $this->curl->setUserAgent(self::USER_AGENT);
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
        foreach ($headers as $key => $value) {
            $this->curl->setHeader($key, $value);
        }
        if ($fileUpload) {
            $this->curl->setOpt(CURLOPT_SAFE_UPLOAD, true);
        }
        $res = $this->curl->post($url, $data);
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
        return $this->post($this->createRequestUri($url), $data, $headers, true);
    }

    private function createRequestUri($url)
    {
        return $url . "?" . http_build_query([
            'APIKEY' => $this->apiKey,
        ]);
    }

    private function checkResponseStatus()
    {
        if ($this->curl->error) {
            throw new DocomoApiException("Response status: {$this->curl->errorCode}: {$this->curl->errorMessage}");
        }
    }
}
