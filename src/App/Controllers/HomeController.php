<?php

namespace App\Controllers;

use App\Services\TransactionService;
use App\Services\UserService;
use Framework\Database;
use Framework\TemplateEngine;

class HomeController extends Controller
{
    public function __construct(
        protected TemplateEngine $templateEngine,
        protected Database $db,
        protected UserService $userService,
        protected TransactionService $transactionService
    ) {
        parent::__construct($templateEngine);
    }

    public function index(): void
    {
        $limit = 3;
        $currentPage = $_GET['p'] ?? 1;
        $offset = ($currentPage - 1) * $limit;
        $searchQuery = $_GET['q'] ?? null;

        $previousPageQuery = http_build_query([
            'p' => $currentPage - 1,
            'q' => $searchQuery,
        ]);
        $nextPageQuery = http_build_query([
            'p' => $currentPage + 1,
            'q' => $searchQuery,
        ]);


        [$transactions, $count] = $this->transactionService->getAll($limit, $offset);

        $totalPages = ceil($count / $limit);

        $pageLinks = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $pageLinks[$i] = http_build_query([
                'p' => $i,
                'q' => $searchQuery,
            ]);
        }

        echo $this->templateEngine->render('index.php', [
            'transactions' => $transactions,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'searchQuery' => $searchQuery,
            'previousPageQuery' => $previousPageQuery,
            'nextPageQuery' => $nextPageQuery,
            'pageLinks' => $pageLinks,
        ]);
    }
}