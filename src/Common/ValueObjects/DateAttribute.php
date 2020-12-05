<?php

declare(strict_types=1);

namespace App\Common\ValueObjects;

use DateTime;

class DateAttribute
{

    protected ?DateTime $date = null;

    /**
     * @param string|null $date
     * @throws \Exception
     */
    public function __construct(?string $date)
    {
        $this->setDateFromString($date);
    }


    public function getDateTime(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param ?string $date
     * @throws \Exception
     */
    protected function setDateFromString(?string $date): void
    {
        if (!empty($date)) {
            $this->date = new DateTime($date);
        }
    }
}