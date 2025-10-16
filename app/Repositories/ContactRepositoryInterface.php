<?php
namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Contact;

interface ContactRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function search(?string $q, int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): ?Contact;
    public function create(array $data): Contact;
    public function update(int $id, array $data): Contact;
    public function delete(int $id): bool;
    public function getByIds(array $ids);
}
