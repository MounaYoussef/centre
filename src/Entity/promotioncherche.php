<?php

namespace App\Entity;
class promotioncherche{
    /**
     * @var int|null
     */
    private $maxprix;

    /**
     * @return int|null
     */
    public function getMaxprix(): ?int
    {
        return $this->maxprix;
    }

    /**
     * @param int|null $maxprix
     */
    public function setMaxprix(int $maxprix): void
    {
        $this->maxprix = $maxprix;
    }
}