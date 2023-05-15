<?php

namespace Gorse;
use JsonSerializable;


class User implements JsonSerializable
{
    public string $userId;
    public array $labels;

    public function __construct(string $userId, array $labels)
    {
        $this->userId = $userId;
        $this->labels = $labels;
    }

    public function jsonSerialize(): array
    {
        return [
            'UserId' => $this->userId,
            'Labels' => $this->labels,
        ];
    }

    public static function fromJSON($json): User
    {
        return new User($json->UserId, $json->Labels);
    }
}
