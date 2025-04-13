<?php

namespace App\Controllers;

use App\Services\ReceiptService;
use App\Services\TransactionService;
use App\Services\ValidationService;
use Framework\TemplateEngine;

class ReceiptController extends Controller
{
    public function __construct(
        protected TemplateEngine $templateEngine,
        private ValidationService $validatorService,
        private TransactionService $transactionService,
        private ReceiptService $receiptService,
    ) {
        parent::__construct($templateEngine);
    }


    public function create(array $params): void
    {
        $transaction = $this->transactionService->fetch($params['transaction']);

        if (!$transaction) {
            redirect('/');
        }

        echo $this->templateEngine->render('receipts/create.php', [
            'transaction_id' => $params['transaction'],
        ]);
    }


    public function store(array $params): void
    {
        $transaction = $this->transactionService->fetch($params['transaction']);

        if (!$transaction) {
            redirect('/');
        }

        $file = $_FILES['receipt'] ?? null;
        $this->validatorService->validateFile($file, ['image/jpeg', 'image/png', 'application/pdf'], 3 * 1024 * 1024);

        $this->receiptService->store($file, $transaction['id']);

        redirect('/');
    }

    public function getReceipt(array $params): void
    {
        $transaction = $this->transactionService->fetch($params['transaction']);

        if (!$transaction) {
            redirect('/');
        }

        $receipt = $this->receiptService->fetch($params['receipt'], $params['transaction']);

        if (!$receipt) {
            redirect('/');
        }


        $this->receiptService->read($receipt);
    }


    public function delete(array $params): void
    {
        $transaction = $this->transactionService->fetch($params['transaction']);

        if (!$transaction) {
            redirect('/');
        }

        $receipt = $this->receiptService->fetch($params['receipt'], $params['transaction']);

        if (!$receipt) {
            redirect('/');
        }

        $this->receiptService->delete($receipt);

        redirect('/');
    }


}