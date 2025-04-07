<?php 
class Category_Controller{
    private $db;
    private $categoryModel;
    public function __construct(PDO $db){
        $this->db = $db;
        $this->categoryModel = new Category_Model($this->db);
    }
    function showCategories(){
        $result = $this->categoryModel->showCategoriesList();
        include './categories/categories.php';
    }
    function addCategory(){
        $result = $this->categoryModel->createCategory();
        include './categories/add-category.php';
    }
    function editCategory(){
        $dataOld = $this->categoryModel->dataCategoryOld();
        if(isset($dataOld)){
            $result = $this->categoryModel->editCategory();
            include './categories/edit-category.php';
        }else{
            header("Location: ../404/");
        }
    }
    function deleteCategory(){
        $result = $this->categoryModel->showCategoriesList();
        $alertDelete = $this->categoryModel->deleteCategory();
        include './categories/categories.php';
    }
    function showCategoriesAside(){
        $categories = $this->categoryModel->showCategoriesList();
        include './public/layout/aside.php';
    }
}
