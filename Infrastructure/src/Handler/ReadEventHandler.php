<?php

declare(strict_types=1);

namespace Infrastructure\Handler;

use Domain\Command\Exception;
use Domain\Query\Expense\ExpenseQuery;
use Domain\Query\ReadEvent\ReadEventQuery;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class ReadEventHandler implements RequestHandlerInterface
{
    /**
     * @var ReadEventQuery
     */
    private $readEventQuery;

    /**
     * @var ExpenseQuery
     */
    private $expenseQuery;

    /**
     * @var TemplateRendererInterface
     */
    private $template;

    public function __construct(
        ReadEventQuery $readEventQuery,
        ExpenseQuery $expenseQuery,
        TemplateRendererInterface $template
    ) {
        $this->readEventQuery = $readEventQuery;
        $this->expenseQuery = $expenseQuery;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $slug = $request->getAttribute('eventSlug');

        $data = [];
        try{
            $data['event'] = $this->readEventQuery->execute($slug);
            $data['expenses'] = $this->expenseQuery->execute($data['event']->getId());
            $data['event']->fillExpenses($data['expenses']);
        } catch (Exception\ValidationException $e) {
            return new HtmlResponse($this->template->render('error::404'), 404);
        }

        return new HtmlResponse($this->template->render('app::read-event', $data));
    }
}
