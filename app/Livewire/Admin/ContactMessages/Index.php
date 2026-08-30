<?php

namespace App\Livewire\Admin\ContactMessages;

use App\Models\ContactMessage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Contact Messages'])]
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

        ContactMessage::where('id', $id)->where('status', 'new')->update(['status' => 'read']);

        $this->dispatch('open-modal', name: 'message-view');
    }

    public function closeView(): void
    {
        $this->viewingId = null;
        $this->dispatch('close-modal', name: 'message-view');
    }

    public function updateStatus(int $id, string $status): void
    {
        if (! in_array($status, ['new', 'read', 'replied', 'closed'], true)) {
            return;
        }

        ContactMessage::findOrFail($id)->update(['status' => $status]);
    }

    public function render()
    {
        $messages = ContactMessage::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%")
                        ->orWhere('subject', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->latest()
            ->paginate(15);

        $viewing = $this->viewingId ? ContactMessage::find($this->viewingId) : null;

        return view('livewire.admin.contact-messages.index', [
            'messages' => $messages,
            'viewing' => $viewing,
        ]);
    }
}
