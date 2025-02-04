<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\TransactionService;

class HomeController
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService
    ) {}

    public function home()
    {
        $transaction = $this->transactionService->getUsertransaction();

        echo $this->view->render("index.php", [
            'transactions' => $transaction
        ]);
    }
}
