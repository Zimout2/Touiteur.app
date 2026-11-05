<?php

namespace touiteur\action ;

abstract class Action {
    protected ?string $http_method = null ;
    protected ?string $hostname = null;
    protected ?string $script_name = null;
    
    public function __construct(){
        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    // Retire les mots qui commencent par # (les tags sont affichés à part)
    protected function retirerTags(string $message): string
    {
        $mots = explode(' ', $message);
        $motsSansTag = [];
        foreach ($mots as $mot) {
            if ($mot !== '' && $mot[0] !== '#') {
                $motsSansTag[] = $mot;
            }
        }
        return implode(' ', $motsSansTag);
    }

    abstract public function execute() : string;

}