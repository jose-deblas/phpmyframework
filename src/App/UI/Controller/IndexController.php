<?php

namespace App\UI\Controller;

use Framework\Http\Request;
use Framework\Http\Response;
use App\Application\Service\GetPostsService;
use App\Infrastructure\Persistence\PostRepository;

class IndexController extends BaseController
{
    public function execute(Request $request): Response
    {
        // Dependency Injection would tipically be handled by a container
        $getPostsService = new GetPostsService(new PostRepository());
        $posts = $getPostsService->execute();
        
        $postsArray = array_map(fn($post) => $post->toArray(), $posts);

        $content = $this->render('index', ['posts' => $postsArray]);
        $statusCode = 200;

        return new Response($content, $statusCode);
    }
}
