// Admin Panel JavaScript Functions

// Modal Management
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        // Reset form if exists
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('[id$="Modal"]');
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
});

// Image Preview
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak valid. Hanya JPG, PNG, dan GIF yang diperbolehkan.');
            input.value = '';
            return;
        }
        
        // Validate file size (max 5MB)
        if (file.size > 5000000) {
            alert('Ukuran file terlalu besar. Maksimal 5MB.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
        };
        reader.readAsDataURL(file);
    }
}

// File Preview for Documents
function previewFile(input, previewTextId) {
    const previewText = document.getElementById(previewTextId);
    const file = input.files[0];
    
    if (file) {
        // Validate file size (max 10MB)
        if (file.size > 10000000) {
            alert('Ukuran file terlalu besar. Maksimal 10MB.');
            input.value = '';
            return;
        }
        
        if (previewText) {
            const fileSize = (file.size / 1024).toFixed(2);
            previewText.textContent = `File: ${file.name} (${fileSize} KB)`;
            previewText.classList.remove('hidden');
        }
    }
}

// Edit Modal - Populate Data
function openEditModal(data) {
    const form = document.querySelector('#editModal form');
    if (!form) return;
    
    // Populate form fields
    for (const key in data) {
        const input = form.querySelector(`[name="${key}"]`);
        if (input) {
            if (input.type === 'checkbox') {
                input.checked = data[key] == 1 || data[key] === true;
            } else if (input.type === 'radio') {
                const radio = form.querySelector(`[name="${key}"][value="${data[key]}"]`);
                if (radio) radio.checked = true;
            } else {
                input.value = data[key];
            }
        }
    }
    
    // Show existing image if available
    if (data.gambar || data.foto || data.logo) {
        const imgPreview = document.getElementById('editImagePreview');
        if (imgPreview) {
            const imgPath = data.gambar || data.foto || data.logo;
            imgPreview.src = BASE_URL + '/uploads/' + imgPath;
            imgPreview.classList.remove('hidden');
        }
    }
    
    openModal('editModal');
}

// Delete Confirmation
function confirmDelete(id, name, deleteUrl) {
    const modal = document.getElementById('deleteModal');
    if (!modal) return;
    
    const message = modal.querySelector('#deleteMessage');
    const form = modal.querySelector('form');
    
    if (message) {
        message.textContent = `Apakah Anda yakin ingin menghapus "${name}"?`;
    }
    
    if (form) {
        form.action = deleteUrl;
    }
    
    openModal('deleteModal');
}

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('border-red-500');
            
            // Show error message
            let errorMsg = field.nextElementSibling;
            if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                errorMsg = document.createElement('span');
                errorMsg.className = 'error-message text-red-500 text-sm mt-1';
                errorMsg.textContent = 'Field ini wajib diisi';
                field.parentNode.appendChild(errorMsg);
            }
        } else {
            field.classList.remove('border-red-500');
            const errorMsg = field.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
                errorMsg.remove();
            }
        }
    });
    
    return isValid;
}

// Show Toast Notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

// Confirm action with native prompt
function confirmAction(message) {
    return confirm(message);
}

// Auto-close flash messages
document.addEventListener('DOMContentLoaded', function() {
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        setTimeout(() => {
            flashMessage.style.opacity = '0';
            flashMessage.style.transition = 'opacity 0.5s';
            setTimeout(() => flashMessage.remove(), 500);
        }, 5000);
    }
});

// Table Search Function
function searchTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    
    if (!input || !table) return;
    
    input.addEventListener('keyup', function() {
        const filter = input.value.toLowerCase();
        const rows = table.getElementsByTagName('tr');
        
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;
            
            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
            
            row.style.display = found ? '' : 'none';
        }
    });
}

// Slug Generator
function generateSlug(text) {
    return text
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

// Auto-generate slug from title
function autoSlug(titleInputId, slugInputId) {
    const titleInput = document.getElementById(titleInputId);
    const slugInput = document.getElementById(slugInputId);
    
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            slugInput.value = generateSlug(this.value);
        });
    }
}
