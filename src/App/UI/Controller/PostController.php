<?php

namespace App\UI\Controller;

use Framework\Http\Request;
use Framework\Http\Response;

use App\Application\Service\GetSinglePostService;
use App\Infrastructure\Persistence\PostRepository;
use App\Domain\Model\Post;


class PostController extends BaseController
{
    private GetSinglePostService $getSinglePostService;
    
    public function __construct(GetSinglePostService $getSinglePostService)
    {
        $this->getSinglePostService = $getSinglePostService;
    }

    public function execute(Request $request): Response
    {
        $parameters = $request->getQuery();
        $post = $this->getSinglePostService->execute($parameters->get('id', 0));

        if ($post === null) {
            $content = $this->render('not-found', ['message' => 'Post not found']);
            $statusCode = 404;

            return new Response($content, $statusCode);
        }
        
        $content = $this->render('post', ['post' => $post->toArray()]);
        $statusCode = 200;

        return new Response($content, $statusCode);
    }
}
