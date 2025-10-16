<?php

namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentContactRepository implements ContactRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Contact::query()->orderByDesc('id')->paginate($perPage);
    }

    public function search(?string $q, int $perPage = 15): LengthAwarePaginator
    {
        $qb = Contact::query()->orderByDesc('id');

        if ($q) {
            $qb->where(function ($sub) use ($q) {
                $sub->where('contact_name', 'like', "%{$q}%")
                    ->orWhere('contact_email', 'like', "%{$q}%")
                    ->orWhere('contact_phone', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%")
                    ->orWhere('address', 'like', "%{$q}%");
            });
        }

        return $qb->paginate($perPage);
    }

    public function find(int $id): ?Contact
    {
        return Contact::find($id);
    }

    public function create(array $data): Contact
    {
        return Contact::create($data);
    }

    public function update(int $id, array $data): Contact
    {
        $contact = Contact::findOrFail($id);
        $contact->update($data);
        return $contact;
    }

    public function delete(int $id): bool
    {
        $contact = Contact::findOrFail($id);
        return (bool) $contact->delete();
    }

    public function getByIds(array $ids)
    {
        return Contact::whereIn('id', $ids)->get();
    }
}
