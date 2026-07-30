@extends('layout.navigation')

@section('title','New User Verification')
@section('main-content')
<div class="mb-6">
  <h1 class="text-2xl font-bold text-accent mb-4">Inventory Management</h1>

  <div class="flex flex-col sm:flex-row justify-between gap-4 mb-4">
    <div class="flex flex-col sm:flex-row gap-2">
      <button id="addUserBtn" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded shadow w-full sm:w-auto">
        <i class="fa-solid fa-user-plus mr-2"></i>Add Item
      </button>
      <button id="manageUnitsBtn" type="button" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow w-full sm:w-auto">
        <i class="fa-solid fa-ruler mr-2"></i>Manage Units
      </button>
      <a href="{{ route('inventory.archived') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow w-full sm:w-auto inline-flex items-center">
        <i class="fa-solid fa-box-archive mr-2"></i>Suspended / Deleted
      </a>
    </div>

    <div class="flex flex-col sm:flex-row gap-2">
      {{-- <select id="positionFilter" class="border rounded p-2 w-full sm:w-auto">
        <option value="">All Positions</option>
        <option value="Receptionist">Receptionist</option>
        <option value="Dentist">Dentist</option>
        <option value="Admin">Admin</option>
      </select> --}}
      <input type="text" id="searchInput" placeholder="Search..." class="border rounded p-2 w-full sm:w-60" />
      <button onclick="InventoryList(1)" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded">
        Search
      </button>
    </div>
  </div>

  <!-- User Table -->
  <div class="overflow-x-auto rounded shadow border">
    <table class="w-full table-auto text-sm text-center">
      <thead class="bg-secondary text-accent">
        <tr>
          <th class="py-3 px-4 border">Name</th>
          <th class="py-3 px-4 border">Unit</th>
          <th class="py-3 px-4 border">Price</th>
          <th class="border px-4 py-2">Total Stock</th>
              <th class="py-3 px-4 border">Description</th>
          <th class="py-3 px-4 border">Action</th>
        </tr>
      </thead>
      <tbody id="newtbody" class="bg-white">
        <!-- Populated via JS -->
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div id="pagination" class="mt-4 flex gap-2 justify-center"></div>
</div>

