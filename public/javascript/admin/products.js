function validateAddProduct() {
    let categoryId = document.getElementById("categoryId");
    let image = document.getElementById("image");
    let productName = document.getElementById("productName");
    let details = document.getElementById("details");
    let valid = true;
    
    // Reset border color
    categoryId.style.borderColor = 'gray';
    image.style.borderColor = 'gray';
    productName.style.borderColor = 'gray';
    details.style.borderColor = 'gray';
    
    // Validate categoryId
    if(categoryId.value == 0){
        categoryId.style.borderColor = 'red';
        valid = false;
    }
    
    
    // Validate productName
    if(productName.value.trim() === ""){
        productName.style.borderColor = 'red';
        valid = false;
    }
    
    // Validate details
    if(details.value.trim() === ""){
        details.style.borderColor = 'red';
        valid = false;
    }
    
    return valid;
}
