$(document).ready(function () {
    const menuList = $('#menuList');
    const menuModal = $('#menuModal');
    const menuForm = $('#menuForm');
    const modalTitle = $('#modalTitle');
    const menuId = $('#menuId');
    const name = $('#name');
    const price = $('#price');
    const addMenuBtn = $('#addMenuBtn');
    const closeModal = $('#closeModal');

    // Fetch Menus
    function fetchMenus() {
        $.get('../php/menu_crud.php', function (menus) {
            menuList.empty();
            menus = JSON.parse(menus);
            menus.forEach(menu => {
                const menuItem = `
                    <div class="menu-item">
                        <span>${menu.name} - ${menu.price}</span>
                        <button class="editBtn" 
                                data-id="${menu.id}" 
                                data-name="${menu.name}" 
                                data-price="${menu.price}">Edit</button>
                        <button class="deleteBtn" data-id="${menu.id}">Delete</button>
                    </div>
                `;
                menuList.append(menuItem);
            });
        });
    }

    // Open Modal
    addMenuBtn.click(function () {
        modalTitle.text('Add New Menu');
        menuId.val('');
        name.val('');
        price.val('');
        menuModal.fadeIn();
    });

    // Close Modal
    closeModal.click(function () {
        menuModal.fadeOut();
    });

    // Save Menu
    menuForm.submit(function (e) {
        e.preventDefault();
        const id = menuId.val();
        const action = id ? 'update' : 'create';

        $.post('../php/menu_crud.php', { action, id, name: name.val(), price: price.val() }, function (response) {
            if (response === "success") {
                fetchMenus();
                menuModal.fadeOut();
            } else {
                alert("Failed to save menu. Please try again.");
            }
        });
    });

    // Edit Menu
    $(document).on('click', '.editBtn', function () {
        const id = $(this).data('id');
        const menuName = $(this).data('name');
        const menuPrice = $(this).data('price');

        menuId.val(id);
        name.val(menuName);
        price.val(menuPrice);
        modalTitle.text('Update Menu');
        menuModal.fadeIn();
    });

    // Delete Menu
    $(document).on('click', '.deleteBtn', function () {
        const id = $(this).data('id');

        if (confirm("Are you sure you want to delete this menu?")) {
            $.post('../php/menu_crud.php', { action: 'delete', id }, function (response) {
                if (response === "success") {
                    fetchMenus();
                } else {
                    alert("Failed to delete menu. Please try again.");
                }
            });
        }
    });

    // Initialize
    fetchMenus();
});
