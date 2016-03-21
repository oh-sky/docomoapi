<?php
namespace OhSky\DocomoApi;

class LineCharactor extends DocomoApi
{
    const ENDPOINT = 'https://api.apigw.smt.docomo.ne.jp/characterRecognition/v1/line';

    public function request($filePath, $lang = 'jpn')
    {
        return $this->postMultipartFormData(self::ENDPOINT, [
            'upload_files' => [
                'image' => $filePath,
            ],
            'lang' => $lang,
        ]);
    }
}
