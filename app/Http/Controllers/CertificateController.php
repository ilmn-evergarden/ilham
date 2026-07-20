<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Display a listing of certificates with search & sort.
     */
    public function index(Request $request): View
    {
        $query = $request->user()->certificates();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('issuer', 'like', "%{$search}%");
            });
        }

        // Sort by issue_date — default: newest first
        $sort  = $request->input('sort', 'desc');
        $order = $sort === 'asc' ? 'asc' : 'desc';
        $query->orderBy('issue_date', $order)->orderByDesc('id');

        $certificates = $query->paginate(12)->withQueryString();

        return view('certificates.index', compact('certificates', 'sort'));
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create(): View
    {
        return view('certificates.create');
    }

    /**
     * Store a newly created certificate.
     */
    public function store(StoreCertificateRequest $request): RedirectResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }

        Certificate::create($data);

        return redirect()->route('certificates.index')
            ->with('status', 'certificate-created');
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(Request $request, Certificate $certificate): View
    {
        abort_if($certificate->user_id !== $request->user()->id, 403);

        return view('certificates.edit', compact('certificate'));
    }

    /**
     * Update the specified certificate.
     */
    public function update(UpdateCertificateRequest $request, Certificate $certificate): RedirectResponse
    {
        abort_if($certificate->user_id !== $request->user()->id, 403);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image file
            if ($certificate->image) {
                Storage::disk('public')->delete($certificate->image);
            }
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }

        $certificate->update($data);

        return redirect()->route('certificates.index')
            ->with('status', 'certificate-updated');
    }

    /**
     * Remove the specified certificate and its image file.
     */
    public function destroy(Request $request, Certificate $certificate): RedirectResponse
    {
        abort_if($certificate->user_id !== $request->user()->id, 403);

        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }

        $certificate->delete();

        return redirect()->route('certificates.index')
            ->with('status', 'certificate-deleted');
    }
}
