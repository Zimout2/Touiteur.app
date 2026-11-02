<?php



namespace touiteur\render;


class TouiteurRenderer implements Renderer {

    private string message;
    private Entite user;
    private string date;
    private ?int like = null;

    public function __construct(Touite t) {
        this->message = t->message;
        this->user = t->user;

    }


    public function render(): string {}




}