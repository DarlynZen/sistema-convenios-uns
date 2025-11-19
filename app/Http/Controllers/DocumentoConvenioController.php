<?php

namespace App\Http\Controllers;

use App\Models\DocumentoConvenio;
use App\Models\Convenio;
use App\Services\DocumentoConvenioService;
use App\Repositories\DocumentoConvenioRepository;
use App\Http\Requests\StoreDocumentoConvenioRequest;
use App\Http\Requests\UpdateDocumentoConvenioRequest;

class DocumentoConvenioController extends Controller
{
    public function __construct(
        private DocumentoConvenioService $documentoService,
        private DocumentoConvenioRepository $documentoRepository
    ) {}

    public function index(Convenio $convenio)
    {
        $documentos = $this->documentoRepository->getByConvenio($convenio);
        return response()->json($documentos);
    }

    public function store(StoreDocumentoConvenioRequest $request, Convenio $convenio)
    {
        $data = $request->validated();
        $data['documento'] = $request->file('documento');

        $documento = $this->documentoService->create($convenio, $data);
        return response()->json($documento, 201);
    }

    public function show(DocumentoConvenio $documentoConvenio)
    {
        $documentoConvenio = $this->documentoRepository->findWithConvenio($documentoConvenio->id);
        return response()->json($documentoConvenio);
    }

    public function update(UpdateDocumentoConvenioRequest $request, DocumentoConvenio $documentoConvenio)
    {
        $data = $request->validated();
        
        if ($request->hasFile('documento')) {
            $data['documento'] = $request->file('documento');
        }

        $documento = $this->documentoService->update($documentoConvenio, $data);
        return response()->json($documento);
    }

    public function destroy(DocumentoConvenio $documentoConvenio)
    {
        $this->documentoService->delete($documentoConvenio);
        return response()->json(['message' => 'Documento eliminado exitosamente.'], 200);
    }

    public function download(DocumentoConvenio $documentoConvenio)
    {
        return $this->documentoService->download($documentoConvenio);
    }
}
