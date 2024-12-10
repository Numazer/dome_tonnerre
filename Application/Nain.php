<?php

class Nain extends Perso implements Arme, Talent {

    public function __construct(string $name){
        $this -> name = $name;
        $this -> PV = 1000;
        $this -> endurance = 70;
        $this -> force = 60;
        $this -> enVie = true;
        $this -> nomArme = "Hache";
    }
    
    public function getName(){
        return $this -> name;
    }

    public function setName(string $name){
        $this -> name = $name;
    }
    public function getPV(){
        return $this -> PV;
    }

    public function setPV(int $PV){
        $this -> PV = $PV;
    }
    public function getEndurance(){
        return $this -> endurance;
    }

    public function setEndurance(int $endurance){
        $this -> endurance = $endurance;
    }
    public function getForce(){
        return $this -> force;
    }

    public function setforce(int $force){
        $this -> force = $force;
    }

    public function getEnVie(){
        return $this -> enVie;
    }
    
    public function setEnVie(bool $enVie){
        $this -> enVie = $enVie;
    }

    
    public function getNomArme(){
        return $this -> nomArme;
    }

    // Différentes armes
    public function Epee(){}
    public function Arc(){}
    public function Masse(){}
    public function Baton(){}
    public function Dague(){}
    public function Hache(){
        $this -> nomArme = "Hache";
        return $this -> force = 200;
    }

     // Différents talents
    public function Cavalier(){}
    public function Magicien(){}
    public function Guerrier(){}
    public function Necromencion(){}
    public function Voleur(){}
    public function Assassin(){}
    public function Pretre(){}

    // Actions possibles
    public function attaquer(){
        return $this -> force;
    }
    public function defendre(){
        return $this -> endurance;
    }
    public function deceder(){}
    public function crashTheGameIfLoose(){}

    public function recevoirDommage($dommages) {
        $this->setPV($this-> PV -= $dommages);
        if ($this-> PV <= 0) {
            $this->enVie = false;
        }
    }
 
    public function soigner(){
        $this->setPV($this -> PV + 50);
    }
}