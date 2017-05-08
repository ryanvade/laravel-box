<?php

namespace LaravelBox\Comamnds;

interface CommandInterface
{
  function execute();
  function getResult();
  
}
