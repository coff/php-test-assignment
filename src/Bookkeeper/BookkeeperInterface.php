<?php

namespace Coff\TestAssignment\Bookkeeper;

interface BookkeeperInterface
{
    public function init() : self;

    public function setInputData($inputData) : self;

    public function commit() : self;

    public function getResult();
}