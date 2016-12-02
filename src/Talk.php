<?php
namespace OhSky\DocomoApi;

/**
 * @see https://dev.smt.docomo.ne.jp/?p=docs.api.page&api_name=dialogue&p_name=api_1#tag01
 */
class Talk extends DocomoApi
{
    const ENDPOINT = 'https://api.apigw.smt.docomo.ne.jp/dialogue/v1/dialogue';

    /**
     * @param string $utt 発話内容
     * @param string $context 会話を継続する場合のcontext。前回のresponse bodyから取得
     * @return array
     */
    public function request($utt, $context = '')
    {
        $data = ['utt' => $utt];
        if (
            is_string($context) &&
            strlen($context)
        ) {
            $data['context'] = $context;
        }
        $res = $this->post(
            self::ENDPOINT,
            json_encode($data),
            ['Content-Type: application/json']
        );
        return $res;
    }
}
