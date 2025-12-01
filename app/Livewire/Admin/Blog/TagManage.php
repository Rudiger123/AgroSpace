<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestion des Tags')]
class TagManage extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Propriétés pour le formulaire
    public $showModal = false;
    public $showDeleteModal = false;
    public $showBulkModal = false;
    public $tagId;
    public $name;
    public $slug;
    public $description;
    public $color;
    public $is_active = true;

    // Propriétés pour la recherche et filtrage
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    public $selectedTags = [];
    public $selectAll = false;

    // Propriétés pour l'import/export
    public $importFile;
    public $showImportModal = false;

    // Préréglages de couleurs
    public $colorPresets = [
        '#22c55e',
        '#16a34a',
        '#15803d',
        '#166534',
        '#14532d',
        '#f59e0b',
        '#d97706',
        '#b45309',
        '#92400e',
        '#78350f',
        '#ef4444',
        '#dc2626',
        '#b91c1c',
        '#991b1b',
        '#7f1d1d',
        '#3b82f6',
        '#2563eb',
        '#1d4ed8',
        '#1e40af',
        '#1e3a8a',
        '#8b5cf6',
        '#7c3aed',
        '#6d28d9',
        '#5b21b6',
        '#4c1d95',
        '#ec4899',
        '#db2777',
        '#be185d',
        '#9d174d',
        '#831843',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:tags',
        'description' => 'nullable|string',
        'color' => 'nullable|string|max:50',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'Le nom du tag est obligatoire.',
        'slug.required' => 'Le slug est obligatoire.',
        'slug.unique' => 'Ce tag existe déjà.',
    ];

    protected function getTranslatedMessages()
    {
        return [
            'name.required' => __('tags.validation.name_required'),
            'slug.required' => __('tags.validation.slug_required'),
            'slug.unique' => __('tags.validation.slug_unique'),
        ];
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedTags = Tag::search($this->search)
                ->orderBy($this->sortField, $this->sortDirection)
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedTags = [];
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function create()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $this->tagId = $tag->id;
        $this->name = $tag->name;
        $this->slug = $tag->slug;
        $this->description = $tag->description;
        $this->color = $tag->color;
        $this->is_active = $tag->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->tagId) {
            $rules['slug'] = 'required|string|max:255|unique:tags,slug,' . $this->tagId;
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'color' => $this->color,
            'is_active' => $this->is_active,
        ];

        if ($this->tagId) {
            Tag::find($this->tagId)->update($data);
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => __('tags.updated_success'),
                'icon' => 'check-circle'
            ]);
        } else {
            Tag::create($data);
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => __('tags.created_success'),
                'icon' => 'plus-circle'
            ]);
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function confirmDelete($id)
    {
        $this->tagId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Tag::find($this->tagId)->delete();
        $this->dispatch('toast', [
            'type' => 'error',
            'message' => __('tags.deleted_success'),
            'icon' => 'trash'
        ]);
        $this->closeDeleteModal();
    }

    public function bulkDelete()
    {
        Tag::whereIn('id', $this->selectedTags)->delete();
        $this->dispatch('toast', [
            'type' => 'error',
            'message' => count($this->selectedTags) . ' ' . __('tags.bulk_deleted_success'),
            'icon' => 'trash'
        ]);
        $this->selectedTags = [];
        $this->selectAll = false;
        $this->showBulkModal = false;
    }

    public function toggleStatus($id)
    {
        $tag = Tag::find($id);
        $tag->is_active = !$tag->is_active;
        $tag->save();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => __('tags.status_updated'),
            'icon' => 'toggle-on'
        ]);
    }

    public function duplicate($id)
    {
        $tag = Tag::find($id);
        $newTag = $tag->replicate();
        $newTag->name = $tag->name . ' (' . __('tags.copy_suffix') . ')';
        $newTag->slug = Str::slug($newTag->name);
        $newTag->save();

        $this->dispatch('toast', [
            'type' => 'info',
            'message' => __('tags.duplicated_success'),
            'icon' => 'copy'
        ]);
    }

    public function export()
    {
        $tags = Tag::all();
        $csv = __('tags.export_header') . "\n";

        foreach ($tags as $tag) {
            $csv .= "{$tag->name},{$tag->slug},\"{$tag->description}\",{$tag->color}," . ($tag->is_active ? __('tags.status_active') : __('tags.status_inactive')) . "\n";
        }

        return response()->stream(
            function () use ($csv) {
                echo $csv;
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . __('tags.export_filename') . '-' . now()->format('Y-m-d-His') . '.csv"',
            ]
        );
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:csv,txt|max:1024'
        ]);

        $file = fopen($this->importFile->getRealPath(), 'r');
        $header = fgetcsv($file); // Skip header

        $imported = 0;
        while ($row = fgetcsv($file)) {
            Tag::create([
                'name' => $row[0],
                'slug' => Str::slug($row[0]),
                'description' => $row[2] ?? null,
                'color' => $row[3] ?? null,
                'is_active' => ($row[4] ?? __('tags.status_active')) === __('tags.status_active'),
            ]);
            $imported++;
        }

        fclose($file);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => "{$imported} " . __('tags.imported_success'),
            'icon' => 'upload'
        ]);

        $this->showImportModal = false;
        $this->importFile = null;
    }

    private function resetInputFields()
    {
        $this->tagId = null;
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->color = '';
        $this->is_active = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    public function render()
    {
        $tags = Tag::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.blog.tag-manage', [
            'tags' => $tags,
        ]);
    }
}
