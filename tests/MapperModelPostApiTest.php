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
     * @throws ReflectionException
     */
    public function testData($input, $output)
    {
        $post = PostModel::make($input);

        $this->assertTrue(is_object($post), 'Checking Flex Model');
        $this->assertTrue(is_object($post->author), 'Checking Flex Model Sub Object');

        $postApi = PostApiModel::make($post);

        $this->assertEquals($output, $postApi->toArray(), 'Checking mapper');
    }
}

class AuthorModel extends DtoModel
{
    public $name;
    public $email;
}

class PostModel extends DtoModel
{
    public $title;
    public $body;
    public $author;

    public function fillAuthor($author)
    {
        return AuthorModel::make($author);
    }
}


class PostApiModel extends MapperModel
{
    public $header      = 'title';
    public $body        = 'body';
    public $authorName  = 'author.name';
    public $authorEmail = 'author.email';
}