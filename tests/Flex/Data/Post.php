<?php

namespace Fnp\Dto\Test\Flex\Data;

use Fnp\Dto\Flex\DtoModel;

class Post extends DtoModel
{
    public $title;
    public $body;
    public $author;

    /**
     * @param mixed $author
     *
     * @return Author
     */
    public function fillAuthor($author)
    {
        return Author::make($author);
    }

    /**
     * @param Author $author
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}