<?php

namespace LaravelBox\Comamnds;

interface CommandInterface
{
    public function execute();

    public function getResult();
}
