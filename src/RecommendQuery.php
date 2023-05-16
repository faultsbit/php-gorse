<?php

namespace Gorse;

use JsonSerializable;

class RecommendQuery implements JsonSerializable
{
    public string $userId;
    public string $category;
    public int $n;
    public int $offset;
    public string $writeBackType;
    public string $writeBackDelay;

    public function __construct($userId, $category = null, $offset = 0, $n = 10, $writeBackType = '', $writeBackDelay = '')
    {
        $this->userId = $userId;
    }

    public function jsonSerialize(): array
    {
        return [
            'n' => $this->n,
            'offset' => $this->offset,
            'write-back-type' => $this->writeBackType,
            'write-back-delay' => $this->writeBackDelay
        ];
    }
}
