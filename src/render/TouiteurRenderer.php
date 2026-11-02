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





















    public function render(int $selector): string {
        if ($selector == SHORT) {
            $messageCourt = substr($this->message, 0, 100);
            $html = "<div>";
            $html .= "<h4>" . $this->user->pseudo . "</h4>";
            $html .= "<p>" . $messageCourt . "</p>";
            //bouton ou lien "plus"
            //date
            //like
        }
    }




}