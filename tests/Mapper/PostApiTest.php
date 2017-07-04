<?php

namespace Fnp\Dto\Test\Mapper;

use Fnp\Dto\Test\Flex\Data\Post;
use Fnp\Dto\Test\Mapper\Data\PostApi;

class PostApiTest extends \PHPUnit_Framework_TestCase
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