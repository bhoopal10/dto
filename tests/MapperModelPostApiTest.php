<?php

use Fnp\Dto\Flex\DtoModel;
use Fnp\Dto\Mapper\MapperModel;

class MapperModelPostApiTest extends \PHPUnit_Framework_TestCase
{
    public function generateData()
    {
        return [

            [
                [
                    'title'  => 'Post Header',
                    'body'   => 'Post Body',
                    'author' => [
                        'name'  => 'John Doe',
                        'email' => 'john.doe@example.com',
                    ],
                ],
                [
                    'header'      => 'Post Header',
                    'body'        => 'Post Body',
                    'authorName'  => 'John Doe',
                    'authorEmail' => 'john.doe@example.com',
                ],
            ],
        ];
    }

    /**
     * @param $input
     * @param $output
     *
     * @dataProvider generateData
     */
    public function testData($input, $output)
    {
        $post = Post::make($input);

        $this->assertTrue(is_object($post));
        $this->assertTrue(is_object($post->author));

        $postApi = PostApi::make($post);

        $this->assertEquals($output, $postApi->toArray());
    }


}

class Author extends DtoModel
{
    public $name;
    public $email;
}

class Post extends DtoModel
{
    public $title;
    public $body;
    public $author;

    public function fillAuthor($author)
    {
        return Author::make($author);
    }
}


class PostApi extends MapperModel
{
    public $header      = 'title';
    public $body        = 'body';
    public $authorName  = 'author.name';
    public $authorEmail = 'author.email';
}