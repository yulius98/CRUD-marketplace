<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Produk</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-lime-50">

<div class="container mx-auto px-4 py-8">
    <!-- Header dengan Search -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Produk</h2>
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="text" 
                       class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       id="searchInput" 
                       placeholder="Cari produk...">
                <span class="absolute right-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
            </div>
            <button type="button" 
                    class="bg-blue-400 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-sm transition duration-150" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addModal">
                Tambah Produk
            </button>
        </div>
    </div>

    <!-- Tabel Produk -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-500">
            <thead class="bg-green-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Link</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Harga Diskon</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Status Diskon</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="productsTable" class="bg-white divide-y divide-gray-500">
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4 bg-white p-4 rounded-lg shadow">
        <div class="text-sm text-gray-700">
            Menampilkan <span id="currentItems" class="font-medium">0</span> dari 
            <span id="totalItems" class="font-medium">0</span> item
        </div>
        <div class="flex items-center space-x-4">
            <select id="itemsPerPage" 
                    class="rounded-md border-gray-300 py-1 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="5"selected>5 per halaman</option>
                <option value="10">10 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
            </select>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <button id="prevPage" 
                        class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150">
                    Sebelumnya
                </button>
                <span id="currentPage" 
                      class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    1
                </span>
                <button id="nextPage" 
                        class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150">
                    Selanjutnya
                </button>
            </nav>
        </div>
    </div>
</div>

<!-- Tambahkan Modal Form sebelum tag script -->
<div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Tambah/Edit Produk</h3>
            <form id="productForm" class="space-y-4">
                <input type="hidden" id="productId">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input type="text" id="kategori" name="kategori" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" id="produk" name="produk" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="description" name="description" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" id="harga" name="harga" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Link Pembelian</label>
                    <input type="url" id="link" name="link" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">URL Gambar</label>
                    <input type="url" id="img" name="img" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga Diskon (Jika Ada)</label>
                    <input type="number" id="harga_diskon" name="harga_diskon" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="produk_diskon" name="produk_diskon" 
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <label class="ml-2 block text-sm text-gray-900">Status Diskon</label>
                </div>

                <div class="flex justify-end space-x-3 mt-5">
                    <button type="button" onclick="closeModal()" 
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentPage = 1;
let itemsPerPage = 10;
let filteredProducts = [];

// Fungsi untuk memotong teks
function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength) + '...';
}

// Fungsi untuk memformat angka ke format rupiah
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(angka);
}

function updateTable() {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedProducts = filteredProducts.slice(startIndex, endIndex);
    
    let html = '';
    paginatedProducts.forEach(function(product) {
        html += `
            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">${product.id}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">${product.kategori}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                    <img src="${product.img}" alt="${product.produk}" class="h-10 w-10 object-cover rounded">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                    <span title="${product.produk}">${truncateText(product.produk, 10)}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 ">
                    <span title="${product.description}">${truncateText(product.description, 10)}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">${product.jumlah}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">${formatRupiah(product.harga)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                    <a href="${product.link}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat</a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">${formatRupiah(product.harga_diskon)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                    <span class="px-2 py-1 text-xs rounded-full ${product.produk_diskon ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${product.produk_diskon ? 'Diskon' : 'Normal'}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                    <button class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md transition duration-150" 
                            onclick='editProduct(${JSON.stringify(product).replace(/'/g, "&#39;")})'>
                        Edit
                    </button>
                    <button class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md transition duration-150" 
                            onclick="deleteProduct(${product.id})">
                        Hapus
                    </button>
                </td>
            </tr>
        `;
    });
    
    $('#productsTable').html(html);
    $('#currentItems').text(Math.min(endIndex, filteredProducts.length));
    $('#totalItems').text(filteredProducts.length);
    $('#currentPage').text(currentPage);
    
    // Update status tombol pagination
    const maxPage = Math.ceil(filteredProducts.length / itemsPerPage);
    $('#prevPage').prop('disabled', currentPage === 1)
        .toggleClass('opacity-50 cursor-not-allowed', currentPage === 1);
    $('#nextPage').prop('disabled', currentPage >= maxPage)
        .toggleClass('opacity-50 cursor-not-allowed', currentPage >= maxPage);
}

