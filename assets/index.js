 // File: admin/product_manage.html
 
 let products = [];
        let editIndex = null;
        let nextProductId = 1; // Auto-increment Product ID

        function renderTable() {
            const tbody = document.getElementById('productTableBody');
            tbody.innerHTML = '';
            products.forEach((product, idx) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${product.product_id}</td>
                    <td>${product.name}</td>
                    <td>${product.category}</td>
                    <td>${product.price}</td>
                    <td>${product.image ? `<img src="${product.image}" class="img-thumb" alt="Image">` : ''}</td>
                    <td>${product.description}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-1" onclick="editProduct(${idx})"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteProduct(${idx})"><i class="bi bi-trash"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('productName').value.trim();
            const category = document.getElementById('productCategory').value;
            const price = document.getElementById('productPrice').value;
            const description = document.getElementById('productDescription').value.trim();
            const imageInput = document.getElementById('productImage');
            let image = '';

            function saveAndRender(img) {
                if (editIndex === null) {
                    products.push({ 
                        product_id: nextProductId++, // Use product_id instead of id
                        name, category, price, description, image: img 
                    });
                } else {
                    products[editIndex] = { 
                        ...products[editIndex], // Keep the same product_id
                        name, category, price, description, image: img 
                    };
                    editIndex = null;
                    document.getElementById('saveBtn').textContent = 'Save Product';
                    document.getElementById('cancelEditBtn').classList.add('d-none');
                }
                document.getElementById('productForm').reset();
                renderTable();
            }

            if (imageInput.files && imageInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    image = e.target.result;
                    saveAndRender(image);
                };
                reader.readAsDataURL(imageInput.files[0]);
            } else {
                image = editIndex !== null ? products[editIndex].image : '';
                saveAndRender(image);
            }
        });

        function editProduct(idx) {
            const product = products[idx];
            document.getElementById('productName').value = product.name;
            document.getElementById('productCategory').value = product.category;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productDescription').value = product.description;
            // Can't set file input value for image
            editIndex = idx;
            document.getElementById('saveBtn').textContent = 'Update Product';
            document.getElementById('cancelEditBtn').classList.remove('d-none');
        }

        function deleteProduct(idx) {
            if (confirm('Are you sure you want to delete this product?')) {
                products.splice(idx, 1);
                renderTable();
                if (editIndex === idx) {
                    document.getElementById('productForm').reset();
                    editIndex = null;
                    document.getElementById('saveBtn').textContent = 'Save Product';
                    document.getElementById('cancelEditBtn').classList.add('d-none');
                }
            }
        }

        document.getElementById('cancelEditBtn').addEventListener('click', function() {
            document.getElementById('productForm').reset();
            editIndex = null;
            document.getElementById('saveBtn').textContent = 'Save Product';
            this.classList.add('d-none');
        });

        renderTable();