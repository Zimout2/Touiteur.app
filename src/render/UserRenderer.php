<?php



namespace touiteur\render;

use touiteur\entite\User;


class UserRenderer implements Renderer {











    private string $name;
    private string $prenom;
    private ?int $like = 0;












    public function __construct(Touite $t) {
        $this->message = $t->message;
        $this->user = $t->user;
        $this->date = $t->date;
        $this->like = $t->like;
    }





















    public function render(): string {
        
    }




}