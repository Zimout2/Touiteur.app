<?php

namespace touiteur\touite;

use touiteur\entite\User;

class Touite {
    protected int $id;
    protected string $message = "";
    protected int $id_user;
    protected string $date;
    protected int $likes;
    protected int $dislikes;
    protected int $id_tag;

    public function __construct(int $id, string $message, int $id_user, int $date, int $likes, int $dislikes, int $id_tag) {
        $this->id = $id;
        $this->message = $message;
        $this->id_user = $id_user;
        $this->date = $date;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->id_tag = $id_tag;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getMessage(): string{
        return $this->message;
    }
    public function setMessage(string $message): void{
        $this->message = $message;
    }

    public function getUser(): User{
        return $this->user;
    }
    public function getDate(): string{
        return $this->date;
    }
    public function getLikes(): ?int{
        return $this->likes;
    }
    public function getDislikes(): ?int{
        return $this->dislikes;
    }
    public function estLike(): bool{
        $listeLikesUsr = $this->user->getListe_touites_liker();
        return in_array($this, $listeLikesUsr);
    }

    public function estDislike(): bool{
        $listeDislikesUsr = $this->user->getListe_touites_disliker();
        return in_array($this, $listeDislikesUsr);
    }

    protected function hashtag(string $msg): void{
        for ($i = 0; $i <= strlen($msg) ; $i++) {
            if (strcmp((substr($msg, $i, 1)), "#") == 0) {
                $j = 0;
                $tag = "";
                while (strcmp((substr($msg, $i + $j, 1)), " ") != 0){
                    $tag . (substr($msg, $i + $j, 1));
                    $j++;
                }
                $this->tags.array_push($tag);
            }
        }
    }

    public function getTags(): array{
        $this->hashtag($this->message);
        return $this->tags;
    }
    public function setTags(array $tags){
        $this->tags = $tags;
    }

    public function __toString(): string {
        return json_encode(get_object_vars($this));
    }
}