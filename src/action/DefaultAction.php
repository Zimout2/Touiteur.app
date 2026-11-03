<?php

namespace touiteur\action ;


class DefaultAction extends Action
{
    public function execute(): string
    {
        return "<h2>Bienvenue !</h2>";
    }
}
