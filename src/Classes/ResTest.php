<?php

class ResTest{
    private $test;
    private $resultat;

    public function __construct(Test $test)
    {
        $this->test = $test;
        $this->resultat = $test->getMessage();
    }
}