<!-- Modal: Add User -->
<div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
  <div class="bg-white w-full max-w-xl rounded-lg p-6 shadow-lg relative">
    <h3 class="text-lg font-bold mb-4">Add Item</h3>
    <form class="flex flex-col gap-3" id="addUserForm">
      <div class="grid sm:grid-cols-2 gap-3">
    
        <div>
          <label class="font-semibold">Name</label>
          <input type="text" name="name" required class="w-full border p-2 rounded" />
        </div>
        <div>
          <label class="font-semibold">Price</label>
          <input type="number" name="price" class="w-full border p-2 rounded" />
        </div>
        <div>
          <label class="font-semibold">Description</label>
          <input type="text" name="description" class="w-full border p-2 rounded" />
        </div>
       
        <div>
          <label class="font-semibold">Unit</label>
          <select name="unit" id="unit" required class="w-full border p-2 rounded unit-select">
            <option value="">-- Select Unit --</option>
            @foreach($units as $unit)
              <option value="{{ $unit->name }}">{{ $unit->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <hr class="my-3">
      <h4 class="font-semibold text-gray-700">Initial Batch (Optional)</h4>
      <div class="grid sm:grid-cols-2 gap-3">
        <div>
          <label class="font-semibold">Quantity</label>
          <input type="number" name="batch_quantity" min="0" class="w-full border p-2 rounded" placeholder="Initial stock quantity" />
        </div>
        <div>
          <label class="font-semibold">Expiration Date</label>
          <input type="date" name="batch_expiration_date" class="w-full border p-2 rounded" />
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-4">
        <button type="submit" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button>
        <button type="button" id="closeModalBtn" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Edit Item -->
<div id="editItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
  <div class="bg-white w-full max-w-xl rounded-lg p-6 shadow-lg relative">
    <h3 class="text-lg font-bold mb-4">Edit Item</h3>
    <form class="flex flex-col gap-3" id="editItemForm">
      <input type="hidden" name="edit_id" id="edit_id">
      <div class="grid sm:grid-cols-2 gap-3">
        <div>
          <label class="font-semibold">Name</label>
          <input type="text" name="edit_name" id="edit_name" required class="w-full border p-2 rounded" />
        </div>
        <div>
          <label class="font-semibold">Price</label>
          <input type="number" step="0.01" name="edit_price" id="edit_price" required class="w-full border p-2 rounded" />
        </div>
        <div>
          <label class="font-semibold">Description</label>
          <input type="text" name="edit_description" id="edit_description" class="w-full border p-2 rounded" />
        </div>
        <div>
          <label class="font-semibold">Unit</label>
          <select name="edit_unit" id="edit_unit" required class="w-full border p-2 rounded unit-select">
            <option value="">-- Select Unit --</option>
            @foreach($units as $unit)
              <option value="{{ $unit->name }}">{{ $unit->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="flex justify-end gap-3 mt-4">
        <button type="submit" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded">Save changes</button>
        <button type="button" id="closeEditModalBtn" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: View User -->
<div id="viewModal" class="fixed inset-0 flex items-center justify-center backdrop-blur-sm bg-black/30 hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
    <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl">&times;</button>
    <h2 class="text-xl font-semibold mb-4">User Info</h2>
    <div id="modalContent" class="text-sm text-gray-800 space-y-2">
      <!-- Filled dynamically -->
    </div>
    <div class="mt-4 text-right">
      <button onclick="closeModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Close</button>
    </div>
  </div>
</div>

<!-- Modal: Manage Units -->
<div id="unitsModal" class="fixed inset-0 flex items-center justify-center backdrop-blur-sm bg-black/30 hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
    <button type="button" id="closeUnitsModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl">&times;</button>
    <h2 class="text-xl font-bold mb-4 text-blue-700">Manage Units</h2>

    <form id="addUnitForm" class="flex gap-2 mb-4">
      <input type="text" id="newUnitName" placeholder="New unit (e.g. tablet)" required maxlength="50"
             class="flex-1 border p-2 rounded">
      <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Add</button>
    </form>

    <ul id="unitsList" class="divide-y border rounded max-h-72 overflow-y-auto"></ul>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // ─────────────────────────────────────────────
  // UNIT MANAGEMENT (add / edit / delete)
  // ─────────────────────────────────────────────
  const UNIT_CSRF = '{{ csrf_token() }}';

  function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, s => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[s]));
  }

  function loadUnits() {
    $.get('{{ route('units.list') }}', function (res) {
      const rows = (res.data || []).map(u => `
        <li class="flex items-center justify-between px-3 py-2">
          <span class="unit-name">${escapeHtml(u.name)}</span>
          <span class="flex gap-2">
            <button type="button" class="unit-edit bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-sm"
                    data-id="${u.id}" data-name="${escapeHtml(u.name)}">Edit</button>
            <button type="button" class="unit-delete bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm"
                    data-id="${u.id}" data-name="${escapeHtml(u.name)}">Delete</button>
          </span>
        </li>`).join('');
      $('#unitsList').html(rows || '<li class="px-3 py-4 text-center text-gray-500">No units yet.</li>');
      refreshUnitDropdowns(res.data || []);
    });
  }

  // Panatilihing updated ang Add/Edit Item dropdowns nang hindi nagre-reload
  function refreshUnitDropdowns(units) {
    $('.unit-select').each(function () {
      const current = $(this).val();
      const opts = ['<option value="">-- Select Unit --</option>']
        .concat(units.map(u => `<option value="${escapeHtml(u.name)}">${escapeHtml(u.name)}</option>`));
      $(this).html(opts.join(''));
      if (current) $(this).val(current);
    });
  }

  function unitError(xhr, fallback) {
    const json = xhr.responseJSON || {};
    const msg = json.message || Object.values(json.errors || {}).flat()[0] || fallback;
    Swal.fire('Error', msg, 'error');
  }

  $(document).on('click', '#manageUnitsBtn', function () {
    loadUnits();
    $('#unitsModal').removeClass('hidden');
  });
  $(document).on('click', '#closeUnitsModalBtn', function () {
    $('#unitsModal').addClass('hidden');
  });

  $(document).on('submit', '#addUnitForm', function (e) {
    e.preventDefault();
    $.post('{{ route('units.store') }}', { name: $('#newUnitName').val(), _token: UNIT_CSRF })
      .done(function (res) {
        $('#newUnitName').val('');
        loadUnits();
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
      })
      .fail(xhr => unitError(xhr, 'Failed to add unit.'));
  });

  $(document).on('click', '.unit-edit', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    Swal.fire({
      title: 'Edit Unit',
      input: 'text',
      inputValue: name,
      showCancelButton: true,
      confirmButtonText: 'Save',
      inputValidator: v => (!v || !v.trim()) && 'Unit name is required.'
    }).then(result => {
      if (!result.isConfirmed) return;
      $.ajax({
        url: '/units/' + id,
        method: 'PUT',
        data: { name: result.value, _token: UNIT_CSRF },
        success: function (res) {
          loadUnits();
          InventoryList(1); // refresh table (unit names may have changed)
          Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
        },
        error: xhr => unitError(xhr, 'Failed to update unit.')
      });
    });
  });

  $(document).on('click', '.unit-delete', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    Swal.fire({
      title: 'Delete unit?',
      text: `"${name}" will be removed from the unit list.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete',
      confirmButtonColor: '#dc2626'
    }).then(result => {
      if (!result.isConfirmed) return;
      $.ajax({
        url: '/units/' + id,
        method: 'DELETE',
        data: { _token: UNIT_CSRF },
        success: function (res) {
          loadUnits();
          Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
        },
        error: xhr => unitError(xhr, 'Failed to delete unit.')
      });
    });
  });

  // modal control
  function closeModal() {
    $('#viewModal').addClass('hidden');
  }

  let currentPage = parseInt(localStorage.getItem('inventorycurrentpage')) || 1;
  let currentSearch = '';

  function InventoryList(page = 1) {
    currentPage = page;
    localStorage.setItem('inventorycurrentpage', page);
    currentSearch = $('#searchInput').val();
    currentPosition = $('#positionFilter').val();
    localStorage.setItem('inventoryFilter', currentPosition);

    $.ajax({
      type: "GET",
      url: "{{ route('InventoryList') }}",
      data: {
        search: currentSearch,
        position: currentPosition,
        page: page
      },
      success: function (response) {
        if (response.status === 'success') {
          let rows = '';
          response.data.forEach(item => {
            const safeDesc = (item.description ?? '').replace(/"/g, '&quot;');
            rows += `
<tr>
  <td class="border py-2 px-4">${item.name}</td>
  <td class="border py-2 px-4">${item.unit}</td>
  <td class="border py-2 px-4">${item.price}</td>
  <td class="border py-2 px-4">${item.total_quantity ?? 0}</td>
  <td class="border py-2 px-4">${item.description ?? ''}</td>
  <td class="border py-2 px-4 whitespace-nowrap">
    @if(session('active_branch_id') === 'admin')
      <a href="/medicines/${item.id}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2" disabled>View</a>
    @else
      <a href="/medicines/${item.id}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2">View</a>
    @endif
    <button type="button"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mr-2 editBtn"
            data-id="${item.id}"
            data-name="${(item.name ?? '').replace(/"/g, '&quot;')}"
            data-unit="${item.unit ?? ''}"
            data-price="${item.price ?? ''}"
            data-description="${safeDesc}">Edit</button>
    <button type="button"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded deleteBtn"
            data-id="${item.id}"
            data-name="${(item.name ?? '').replace(/"/g, '&quot;')}">Delete</button>
  </td>
