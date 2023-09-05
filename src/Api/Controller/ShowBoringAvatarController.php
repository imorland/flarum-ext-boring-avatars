<?php

namespace IanM\BoringAvatars\Api\Controller;

use Flarum\Bus\Dispatcher;
use Flarum\User\User;
use IanM\BoringAvatars\BoringAvatar;
use IanM\BoringAvatars\Command\GenerateAvatar;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShowBoringAvatarController implements RequestHandlerInterface
{
    public function __construct(protected Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = User::find(Arr::get($request->getQueryParams(), 'id'));

        if (!$user) {
            throw new ModelNotFoundException();
        }

        if (empty($user->user_svg)) {
            /** @var User $user */
            $user = $this->bus->dispatch(new GenerateAvatar(
                $user, 
                BoringAvatar::$defaultGenerationSize, 
                BoringAvatar::$defaultSquareAvatar
            ));
        }

        return new HtmlResponse(
            base64_decode($user->user_svg),
            200,
            [
                'Content-Type' => 'image/svg+xml',
                'Cache-Control' => 'max-age=0, s-maxage=1'
            ]
        );
    }
}
