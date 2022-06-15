<?php

namespace App\Http\Presenters;

interface PresenterInterface
{
    public function render($query);
    public function renderCollection($query);
}