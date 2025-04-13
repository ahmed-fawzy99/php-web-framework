<?php

namespace App\Controllers;

use App\Services\TransactionService;
use App\Services\ValidationService;
use Framework\TemplateEngine;

class TransactionController extends Controller
{
    public function __construct(
        protected TemplateEngine $templateEngine,
        private ValidationService $validatorService,
        private TransactionService $transactionService,
    ) {
        parent::__construct($templateEngine);
    }


    public function create(): void
    {
        echo $this->templateEngine->render('transactions/create.php');
    }

    public function edit(array $params): void
    {
        $transaction = $this->transactionService->fetch($params['transaction']);

        if (!$transaction) {
            redirect('/');
        }

        echo $this->templateEngine->render('transactions/edit.php', [
            'transaction' => $transaction,
        ]);
    }

    public function store(): void
    {
        $this->validatorService->validateTransaction($_POST);

        $this->transactionService->store($_POST);

        redirect('/');
    }

    public function update(array $params): void
    {
        $transaction = $this->transactionService->fetch($params['transaction']);

        if (!$transaction) {
            redirect('/');
        }

        $this->validatorService->validateTransaction($_POST);

        $this->transactionService->update($params['transaction'], $_POST);

        redirect('/');
    }

    public function delete(array $params): void
    {
        $transaction = $this->transactionService->fetch($params['transaction']);

        if (!$transaction) {
            redirect('/');
        }

        $this->transactionService->delete($params['transaction']);

        redirect('/');
    }

    public function deleteReceipt(array $params): void
    {
//        dd($params);
//        $transaction = $this->transactionService->fetch($params['transaction']);
//
//        if (!$transaction) {
//            redirect('/');
//        }
//
//        $this->transactionService->deleteReceipt($params['receipt']);
//
//        redirect('/transactions/' . $params['transaction'] . '/edit');
    }


}