<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'FAQs'])]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public bool $trashed = false;

    public ?int $editingId = null;
    public ?int $deletingId = null;

    public string $question = '';
    public string $answer = '';
    public bool $is_active = true;
    public int $sort_order = 0;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingTrashed(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'status', 'trashed']);
        $this->resetPage();
    }

    protected function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->dispatch('open-offcanvas', name: 'faq-form');
    }

    public function edit(int $id): void
    {
        $faq = Faq::findOrFail($id);

        $this->editingId = $faq->id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->is_active = $faq->is_active;
        $this->sort_order = $faq->sort_order;

        $this->dispatch('open-offcanvas', name: 'faq-form');
    }

    public function save(): void
    {
        $this->validate();

        $faq = $this->editingId
            ? Faq::findOrFail($this->editingId)
            : new Faq();

        $faq->question = $this->question;
        $faq->answer = $this->answer;
        $faq->is_active = $this->is_active;
        $faq->sort_order = $this->sort_order;
        $faq->save();

        $this->dispatch('toast', message: $this->editingId ? 'FAQ updated.' : 'FAQ created.', type: 'success');

        $this->closeForm();
    }

    public function closeForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'faq-form');
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'question', 'answer', 'is_active', 'sort_order']);
        $this->resetValidation();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal', name: 'delete-faq');
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->dispatch('close-modal', name: 'delete-faq');
    }

    public function delete(): void
    {
        Faq::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        $this->dispatch('toast', message: 'FAQ moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-faq');
    }

    public function restore(int $id): void
    {
        Faq::onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'FAQ restored.', type: 'success');
    }

    public function toggleStatus(int $id): void
    {
        $faq = Faq::findOrFail($id);
        $faq->update(['is_active' => ! $faq->is_active]);
    }

    public function render()
    {
        $faqs = Faq::query()
            ->when($this->trashed, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', fn ($query) => $query->where('question', 'like', "%{$this->search}%"))
            ->when($this->status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($this->status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')
            ->paginate(15);

        return view('livewire.admin.faqs.index', [
            'faqs' => $faqs,
        ]);
    }
}
