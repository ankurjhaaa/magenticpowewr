<?php
namespace App\Livewire\Admin\Inquiries;

use App\Models\Inquiry;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Product Enquiries'])]

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';

    public ?int $viewingId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'status']);
        $this->resetPage();
    }

    public function view(int $id): void
    {
        $this->viewingId = $id;

        Inquiry::where('id', $id)->where('status', 'new')->update(['status' => 'read']);

        $this->dispatch('open-modal', name: 'inquiry-view');

    }
    public function closeView(): void
    {
        $this->viewingId = null;
        $this->dispatch('close-modal', name: 'inquiry-view');
    }

    public function updateStatus(int $id, string $status): void
    {
        if (! in_array($status, ['new', 'read', 'replied', 'closed'], true)) {
            return;
        }

        Inquiry::findOrFail($id)->update(['status' => $status]);
    }

    public function render()
    {
        $inquiries = Inquiry::query()->with('variant')->when($this->search !== '', function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });

        })->when($this->status !== '', fn($query) => $query->where('status', $this->status))
            ->latest()
            ->paginate(15);

        $viewing = $this->viewingId ? Inquiry::with('variant')->find($this->viewingId) : null;

        return view('livewire.admin.inquiries.index', [
            'inquiries' => $inquiries,
            'viewing'   => $viewing,
        ]);

    }
}
