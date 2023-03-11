<?php


namespace App\Services;


class CategoryService
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getCategories()
    {
        //Get categories for menu
        $categories = $this->model
            ->select('id', 'parent_id', 'lft', 'rgt')
            ->where('status', 1)
            ->orderBy('sorting')
            ->get();

        return $this->nestedMenu($categories);
    }

    //order nest menu
    public function nestedMenu($array, $parent_id = 0)
    {
        $temp_array = array();
        foreach ($array as $element) {
            if ($element->parent_id == $parent_id) {
                $element->subs = $this->nestedMenu($array, $element->id);
                $temp_array[] = $element;
            }
        }
        return $temp_array;
    }

    //make breadcrumb for category
    public function breadcrumb($lft = 0, $rgt = 0)
    {
        return $this->model
            ->where('lft', '<=', $lft)
            ->where('rgt', '>=', $rgt)
            ->orderBy('lft', 'ASC')
            ->get();
    }
    public function getArrayParentId($left = 0, $right = 0)
    {
        $result = [];
        $parents = $this->model->where([
            ['lft', '<', $left],
            ['rgt', '>', $right],
        ])
            ->get()
            ->toArray();
        if (!empty($parents)) {
            $result = array_column($parents, 'id');
        }

        return $result;
    }

    public function getArrayChildrenId($left = 0, $right = 0): array
    {
        $result = [];
        $children = $this->model->where([
            ['lft', '>=', $left],
            ['rgt', '<=', $right],
        ])
            ->get()
            ->toArray();
        if (!empty($children)) {
            $result = array_column($children, 'id');
        }

        return $result;
    }

    /**
     * make dropdown  for category product
     * @param string $text
     * @param int|null $exceptId
     * @return array
     */
    public function dropdown(string $text = '', int $exceptId = null)
    {
        $categories = $this->model->where('status', 1);
        if ($exceptId !== null) {
            $current_category = $this->model->find($exceptId);
            if ($current_category) {
                //get children categories
                $children = $this->getArrayChildrenId($current_category->lft, $current_category->rgt);
                $categories = $categories->where('id', '<>', $exceptId);
                $categories = $categories->whereNotIn('id', $children);
            }
        }
        $categories = $categories->orderBy('lft', 'ASC')->get();

        $data = [];
        if (!empty($text)) {
            $data[0] = $text;
        }
        if ($categories->count() > 0) {
            foreach ($categories as $key => $category) {
                $data[$category->id] = str_repeat('_ ', (($category->level > 0) ? ($category->level - 1) : 0)) . $category->title;
            }
        }

        return $data;
    }


    //Used for SPAs
    public function dropdown_associated(string $text = '', int $exceptId = null)
    {
        $categories = $this->model->where('status', 1);
        if ($exceptId !== null) {
            $current_category = $this->model->find($exceptId);
            if ($current_category) {
                //get children categories
                $children = $this->getArrayChildrenId($current_category->lft, $current_category->rgt);
                $categories = $categories->where('id', '<>', $exceptId);
                $categories = $categories->whereNotIn('id', $children);
            }
        }
        $categories = $categories->orderBy('lft')->get();

        $data = [];
        if (!empty($text)) {
            $data[0] = $text;
        }
        if ($categories->count() > 0) {
            foreach ($categories as $key => $category) {
                $data[] = [
                    'id' => $category->id,
                    'text' => html_entity_decode(str_repeat('&nbsp;&nbsp;', (($category->level > 0) ? ($category->level - 1) : 0)) . $category->title)
                ];
            }
        }

        return $data;
    }
}
