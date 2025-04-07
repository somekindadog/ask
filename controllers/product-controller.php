<?php
class Product_Controller
{
    private $db;
    private $categoryModel;
    private $productModel;
    private $commentModel;
    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->categoryModel = new Category_Model($this->db);
        $this->productModel = new Product_Model($this->db);
        $this->commentModel = new Comment_Model($this->db);
    }
    function showProductList()
    {
        $result = $this->productModel->showProductList();
        include './posts/posts.php';
    }
    function showProductListByCategory($categoryId)
    {
        $posts = $this->productModel->showProductListByCategory($categoryId);
        include './component/relate-posts.php';
    }
    function showProductListWeb()
    {
        $posts = $this->productModel->showProductList();
        include './component/posts.php';
    }
    function noFilterOrSearch($url, $db)
    {
        $maylike = $this->productModel->showProductList();
        include $url;
    }
    function addProduct()
    {
        $categories = $this->categoryModel->showCategoriesList();
        $result = $this->productModel->createProduct();
        include './posts/add-product.php';
    }
    function editProduct()
    {
        $dataOld = $this->productModel->dataProductOld();
        if (isset($dataOld)) {
            $categories = $this->categoryModel->showCategoriesList();
            $result = $this->productModel->editProduct();
            include './posts/edit-product.php';
        } else {
            header("Location: ../404/");
        }
    }
    function deleteProduct()
    {
        $result = $this->productModel->showProductList();
        $alertDelete = $this->productModel->deleteProduct();
        include './posts/posts.php';
    }
    function updateStatusProduct()
    {
        $alertUpdate = $this->productModel->updateStatusProduct();
        include './posts/posts.php';
    }
    function detailsProduct()
    {
        $result = $this->productModel->detailsProduct();
        include './posts/details-product.php';
    }
    function detailsProductWeb()
    {
        $product = $this->productModel->detailsProduct();
        if (isset($_POST) && count($_POST) > 0) {
            $result = $this->commentModel->addComment($_POST, $this->db);
        }
        if ($product !== "Lỗi") {
            include './public/views/read-blog.php';
        } else {
            include './public/views/home.php';
        }
    }

    public function addComment()
    {
        $result = $this->commentModel->addComment($_POST, $this->db);
        $id_post = $_POST['post_id'];
        $product = $this->productModel->findPost($id_post);
        include_once './public/views/read-blog.php';
    }



    function filterProduct()
    {
        $posts = $this->productModel->filterProduct();
        include '../component/filter-posts.php';
        if (is_null($posts)) {
            $this->noFilterOrSearch("../component/maylike.php", require '../config/database.php');
        }
    }
    function showAImageMore()
    {
        $result = $this->productModel->showAListImageMore();
        include '../admin/posts/images.php';
    }
    function deleteImageMore()
    {
        $alertDelete = $this->productModel->deleteImageMore();
        include '../admin/posts/images.php';
    }
    function showProductByStatusLimit($title, $status, $limit)
    {
        $posts = $this->productModel->showProductByStatusLimit($status, $limit);
        include './component/productByStatus.php';
    }
    function searchhh()
    {
        $posts = $this->productModel->searchhh();
        include './component/searchhh.php';
    }
}
?>