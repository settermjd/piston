<?php

namespace Refinery29\Piston;

interface Decorator
{
    /**
     * @param Piston $app
     */
    public function __construct(Piston $app);

    /**
     * @return Piston
     */
    public function register();
}
