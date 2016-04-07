<?php
namespace OhSky\DocomoApi;

/**
 * @see https://dev.smt.docomo.ne.jp/?p=docs.api.page&api_name=text_to_speech&p_name=api_hoya#tag01
 */
class Talk extends DocomoApi {
const ENDPOINT = 'https://api.apigw.smt.docomo.ne.jp/voiceText/v1/textToSpeech';

    /**
     * @param string $text 音声化するテキスト 200文字以内(utf-8)
     * @return array
     */
    public function request($text)
    {
        $data = [
            'text' => $text,
            'speaker' => 'haruka'
        ];
        $res = $this->post(
            self::ENDPOINT,
            $data
        );
        return $res;
    }

}