document.getElementById("addBtn").addEventListener("click", function() {
    let name = document.getElementById("name").value;
    let price = document.getElementById("price").value;

    if (name === "" || price === "") {
        alert("Lütfen ürün adı ve fiyat girin!");
        return;
    }

    let li = document.createElement("li");
    li.textContent = name + " - " + price + "₺";

    document.getElementById("productList").appendChild(li);

    document.getElementById("name").value = "";
    document.getElementById("price").value = "";
});


