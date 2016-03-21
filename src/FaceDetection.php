<?php
namespace OhSky\DocomoApi;

/**
 * @see https://dev.smt.docomo.ne.jp/?p=common_page&p_name=pux_detectface
 */
class FaceDetection extends DocomoApi
{
    const ENDPOINT = 'https://api.apigw.smt.docomo.ne.jp/puxImageRecognition/v1/faceDetection';

    public function request($filePath)
    {
        return $this->postMultipartFormData(self::ENDPOINT, [
            'upload_files' => [
                'inputFile' => $filePath,
            ],
            'enjoyJudge' => 1,
            'response' => 'json',
        ]);
    }
}
