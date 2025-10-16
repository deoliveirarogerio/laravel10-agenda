<?php
namespace App\Services;

use App\Repositories\ContactRepositoryInterface;
use App\Jobs\SendContactNotificationJob;
use Illuminate\Support\Facades\Config;

class ContactService
{
    protected $repo;

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
        // dispatch job to queue
        $recipient = env('NOTIFICATION_MAIL');
        if ($recipient) {
            SendContactNotificationJob::dispatch($contact)->onQueue('back_emails');
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
