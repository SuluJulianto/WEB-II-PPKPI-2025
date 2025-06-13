function btn_edit(id, sku, productName) {
    console.log("Edit ID: " + id + ", SKU: " + sku + ", Product: " + productName); 
    alert("Anda akan mengedit produk:\nID: " + id + "\nSKU: " + sku + "\nProduct: " + productName);

}

function btn_delete(id, sku, productName) {
    console.log("Delete ID: " + id + ", SKU: " + sku + ", Product: " + productName); 
    if (confirm("Anda yakin ingin menghapus produk:\nID: " + id + "\nSKU: " + sku + "\nProduct: " + productName + "?")) {
    
}
}