<?php

namespace App\Http\Controllers\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqRequest;
use App\Services\Faq\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index()
    {
        $faqs = $this->faqService->getAllFaqs();
        return view('pages.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('pages.faq.create');
    }

    public function store(FaqRequest $request)
    {
        try {
            $this->faqService->createFaq($request->validated());
            return redirect()->route('faq.index')->with('success', 'FAQ created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create FAQ: ' . $e->getMessage());
        }
    }

    public function edit($faq_id)
    {
        try {
            $faq = $this->faqService->getFaqById($faq_id);
            return view('pages.faq.edit', compact('faq'));
        } catch (\Exception $e) {
            return redirect()->route('faq.index')->with('error', 'FAQ not found');
        }
    }

    public function update(FaqRequest $request, $faq_id)
    {
        try {
            $this->faqService->updateFaq($faq_id, $request->validated());
            return redirect()->route('faq.index')->with('success', 'FAQ updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update FAQ: ' . $e->getMessage());
        }
    }

    public function destroy($faq_id)
    {
        try {
            $this->faqService->deleteFaq($faq_id);
            return response()->json(['success' => true, 'message' => 'FAQ deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete FAQ: ' . $e->getMessage()], 500);
        }
    }

    public function changeStatus($faq_id)
    {
        try {
            $faq = $this->faqService->changeStatus($faq_id);
            return response()->json(['success' => true, 'status' => $faq->status, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $faqs = $this->faqService->getAllFaqs();
            return response()->json(['data' => $faqs]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch FAQs'], 500);
        }
    }
}

