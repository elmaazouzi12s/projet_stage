<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\SubCategory;
use Livewire\Component;
use Illuminate\Support\Str;

class Categories extends Component
{
    public $category_name;
    public $selected_category_id;
    public $updateCategoryMode = false;

    public $subcategory_name;
    public $parent_category;
    public $selected_subcategory_id;
    public $updateSubCategoryMode = false;

    public function addCategory()
    {
        $this->validate([
            "category_name" => "required|unique:categories,category_name"
        ]);

        $category = new Category();
        $category->category_name = $this->category_name;
        $saved = $category->save();

        if ($saved) {
            toastr()->success('New Category has been successfully added');
            $this->category_name = null;
            $this->dispatchBrowserEvent('hideCategoryModal');
        } else {
            toastr()->error('Somthing Went Wrong..!');
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->selected_category_id = $category->id;
        $this->category_name = $category->category_name;
        $this->updateCategoryMode = true;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updateCategory()
    {
        if ($this->selected_category_id) {
            $this->validate([
                "category_name" => 'required|unique:categories,category_name,'.$this->selected_category_id
            ]);
            $category = Category::findOrFail($this->selected_category_id);
            $category->category_name = $this->category_name;
            $updated = $category->save();

            if ($updated) {
                $this->dispatchBrowserEvent('hideCategoryModal');
                toastr()->success('Category has been successfully updated');
                $this->updateCategoryMode = false;
            } else {
                toastr()->error('Somthing Went Wrong..!');
            }
        }
    }

    public function addSubCategory()
    {
        $this->validate([
            "parent_category" => 'required',
            "subcategory_name" => 'required|unique:sub_categories,subcategory_name',
        ]);

        $subcategory =  new SubCategory();
        $subcategory->subcategory_name = $this->subcategory_name;
        $subcategory->slug = Str::slug($this->subcategory_name);
        $subcategory->parent_category = $this->parent_category;
        $saved = $subcategory->save();

        if ($saved) {
            toastr()->success('New Sub-Category has been successfully added');
            $this->subcategory_name = null;
            $this->parent_category = null;
            $this->dispatchBrowserEvent('hideSubCategoryModal');
        } else {
            toastr()->error('Somthing Went Wrong..!');
        }
    }

    public function editSubCategory($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $this->selected_subcategory_id = $subcategory->id;
        $this->parent_category = $subcategory->parent_category;
        $this->subcategory_name = $subcategory->subcategory_name;
        $this->updateSubCategoryMode = true;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetInputForm()
    {
        $this->resetErrorBag();
        $this->category_name = null;
        $this->subcategory_name = null;
        $this->parent_category = null;
        $this->resetValidation();
    }

    public function updateSubCategory()
    {
        if ($this->selected_subcategory_id) {
            $this->validate([
                "subcategory_name" => 'required|unique:sub_categories,subcategory_name,'.$this->selected_subcategory_id
            ]);
            $subcategory = SubCategory::findOrFail($this->selected_subcategory_id);
            $subcategory->subcategory_name = $this->subcategory_name;
            $subcategory->parent_category = $this->parent_category;
            $subcategory->slug = Str::slug($this->subcategory_name);
            $updated = $subcategory->save();

            if ($updated) {
                $this->dispatchBrowserEvent('hideCategoryModal');
                toastr()->success('SubCategory has been successfully updated');
                $this->updateCategoryMode = false;
            } else {
                toastr()->error('Somthing Went Wrong..!');
            }
        }
    }

    public function render()
    {
        return view('livewire.categories', [
            "categories" => Category::orderBy('ordering', "ASC")->get(),
            "subcategories" => SubCategory::orderBy('ordering', "ASC")->get()
        ]);
    }
}