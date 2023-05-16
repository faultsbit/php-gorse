<?php

namespace Gorse;

use JsonSerializable;

class Item implements JsonSerializable
{
    public array $categories;
    public string $comment;
    public bool $isHidden;
    public string $itemId;
    public array $labels;
    public string $timestamp;

    public function __construct(string $itemId,array $labels,array $categories = [],$isHidden = false,$timestamp = '',$comment='') {
        $this->itemId = $itemId;
        $this->labels = $labels;
        $this->categories = $categories;
        $this->isHidden = $isHidden;
        $this->timestamp = $timestamp;
        $this->comment = $comment;
    }

    public function jsonSerialize(): array
    {
        return [
            'Categories' => $this->categories,
            'Comment' => $this->comment,
            'IsHidden' => $this->isHidden,
            'ItemId' => $this->itemId,
            'Labels' => $this->labels,
            'Timestamp' => $this->timestamp
        ];
    }
}
