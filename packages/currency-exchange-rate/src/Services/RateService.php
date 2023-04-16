<?php

interface RateService
{
    public function fetchRates($url): string | bool;
}