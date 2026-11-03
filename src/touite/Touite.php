<?php

namespace touiteur\touite;

use touiteur\entite\User;

class Touite {
    protected int $id;
    protected string $message = "";
    protected User $user;
    protected string $date;
    protected ?int $likes;
    protected array $tags;

    public function __construct(int $id, string $message, User $user, string $date, ?int $likes, array $tags){
        $this->id = $id;
        $this->message = $message;
        $this->user = $user;
        $this->date = $date;
        $this->likes = $likes;
        $this->tags = $tags;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getMessage(): string{
        return $this->message;
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

    public function estLike(): bool{
        $listeLikesUsr = $this->user->getListe_touites_liker();
        return in_array($this, $listeLikesUsr);
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

    public function __toString(): string {
        return json_encode(get_object_vars($this));
    }
}