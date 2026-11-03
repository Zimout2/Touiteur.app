<?php



namespace touiteur\render;

use touiteur\entite\User;
use touiteur\touite\Touite;


class TouiteurRenderer implements Renderer {











    private string $message;
    private User $user;
    private string $date;
    private ?int $likes = 0;












    public function __construct(Touite $t) {
        $this->message = $t->getMessage();
        $this->user = $t->getUser();
        $this->date = $t->getDate();
        $this->likes = $t->getLikes();
    }





















    public function render(): string {
        $messageCourt = substr($this->message, 0, 100);
        $isMessageLong = strlen($this->message) > 100;

        $html = "<div>";
        $html .= "<h4>" . $this->user->pseudo . "</h4>";
        if ($isMessageLong) {
            $html .= "<p>" . $messageCourt . "...</p>";
            $html .= "<details>";
            $html .= "  <summary>Voir plus</summary>";
            $html .= "  <p>" . $this->message . "</p>";
            $html .= "</details>";
        } else {
            $html .= "<p>" . $this->message . "</p>";
        }
        $html .= "<small>" . $this->date . "</small>";
        $html .= "<small> Like : " . $this->like . "</small>";
        $html .= "<br>";

        return $html;
    }




}