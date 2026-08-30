<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\DocumentAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['preview']);
    }

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
            ->with(['category', 'uploader', 'attachments'])
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
            'title' => 'required',
            'file' => 'required|mimes:pdf|max:10240',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx|max:10240',
            'tanggal_surat' => 'nullable|date',
        ]);

        $file = $request->file('file');
        $name = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $name, 'public');
        $tags = array_map('trim', array_filter(explode(',', (string)$request->tags)));

        $isPrivate = $request->has('is_private_to_uploader') ? true : false;
        $isPublic = $isPrivate ? false : ($request->has('is_public') ? true : false);

        $document = Document::create([
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

        // Process attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attFile) {
                if ($attFile && $attFile->isValid()) {
                    $attName = time() . '_' . rand(100, 999) . '_' . $attFile->getClientOriginalName();
                    $attPath = $attFile->storeAs('documents/attachments', $attName, 'public');

                    $document->attachments()->create([
                        'file_name' => $attFile->getClientOriginalName(),
                        'file_path' => $attPath,
                        'file_size' => $attFile->getSize(),
                        'file_type' => strtolower($attFile->getClientOriginalExtension()),
                    ]);
                }
            }
        }

        return redirect()->route('documents.search')->with('success', 'Dokumen berhasil disimpan');
    }

    public function show(Document $document)
    {
        $this->authorizeDocumentAccess($document);
        $document->load('attachments');
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
        $document = Document::with('attachments')->findOrFail($id);
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
            'new_attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx|max:10240',
        ]);

        $isPrivate = $request->has('is_private_to_uploader') ? true : false;
        $isPublic = $isPrivate ? false : ($request->has('is_public') ? true : false);

        $document->update([
            'title' => $request->title,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'category_id' => $request->category_id,
            'tanggal_surat' => $request->tanggal_surat,
            'tags' => $request->tags ? array_map('trim', explode(',', $request->tags)) : [],
            'is_public' => $isPublic,
            'is_private_to_uploader' => $isPrivate,
        ]);

        // Process new attachments if uploaded
        if ($request->hasFile('new_attachments')) {
            foreach ($request->file('new_attachments') as $attFile) {
                if ($attFile && $attFile->isValid()) {
                    $attName = time() . '_' . rand(100, 999) . '_' . $attFile->getClientOriginalName();
                    $attPath = $attFile->storeAs('documents/attachments', $attName, 'public');

                    $document->attachments()->create([
                        'file_name' => $attFile->getClientOriginalName(),
                        'file_path' => $attPath,
                        'file_size' => $attFile->getSize(),
                        'file_type' => strtolower($attFile->getClientOriginalExtension()),
                    ]);
                }
            }
        }

        return redirect()->route('documents.search')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function downloadAttachment(DocumentAttachment $attachment)
    {
        $document = $attachment->document;
        $this->authorizeDocumentAccess($document);

        if (!Storage::disk('public')->exists($attachment->file_path)) {
            abort(404, 'File lampiran tidak ditemukan.');
        }

        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
    }

    public function destroyAttachment(DocumentAttachment $attachment)
    {
        $document = $attachment->document;
        $this->authorizeDocumentAccess($document);
        $this->authorizeDocumentEdit($document);

        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        return back()->with('success', 'Lampiran berhasil dihapus.');
    }
}
