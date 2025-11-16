<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestion des Catégories')]
class CategoryManage extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showDeleteModal = false;
    public $categoryId;
    public $name;
    public $slug;
    public $icon;
    public $color = '#22c55e';
    public $description;
    public $is_active = true;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories',
        'icon' => 'nullable|string|max:255',
        'color' => 'required|string|max:7',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'Le nom de la catégorie est obligatoire.',
        'slug.required' => 'Le slug est obligatoire.',
        'slug.unique' => 'Ce slug est déjà utilisé.',
        'color.required' => 'La couleur est obligatoire.',
    ];

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
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
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->icon = $category->icon;
        $this->color = $category->color;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->categoryId) {
            $rules['slug'] = 'required|string|max:255|unique:categories,slug,' . $this->categoryId;
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'color' => $this->color,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->categoryId) {
            Category::find($this->categoryId)->update($data);
            $message = 'Catégorie mise à jour avec succès.';
        } else {
            Category::create($data);
            $message = 'Catégorie créée avec succès.';
        }

        $this->message($message);
        $this->closeModal();
        $this->resetInputFields();
    }

    public function confirmDelete($id)
    {
        $this->categoryId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Category::find($this->categoryId)->delete();
        $message = 'Catégorie supprimée avec succès.';
        $this->message($message);
        $this->closeDeleteModal();
    }

    public function toggleStatus($id)
    {
        $category = Category::find($id);
        $category->is_active = !$category->is_active;
        $category->save();

        $message =  'Statut de la catégorie mis à jour.';
        $this->message($message);
    }

    public function message($message)
    {
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    private function resetInputFields()
    {
        $this->categoryId = null;
        $this->name = '';
        $this->slug = '';
        $this->icon = '';
        $this->color = '#22c55e';
        $this->description = '';
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
        $query = Category::orderBy($this->sortField, $this->sortDirection);
        if ($this->search) {
            $query->search($this->search);
        }
        $categories = $query->paginate(12);

        return view('livewire.admin.blog.category-manage', [
            'categories' => $categories,
        ]);
    }
}
