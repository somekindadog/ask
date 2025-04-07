/* --------------------------- LỌC THEO TRẠNG THÁI -------------------------- */
document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử select
    var statusSelect = document.getElementById("fillter-status");

    // Lấy danh sách bài viết
    var products = document.querySelectorAll(".product");

    // Thêm sự kiện cho select status
    statusSelect.addEventListener("change", function () {
        // Lọc bài viết theo trạng thái
        filterByStatus(statusSelect.value);
    });

    function filterByStatus(selectedStatus) {
        // Lặp qua danh sách bài viết và ẩn/hiện bài viết dựa trên trạng thái
        products.forEach(function (product) {
            var productStatus = product.getAttribute("data-filter");
            if (selectedStatus === "none" || productStatus === selectedStatus) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        });
    }
});
/* --------------------------- LỌC THEO TRẠNG THÁI -------------------------- */

/* ---------------------- LỌC THEO TEXT + TĂNG GIẢM DẦN --------------------- */
document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử select
    var textSelect = document.getElementById("fillter-text");

    // Lấy danh sách bài viết
    var products = document.querySelectorAll(".product");

    // Thêm sự kiện cho select text
    textSelect.addEventListener("change", function () {
        // Sắp xếp bài viết theo tùy chọn
        sortProducts(textSelect.value);
    });

    function sortProducts(selectedOption) {
        // Lấy danh sách bài viết và chuyển đổi thành mảng để sử dụng sort
        var productsArray = Array.from(products);

        switch (selectedOption) {
            case "az":
                // Sắp xếp a-z
                productsArray.sort(function (a, b) {
                    var titleA = a.querySelector(".title").innerText.toUpperCase();
                    var titleB = b.querySelector(".title").innerText.toUpperCase();
                    return titleA.localeCompare(titleB);
                });
                break;
            case "za":
                // Sắp xếp z-a
                productsArray.sort(function (a, b) {
                    var titleA = a.querySelector(".title").innerText.toUpperCase();
                    var titleB = b.querySelector(".title").innerText.toUpperCase();
                    return titleB.localeCompare(titleA);
                });
                break;
        }

        // Gán lại thứ tự bài viết trong danh sách
        productsArray.forEach(function (product) {
            document.getElementById("product-list").appendChild(product);
        });
    }
});
/* ---------------------- LỌC THEO TEXT + TĂNG GIẢM DẦN --------------------- */