// Fungsi untuk memuat data produk
function loadProducts(search = '') {
    $.ajax({
        url: '/get-products',
        method: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.status === 'success' && response.data) {
                filteredProducts = response.data.filter(product => {
                    if (!search) return true;
                    const searchLower = search.toLowerCase();
                    return (
                        (product.produk && product.produk.toLowerCase().includes(searchLower)) ||
                        (product.description && product.description.toLowerCase().includes(searchLower)) ||
                        (product.kategori && product.kategori.toLowerCase().includes(searchLower))
                    );
                });
                updateTable();
            } else {
                console.error('Invalid response format:', response);
                alert('Format response tidak valid');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
            alert('Gagal memuat data produk: ' + error);
        }
    });
}

// Fungsi untuk menyimpan/mengupdate produk
function saveProduct() {
    const productId = $('#productId').val();
    const formData = {
        kategori: $('#kategori').val(),
        produk: $('#produk').val(),
        description: $('#description').val(),
        jumlah: $('#jumlah').val(),
        harga: $('#harga').val(),
        link: $('#link').val(),
        img: $('#img').val(),
        harga_diskon: $('#harga_diskon').val() || 0,
        produk_diskon: $('#produk_diskon').is(':checked') ? 1 : 0
    };

    const url = productId ? `/products/${productId}` : '/products';
    const method = productId ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        method: method,
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            closeModal();
            loadProducts();
            alert(productId ? 'Produk berhasil diupdate!' : 'Produk berhasil ditambahkan!');
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
            alert('Terjadi kesalahan: ' + (xhr.responseJSON?.message || error));
        }
    });

    return false;
}

// Fungsi untuk mengedit produk
function editProduct(product) {
    // Tampilkan modal
    showModal();
    
    // Isi form dengan data produk yang akan diedit
    $('#productId').val(product.id);
    $('#kategori').val(product.kategori);
    $('#produk').val(product.produk);
    $('#description').val(product.description);
    $('#jumlah').val(product.jumlah);
    $('#harga').val(product.harga);
    $('#link').val(product.link);
    $('#img').val(product.img);
    $('#harga_diskon').val(product.harga_diskon);
    $('#produk_diskon').prop('checked', product.produk_diskon === 1);
}

// Fungsi untuk menghapus produk
function deleteProduct(id) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        $.ajax({
            url: `/products/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                loadProducts();
                alert('Produk berhasil dihapus!');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                alert('Terjadi kesalahan saat menghapus produk: ' + (xhr.responseJSON?.message || error));
            }
        });
    }
}

// Fungsi untuk mereset form
function resetForm() {
    $('#productId').val('');
    $('#kategori').val('');
    $('#produk').val('');
    $('#description').val('');
    $('#jumlah').val('');
    $('#harga').val('');
    $('#link').val('');
    $('#img').val('');
    $('#harga_diskon').val('');
    $('#produk_diskon').prop('checked', false);
}

// Setup AJAX CSRF token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Event listener saat modal ditutup
$('#addModal').on('hidden.bs.modal', function () {
    resetForm();
});

// Inisialisasi komponen saat dokumen siap
$(document).ready(function() {
    // Event listener yang sudah ada sebelumnya tetap sama
    
    // Tambahan event listener untuk form submit
    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        saveProduct();
    });
});

// Event Listeners
$(document).ready(function() {
    loadProducts();
    
    $('#searchInput').on('keyup', function() {
        currentPage = 1;
        loadProducts($(this).val());
    });
    
    $('#prevPage').click(function() {
        if (currentPage > 1) {
            currentPage--;
            updateTable();
        }
    });
    
    $('#nextPage').click(function() {
        const maxPage = Math.ceil(filteredProducts.length / itemsPerPage);
        if (currentPage < maxPage) {
            currentPage++;
            updateTable();
        }
    });
    
    $('#itemsPerPage').change(function() {
        itemsPerPage = parseInt($(this).val());
        currentPage = 1;
        updateTable();
    });
});

// Tambahkan fungsi-fungsi berikut di dalam script
function showModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('addModal').classList.add('hidden');
    resetForm();
}

// Update event listener untuk tombol Tambah Produk
document.querySelector('[data-bs-target="#addModal"]').addEventListener('click', showModal);

// ... rest of your existing code (loadProducts, saveProduct, etc.) ...
</script>

</body>
</html>
