<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['preview']);
    }


    // public function search(Request $request)
    // {
    //     $q = $request->q;

    //     $documents = Document::query()
    //         ->when($q, function ($query) use ($q) {
    //             $query->where('title', 'like', "%$q%")
    //                 ->orWhere('nomor_surat', 'like', "%$q%") // ✅ Updated
    //                 ->orWhere('perihal', 'like', "%$q%");
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(20);

    //     return view('documents.search', compact('documents', 'q'));
    // }

    protected function authorizeDocumentAccess(Document $document)
    {
        $user = Auth::user();
        if ($user && $document->is_private_to_uploader && $document->uploaded_by !== $user->id && !$user->hasRole('Super Admin')) {
            abort(403, 'Dokumen ini bersifat rahasia dan hanya dapat diakses oleh pengupload.');
        }
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $category = $request->category;
        $user = Auth::user();

        // Default uploader to logged in user if not specified in request
        if (!$request->has('uploader')) {
            $uploader = $user ? (string)$user->id : 'all';
        } else {
            $uploader = $request->uploader;
        }

        $categories = Category::orderBy('name')->get();
        $uploaders = User::orderBy('name')->get();

        $documents = Document::query()
            ->with(['category', 'uploader'])
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                    ->orWhere('nomor_surat', 'like', "%$q%")
                    ->orWhere('perihal', 'like', "%$q%");
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($uploader && $uploader !== 'all', function ($query) use ($uploader) {
                $query->where('uploaded_by', $uploader);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('documents.search', compact('documents', 'q', 'categories', 'category', 'uploaders', 'uploader'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240',
            'tanggal_surat' => 'nullable|date',
        ]);

        $file = $request->file('file');
        $name = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $name, 'public');
        $tags = array_map('trim', explode(',', $request->tags));

        $isPrivate = $request->has('is_private_to_uploader') ? true : false;
        $isPublic = $isPrivate ? false : ($request->has('is_public') ? true : false);

        Document::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'tags' => $tags,
            'file_name' => $name,
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
            'is_public' => $isPublic,
            'is_private_to_uploader' => $isPrivate,
        ]);

        return redirect()->route('documents.search')->with('success', 'Dokumen berhasil disimpan');
    }

    public function show(Document $document)
    {
        $this->authorizeDocumentAccess($document);
        return view('documents.show', compact('document'));
    }

    public function preview(Document $document)
    {
        $this->authorizeDocumentAccess($document);

        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return view('documents.preview', compact('document'));
    }

    protected function authorizeDocumentEdit(Document $document)
    {
        $user = Auth::user();
        if ($user && $document->uploaded_by !== $user->id && !$user->hasRole('Super Admin')) {
            abort(403, 'Anda hanya dapat mengedit dokumen yang Anda unggah sendiri.');
        }
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $this->authorizeDocumentAccess($document);
        $this->authorizeDocumentEdit($document);

        $categories = Category::all();

        return view('documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $this->authorizeDocumentAccess($document);
        $this->authorizeDocumentEdit($document);

        $request->validate([
            'title' => 'required',
            'nomor_surat' => 'nullable|string',
            'perihal' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'tanggal_surat' => 'nullable|date',
            'tags' => 'nullable|string',
        ]);

        $isPrivate = $request->has('is_private_to_uploader') ? true : false;
        $isPublic = $isPrivate ? false : ($request->has('is_public') ? true : false);

        $document->update([
            'title' => $request->title,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'category_id' => $request->category_id,
            'tanggal_surat' => $request->tanggal_surat,
            'tags' => $request->tags ? explode(',', $request->tags) : [],
            'is_public' => $isPublic,
            'is_private_to_uploader' => $isPrivate,
        ]);

        return redirect()->route('documents.search')->with('success', 'Dokumen berhasil diperbarui.');
    }
}
