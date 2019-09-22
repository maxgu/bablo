<?php

declare(strict_types=1);

namespace Infrastructure\Handler;

use Domain\Command\CreateEvent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Http\Request;

class CreateEventHandler implements RequestHandlerInterface
{
    /**
     * @var CreateEvent\CreateEventCommand
     */
    private $command;

    /**
     * @var TemplateRendererInterface
     */
    private $template;

    public function __construct(
        CreateEvent\CreateEventCommand $command,
        TemplateRendererInterface $template
    ) {
        $this->command = $command;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            $params = $request->getParsedBody();

            try{
                $slug = $this->command->execute(
                    new CreateEvent\CreateEventContext($params['eventName'], $params['members'])
                );
            } catch (CreateEvent\Exception\ValidationException $e) {
                return new HtmlResponse($this->template->render(
                    'app::create-event',
                    ['errors' => $e->getMessage()]
                ));
            }

            return new RedirectResponse('/' . $slug);
        }

        return new HtmlResponse($this->template->render('app::create-event'));
    }
}
