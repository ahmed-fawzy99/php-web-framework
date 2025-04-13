<?php

declare(strict_types=1);

namespace App\Services;


use App\Config\Path;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class ReceiptService
{
    public function __construct(
        private Database $db
    ) {
    }

    public function fetch(int $id, int $transactionId): false|array
    {
        $query = "SELECT * FROM receipts WHERE id = :id AND transaction_id = :transaction_id";
        return $this->db->query($query, [
            'id' => $id,
            'transaction_id' => $transactionId,
        ])->fetch();
    }

    public function store(array $file, int $transactionId): void
    {
        $originalFileName = preg_replace('/[^A-Za-z0-9._-]/', '', $file['name']);
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;

        $uploadPath = Path::UPLOADS_DIR . '/receipts/' . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new ValidationException(['receipt' => ['Failed to upload file.']]);
        }

        $this->db->query(
            'INSERT INTO receipts (original_file_name, storage_file_name, media_type, transaction_id) 
            VALUES (:original_file_name, :storage_file_name, :media_type, :transaction_id)',
            [
                'original_file_name' => $originalFileName,
                'storage_file_name' => $newFileName,
                'media_type' => $file['type'],
                'transaction_id' => $transactionId,
            ]
        );
    }

    public function read(array $receipt): false|array
    {
        if ($receipt) {
            $filePath = Path::UPLOADS_DIR . '/receipts/' . $receipt['storage_file_name'];

            if (!file_exists($filePath)) {
                throw new ValidationException(['receipt' => ['File not found.']]);
            }

            header('Content-Type: ' . $receipt['media_type']);
            header('Content-Disposition: inline; filename="' . $receipt['original_file_name'] . '"');
            readfile($filePath);
        }

        throw new ValidationException(['receipt' => ['Empty receipt.']]);
    }

    public function delete(array $receipt): void
    {
        if ($receipt) {
            $filePath = Path::UPLOADS_DIR . '/receipts/' . $receipt['storage_file_name'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $this->db->query('DELETE FROM receipts WHERE id = :id', ['id' => $receipt['id']]);
        }
    }

}
