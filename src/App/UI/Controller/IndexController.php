<?php

namespace App\UI\Controller;

use Framework\Http\Request;
use Framework\Http\Response;
use App\Application\Service\GetPostsService;

class IndexController extends BaseController
{
    private GetPostsService $getPostsService;

    public function __construct(GetPostsService $getPostsService)
    {
        $this->getPostsService = $getPostsService;
    }

    public function execute(Request $request): Response
    {
        $posts = $this->getPostsService->execute();
        
        $postsArray = array_map(fn($post) => $post->toArray(), $posts);

        $content = $this->render('index', ['posts' => $postsArray]);
        $statusCode = 200;

        return new Response($content, $statusCode);
    }
}
