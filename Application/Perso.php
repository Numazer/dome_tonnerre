<?php

abstract class Perso{
    protected string $name;
    protected int $PV;
    protected int $endurance;
    protected int $force;
    protected bool $enVie;
    protected string $nomArme;

    protected function __construct(string $name, int $PV, int $endurance, int $force, bool $enVie, string $nomArme){
    // $this -> name = $name;
    // $this -> PV = $PV;
    // $this -> endurance = $endurance;
    // $this -> force = $force;
    // $this -> enVie = $enVie;
}

    public function attaquer(){}

    public function defendre(){}

    public function deceder(){}
    
    public function crashTheGameIfLoose(){}

    public function soigner(){}
}

