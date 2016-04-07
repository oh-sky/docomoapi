<?php
namespace OhSky\DocomoApi;

/**
 * @see https://dev.smt.docomo.ne.jp/?p=docs.api.page&api_name=dialogue&p_name=api_1#tag01
 */
class Talk extends DocomoApi
{
    const ENDPOINT = 'https://api.apigw.smt.docomo.ne.jp/dialogue/v1/dialogue';

    /** @var string|null $context */
    private $context = null;

    /**
     * @param string $utt 発話内容
     * @param boolean $kaiwa 会話を継続するかどうかフラグ
     * @return array
     */
    public function request($utt, $kaiwa = false)
    {
        $data = ['utt' => $utt];
        if (isset($this->context)) {
            $data['context'] = $this->context;
        }
        $res = $this->post(
            self::ENDPOINT,
            json_encode($data),
            ['Content-Type: application/json']
        );
        $this->context = $kaiwa ? $res['body']['context'] : null;
        return $res;
    }
}
