<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    protected $service;

    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 8);
        return response()->json($this->service->list($perPage));
    }

    public function store(ContactRequest $request)
    {
        // Cria e dispara o job no próprio Service (com recipient correto)
        $contact = $this->service->create($request->validated());

        return response()->json($contact, 201);
    }

    public function show($id)
    {
        return response()->json($this->service->show($id));
    }

    public function update(ContactRequest $request, $id)
    {
        return response()->json($this->service->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }

    public function exportCsv(Request $request)
    {
        $ids = $request->input('ids', []);
        $contacts = $this->service->getByIds($ids);

        $response = new StreamedResponse(function() use ($contacts) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id','cep','state','city','neighborhood','address','number','contact_name','contact_email','contact_phone']);
            foreach ($contacts as $c) {
                fputcsv($handle, [
                    $c->id,$c->cep,$c->state,$c->city,$c->neighborhood,$c->address,$c->number,$c->contact_name,$c->contact_email,$c->contact_phone
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type','text/csv');
        $response->headers->set('Content-Disposition','attachment; filename="contacts_export.csv"');
        return $response;
    }
}
