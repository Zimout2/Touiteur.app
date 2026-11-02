<?php

namespace touiteur\touite;

class Touite {
    protected int $id;
    protected string $message = "";
    protected User $user;
    protected string $date;
    protected ?int $likes;
    protected array $tags;

    public function __construct(int $id, string $message, User $user, string $date, ?int $likes, array $tags, Tag $hashtag, bool $estlike){
        $this->id = $id;
        $this->message = $message;
        $this->user = $user;
        $this->date = $date;
        $this->likes = $likes;
        $this->tags = $tags;
    }

    function getId(): int{
        return $this->id;
    }

    function getMessage(): string{
        return $this->message;
    }

    function getUser(): User{
        return $this->user
    }

    function getDate(): string{
        return $this->date;
    }

    function getLikes(): string{
        return $this->likes;
    }

    function getTags(): array{
        return $this->tags;
    }

    function estLike(): bool{



    }

    function hashtag(): Tag{



    }

    public function __toString(): string {
        return json_encode(get_object_vars($this));
    }

}