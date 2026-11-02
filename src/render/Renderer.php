<?php



namespace touiteur\render;


interface Renderer {

    const SHORT = 1;
    const ALL = 2;

    public function render(int $selector): string ;




}