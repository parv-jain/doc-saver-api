<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function getDocument($document_id)
    {
        return response()->json(Document::with(['user'])->find($document_id));
    }

    public function addNewDocument(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id',
            'document' => 'required|max:10240|mimes:pdf',
            'document_info' => 'required|unique:users'
        ]);

        $fileName = $request->file('document')->getClientOriginalName();
        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '.', $fileName);
        $fileName = uniqid('DocSaverDocument') . '_' . $fileName;
        $path = 'files' . DIRECTORY_SEPARATOR . $request['user_id'] . DIRECTORY_SEPARATOR;
        $destinationPath = base_path('public') . DIRECTORY_SEPARATOR . $path;
        $request->file('document')->move($destinationPath, $fileName);
        $request->merge([ 'document_url' => '/public/' . $path . $fileName ]);
        $document = Document::create($request->all());
        
        return response()->json($user, 201);
    }
}
