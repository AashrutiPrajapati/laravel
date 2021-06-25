<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function manageCategory()
    {
        $categories = Category::where('parent_id', '=', 0)->get();
        $allCategories = Category::pluck('name', 'id');
        $view = view('categories.categoryTreeview', compact('categories', 'allCategories'))->render();
        $response = [
            'element' => [
                [
                    'success' => 'success',
                    'name' => 'laravel',
                    'selector' => '#content',
                    'html' => $view
                    ]
                    ]
                ];
        
        header('content-type:application/json');
        echo json_encode($response);
    }

    public function addCategory(Request $request)
    {
        $category = new Category;
        $post['name'] = $request->input('name');
        $post['parent_id'] = $request->get('parent_id');
        $post['status'] = $request->get('status');
        $post['description'] = $request->get('description');
        if ($post['parent_id'] == NULL) {
            $post['parent_id'] = 0;
        }
        $id = Category::insertGetId($post);
        $category = Category::find($id);
        $parentCategory = Category::find($category->parent_id);
        if ($category->parent_id != 0) {
            $category->pathId = $parentCategory['pathId'] . " = " . $id;
        } else {
            $category->pathId = $id;
        }
        $category->save();
        return redirect('category')->with('success', 'New Category added successfully.');
    }

    public function addSubCategory(Request $request)
    {
        $category = new Category;
        $this->validate($request, [
            'name' => 'required', 'description' => 'required'
        ]);
        $post['name'] = $request->get('name');
        $post['parent_id'] = $request->get('parent_id');
        $post['description'] = $request->get('description');
        $post['status'] = $request->get('status');
        $id = Category::insertGetId($post);
        $category = Category::find($id);
        $parentCategory = Category::find($category->parent_id);
        if ($category->parent_id != 0) {
            $category->pathId = $parentCategory['pathId'] . " = " . $id;
        } else {
            $category->pathId = $id;
        }
        $category->save();
        return redirect('category')->with('success', 'SubCategory added successfully.');
    }

    public function edit(Category $category, $id)
    {
        $categories = Category::where('parent_id', '=', 0)->get();
        $currentCategory = Category::find($id);
        $pathId = $currentCategory->pathId;
        $allCategories = Category::where('pathId', 'NOT LIKE', "{$pathId}%")
            ->get();
        $view = view('categories.updateCategoryTreeview', compact('currentCategory', 'id', 'allCategories', 'categories'))->render();
        $response = [
            'element' => [
                [
                    'success' => 'success',
                    'name' => 'laravel',
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }

    public function update(Request $request, Category $category, $id)
    {
        $category = Category::find($id);
        $category->name = $request->input("name");
        $category->parent_id = $request->input("parent_id");
        if (!$category->parent_id) {
            $category->parent_id = 0;
        }
        if ($category->parent_id != 0) {
            $parentCategory = Category::find($category->parent_id);
            $category->pathId = $parentCategory->pathId . ' = ' . $id;
        } else {
            $category->pathId = $id;
        }
        $category->updated_at = Carbon::now();
        $category->save();

        $childCategories = Category::where('pathId', 'LIKE', "%{$id}%")->where('id', '!=', $id)->get();
        // print_r($childCategories);die;
        foreach ($childCategories as $key => $child) {
            if ($child->parent_id == $id) {
                $child->pathId = $category->pathId . ' = ' . $child->id;
            } else {
                $parentCategory = Category::find($child->parent_id);
                $child->pathId = $parentCategory->pathId . ' = ' . $child->id;
            }
            $child->save();
        }
        return redirect('category')
            ->with('success', 'Category Updated Succesfully');
    }
    public function destroy(Category $category, $id)
    {
        $category = Category::find($id);
        $childCategories = Category::where('pathId', 'LIKE', "%{$id}%")->where('id', '!=', $id)->get();
        // print_r($childCategories);die;
        foreach ($childCategories as $value) {
            $value->parent_id = $category->parent_id;
            $value->pathId = $category->parent_id . " = " . $value->id;
            $value->save();
        }
        if ($category->delete()) {
            $categories = Category::all();
            if ($categories) {
                $categories = $categories->where('parent_id', '=', '0');
                foreach ($categories as $key => $category) {
                    $category->pathId = $category->id;
                    $category->save();
                }
            }
        }
        return redirect('category')
            ->with('success', 'Category Deleted Succesfully');
    }
}
