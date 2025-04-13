<?php

declare(strict_types=1);

namespace App\Services;


use Framework\Database;
use Framework\Exceptions\ValidationException;

class TransactionService
{
    public function __construct(
        private Database $db
    ) {
    }

    public function fetch(int $id): false|array
    {
        $query = "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
                FROM transactions WHERE id = :id AND user_id = :user_id";
        return $this->db->query($query, ['id' => $id, 'user_id' => $_SESSION['user']])->fetch();
    }

    public function getAll(int $limit, int $offset): array
    {
        $searchQuery = addcslashes($_GET['q'] ?? '', '%_');

        $countQuery = "SELECT COUNT(*) FROM transactions WHERE user_id = :user_id AND description LIKE :searchQuery";
        $countParams = [
            'user_id' => $_SESSION['user'],
            'searchQuery' => '%' . $searchQuery . '%',
        ];
        $count = $this->db->query($countQuery, $countParams)->count();


        $query = "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date 
            FROM transactions WHERE user_id = :user_id AND description LIKE :searchQuery
            LIMIT {$limit} OFFSET {$offset}";

        $params = [
            'user_id' => $_SESSION['user'],
            'searchQuery' => '%' . $searchQuery . '%',
        ];

        $transactions = $this->db->query($query, $params)->fetchAll();

        //  Fetch receipts for each transaction
        $transactions = array_map(function (array $transaction) {
            $transaction['receipts'] = $this->db->query(
                "SELECT * FROM receipts WHERE transaction_id = :transaction_id",
                ['transaction_id' => $transaction['id']]
            )->fetchAll();
            return $transaction;
        }, $transactions);

        return [$transactions, $count];
    }

    public function store(array $formData): void
    {
        $query = "INSERT INTO transactions (user_id, description, amount, date) VALUES (:user_id, :description, :amount, :date)";

        try {
            $this->db->query($query, [
                'user_id' => $_SESSION['user'],
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formData['date'] . ' 00:00:00'
            ]);
        } catch (\PDOException $e) {
            throw new ValidationException(["FormErrors" => ["Error: " . $e->getMessage()]]);
        }
    }

    public function update(int $id, array $formData): void
    {
        $query = "UPDATE transactions SET description = :description, amount = :amount, date = :date WHERE id = :id AND user_id = :user_id";

        try {
            $this->db->query($query, [
                'id' => $id,
                'user_id' => $_SESSION['user'],
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formData['date'] . ' 00:00:00'
            ]);
        } catch (\PDOException $e) {
            throw new ValidationException(["FormErrors" => ["Error: " . $e->getMessage()]]);
        }
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM transactions WHERE id = :id AND user_id = :user_id";

        try {
            $this->db->query($query, [
                'id' => $id,
                'user_id' => $_SESSION['user'],
            ]);
        } catch (\PDOException $e) {
            throw new ValidationException(["FormErrors" => ["Error: " . $e->getMessage()]]);
        }
    }

}
