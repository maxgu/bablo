<?php

declare(strict_types=1);

namespace Infrastructure\Handler;

use Domain\Command\AddExpense;
use Domain\Command\Exception\ValidationException;
use Domain\Repository\EventRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Http\Request;

class AddExpenseHandler implements RequestHandlerInterface
{
    /**
     * @var AddExpense\AddExpenseCommand
     */
    private $command;

    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * @var TemplateRendererInterface
     */
    private $template;

    public function __construct(
        AddExpense\AddExpenseCommand $command,
        EventRepositoryInterface $eventRepository,
        TemplateRendererInterface $template
    ) {
        $this->command = $command;
        $this->eventRepository = $eventRepository;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $slug = $request->getAttribute('eventSlug');

        $data = [
            'event' => $this->eventRepository->findBySlug($slug),
        ];

        if ($request->getMethod() === Request::METHOD_POST) {
            $params = $request->getParsedBody();

            try {
                $this->command->execute(
                    new AddExpense\AddExpenseContext(
                        $slug,
                        $params['description'],
                        (int)$params['amount'],
                        $params['paidBy']
                    )
                );
            } catch (ValidationException $e) {
                $data['errors'] = $e->getMessage();
                return new HtmlResponse($this->template->render(
                    'app::add-expense',
                    $data
                ));
            }

            return new RedirectResponse('/' . $slug);
        }

        return new HtmlResponse($this->template->render('app::add-expense', $data));
    }
}
