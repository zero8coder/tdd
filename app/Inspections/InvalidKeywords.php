<?php


namespace App\Inspections;


class InvalidKeywords
{
    protected $keywords = [
        'something forbidden'
    ];

    public function detect($body)
    {
        foreach ($this->keywords as $invalidKeyword) {
            if (stripos($body, $invalidKeyword) !== false) {
                throw new \Exception('回复有违规词汇');
            }
        }
    }


}
