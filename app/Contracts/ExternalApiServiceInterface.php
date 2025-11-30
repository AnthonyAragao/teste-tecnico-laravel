<?php

namespace App\Contracts;

interface ExternalApiServiceInterface
{
    public function generateAvatar(): string;
    public function getCountries(): array;
}