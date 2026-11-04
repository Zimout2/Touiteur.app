<?php

namespace touiteur\touite;

use touiteur\entite\User;

class Touite {
    protected int $id;
    protected string $message = "";
    protected User $user;
    protected string $date;
    protected ?int $likes;
    protected ?array $tags;

    public function __construct(int $id, string $message, User $user, string $date, ?int $likes){
        $this->id = $id;
        $this->message = $message;
        $this->user = $user;
        $this->date = $date;
        $this->likes = $likes;
        $this->tags = [];
    }

    public function getId(): int{
        return $this->id;
    }
    public function setId(int $id): void{
        $this->id = $id;
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
    public function setUser(User $user): void{
        $this->user = $user;
    }

    public function getDate(): string{
        return $this->date;
    }
    public function setDate(string $date): void{
        $this->date = $date;
    }

    public function getLikes(): ?int{
        return $this->likes;
    }
    public function setLikes(?int $likes): void{
        $this->likes = $likes;
    }

    public function getDislikes(): ?int{
        return $this->dislikes;
    }
    public function setDislikes(?int $dislikes): void{
        $this->dislikes = $dislikes;
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

    public function getTags(): ?array{
        $this->hashtag($this->message);
        return $this->tags;
    }
    public function setTags(?array $tags){
        $this->tags = $tags;
    }

    public function __toString(): string {
        return json_encode(get_object_vars($this));
    }




    public function addListeTag (int $idTag): void {
        if (!in_array($idTag, $this->liste_tag) {
            $this->liste_tag[] = $idTag;
        }
    }

    public function removeListeTag (int $idTag): void {
        if (in_array($idTag, $this->liste_tag) {
            unset($liste_tag[array_search($idTag, $liste_tag)]);
        }
    }

    public function isListeTag (int $idTag): bool {
        return (in_array($idTag, $this->liste_tag));
    }




}