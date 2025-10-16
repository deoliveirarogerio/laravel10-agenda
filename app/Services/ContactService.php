<?php
namespace App\Services;

use App\Jobs\SendContactNotificationJob;
use App\Repositories\ContactRepositoryInterface;

class ContactService
{
    protected ContactRepositoryInterface $repo;

    public function __construct(ContactRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list($perPage = 15)
    {
        return $this->repo->paginate($perPage);
    }

    public function show($id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        $contact = $this->repo->create($data);

        $recipient = (string) env('NOTIFICATION_MAIL');
        if (!empty($recipient)) {
            SendContactNotificationJob::dispatch($contact, $recipient)->onQueue('back_emails');
        }

        return $contact;
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }

    public function getByIds(array $ids)
    {
        return $this->repo->getByIds($ids);
    }
}