</tr>`;

          });
          $('#newtbody').html(rows);

          let paginationHTML = '';
          if (response.pagination.prev_page_url) {
            paginationHTML += `<button onclick="InventoryList(${parseInt(currentPage) - 1})" class="px-3 py-1 bg-gray-200 rounded">Previous</button>`;
          }
          if (response.pagination.next_page_url) {
            paginationHTML += `<button onclick="InventoryList(${parseInt(currentPage) + 1})" class="px-3 py-1 bg-gray-200 rounded">Next</button>`;
          }
          $('#pagination').html(paginationHTML);
        }
      }
    });
  }

  $(document).ready(function () {
    const savedPosition = localStorage.getItem('inventoryFilter');
    if (savedPosition !== null) {
      $('#positionFilter').val(savedPosition);
    }

    $('#searchInput').on('input', function () {
      localStorage.setItem('currentPage', 1);
      InventoryList(1);
    });

    $('#positionFilter').on('change', function () {
      localStorage.setItem('inventoryFilter', $(this).val());
      localStorage.setItem('currentPage', 1);
      InventoryList(1);
    });

    $('#addUserBtn').click(() => $('#addUserModal').removeClass('hidden'));
    $('#closeModalBtn').click(() => $('#addUserModal').addClass('hidden'));
    $(window).click(function (e) {
      if ($(e.target).is('#addUserModal')) {
        $('#addUserModal').addClass('hidden');
      }
    });

    $('#addUserForm').submit(function (e) {
      e.preventDefault();
      const formData = {
    
        name: $('input[name="name"]').val(),
        unit: $('select[name="unit"]').val(),
        description: $('input[name="description"]').val(),
        price: $('input[name="price"]').val(),
        batch_quantity: $('input[name="batch_quantity"]').val(),
        batch_expiration_date: $('input[name="batch_expiration_date"]').val(),
      
        _token: '{{ csrf_token() }}'
      };

      $.ajax({
        type: 'POST',
        url: '{{ route("medicines.store") }}',
        data: formData,
        success: function (response) {
          if (response.status === 'success') {
            Swal.fire('Success!', response.message, 'success');
            $('#addUserModal').addClass('hidden');
            $('#addUserForm')[0].reset();
            InventoryList(currentPage);
          } else {
            Swal.fire('Error', response.message, 'error');
          }
        },
        error: function (xhr) {
          Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong.', 'error');
        }
      });
    });

    // EDIT — open modal with row data
    $(document).on('click', '.editBtn', function () {
      const $b = $(this);
      $('#edit_id').val($b.data('id'));
      $('#edit_name').val($b.data('name'));
      $('#edit_unit').val($b.data('unit'));
      $('#edit_price').val($b.data('price'));
      $('#edit_description').val($b.data('description'));
      $('#editItemModal').removeClass('hidden');
    });

    $('#closeEditModalBtn').click(() => $('#editItemModal').addClass('hidden'));
    $(window).click(function (e) {
      if ($(e.target).is('#editItemModal')) {
        $('#editItemModal').addClass('hidden');
      }
    });

    $('#editItemForm').submit(function (e) {
      e.preventDefault();
      const id = $('#edit_id').val();
      $.ajax({
        type: 'POST',
        url: '/medicines/' + id,
        data: {
          _method: 'PUT',
          _token: '{{ csrf_token() }}',
          name: $('#edit_name').val(),
          unit: $('#edit_unit').val(),
          price: $('#edit_price').val(),
          description: $('#edit_description').val(),
        },
        success: function (response) {
          if (response.status === 'success') {
            Swal.fire('Saved!', response.message, 'success');
            $('#editItemModal').addClass('hidden');
            InventoryList(currentPage);
          } else {
            Swal.fire('Error', response.message, 'error');
          }
        },
        error: function (xhr) {
          Swal.fire('Error', xhr.responseJSON?.message || 'Update failed.', 'error');
        }
      });
    });

    // DELETE — confirm then call destroy
    $(document).on('click', '.deleteBtn', function () {
      const id = $(this).data('id');
      const name = $(this).data('name');
      Swal.fire({
        title: 'Delete this item?',
        text: `"${name}" will be permanently removed.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Yes, delete it',
      }).then((result) => {
        if (!result.isConfirmed) return;
        $.ajax({
          type: 'POST',
          url: '/medicines/' + id,
          data: {
            _method: 'DELETE',
            _token: '{{ csrf_token() }}',
          },
          success: function (response) {
            if (response.status === 'success') {
              Swal.fire('Deleted', response.message, 'success');
              InventoryList(currentPage);
            } else {
              Swal.fire('Error', response.message, 'error');
            }
          },
          error: function (xhr) {
            Swal.fire('Cannot delete', xhr.responseJSON?.message || 'Delete failed.', 'error');
          }
        });
      });
    });

    InventoryList(currentPage);
  });
</script>
@endsection
