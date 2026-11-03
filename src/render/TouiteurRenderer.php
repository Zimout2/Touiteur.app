<?php



namespace touiteur\render;


class TouiteurRenderer implements Renderer {











    private string $message;
    private Entite $user;
    private string $date;
    private ?int $like = 0;












    public function __construct(Touite $t) {
        $this->message = $t->message;
        $this->user = $t->user;
        $this->date = $t->date;
        $this->like = $t->like;
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

        return $html;
    }




}