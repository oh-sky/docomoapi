<?php
namespace OhSky\DocomoApi;

class ImageClassify extends DocomoApi
{
    const ENDPOINT = 'https://api.apigw.smt.docomo.ne.jp/imageRecognition/v1/concept/classify/';

    /**
     * @param string $filePath
     * @param string $modelName
     * @return array
     * @see https://dev.smt.docomo.ne.jp/?p=docs.api.page&api_name=image_recognition&p_name=category_classify#tag01
     */
    public function request($filePath, $modelName)
    {
        return $this->postMultipartFormData(self::ENDPOINT, [
            'upload_files' => [
                'image' => $filePath,
            ],
            'modelName' => $modelName,
        ]);
    }

    public function scene($filePath)
    {
        return $this->request($filePath, 'scene');
    }

    public function fashionPattern($filePath)
    {
        return $this->request($filePath, 'fashion_pattern');
    }

    public function fashionType($filePath)
    {
        return $this->request($filePath, 'fashion_type');
    }

    public function fashionStyle($filePath)
    {
        return $this->request($filePath, 'fashion_style');
    }

    public function fashionColor($filePath)
    {
        return $this->request($filePath, 'fashion_color');
    }

    public function food($filePath)
    {
        return $this->request($filePath, 'food');
    }

    public function flower($filePath)
    {
        return $this->request($filePath, 'flower');
    }

    public function kinoko($filePath)
    {
        return $this->request($filePath, 'kinoko');
    }
}
